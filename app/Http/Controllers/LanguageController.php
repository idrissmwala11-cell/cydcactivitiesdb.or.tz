<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, ['en', 'sw'], true), 404);

        session(['locale' => $locale]);
        app()->setLocale($locale);

        return back();
    }
}
