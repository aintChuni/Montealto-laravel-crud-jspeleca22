<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ImageUploadController extends Controller
{
    public function index(): View
    {
        return view('uploads.index', [
            'images' => Image::latest()->paginate(12)
        ]);
    }

    public function create(): View
    {
        return view('uploads.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('image');
        $path = $file->store('images', 'public');

        Image::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path
        ]);

        return redirect()->route('images.index')
            ->with('success', 'Image uploaded successfully!');
    }

    public function show(Image $image): View
    {
        return view('uploads.show', compact('image'));
    }

    public function destroy(Image $image): RedirectResponse
    {
        // Delete the file from storage
        Storage::disk('public')->delete($image->path);
        
        // Delete the database record
        $image->delete();

        return redirect()->route('images.index')
            ->with('success', 'Image deleted successfully!');
    }
}