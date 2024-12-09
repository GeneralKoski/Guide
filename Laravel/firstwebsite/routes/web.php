<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/contact/{fullname}', function ($fullname) {
    return $fullname;
});

Route::get('/test', function () {
    return "This is a test!";
})->name("testpage");

Route::prefix('portfolio')->group(function () {
    Route::get('', function () {
        return view('portfolio');
    });

    Route::get('company', function () {
        return view('company');
    });

    Route::get('organization', function () {
        return view('organization');
    });
});