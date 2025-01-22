<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Query data dengan filter kategori jika ada
        $query = Event::with('kategori');

        // Terapkan filter berdasarkan request (kategori_id)
        if (request()->has('kategori_id')) {
            $query->whereHas('kategori', function ($q) {
                $q->whereIn('id', request('kategori_id'));
            });
        }

        // Ambil data, format, dan kembalikan koleksi
        return $query->get()->map(function ($event) {
            return [
                'id' => $event->id,
                'name' => $event->name,
                'categories' => $event->kategori->pluck('name')->join(', '),
                'description' => $event->description,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                'status' => $event->status,
                'members_count' => $event->members_count ?? 0,
            ];
        });
    }

    /**
     * Menentukan header kolom untuk file Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Event',
            'Kategori',
            'Deskripsi',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
            'Jumlah Peserta',
        ];
    }
}
