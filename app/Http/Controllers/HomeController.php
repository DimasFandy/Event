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
        $events = Event::where('status', 'active')->get();
        $categories = Kategori::all();
        return view('user.home', compact('events', 'categories'));
    }
    // Show events by category
    public function showCategoryEvents($categoryId)
    {
        // Cari kategori berdasarkan ID
        $category = Kategori::findOrFail($categoryId);
// dd($category);
        // Ambil events yang terhubung dengan kategori ini dan memiliki status 'active'
        $events = $category->events()->where('status', 'active')->get();

        // Kirim data kategori dan events ke view
        return view('user.event.view', compact('events', 'category'));
    }

}
