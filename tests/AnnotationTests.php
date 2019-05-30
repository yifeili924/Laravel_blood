<?php

use App\Annotation;
use App\Http\Services\UtilsService;
use App\Slide;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Created by PhpStorm.
 * User: kebler
 * Date: 07/12/18
 * Time: 17:12
 */

class AnnotationTests extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function testRetrieveAnnotatinos()
    {
        $slide = new Slide();
        $slide->name = "image.dzi";
        $slide->bucket_name = "s3Bucket";
        $slide->save();

        $slideId = 1;
        $annoText = "Annotation Test text";
        $annoXCoord = "6.3232";
        $annoYCoord = "0.334324";
        $annoZoom = "1.232";
        $userId = 1;

        UtilsService::saveAnnotation($slideId, $annoText, $annoXCoord, $annoYCoord, $annoZoom, $userId, "");

        $slideId = 1;
        $annoText = "Annotation Test text 2";
        $annoXCoord = "4.3232";
        $annoYCoord = "-2.334324";
        $annoZoom = "2.232";
        $userId = 2;
        UtilsService::saveAnnotation($slideId, $annoText, $annoXCoord, $annoYCoord, $annoZoom, $userId, "");

        $newSlide = Slide::find($slideId);

        $this->assertEquals(2, count($newSlide->annotations));
        $annotation = Annotation::find(1);
        $this->assertEquals("s3Bucket", $annotation->slide->bucket_name);

    }

}