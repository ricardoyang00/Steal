<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\FAQ;
use App\Models\Contacts;
use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function about()
    {
        $abouts = About::all();
        return view('pages.about', ['abouts' => $abouts]);
    }

    public function faqs()
    {
        $faqs = FAQ::all();
        return view('pages.faqs', ['faqs' => $faqs]);
    }

    public function contact()
    {   
        $contacts = Contacts::all();
        return view('pages.contact', ['contacts' => $contacts]);
    }
}
