<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;

class PagesController extends Controller
{
    public function about(): View
    {
        $title = 'About';
        return view('pages.about', compact('title'));
    }

    public function blog(): View
    {
        $title = 'Blog';
        return view('pages.blog', compact('title'));
    }

    public function contact(): View
    {
        $title = 'Contact';
        return view('pages.contact', compact('title'));
    }

    public function staff(): View
    {
        $staff = User::paginate(10);
        $title = 'Staff';
        return view('pages.staff', compact('staff', 'title'));
    }
}