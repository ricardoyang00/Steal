<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Age;

class AgeController extends Controller
{
    public function show($id)
    {
        $age = Age::find($id);
        return view('pages.age', ['age' => $age]);
    }
}
