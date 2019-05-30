<?php

namespace App\Http\Services;
use DB;

class GuidelineService {

    public static function getPublished() {
        $results = DB::select('SELECT * FROM guidelines where draft = 0 or draft is NULL');
        return $results;
    }

    public static function getDrafts() {
        $results = DB::select('SELECT * FROM guidelines where draft = 1');
        return $results;
    }

    /**
     * @param $id
     * @param $title
     * @param $summary
     * @param $references
     * @param $category
     * @param $draft
     */
    public static function updateGuideline($id, $title, $summary, $references, $category, $draft)
    {
        DB::table("guidelines")
            ->where("id", $id)
            ->update([
                "title" => $title,
                "summary" => $summary,
                "reference" => $references,
                "category" => $category,
                "draft" => $draft]);
    }

    /**
     * @param $title
     * @param $summary
     * @param $references
     * @param $category
     * @param $draft
     */
    public static function insertGuideline($title, $summary, $references, $category, $draft)
    {
        DB::insert('insert into guidelines (title, summary, reference, category, draft) values (?, ?, ?, ?, ?)',
            [$title,
                $summary,
                $references,
                $category,
                $draft]);
    }

    /**
     * @param $r_id
     */
    public static function deleteGuideline($r_id) {
        DB::table('guidelines')->where('id', '=', $r_id)->delete();
    }

}
