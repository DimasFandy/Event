<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional jika tabel mengikuti konvensi Laravel)
    protected $table = 'kategori';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'name', 'description', 'weight', 'status'
    ];

    // Relasi banyak ke banyak dengan Event
      // Relasi many-to-many dengan Event
      public function events()
      {
          return $this->belongsToMany(Event::class, 'event_kategori', 'kategori_id', 'event_id');
      }
}
