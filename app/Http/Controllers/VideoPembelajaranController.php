<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\VideoPembelajaran;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
    ]);

    try {

        $file = $request->file('file_video');

        $namaFile = time().'_'.$file->getClientOriginalName();

        $file->storeAs(
            'video',
            $namaFile,
            'public'
        );

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

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ],500);

    }
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
public function stream($id)
{
    $video = VideoPembelajaran::findOrFail($id);

    $path = Storage::disk('public')->path('video/' . $video->file_video);

    if (!file_exists($path)) {
        return response()->json([
            'message' => 'File video tidak ditemukan',
            'path' => $path
        ], 404);
    }

    return response()->file($path, [
        'Content-Type' => 'video/mp4',
        'Accept-Ranges' => 'bytes'
    ]);
}
}
