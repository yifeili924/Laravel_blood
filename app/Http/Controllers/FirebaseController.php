<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class FirebaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fb = new App\FB();
        $firebase = $fb->connect_firebase();
        $key = "371";
        $comments = $fb->update_seen($firebase, $key, "24");
        print_r($comments);
    }

}