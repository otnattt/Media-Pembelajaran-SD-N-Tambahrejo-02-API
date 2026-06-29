<!DOCTYPE html>
<html>
<head>
    <title>Hasil Penilaian</title>

    <style>
        body{
            font-family: sans-serif;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            border:1px solid #000;
            padding:8px;
        }
    </style>
</head>
<body>

<h2>Data Hasil Penilaian</h2>

<table>
    <thead>
        <tr>
            <th>Siswa</th>
            <th>Kuis</th>
            <th>Nilai</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>

   <tbody>

@forelse($hasil as $index => $item)

<tr>
    <td>{{ $index + 1 }}</td>

    <td>
        {{ $item->siswa->nama ?? '-' }}
    </td>

    <td>
        {{ $item->kuis->judul ?? '-' }}
    </td>

    <td>
        {{ $item->total_nilai }}
    </td>

    <td>
        {{ $item->created_at->format('Y-m-d') }}
    </td>

    <td>
        {{ $item->total_nilai >= 75 ? 'Lulus' : 'Remedial' }}
    </td>
</tr>

@empty

<tr>
    <td colspan="6" style="text-align:center">
        Tidak ada data
    </td>
</tr>

@endforelse

</tbody>
</table>

</body>
</html>
