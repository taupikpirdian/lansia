<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\Kondisi;
use App\Models\Kategori;
use App\Models\Pengampu;
use App\Models\StatusNikah;
use Illuminate\Http\Request;

class LansiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.biodata.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $is_edit = false;
        $data = null;
        $agamas = Agama::all();
        $statusNikahs = StatusNikah::all();
        $kategoris = Kategori::all();
        $kondisis = Kondisi::all();
        $pengampus = Pengampu::all();
        return view('admin.biodata.create', compact('is_edit', 'data', 'agamas', 'statusNikahs', 'kategoris', 'kondisis', 'pengampus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
