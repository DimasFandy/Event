<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Reason;
use App\Models\Member;


class ParticipantController extends Controller
{
    //method untuk menghapus member yang sudah terdaftar di events
    public function removeParticipant(Request $request, $event_id, $member_id)
{
    $event = Event::findOrFail($event_id);
    $member = Member::findOrFail($member_id);

    // Periksa apakah alasan penghapusan ada di request
    if ($request->has('reason')) {
        $reason = $request->reason;

        // Simpan alasan penghapusan ke tabel reasons
        Reason::create([
            'event_id' => $event->id,
            'member_id' => $member->id,
            'name' => $member->name,
            'reason' => $reason,
        ]);
    }

    // Hapus peserta dari event
    $event->members()->detach($member->id);

    // Redirect kembali ke halaman detail event
    return redirect()->route('events.show', $event->id)->with('success', 'Peserta berhasil dihapus.');
}

}
