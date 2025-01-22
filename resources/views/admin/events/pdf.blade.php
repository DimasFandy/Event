<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Detail Event</h1>
    <table>
        <tr>
            <th>Nama:</th>
            <td>{{ $event->name }}</td>
        </tr>
        <tr>
            <th>Kategori:</th>
            <td>
                @foreach ($event->kategori as $kategori)
                    {{ $kategori->name }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Deskripsi:</th>
            <td>{{ $event->description }}</td>
        </tr>
        <tr>
            <th>Tanggal Mulai:</th>
            <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d-M-Y H:i') }}</td>
        </tr>
        <tr>
            <th>Tanggal Selesai:</th>
            <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d-M-Y H:i') }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>{{ $event->status }}</td>
        </tr>
        <tr>
            <th>Jumlah Peserta:</th>
            <td>{{ $event->members->count() }} peserta</td>
        </tr>
    </table>

    <h2>Daftar Peserta</h2>
    @if ($members->isEmpty())
        <p>Tidak ada peserta terdaftar.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Email</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $index => $member)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($member->pivot->created_at)->format('d-M-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
