<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\EventMember; // Pastikan Anda memiliki model ini untuk relasi antara member dan event
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    // Ambil data umum
    $kategoris = Kategori::all();
    $events = Event::with('members')->get(); // Pastikan relasi dengan members dimuat
    $members = Member::all();

    // Menghitung jumlah anggota
    $memberCount = $members->count();

    // Menghitung jumlah event
    $eventCount = $events->count();

    $latestEvents = Event::orderBy('created_at', 'desc')->take(5)->get();

    // Menghitung jumlah member yang terdaftar untuk event tertentu
    $registeredMembersCount = $events->flatMap(function ($event) {
        return $event->members;
    })->count();

    // Menghitung jumlah event yang sudah selesai (berdasarkan tanggal)
    $completedEventsCount = $events->filter(function ($event) {
        return Carbon::parse($event->date)->isPast();
    })->count();

    // Analisis data - Jumlah event per bulan
    $eventsPerMonth = $events->groupBy(function ($event) {
        return Carbon::parse($event->date)->format('F Y');
    })->map(function ($group) {
        return $group->count();
    });

    // Data jumlah members yang terdaftar per bulan
    $membersPerMonth = $events->groupBy(function ($event) {
        return Carbon::parse($event->date)->format('F Y');
    })->map(function ($group) {
        return $group->flatMap(function ($event) {
            return $event->members;
        })->count();
    });

    // Data bulan-bulan selanjutnya (next months)
    $nextMonths = collect();
    $nextMembers = collect(); // Tambahkan variabel untuk jumlah member bulan mendatang
    for ($i = 1; $i <= 3; $i++) {  // Ambil data untuk 3 bulan ke depan
        $nextMonth = Carbon::now()->addMonth($i);
        $monthLabel = $nextMonth->format('F Y');

        // Jumlah event bulan mendatang
        $nextMonths[$monthLabel] = $events->filter(function ($event) use ($nextMonth) {
            return Carbon::parse($event->date)->isSameMonth($nextMonth);
        })->count();

        // Jumlah member bulan mendatang
        $nextMembers[$monthLabel] = $events->filter(function ($event) use ($nextMonth) {
            return Carbon::parse($event->date)->isSameMonth($nextMonth);
        })->flatMap(function ($event) {
            return $event->members;
        })->count();
    }

    // Data untuk jumlah member terdaftar per event
    $eventsWithMembers = $events->map(function ($event) {
        return [
            'event_name' => $event->name,
            'member_count' => $event->members->count(),
            'total_capacity' => $event->capacity,
        ];
    });

    // Menghitung persentase peminat per event
    $eventsWithInterestPercentage = $eventsWithMembers->map(function ($event) {
        $percentage = ($event['member_count'] / max($event['total_capacity'], 1)) * 100;
        return [
            'event_name' => $event['event_name'],
            'interest_percentage' => round($percentage, 2),
        ];
    });

    // Kirim data ke view
    return view('admin.dashboard', compact(
        'memberCount',
        'eventCount',
        'registeredMembersCount',
        'completedEventsCount',
        'eventsPerMonth',
        'membersPerMonth', // Kirim data members per bulan
        'events',
        'kategoris',
        'nextMonths',
        'nextMembers', // Kirim data jumlah member bulan mendatang
        'eventsWithMembers',
        'eventsWithInterestPercentage',
        'latestEvents'
    ));
}

}
