<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $kategoris = Kategori::all(); // Fetch all categories from the database
    $events = Event::all(); // Fetch all events from the database
    $members = Member::all(); // Fetch all members from the database

    // If the user is not logged in, redirect to the login page with a message
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'You need to login first');
    }

    // If the user is logged in, pass data to the dashboard view
    return view('admin.dashboard', compact('events', 'kategoris', 'members'));
}

}
