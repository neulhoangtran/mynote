<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/upload-note-image', function (Request $request) {
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('notes/images', 'public');
        return response()->json(['url' => '/public' . Storage::url( $path)]);
    }
    return response()->json(['error' => 'No image uploaded'], 400);
});

Route::get('/gridnote', function () {
    return view('gridnote');
});