<?php

namespace App\Http\Controllers\admin;

use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Slider::all();
        return view('admin.slider.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $is_edit = false;
        $data = null;
        return view('admin.slider.create', compact('is_edit', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'required',
        ]);

        $file = $request->file('image');
        $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('sliders', $filename, 'public');

        Slider::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $filename,
            'link' => $path,
        ]);

        return redirect()->route('dashboard.slider.index')->with('success', 'Slider created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Slider::findOrFail($id);
        return view('admin.slider.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $is_edit = true;
        $data = Slider::findOrFail($id);
        return view('admin.slider.create', compact('is_edit', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slider = Slider::findOrFail($id);

        // Default data yang diupdate
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Kalau ada file baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($slider->link && Storage::disk('public')->exists($slider->link)) {
                Storage::disk('public')->delete($slider->link);
            }

            // Upload gambar baru
            $file = $request->file('image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sliders', $filename, 'public');

            // Simpan nama file dan path baru
            $data['image'] = $filename;
            $data['link'] = $path;
        }

        $slider->update($data);

        return redirect()->route('dashboard.slider.index')->with('success', 'Slider updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);

        // Hapus gambar dari storage
        if ($slider->link && Storage::disk('public')->exists($slider->link)) {
            Storage::disk('public')->delete($slider->link);
        }

        $slider->delete();

        return redirect()->route('dashboard.slider.index')->with('success', 'Slider deleted successfully');
    }
}