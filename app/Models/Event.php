<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional jika tabel mengikuti konvensi Laravel)
    protected $table = 'events';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'kategori_id',
        'status',
        'image_path'
    ];

    // Relasi banyak ke banyak dengan Criteria
    // Relasi many-to-many dengan Kategori
    public function kategori()
    {
        return $this->belongsToMany(Kategori::class, 'event_kategori', 'event_id', 'kategori_id');
    }
    public function members()
    {
        return $this->belongsToMany(Member::class, 'events_member', 'event_id', 'member_id');
    }

    public function getMembersCountAttribute()
    {
        return $this->members()->count();
    }
}
