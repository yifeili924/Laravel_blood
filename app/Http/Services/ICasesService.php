<?php
/**
 * Created by PhpStorm.
 * User: kebler
 * Date: 20/01/19
 * Time: 17:21
 */

namespace App\Http\Services;


use App\Conclusion;
use App\Feature;
use App\Featureset;
use App\Icase;
use App\Investigation;
use App\Models\User;
use App\Rcache;
use App\Submission;

class ICasesService
{
    /**
     * Using this method the user save an answer (i.e. able to modify) or submit a answer
     * (i.e. cant modify) based on the finalized flag if the user saves or submits
     * we wipe existing answers and save newsones.
     *
     * @param $user
     * @param $icase
     * @param $invArray
     * @param $concArray
     * @param $featureSetArray
     * @return Submission
     */
    public static function submitAnswers($user, $icase, $invArray, $concArray, $featureSetArray, $finalized)
    {
        $existing  = Submission::where('user_id', $user->id)->where('icase_id', $icase->id)->first();
        if (!isset($existing)) {
            $submission = new Submission();
            $submission->user()->associate($user);
            $submission->icase()->associate($icase);
            $submission->finilised = $finalized;
            $submission->save();
            // user submits investigations/conclusions(diagnosis)
            $submission->investigations()->saveMany($invArray);
            $submission->conclusions()->saveMany($concArray);

            //user submits featureSets
            foreach ($featureSetArray as $featureSet) {
                $newFeatureSet = new Featureset();
                $slide = $featureSet['slide'];
                $newFeatureSet->slide()->associate($slide);
                $newFeatureSet->submission()->associate($submission);
                $newFeatureSet->save();
                $newFeatureSet->features()->saveMany($featureSet['features']);
            }
            return $submission;
        }else {
            $existing->finilised = $finalized;
            $existing->save();
            $existing->investigations()->detach();
            $existing->conclusions()->detach();
            $existing->investigations()->saveMany($invArray);
            $existing->conclusions()->saveMany($concArray);

            foreach ($existing->featuresets as $existingFeatureSet) {
                $existingFeatureSet->features()->detach();
                //user submits featureSets
                foreach ($featureSetArray as $featureSet) {
                    $slide = $featureSet['slide'];
                    if ($slide->id == $existingFeatureSet->slide->id) {
                        $existingFeatureSet->features()->saveMany($featureSet['features']);
                    }
                }
            }
            return $existing;
        }
    }

    public static function getReport($id)
    {
        $existing = Rcache::where('icase_id', $id)->first();
        if (isset($existing)) {
            return unserialize($existing->rdata);
        }
        $icase = Icase::find($id);
        $invs = [];
        $conclusions = [];
        /*
         * we need an array to store the slides for each case, and for each slide we need the total number of
         * features submitted to it. so we need to get the slides for a case. icase->slides;
         */
        $globalSlides = $icase->slides;
        foreach ($icase->submissions()->where('finilised', true)->get() as $submission) {
            foreach ($submission->investigations as $investigation) {
                array_push($invs, $investigation->id);
            }
            foreach ($submission->conclusions as $conclusion) {
                array_push($conclusions, $conclusion->id);
            }

            foreach ($submission->featuresets as $featureset) {
                $gSlide = self::getGlobalSlideById($globalSlides, $featureset->slide->id);
                if (isset($gSlide)) {
                    foreach ($featureset->features as $feature) {
                        array_push($gSlide->totalFeatures, $feature->id);
                    }
                }
            }
        }

        $featuresetReport = [];
        foreach ($globalSlides as $globalSlide) {
            array_push($featuresetReport, [
                'slideId' => $globalSlide->id,
                "features" => self::getReportInfo($globalSlide->totalFeatures, new Feature())]);
        }

        $icaseReport['investigations'] = self::getReportInfo($invs, new Investigation());
        $icaseReport['conclusions'] = self::getReportInfo($conclusions, new Conclusion());
        $icaseReport['featuresets'] = $featuresetReport;

        $rcache = new Rcache();
        $rcache->icase_id = $id;
        $rcache->rdata = serialize($icaseReport);
        $rcache->save();
        return $icaseReport;
    }


    /**
     * @param $invs
     * @return array
     */
    public static function getReportInfo($invs, $model)
    {
        $invCount = array_count_values($invs);
        $invsReport = collect($invCount)->sortByDesc(null, 0)->all();
        $finalInv = [];
        foreach ($invsReport as $key => $inv) {
            array_push($finalInv, ['id' => $key, 'stat' => $inv, 'perc' => round($inv * 100 / array_sum($invsReport))]);
        }
        $newfinal = [];
        foreach ($finalInv as $final) {
            if($final["perc"] > 2){
                $final["desc"] = $model::find($final["id"])->description;
                array_push($newfinal, $final);
            }
        }
        return $newfinal;
    }

    private static function getGlobalSlideById($globalSlides, $id)
    {
        foreach ($globalSlides as $globalSlide) {
            if ($globalSlide->id == $id) {
                return $globalSlide;
            }
        }
        return null;
    }

    public static function generateAnswersForIcase($icaseId)
    {
        $users = User::where("username", '!=', 'admin')->get();
        $icase = Icase::find($icaseId);

        $take = 8;
        $invs = Investigation::take($take)->get();
        $concs = Conclusion::take($take)->get();
        $feat = Feature::take($take)->get();

        //lets give weights to investigation
        foreach ($users as $user) {
            //pick a random number of investigations to be picked
            $invnumber      = rand(2, 5);
            $selectedInvs   = $invs->random($invnumber);
            $invnumber      = rand(2, 5);
            $selectedConcs  = $concs->random($invnumber);


            $fs = [];
            foreach ($icase->slides as $slide) {
                $invnumber      = rand(2, 5);
                $selectedfeat   = $feat->random($invnumber);
                array_push($fs, ["slide" => $slide, "features" => $selectedfeat]);
            }
            $submission = self::submitAnswers($user, $icase, $selectedInvs, $selectedConcs, $fs, true);
        }
        return $submission;
    }

    public static function getEntity($index, $myArray)
    {
        foreach ($myArray as $i => $item) {
            if ($index === $i) {
                return $myArray[$i];
            }
        }
    }
}