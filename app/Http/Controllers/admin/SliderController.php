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
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'person1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'person1_name' => 'nullable|string|max:255',
            'person1_position' => 'nullable|string|max:255',
            'person2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'person2_name' => 'nullable|string|max:255',
            'person2_position' => 'nullable|string|max:255',
            'person3_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'person3_name' => 'nullable|string|max:255',
            'person3_position' => 'nullable|string|max:255',
        ]);

        // Prepare data array
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'person1_name' => $request->person1_name,
            'person1_position' => $request->person1_position,
            'person2_name' => $request->person2_name,
            'person2_position' => $request->person2_position,
            'person3_name' => $request->person3_name,
            'person3_position' => $request->person3_position,
        ];

        // Handle main image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sliders', $filename, 'public');
            $data['image'] = $filename;
            $data['link'] = $path;
        }

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sliders', $filename, 'public');
            $data['background_image'] = $filename;
            $data['background_image_url'] = 'sliders/' . $filename;
        }

        // Handle person1 image upload
        if ($request->hasFile('person1_image')) {
            $file = $request->file('person1_image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sliders', $filename, 'public');
            $data['person1_image'] = $filename;
            $data['person1_image_url'] = 'sliders/' . $filename;
        }

        // Handle person2 image upload
        if ($request->hasFile('person2_image')) {
            $file = $request->file('person2_image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sliders', $filename, 'public');
            $data['person2_image'] = $filename;
            $data['person2_image_url'] = 'sliders/' . $filename;
        }

        // Handle person3 image upload
        if ($request->hasFile('person3_image')) {
            $file = $request->file('person3_image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sliders', $filename, 'public');
            $data['person3_image'] = $filename;
            $data['person3_image_url'] = 'sliders/' . $filename;
        }

        Slider::create($data);

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
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'person1_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'person1_name' => 'nullable|string|max:255',
            'person1_position' => 'nullable|string|max:255',
            'person2_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'person2_name' => 'nullable|string|max:255',
            'person2_position' => 'nullable|string|max:255',
            'person3_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'person3_name' => 'nullable|string|max:255',
            'person3_position' => 'nullable|string|max:255',
        ]);

        $slider = Slider::findOrFail($id);

        // Default data yang diupdate
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'person1_name' => $request->person1_name,
            'person1_position' => $request->person1_position,
            'person2_name' => $request->person2_name,
            'person2_position' => $request->person2_position,
            'person3_name' => $request->person3_name,
            'person3_position' => $request->person3_position,
        ];

        // Handle main image upload
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

        // Handle background image upload
        if ($request->hasFile('background_image')) {
            // Hapus gambar lama
            if ($slider->background_image_url && Storage::disk('public')->exists($slider->background_image_url)) {
                Storage::disk('public')->delete($slider->background_image_url);
            }

            $file = $request->file('background_image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sliders', $filename, 'public');
            $data['background_image'] = $filename;
            $data['background_image_url'] = 'sliders/' . $filename;
        }

        // Handle person1 image upload
        if ($request->hasFile('person1_image')) {
            // Hapus gambar lama
            if ($slider->person1_image_url && Storage::disk('public')->exists($slider->person1_image_url)) {
                Storage::disk('public')->delete($slider->person1_image_url);
            }

            $file = $request->file('person1_image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sliders', $filename, 'public');
            $data['person1_image'] = $filename;
            $data['person1_image_url'] = 'sliders/' . $filename;
        }

        // Handle person2 image upload
        if ($request->hasFile('person2_image')) {
            // Hapus gambar lama
            if ($slider->person2_image_url && Storage::disk('public')->exists($slider->person2_image_url)) {
                Storage::disk('public')->delete($slider->person2_image_url);
            }

            $file = $request->file('person2_image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sliders', $filename, 'public');
            $data['person2_image'] = $filename;
            $data['person2_image_url'] = 'sliders/' . $filename;
        }

        // Handle person3 image upload
        if ($request->hasFile('person3_image')) {
            // Hapus gambar lama
            if ($slider->person3_image_url && Storage::disk('public')->exists($slider->person3_image_url)) {
                Storage::disk('public')->delete($slider->person3_image_url);
            }

            $file = $request->file('person3_image');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('sliders', $filename, 'public');
            $data['person3_image'] = $filename;
            $data['person3_image_url'] = 'sliders/' . $filename;
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