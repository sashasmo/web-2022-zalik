<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('file');

        $imageExtensions = array(
            'ico',
            'bmp',
            'gif',
            'jpg',
            'jpeg',
            'png'
        );

        if ($file == '')
            return response(NULL, 422);
        if (!in_array($file->getClientOriginalExtension(), $imageExtensions))
            return response(NULL, 422);

        $record = Image::create(['filename' => $file->getClientOriginalName()]);
        Storage::disk('local')->put($record->filename, $file);

        return response()->json(['data' => $record], 201);
    }
}
