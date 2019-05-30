<?php
/**
 * Created by PhpStorm.
 * User: iku
 * Date: 2019-03-17
 * Time: 5:48 AM
 */

namespace App;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class FB
{
    public function connect_firebase()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/bloody.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://bloody-24014.firebaseio.com/')
            ->create();
        return $firebase;

    }

    public function add_user_to_fb($firebase, $key, $data)
    {
        $database = $firebase->getDatabase();

        $newPost = $database
            ->getReference('users/' . $key)
            ->set($data);
    }

    public function add_comment_to_user($firebase, $key, $data)
    {
        $database = $firebase->getDatabase();
        $newPost = $database
            ->getReference('users/' . $key . '/comments')->push($data);
    }

    public function read_comments($firebase, $key)
    {
        $database = $firebase->getDatabase();

        $comments_snapshots = $database->getReference('users/' . $key . '/comments')->getSnapshot();
        // get comments of blog
        if ($comments_snapshots->getValue() != "") {
            $comments = $comments_snapshots->getValue();
            foreach ($comments as $key => $row) {
                $comments_date_time[$key] = $row['time']['date'];
            }
            array_multisort($comments_date_time, SORT_DESC, $comments);

        } else {
            $comments = array();

        }
        return $comments;

//        $blog_comments_snapshots = $database->getReference('users/' . $key . '/comments/blog')->getSnapshot();
//        $morph_comments_snapshots = $database->getReference('users/' . $key . '/comments/morph')->getSnapshot();
//        $figure_comments_snapshots = $database->getReference('users/' . $key . '/comments/figure')->getSnapshot();
//        $guidline_comments_snapshots = $database->getReference('users/' . $key . '/comments/guidline')->getSnapshot();
//
//        // get comments of blog
//        if ($blog_comments_snapshots->getValue() != "") {
//            $blog_comments = $blog_comments_snapshots->getValue();
//            foreach ($blog_comments as $key => $row) {
//                $blog_comments_date_time[$key] = $row['time']['date'];
//            }
//            array_multisort($blog_comments_date_time, SORT_DESC, $blog_comments);
//
//        } else {
//            $blog_comments = array();
//
//        }
//        // get comments of morph
//        if ($morph_comments_snapshots->getValue() != "") {
//            $morph_comments = $morph_comments_snapshots->getValue();
//            foreach ($morph_comments as $key => $row) {
//                $morph_comments_date_time[$key] = $row['time']['date'];
//            }
//            array_multisort($morph_comments_date_time, SORT_DESC, $morph_comments);
//
//        } else {
//            $morph_comments = array();
//
//        }
//        // get comments of figure
//        if ($figure_comments_snapshots->getValue() != "") {
//            $figure_comments = $figure_comments_snapshots->getValue();
//            foreach ($figure_comments as $key => $row) {
//                $figure_comments_date_time[$key] = $row['time']['date'];
//            }
//            array_multisort($figure_comments_date_time, SORT_DESC, $figure_comments);
//
//        } else {
//            $figure_comments = array();
//
//        }
//        // get comments of guidline
//        if ($guidline_comments_snapshots->getValue() != "") {
//            $guidline_comments = $guidline_comments_snapshots->getValue();
//            foreach ($guidline_comments as $key => $row) {
//                $guidline_comments_date_time[$key] = $row['time']['date'];
//            }
//            array_multisort($guidline_comments_date_time, SORT_DESC, $guidline_comments);
//
//        } else {
//            $guidline_comments = array();
//
//        }
//
//        return array('blog' => $blog_comments, 'morph' => $morph_comments, 'figure' => $figure_comments, 'guidline' => $guidline_comments);

    }

    public function update_seen($firebase, $key, $blogid, $sample_type)
    {
        $database = $firebase->getDatabase();
        $comments_snapshots = $database->getReference('users/' . $key . '/comments')->getSnapshot();
        if ($comments_snapshots->getValue() != "") {
            foreach ($comments_snapshots->getValue() as $comment_key => $ele) {
                if ($ele['blogid'] == $blogid && $ele['sample_type'] == $sample_type) {
                    $database->getReference('users/' . $key . '/comments/' . $comment_key)->update([
                        'blogid' => $ele['blogid'],
                        'commentid' => $ele['commentid'],
                        'content' => $ele['content'],
                        'time' => $ele['time'],
                        'sample_type' => $ele['sample_type'],
                        'seen' => "1"
                    ]);
                }
            }
        }

    }
}