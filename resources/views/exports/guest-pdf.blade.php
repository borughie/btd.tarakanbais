<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Tamu Digital - SD Indo Tionghua Tarakan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; border-bottom: 2px solid #B3202E; padding-bottom: 15px; }
        .logo { width: 50px; height: 50px; object-fit: contain; }
        .header-text h1 { font-size: 18px; margin: 0; color: #B3202E; }
        .header-text p { font-size: 11px; color: #6B5C5C; margin: 3px 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #B3202E; color: white; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 7px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .center { text-align: center; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #999; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/logo.png') }}" alt="Logo" class="logo" />
        <div class="header-text">
            <h1>Buku Tamu Digital</h1>
            <p>SD Indo Tionghua Tarakan</p>
            <p>Printed: {{ \App\Helpers\DateHelper::formatIndonesian(now()) }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="center" style="width:5%">No</th>
                <th style="width:18%">Waktu</th>
                <th style="width:20%">Instansi</th>
                <th style="width:25%">Tujuan</th>
                <th class="center" style="width:8%">Personil</th>
                <th style="width:14%">PIC</th>
                <th style="width:10%">No. HP</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($guests as $i => $guest)
                <tr>
                    <td class="center">{{ $i + 1 }}</td>
                    <td>{{ \App\Helpers\DateHelper::formatIndonesian($guest->created_at) }}</td>
                    <td>{{ $guest->instansi }}</td>
                    <td>{{ $guest->tujuan }}</td>
                    <td class="center">{{ $guest->jumlah_personil }}</td>
                    <td>{{ $guest->nama_pic ?? '-' }}</td>
                    <td>{{ $guest->no_hp ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 30px;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Total: {{ $total }} tamu | SD Indo Tionghua Tarakan &copy; {{ date('Y') }}
    </div>
</body>
</html>
