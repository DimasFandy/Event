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
        $events = Event::all();
        $members = Member::all();

        // Menghitung jumlah anggota
        $memberCount = $members->count();

        // Menghitung jumlah event
        $eventCount = $events->count();

        // Menghitung jumlah member yang terdaftar untuk event tertentu
        $registeredMembersCount = $events->flatMap(function ($event) {
            return $event->members;
        })->count();

        // Menghitung jumlah event yang sudah selesai (berdasarkan tanggal)
        $completedEventsCount = $events->filter(function ($event) {
            return Carbon::parse($event->date)->isPast();
        })->count();

        // Analisis data - Contoh: jumlah event per bulan
        $eventsPerMonth = $events->groupBy(function ($event) {
            return Carbon::parse($event->date)->format('F Y');
        })->map(function ($group) {
            return $group->count();
        });

        // Data bulan-bulan selanjutnya (next months)
        $nextMonths = collect();
        for ($i = 1; $i <= 3; $i++) {  // Ambil data untuk 3 bulan ke depan
            $nextMonth = Carbon::now()->addMonth($i);
            $monthLabel = $nextMonth->format('F Y');
            $nextMonths[$monthLabel] = $events->filter(function ($event) use ($nextMonth) {
                return Carbon::parse($event->date)->isSameMonth($nextMonth);
            })->count();
        }

        // Data untuk jumlah member terdaftar per event
        $eventsWithMembers = $events->map(function ($event) {
            return [
                'event_name' => $event->name, // Nama event
                'member_count' => $event->members->count(), // Jumlah member terdaftar
                'total_capacity' => $event->capacity, // Misal, menggunakan kapasitas maksimal event
            ];
        });
        // Menghitung persentase peminat per event
        $eventsWithInterestPercentage = $eventsWithMembers->map(function ($event) {
            $percentage = ($event['member_count'] / max($event['total_capacity'], 1)) * 100; // Hindari pembagian dengan 0
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
            'events',
            'kategoris',
            'nextMonths',
            'eventsWithMembers',
            'eventsWithInterestPercentage'
        ));
    }
}
