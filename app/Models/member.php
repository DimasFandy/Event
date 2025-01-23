<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'photo'
    ];
    public function members()
    {
        return $this->hasMany(EventMember::class, 'event_id', 'id');
    }
    public function events()
    {
        return $this->belongsToMany(Event::class, 'events_member', 'member_id', 'event_id')
        ->withTimestamps(); // Menambahkan created_at dan updated_at otomatis;
    }

}
