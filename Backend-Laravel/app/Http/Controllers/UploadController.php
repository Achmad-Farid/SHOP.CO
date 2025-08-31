<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    // POST /api/upload  (form-data: image=<file>)
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|file|mimes:jpg,jpeg,png,webp,avif|max:5120'
        ]);

        $path = $request->file('image')->store('uploads', 'public');
        $url  = asset('storage/'.$path);

        return response()->json([
            'url' => $url,
            'path' => $path
        ]);
    }
}
