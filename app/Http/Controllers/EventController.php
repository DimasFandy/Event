<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori; // Tambahkan model Kategori
use App\Models\EventMember;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create_event'])->only(['create', 'store']);
        $this->middleware(['permission:edit_event'])->only(['edit', 'update']);
        $this->middleware(['permission:read_event'])->only(['read', 'show']);
        $this->middleware(['permission:delete_event'])->only(['destroy', 'delete']);
        $this->middleware(['permission:export_pdf'])->only(['exportPdf']);
    }

    // Menampilkan daftar event dengan pagination
    public function index(Request $request)
    {
        // Ambil semua kategori untuk dropdown
        $categories = Kategori::all();

        // Mulai query untuk mengambil events dengan relasi kategori dan peserta
        $eventsQuery = Event::with('kategori') // Relasi kategori
            ->with('members'); // Relasi members (peserta)

        // Filter berdasarkan kategori_id jika ada
        if ($request->has('kategori_id') && !empty($request->kategori_id)) {
            // Gunakan whereHas untuk memfilter berdasarkan kategori yang ada pada event
            $eventsQuery->whereHas('kategori', function ($query) use ($request) {
                $query->whereIn('kategori.id', $request->kategori_id);
            });
        }

        // Ambil events dengan pagination
        $events = $eventsQuery->paginate(5);

        // Tambahkan jumlah peserta setelah pagination
        $events->getCollection()->transform(function ($event) {
            $event->members_count = $event->members->count(); // Hitung jumlah peserta di setiap event
            return $event;
        });

        // Kembalikan tampilan dengan data kategori dan events
        return view('admin.events.index', compact('events', 'categories'));
    }


    //method untuk halaman user.home
    public function showEvents()
    {
        // Ambil semua events dari database
        $events = Event::all();

        // Kirim data events ke view home.blade.php
        return view('user.home', compact('events'));
    }

    //controller untuk halaman events_details
    // Menampilkan detail event di halaman pengguna
    public function showEventDetail(Event $event)
    {
        // Hitung jumlah peserta yang sudah terdaftar
        $participantCount = $event->members()->count();

        // Kirim data ke view
        return view('user.events_details', compact('event', 'participantCount'));
    }
    // Menampilkan form untuk membuat event baru
    public function create()
    {
        $kategori = Kategori::all(); // Ambil data kategori untuk dropdown
        return view('admin.events.create', compact('kategori'));
    }

    // Menyimpan event baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kategori_id' => 'required|array',
            'kategori_id.*' => 'exists:kategori,id',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);

        // Proses upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events/images', 'public');
        }

        // Menyimpan data event
        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'image_path' => $imagePath, // Simpan path gambar
        ]);

        // Relasi kategori
        $event->kategori()->sync($request->kategori_id);

        return redirect()->route('events.create')->with('success', 'Event berhasil ditambahkan.');
    }


    // Menampilkan form untuk mengedit event
    public function edit(Event $event)
    {
        // Ambil semua kategori untuk dropdown
        $kategori = Kategori::all();

        // Ambil kategori yang terkait dengan event ini
        $selectedCategories = $event->kategori->pluck('id')->toArray(); // Ambil ID kategori yang terpilih

        // Kembalikan tampilan dengan data event, kategori, dan kategori terpilih
        return view('admin.events.edit', compact('event', 'kategori', 'selectedCategories'));
    }


    public function show(Event $event)
    {
        // Ambil peserta yang terdaftar dengan pagination
        $members = $event->members()->paginate(5);  // 5 peserta per halaman, bisa disesuaikan

        // Kirim data event dan peserta ke view
        return view('admin.events.show', compact('event', 'members'));
    }


    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'kategori_id' => 'required|array',
            'kategori_id.*' => 'exists:kategori,id',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($event->image_path) {
                Storage::disk('public')->delete($event->image_path);
            }

            $imagePath = $request->file('image')->store('events/images', 'public');
            $event->image_path = $imagePath; // Perbarui path gambar
        }

        // Perbarui data event
        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        // Sinkronisasi kategori
        $event->kategori()->sync($request->kategori_id);

        return redirect()->route('events.edit', ['event' => $event->id])->with('success', 'Event berhasil diperbarui.');
    }


    public function reactivate(Event $event)
    {
        $event->status = 'active'; // Atau set status lain sesuai kebutuhan
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event berhasil diaktifkan kembali!');
    }

    public function destroy(Event $event)
    {
        $event->status = 'inactive'; // Atau hapus jika diperlukan
        $event->save();

        return redirect()->route('events.index')->with('success', 'Event berhasil dinonaktifkan!');
    }

    public function destroyMember(Request $request, $event_id, $member_id)
    {
        // Cari data event_member dengan event_id dan member_id
        $member = EventMember::where('event_id', $event_id)
            ->where('member_id', $member_id)
            ->first();

        // Log jika data member ditemukan
        \Log::info("Mencari member_id: {$member_id} di event_id: {$event_id}");

        if (!$member) {
            return redirect()->back()->with('error', 'Peserta tidak ditemukan.');
        }

        // Menyimpan alasan penghapusan
        $reason = new Reason();
        $reason->event_id = $event_id;
        $reason->member_id = $member_id;
        $reason->reasons = $request->input('reason');
        $reason->save();

        // Hapus member
        $member->delete();

        return redirect()->route('events.show', $event_id)->with('success', 'Peserta berhasil dihapus.');
    }


    public function getEventsByCategory($categoryId)
    {
        // Ambil events yang terkait dengan kategori tertentu (gunakan kolom 'kategori')
        $events = Event::where('kategori_id', $categoryId)->get();

        // Kembalikan data dalam format JSON
        return response()->json([
            'events' => $events
        ]);
    }

    // controller event_details
    // method untuk menyimpan data ke tabel events_member
    public function register($id, Request $request)
    {
        // Validasi apakah event ada
        $event = Event::findOrFail($id);

        // Cek apakah member sudah mendaftar ke event ini
        $existingRegistration = EventMember::where('event_id', $event->id)
            ->where('member_id', auth('member')->id()) // Ambil ID member dari guard 'member'
            ->first();

        if ($existingRegistration) {
            // Jika sudah mendaftar, tampilkan pesan bahwa member sudah terdaftar
            return redirect()->route('user.events_details', $event->id)
                ->with('error', 'Anda sudah terdaftar untuk event ini.');
        }

        // Simpan data ke tabel events_member
        EventMember::create([
            'event_id' => $event->id,
            'member_id' => auth('member')->id(), // Ambil ID member dari guard 'member'
        ]);

        // Redirect atau tampilkan pesan sukses
        return redirect()->route('user.events_details', $event->id)
            ->with('success', 'Berhasil mendaftar ke event.');
    }
    public function myEvents()
    {
        // Ambil ID member yang sedang login
        $memberId = auth('member')->id();

        // Ambil event di mana pengguna terdaftar sebagai member
        $events = Event::whereHas('members', function ($query) use ($memberId) {
            $query->where('member_id', $memberId);
        })->get();

        // Ambil data member yang login
        $member = auth('member')->user();

        // Kirim data event dan member ke view 'myevent'
        return view('user.myevent', compact('events', 'member'));
    }
    public function exportPdf($event_id)
    {
        $event = Event::with('kategori')->findOrFail($event_id);
        $members = $event->members;

        $pdf = Pdf::loadView('admin.events.pdf', compact('event', 'members'));

        return $pdf->stream('event-detail-' . $event->id . '.pdf');
    }
}
