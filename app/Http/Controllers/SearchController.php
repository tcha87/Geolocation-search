<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use App\Airport;

class SearchController extends Controller
{
    
     public function search(Request $request)
    {
       
        $error = ['error' => 'No results found, please try with different keywords.'];

     
        if($request->has('q')) {

           

            $airports = Airport::search($request->get('q'))->get();

           return View::make('results')->with('airports', $airports);

          
    

        }

    
        return $error;
    }
}
