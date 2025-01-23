<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
// use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    // Show the user home page
    public function home()
    {

        // Ambil data event untuk ditampilkan
        $events = Event::all();

        return view('user.home', compact('events'));
    }
}
