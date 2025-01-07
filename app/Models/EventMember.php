<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMember extends Model
{
    use HasFactory;

    protected $table = 'events_member';
    protected $fillable = ['event_id', 'member_id'];

     // Relasi ke tabel members
     public function member()
     {
         return $this->belongsTo(Member::class, 'member_id');
     }

     // Relasi ke tabel events
     public function event()
     {
         return $this->belongsTo(Event::class, 'event_id');
     }
}
