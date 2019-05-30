<?php

use App\Campaign;
use App\Conclusion;
use App\Feature;
use App\Featureset;
use App\Http\Services\ICasesService;
use App\Http\Services\UtilsService;
use App\Icase;
use App\Investigation;
use App\Models\User;
use App\Rcache;
use App\Slide;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: kebler
 * Date: 16/01/19
 * Time: 00:33
 */

class TestICases extends TestCase
{

    use DatabaseMigrations;

    public function testInteractiveCases()
    {
        /*
         * So welcome to interactive cases - structure of test
         * creator creates an IC
         * creator associates slides to IC
         *
         * user creates a submission for an IC
         * submission contains morphological
         *
         */

        //seed db with users
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();
        $user4 = factory(User::class)->create();
        $user5 = factory(User::class)->create();
        $user6 = factory(User::class)->create();
        $user7 = factory(User::class)->create();
        $user8 = factory(User::class)->create();
        $user9 = factory(User::class)->create();
        $user10 = factory(User::class)->create();
        $joker = factory(User::class)->create();

        // seed db with investigations
        $inv1 = factory(Investigation::class)->create();
        $inv2 = factory(Investigation::class)->create();
        $inv3 = factory(Investigation::class)->create();
        $inv4 = factory(Investigation::class)->create();
        $inv5 = factory(Investigation::class)->create();
        $inv6 = factory(Investigation::class)->create();
        $inv7 = factory(Investigation::class)->create();
        $inv8 = factory(Investigation::class)->create();
        $inv9 = factory(Investigation::class)->create();
        $inv10 = factory(Investigation::class)->create();
        $inv11 = factory(Investigation::class)->create();
        $inv12 = factory(Investigation::class)->create();
        $inv13 = factory(Investigation::class)->create();


        //seed db with conclusions
        $conc1 = factory(Conclusion::class)->create();
        $conc2 = factory(Conclusion::class)->create();
        $conc3 = factory(Conclusion::class)->create();
        $conc4 = factory(Conclusion::class)->create();
        $conc5 = factory(Conclusion::class)->create();
        $conc6 = factory(Conclusion::class)->create();
        $conc7 = factory(Conclusion::class)->create();
        $conc8 = factory(Conclusion::class)->create();
        $conc9 = factory(Conclusion::class)->create();
        $conc10 = factory(Conclusion::class)->create();
        $conc11 = factory(Conclusion::class)->create();
        $conc12 = factory(Conclusion::class)->create();
        $conc13 = factory(Conclusion::class)->create();


        //seed db with features
        $feature1 = factory(Feature::class)->create();
        $feature2 = factory(Feature::class)->create();
        $feature3 = factory(Feature::class)->create();
        $feature4 = factory(Feature::class)->create();
        $feature5 = factory(Feature::class)->create();
        $feature6 = factory(Feature::class)->create();
        $feature7 = factory(Feature::class)->create();
        $feature8 = factory(Feature::class)->create();
        $feature9 = factory(Feature::class)->create();
        $feature10 = factory(Feature::class)->create();
        $feature11 = factory(Feature::class)->create();
        $feature12 = factory(Feature::class)->create();
        $feature13 = factory(Feature::class)->create();




        $creator = factory(User::class)->create();
        $icase = factory(Icase::class)->make();
        $icase->user()->associate($creator);
        $icase->save();
        $this->assertEquals(1, count(User::find($creator->id)->icases));

        $slide = factory(Slide::class)->make();
        $slide->icase()->associate($icase);
        $slide->save();
        $slide1 = factory(Slide::class)->make();
        $slide1->icase()->associate($icase);
        $slide1->save();
        $slide2 = factory(Slide::class)->make();
        $slide2->icase()->associate($icase);
        $slide2->save();
        $this->assertEquals(3, count(Icase::find($icase->id)->slides));

        // a users who makes a submission to an IC

        ICasesService::submitAnswers($user1, $icase,
            [$inv1, $inv2, $inv3, $inv4, $inv5],
            [$conc3, $conc4, $conc6, $conc7, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature1, $feature2, $feature6, $feature8, $feature10]],
                ['slide'=> $slide1, 'features' => [$feature1, $feature2, $feature6, $feature8, $feature10]],
                ['slide'=> $slide2, 'features' => [$feature1, $feature2, $feature6, $feature8, $feature10]]
            ], true);


        // user submits again and override last submission.
        ICasesService::submitAnswers($user1, $icase,
            [$inv1, $inv2, $inv3, $inv4, $inv5],
            [$conc3, $conc4, $conc6, $conc7, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature1, $feature3, $feature7, $feature9, $feature11]],
                ['slide'=> $slide1, 'features' => [$feature1, $feature3, $feature7, $feature9, $feature11]],
                ['slide'=> $slide2, 'features' => [$feature1, $feature3, $feature7, $feature9, $feature11]]
            ], true);

        $getUser = User::find($user1->id);
        $this->assertEquals(1, count($getUser->submissions));
        $this->assertEquals(3, count(Featureset::all()));

        ICasesService::submitAnswers($user2, $icase,
            [$inv1, $inv3, $inv5, $inv7],
            [$conc4, $conc5, $conc6, $conc7, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature1, $feature7, $feature8, $feature12]],
                ['slide'=> $slide1, 'features' => [$feature1, $feature7, $feature9, $feature12]],
                ['slide'=> $slide2, 'features' => [$feature1, $feature7, $feature9, $feature12]]
            ], true);
        ICasesService::submitAnswers($user3, $icase,
            [$inv2, $inv3, $inv4],
            [$conc6, $conc7, $conc9, $conc10, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature4, $feature7, $feature9, $feature11]],
                ['slide'=> $slide1, 'features' => [$feature4, $feature7, $feature9, $feature11, $feature12]],
                ['slide'=> $slide2, 'features' => [$feature4, $feature7, $feature9, $feature11, $feature12]]
            ], true);
        ICasesService::submitAnswers($user4, $icase,
            [$inv9, $inv10, $inv11, $inv12, $inv13],
            [$conc1, $conc4, $conc5, $conc7, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature5, $feature7, $feature11, $feature12, $feature13]],
                ['slide'=> $slide1, 'features' => [$feature7, $feature9, $feature11, $feature12]],
                ['slide'=> $slide2, 'features' => [$feature7, $feature9, $feature11, $feature12]]
            ], true);
        ICasesService::submitAnswers($user5, $icase,
            [$inv5, $inv7],
            [$conc5, $conc7, $conc12, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature7, $feature9]],
                ['slide'=> $slide1, 'features' => [$feature7, $feature9, $feature12]],
                ['slide'=> $slide2, 'features' => [$feature7, $feature9, $feature12]]
            ], true);
        ICasesService::submitAnswers($user6, $icase,
            [$inv4, $inv5, $inv6, $inv7, $inv8],
            [$conc4, $conc5, $conc6, $conc7, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature4, $feature5, $feature6, $feature7]],
                ['slide'=> $slide1, 'features' => [$feature4, $feature5, $feature7, $feature9, $feature12]],
                ['slide'=> $slide2, 'features' => [$feature4, $feature5, $feature7, $feature9, $feature12]]
            ], true);
        ICasesService::submitAnswers($user7, $icase,
            [$inv1, $inv4, $inv7, $inv10, $inv13],
            [$conc4, $conc7, $conc10, $conc12],
            [
                ['slide'=> $slide,  'features' => [$feature1, $feature7, $feature10, $feature13]],
                ['slide'=> $slide1, 'features' => [$feature7, $feature9, $feature12, $feature13]],
                ['slide'=> $slide2, 'features' => [$feature7, $feature9, $feature12, $feature13]]
            ], true);
        ICasesService::submitAnswers($user8, $icase,
            [$inv1, $inv6, $inv7, $inv8, $inv9],
            [$conc5, $conc6, $conc7, $conc9, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature7, $feature9]],
                ['slide'=> $slide1, 'features' => [$feature7, $feature9]],
                ['slide'=> $slide2, 'features' => [$feature7, $feature9]]
            ], true);
        ICasesService::submitAnswers($user9, $icase,
            [$inv4, $inv6, $inv9, $inv11, $inv12],
            [$conc4, $conc5, $conc10, $conc12, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature7, $feature9, $feature12]],
                ['slide'=> $slide1, 'features' => [$feature7, $feature9, $feature12]],
                ['slide'=> $slide2, 'features' => [$feature7, $feature9, $feature12]]
            ], true);
        ICasesService::submitAnswers($user10,$icase,
            [$inv1, $inv4, $inv8, $inv11, $inv12],
            [$conc4, $conc8, $conc11, $conc12, $conc13],
            [
                ['slide'=> $slide,  'features' => [$feature4, $feature7, $feature10, $feature12, $feature13]],
                ['slide'=> $slide1, 'features' => [$feature4, $feature7, $feature10, $feature12, $feature13]],
                ['slide'=> $slide2, 'features' => [$feature4, $feature7, $feature10, $feature12, $feature13]]
            ], true);

        // joker saves an answer but never submits, shouldn effect the reports
        ICasesService::submitAnswers($joker,$icase,
            [$inv2, $inv3, $inv7, $inv10, $inv9],
            [$conc3, $conc7, $conc10, $conc11, $conc12],
            [
                ['slide'=> $slide,  'features' => [$feature3, $feature4, $feature5, $feature6, $feature7]],
                ['slide'=> $slide1, 'features' => [$feature5, $feature6, $feature9, $feature11, $feature12]],
                ['slide'=> $slide2, 'features' => [$feature4, $feature7, $feature10, $feature12, $feature13]]
            ], false);


        $this->assertEquals(10, count(Icase::find($icase->id)->submissions()->where('finilised', true)->get()));

        $report = ICasesService::getReport($icase->id);
        $this->assertEquals(4, $report['investigations'][0]['id']);
        $this->assertEquals(6, $report['investigations'][0]['stat']);
        $this->assertEquals(1, $report['investigations'][1]['id']);
        $this->assertEquals(5, $report['investigations'][1]['stat']);
        $this->assertEquals(7, $report['investigations'][2]['id']);
        $this->assertEquals(5, $report['investigations'][2]['stat']);
        $this->assertEquals(5, $report['investigations'][3]['id']);
        $this->assertEquals(4, $report['investigations'][3]['stat']);
        $this->assertEquals(3, $report['investigations'][4]['id']);
        $this->assertEquals(3, $report['investigations'][4]['stat']);


        $this->assertEquals(13,$report['conclusions'][0]['id']);
        $this->assertEquals(9, $report['conclusions'][0]['stat']);
        $this->assertEquals(7, $report['conclusions'][1]['id']);
        $this->assertEquals(8, $report['conclusions'][1]['stat']);
        $this->assertEquals(4, $report['conclusions'][2]['id']);
        $this->assertEquals(7, $report['conclusions'][2]['stat']);
        $this->assertEquals(5, $report['conclusions'][3]['id']);
        $this->assertEquals(6, $report['conclusions'][3]['stat']);
        $this->assertEquals(6, $report['conclusions'][4]['id']);
        $this->assertEquals(5, $report['conclusions'][4]['stat']);

        $this->assertEquals(3, count($report['featuresets']));

        $slide1Features = $this->getFeaturesetBySlideId($report['featuresets'], $slide->id);

        $this->assertEquals(7,$slide1Features[0]['id']);
        $this->assertEquals(10, $slide1Features[0]['stat']);
        $this->assertEquals(9, $slide1Features[1]['id']);
        $this->assertEquals(5, $slide1Features[1]['stat']);
        $this->assertEquals(12, $slide1Features[2]['id']);
        $this->assertEquals(4   , $slide1Features[2]['stat']);


        $slide1Features = $this->getFeaturesetBySlideId($report['featuresets'], $slide1->id);

        $this->assertEquals(7,$slide1Features[0]['id']);
        $this->assertEquals(10, $slide1Features[0]['stat']);
        $this->assertEquals(9, $slide1Features[1]['id']);
        $this->assertEquals(9, $slide1Features[1]['stat']);
        $this->assertEquals(12, $slide1Features[2]['id']);
        $this->assertEquals(8, $slide1Features[2]['stat']);


        $rcache = Rcache::where('icase_id', $icase->id)->get();
        $this->assertEquals(1, count($rcache));

        //this should come from cache
        $report = ICasesService::getReport($icase->id);
        $this->assertEquals(4, $report['investigations'][0]['id']);
        $this->assertEquals(6, $report['investigations'][0]['stat']);
        $this->assertEquals(1, $report['investigations'][1]['id']);
        $this->assertEquals(5, $report['investigations'][1]['stat']);
        $this->assertEquals(7, $report['investigations'][2]['id']);
        $this->assertEquals(5, $report['investigations'][2]['stat']);
        $this->assertEquals(5, $report['investigations'][3]['id']);
        $this->assertEquals(4, $report['investigations'][3]['stat']);
        $this->assertEquals(3, $report['investigations'][4]['id']);
        $this->assertEquals(3, $report['investigations'][4]['stat']);


        $this->assertEquals(13,$report['conclusions'][0]['id']);
        $this->assertEquals(9, $report['conclusions'][0]['stat']);
        $this->assertEquals(7, $report['conclusions'][1]['id']);
        $this->assertEquals(8, $report['conclusions'][1]['stat']);
        $this->assertEquals(4, $report['conclusions'][2]['id']);
        $this->assertEquals(7, $report['conclusions'][2]['stat']);
        $this->assertEquals(5, $report['conclusions'][3]['id']);
        $this->assertEquals(6, $report['conclusions'][3]['stat']);
        $this->assertEquals(6, $report['conclusions'][4]['id']);
        $this->assertEquals(5, $report['conclusions'][4]['stat']);

        $this->assertEquals(3, count($report['featuresets']));

        $slide1Features = $this->getFeaturesetBySlideId($report['featuresets'], $slide->id);

        $this->assertEquals(7,$slide1Features[0]['id']);
        $this->assertEquals(10, $slide1Features[0]['stat']);
        $this->assertEquals(9, $slide1Features[1]['id']);
        $this->assertEquals(5, $slide1Features[1]['stat']);
        $this->assertEquals(12, $slide1Features[2]['id']);
        $this->assertEquals(4   , $slide1Features[2]['stat']);


        $slide1Features = $this->getFeaturesetBySlideId($report['featuresets'], $slide1->id);

        $this->assertEquals(7,$slide1Features[0]['id']);
        $this->assertEquals(10, $slide1Features[0]['stat']);
        $this->assertEquals(9, $slide1Features[1]['id']);
        $this->assertEquals(9, $slide1Features[1]['stat']);
        $this->assertEquals(12, $slide1Features[2]['id']);
        $this->assertEquals(8, $slide1Features[2]['stat']);

    }

    private function getFeaturesetBySlideId($featuresetArray, $id)
    {
        foreach ($featuresetArray as $featureset) {
            if ($featureset['slideId'] == $id) {
                return $featureset['features'];
            }
        }
        return null;
    }

    public function testImportFeatures()
    {
        $this->assertEquals(0, count(Feature::all()));
        $this->assertEquals(0, count(Investigation::all()));
        $this->assertEquals(0, count(Conclusion::all()));
        UtilsService::importFeatures("interactive.csv");
        $this->assertEquals(true, count(Feature::all()) > 0);
        $this->assertEquals(true, count(Investigation::all()) > 0 );
        $this->assertEquals(true, count(Conclusion::all()) > 0);
    }


    public function testGenerateAnswersForIcase()
    {
        factory(User::class, 200)->create();
        factory(Investigation::class, 100)->create();
        factory(Conclusion::class, 100)->create();
        factory(Feature::class, 100)->create();

        $creator = factory(User::class)->create();
        $icase = factory(Icase::class)->make();
        $icase->user()->associate($creator);
        $icase->save();

        $slides = factory(Slide::class, 3)->create();
        $icase->slides()->saveMany($slides);
        $this->assertEquals(3, count(Icase::find($icase->id)->slides));

        ICasesService::generateAnswersForIcase($icase->id);
        $report  = ICasesService::getReport($icase->id);
        $this->assertEquals(true, isset($report));
    }


    public function testCreateCampaigns()
    {
        $icase = $this->createIcase();

        $campaign1 = new Campaign();
        $campaign2 = new Campaign();
        $campaigns = [$campaign1, $campaign2];
        $icase->campaigns()->saveMany($campaigns);
        $icaseSaved = Icase::find($icase->id);
        $this->assertEquals(2, count($icaseSaved->campaigns));
    }

    /**
     * @return mixed
     */
    public function createIcase()
    {
        factory(User::class, 10)->create();
        factory(Investigation::class, 5)->create();
        factory(Conclusion::class, 4)->create();
        factory(Feature::class, 5)->create();

        $creator = factory(User::class)->create();
        $icase = factory(Icase::class)->make();
        $icase->user()->associate($creator);
        $icase->save();
        return $icase;
    }

}