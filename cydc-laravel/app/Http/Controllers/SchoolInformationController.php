<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolInformationController extends Controller
{
    public function primary()
    {
        return view('school-info.primary');
    }

    public function secondary()
    {
        return view('school-info.secondary');
    }

    public function aLevel()
    {
        return view('school-info.a-level');
    }

    public function university()
    {
        return view('school-info.university');
    }

    public function college()
    {
        return view('school-info.college');
    }

    public function vocationalTraining()
    {
        return view('school-info.vocational-training');
    }

    public function others()
    {
        return view('school-info.others');
    }
}
