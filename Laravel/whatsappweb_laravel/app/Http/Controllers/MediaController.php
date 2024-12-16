<?php

namespace App\Http\Controllers;

use App\Models\Media;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medias = Media::all();
        return view('medias.index', ['medias' => $medias]);
    }
}