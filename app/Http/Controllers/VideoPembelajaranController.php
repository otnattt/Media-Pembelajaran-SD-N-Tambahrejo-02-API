<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoPembelajaran;

class VideoPembelajaranController extends Controller
{
    // tampil data
    public function index()
    {
        $video = VideoPembelajaran::all();

        return response()->json($video);
    }

    // simpan video
    public function store(Request $request)
    {
        
        $request->validate([
            'id_guru' => 'required',
            'judul' => 'required',
            'file_video' => 'required|file|mimes:mp4,mov,avi|max:307200',
            'durasi_video' => 'nullable'
        ]);

        // upload file
        $file = $request->file('file_video');

        $namaFile = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('video'), $namaFile);

        // simpan database
        $video = VideoPembelajaran::create([
        'id_guru' => $request->id_guru,
        'judul' => $request->judul,
        'deskripsi' => $request->deskripsi,
        'file_video' => $namaFile,
        'durasi_video' => $request->durasi_video,
        'status_video' => 'aktif'
    ]);

        return response()->json([
            'success' => true,
            'message' => 'Video berhasil disimpan',
            'data' => $video
        ]);
    }
    public function update(Request $request, $id)
{
    $video = VideoPembelajaran::findOrFail($id);

    $video->judul = $request->judul;
    $video->deskripsi = $request->deskripsi;
    $video->status_video = $request->status_video;

    $video->save();

    return response()->json([
        'message' => 'Video berhasil diupdate',
        'data' => $video
    ]);
}
public function stream($file)
{
    $path = public_path("video/" . $file);

    if (!file_exists($path)) {
        abort(404);
    }

    $size = filesize($path);
    $start = 0;
    $end = $size - 1;

    $headers = [
        'Content-Type' => 'video/mp4',
        'Accept-Ranges' => 'bytes',
    ];

    if (isset($_SERVER['HTTP_RANGE'])) {

        preg_match('/bytes=(\d+)-(\d*)/', $_SERVER['HTTP_RANGE'], $matches);

        $start = intval($matches[1]);

        if ($matches[2] != '') {
            $end = intval($matches[2]);
        }

        $length = $end - $start + 1;

        $headers['Content-Length'] = $length;
        $headers['Content-Range'] = "bytes $start-$end/$size";

        return response()->stream(function () use ($path, $start, $length) {

            $fp = fopen($path, 'rb');

            fseek($fp, $start);

            echo fread($fp, $length);

            fclose($fp);

        }, 206, $headers);
    }

    $headers['Content-Length'] = $size;

    return response()->stream(function () use ($path) {

        readfile($path);

    }, 200, $headers);
}

}
