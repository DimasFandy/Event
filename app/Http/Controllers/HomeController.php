<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Kategori;
// use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    // Show the user home page
    public function home()
    {
        // Ambil data event yang statusnya aktif
        $events = Event::where('status', 'active')->paginate(9); 
        $categories = Kategori::all();
        return view('user.home', compact('events', 'categories'));
    }
}
