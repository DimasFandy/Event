<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Event; // Assuming you need this to interact with the Event model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create_kategori'])->only(['create', 'store']);
        $this->middleware(['permission:edit_kategori'])->only(['edit', 'show']);
        $this->middleware(['permission:read_kategori'])->only(['read', 'show']);
        $this->middleware(['permission:delete_kategori'])->only(['destroy', 'delete']);
    }

    // Menampilkan semua kategori
    public function index()
    {
        $kategoris = Kategori::paginate(10);
        $filteredData = Event::all(); // Sesuaikan query untuk mendapatkan event yang diperlukan
        return view('admin.kategori.index', compact('kategoris', 'filteredData'));
    }

    // Menampilkan form untuk membuat kategori baru
    public function create()
    {
        return view('admin.kategori.create');
    }

    // Menyimpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weight' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan detail kategori
    public function show(Kategori $kategori)
    {
        return view('admin.kategoris.show', compact('kategori'));
    }

    // Menampilkan form untuk mengedit kategori
    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    // Memperbarui kategori
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weight' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus kategori
    public function destroy(Kategori $kategori)
    {
        // Mengubah status kategori menjadi 'inactive'
        $kategori->update(['status' => 'inactive']);
        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus!');
    }

    // Reactivate category (update status to active)
    public function reactivate(Kategori $kategori)
    {
        if ($kategori->status == 'inactive') {
            $kategori->update(['status' => 'active']);
            return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diaktifkan kembali!');
        }

        return redirect()->route('kategoris.index')->with('error', 'Kategori sudah dalam status aktif.');
    }

    // Mendapatkan data dropdown (kategori dan events)
    public function getDropdownData(Request $request)
    {
        try {
            // Ambil data kategori
            $categories = DB::table('kategori')
                ->select('id', 'name')
                ->get();

            // Ambil data events
            $events = Event::select('id', 'name')
                ->get();

            // Gabungkan kategori dan events dalam satu array
            $data = $categories->merge($events);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Mendapatkan data yang sudah difilter berdasarkan kategori
    public function getFilteredData(Request $request)
    {
        try {
            $values = $request->input('values', []);

            if (empty($values)) {
                return response()->json(['error' => 'No values provided'], 400);
            }

            // Ambil data berdasarkan filter
            $kategoris = Kategori::whereIn('id', $values)->get();

            // Render view untuk tabel
            $html = view('partials.kategori_table', compact('kategoris'))->render();

            return response()->json(['html' => $html]);
        } catch (\Exception $e) {
            \Log::error('Error in getFilteredData: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
