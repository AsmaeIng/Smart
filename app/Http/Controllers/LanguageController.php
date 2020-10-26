<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    // set locale in session
    public function swap($locale){
        // available language in template array
        $availLocale = [ 
            'en'=>'en',
            'fr'=>'fr',
            'de'=>'de',
            'pt'=>'pt',
        ];
        // check for existing language
        if (array_key_exists($locale, $availLocale)) {
            session()->put('locale', $locale);
        }
        return redirect()->back();
    }
}
