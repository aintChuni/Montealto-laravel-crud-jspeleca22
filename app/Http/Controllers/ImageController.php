<?php
namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('images.index', compact('images'));
    }

    public function create()
    {
        return view('images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('image');
        $path = $file->store('images', 'public');

        Image::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
        ]);

        return redirect()->route('images.index')->with('success', 'Image uploaded successfully!');
    }

    public function show(Image $image)
    {
        return view('images.show', compact('image'));
    }

    public function edit(Image $image)
    {
        return view('images.edit', compact('image'));
    }

    public function update(Request $request, Image $image)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($image->path);

            // Upload new image
            $file = $request->file('image');
            $path = $file->store('images', 'public');

            $image->update([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
            ]);
        }

        return redirect()->route('images.index')->with('success', 'Image updated successfully!');
    }

    public function destroy(Image $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()->route('images.index')->with('success', 'Image deleted successfully!');
    }
}