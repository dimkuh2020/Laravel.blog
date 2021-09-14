<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
   public function index()
   {

        /*$tag = new Tag(); // проверка slug
        $tag->title = 'Привет мир!';
        $tag->save();*/

       return view('admin.index');
   }
}
