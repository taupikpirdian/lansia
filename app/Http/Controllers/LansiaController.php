<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Desa;
use App\Models\Agama;
use App\Models\Biodata;
use App\Models\Journey;
use App\Models\Kondisi;
use App\Models\Kategori;
use App\Models\Pengampu;
use App\Models\Kecamatan;
use App\Models\StatusNikah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LansiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.biodata.index');
    }

    public function datatable(Request $request)
    {
        if (request()->ajax()) {
            /**
             * column shown in the table
             */
            // check from model Report
            $columns = [
                'biodatas.no_kk',
                'biodatas.nama',
                'biodatas.tempat_lahir',
                'biodatas.tanggal_lahir',
                'biodatas.jk',
                'biodatas.agama_id',
                'biodatas.status_nikah_id',
                'biodatas.kategori_id',
                'biodatas.kondisi_id',
                'biodatas.pengampu_id',
                'biodatas.created_by',
                'biodatas.kecamatan_id',
                'biodatas.desa_id',
            ];

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $role = Auth::user()->roles[0]->name;
            $posts = Biodata::when($role == 'operator-desa', function ($query) use ($request) {
                $query->where('desa_id', Auth::user()->desa_id);
            })->when($role == 'operator-kecamatan', function ($query) use ($request) {
                $query->where('kecamatan_id', Auth::user()->kecamatan_id);
            })->orderBy('created_at', 'desc');

            if ($request->search['value']) {
                $posts = $posts->where('no_kk', 'like', '%' . $request->search['value'] . '%')
                    ->orWhere('nama', 'like', '%' . $request->search['value'] . '%');
            }

            $totalData = $posts->count();
            $posts = $posts->skip($start)->take($limit)->orderBy($order, $dir)->get();
            $data = array();
            $role = Auth::user()->roles[0]->name;
            if (!empty($posts)) {
                foreach ($posts as $key => $post) {
                    $button = '';
                    $button .= '<a href="' . route('dashboard.biodata.show', $post->id) . '" type="button" class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>';
                    if ($role == 'admin' || $role == 'operator-desa') {
                        // status harus dalam proses atau revisi
                        if ($post->status != 'disetujui') {
                            $button .= '<a href="' . route('dashboard.biodata.edit', $post->id) . '" type="button" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>';

                            $button .= '<button type="button" class="btn btn-sm btn-danger" title="Delete" onclick="deleteData(' . $post->id . ')">
                                    <i class="fas fa-trash"></i>
                                </button>';
                        }
                    } else {
                        // status harus dalam proses atau revisi
                        if (in_array($post->status, ['dalam-proses', 'revisi']) && $post->approvals()->where('action_by', Auth::id())->count() == 0) {
                            $canApprove = $role != 'operator-dinas' || $post->approvals()->count() >= 1;

                            if ($canApprove) {
                                // tombol approve
                                $button .= '<button type="button" class="btn btn-sm btn-success" title="Approve" onclick="approveData(' . $post->id . ')">
                                                <i class="fas fa-check"></i>
                                            </button>';
                                // tombol reject
                                $button .= '<button type="button" class="btn btn-sm btn-danger" title="Reject" onclick="rejectData(' . $post->id . ')">
                                                <i class="fas fa-times"></i>
                                            </button>';
                            }
                        }
                    }

                    $htmlButton = '<div class="btn-group" role="group">
                            ' . $button . '
                        </div>';

                    // format data approval
                    // 0 from 2
                    $nestedData['approved'] = $post->approvals()->count() . " dari 2";
                    // use span with class
                    $nestedData['status'] = match ($post->status) {
                        'ditolak' => '<span class="badge badge-danger">Ditolak</span>',
                        'dalam-proses' => '<span class="badge badge-warning">Dalam Proses</span>',
                        'disetujui' => '<span class="badge badge-success">Disetujui</span>',
                        'revisi' => '<span class="badge badge-primary">Revisi</span>',
                        default => '<span class="badge badge-secondary">Unknown</span>',
                    };

                    $nestedData['no_kk'] = $post->no_kk;
                    $nestedData['nama'] = $post->nama;
                    $nestedData['tempat_lahir'] = $post->tempat_lahir;
                    $nestedData['tanggal_lahir'] = $post->tanggal_lahir;
                    $nestedData['jk'] = $post->jk;
                    $nestedData['agama'] = $post->agama->name;
                    $nestedData['status_nikah'] = $post->statusNikah->name;
                    $nestedData['kategori'] = $post->kategori->name;
                    $nestedData['kondisi'] = $post->kondisi->name;
                    $nestedData['pengampu'] = $post->pengampu->name;
                    $nestedData['created_at'] = Carbon::parse($post->created_at)->format('d/m/Y H:i');
                    $nestedData['action'] = $htmlButton;
                    $nestedData['DT_RowIndex'] = ($key + 1) + $start;

                    $data[] = $nestedData;
                }
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalData),
                "data"            => $data
            );

            return response()->json($json_data);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Auth::user()->roles[0]->name;
        // hanya boleh create oleh role admin atau operator-desa
        if ($role != 'admin' && $role != 'operator-desa') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki izin untuk membuat data.');
        }
        $is_edit = false;
        $data = null;
        $agamas = Agama::all();
        $statusNikahs = StatusNikah::all();
        $kategoris = Kategori::all();
        $kondisis = Kondisi::all();
        $pengampus = Pengampu::all();

        // kecamatan
        $kecamatans = Kecamatan::all();
        return view('admin.biodata.create', compact('is_edit', 'data', 'agamas', 'statusNikahs', 'kategoris', 'kondisis', 'pengampus', 'kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Auth::user()->roles[0]->name;
        // hanya boleh create oleh role admin atau operator-desa
        if ($role != 'admin' && $role != 'operator-desa') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki izin untuk membuat data.');
        }
        // 1. Validasi
        $validatedData = $request->validate([
            'no_kk'          => 'required|string|max:20',
            'no_nik'         => 'required|string|max:20',
            'nama'           => 'required|string|max:255',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'jk'             => 'required|in:L,P',
            'agama_id'       => 'required|exists:agamas,id',
            'alamat'         => 'required|string|max:500',
            'file_ktp'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ppks'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status_nikah_id' => 'required|exists:status_nikahs,id',
            'kategori_id'    => 'required|exists:kategoris,id',
            'kondisi_id'     => 'required|exists:kondisis,id',
            'pengampu_id'    => 'required|exists:pengampus,id',
        ]);

        // 2. Handle file uploads
        $fileKtp = null;
        $fileKtpUrl = null;
        $fileKk = null;
        $fileKkUrl = null;
        $filePpks = null;
        $filePpksUrl = null;

        if ($request->hasFile('file_ktp')) {
            $file = $request->file('file_ktp');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('ktp', $filename, 'public');
            $fileKtp = $filename;
            $fileKtpUrl = $path;
        }
        if ($request->hasFile('file_kk')) {
            $file = $request->file('file_kk');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('kk', $filename, 'public');
            $fileKk = $filename;
            $fileKkUrl = $path;
        }
        if ($request->hasFile('file_ppks')) {
            $file = $request->file('file_ppks');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('ppks', $filename, 'public');
            $filePpks = $filename;
            $filePpksUrl = $path;
        }

        // 3. DB Transaction + Try-Catch
        try {
            DB::beginTransaction();
            if (Auth::user()->role == 'admin') {
                // required jika admin
                if (!$request->input('kecamatan_id')) {
                    return redirect()->back()
                        ->with('error', 'Kecamatan harus dipilih.');
                }
                if (!$request->input('desa_id')) {
                    return redirect()->back()
                        ->with('error', 'Desa harus dipilih.');
                }

                $validatedData['kecamatan_id'] = $request->input('kecamatan_id');
                $validatedData['desa_id'] = $request->input('desa_id');
            } else {
                $desa = Desa::where('id', Auth::user()->desa_id)->first();
                if (!$desa) {
                    return redirect()->back()
                        ->with('error', 'Desa tidak ditemukan.');
                }
                $kec = Kecamatan::where('kode_kec', $desa->kode_kec)->first();
                if (!$kec) {
                    return redirect()->back()
                        ->with('error', 'Kecamatan tidak ditemukan.');
                }
                $validatedData['kecamatan_id'] = $kec->id;
                $validatedData['desa_id'] = $desa->id;
            }

            Biodata::create([
                'no_kk'           => $validatedData['no_kk'],
                'no_nik'          => $validatedData['no_nik'],
                'nama'            => $validatedData['nama'],
                'tempat_lahir'    => $validatedData['tempat_lahir'],
                'tanggal_lahir'   => $validatedData['tanggal_lahir'],
                'jk'              => $validatedData['jk'],
                'agama_id'        => $validatedData['agama_id'],
                'kecamatan_id'    => $validatedData['kecamatan_id'],
                'desa_id'         => $validatedData['desa_id'],
                'alamat'          => $validatedData['alamat'],
                'file_ktp'        => $fileKtp,
                'file_ktp_url'    => $fileKtpUrl,
                'file_kk'         => $fileKk,
                'file_kk_url'     => $fileKkUrl,
                'file_ppks'       => $filePpks,
                'file_ppks_url'   => $filePpksUrl,
                'status_nikah_id' => $validatedData['status_nikah_id'],
                'kategori_id'     => $validatedData['kategori_id'],
                'kondisi_id'      => $validatedData['kondisi_id'],
                'pengampu_id'     => $validatedData['pengampu_id'],
                'created_by'      => Auth::id(), // otomatis simpan user login
            ]);

            DB::commit();

            return redirect()->route('dashboard.biodata.index')
                ->with('success', 'Data biodata berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $is_edit = true;
        $data = Biodata::with('journeyApprovals')->findOrFail($id);
        return view('admin.biodata.show', compact('is_edit', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Auth::user()->roles[0]->name;
        // hanya boleh create oleh role admin atau operator-desa
        if ($role != 'admin' && $role != 'operator-desa') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki izin untuk edit data.');
        }
        $is_edit = true;
        $data = Biodata::findOrFail($id);
        if ($data->approvals()->exists()) {
            return redirect()->back()
                ->with('error', 'Data tidak bisa diupdate karena sudah memiliki minimal 1 approval.');
        }

        // status != disetujui
        if ($data->status == 'disetujui') {
            return redirect()->back()
                ->with('error', 'Data tidak bisa diupdate karena sudah disetujui.');
        }
        $agamas = Agama::all();
        $statusNikahs = StatusNikah::all();
        $kategoris = Kategori::all();
        $kondisis = Kondisi::all();
        $pengampus = Pengampu::all();

        // kecamatan
        $kecamatans = Kecamatan::all();
        return view('admin.biodata.create', compact('is_edit', 'data', 'agamas', 'statusNikahs', 'kategoris', 'kondisis', 'pengampus', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Auth::user()->roles[0]->name;
        // hanya boleh create oleh role admin atau operator-desa
        if ($role != 'admin' && $role != 'operator-desa') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki izin untuk edit data.');
        }

        // 1. Validasi
        $validatedData = $request->validate([
            'no_kk'           => 'required|string|max:20',
            'no_nik'          => 'required|string|max:20',
            'nama'            => 'required|string|max:255',
            'tempat_lahir'    => 'required|string|max:100',
            'tanggal_lahir'   => 'required|date',
            'jk'              => 'required|in:L,P',
            'agama_id'        => 'required|exists:agamas,id',
            'alamat'          => 'required|string|max:500',
            'file_ktp'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_kk'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ppks'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status_nikah_id' => 'required|exists:status_nikahs,id',
            'kategori_id'     => 'required|exists:kategoris,id',
            'kondisi_id'      => 'required|exists:kondisis,id',
            'pengampu_id'     => 'required|exists:pengampus,id',
        ]);

        if (Auth::user()->role == 'admin') {
            if (!$request->input('kecamatan_id')) {
                return redirect()->back()
                    ->with('error', 'Kecamatan harus dipilih.');
            }
            if (!$request->input('desa_id')) {
                return redirect()->back()
                    ->with('error', 'Desa harus dipilih.');
            }
            $validatedData['kecamatan_id'] = $request->input('kecamatan_id');
            $validatedData['desa_id'] = $request->input('desa_id');
        } else {
            $desa = Desa::where('id', Auth::user()->desa_id)->first();
            if (!$desa) {
                return redirect()->back()
                    ->with('error', 'Desa tidak ditemukan.');
            }
            $kec = Kecamatan::where('kode_kec', $desa->kode_kec)->first();
            if (!$kec) {
                return redirect()->back()
                    ->with('error', 'Kecamatan tidak ditemukan.');
            }
            $validatedData['kecamatan_id'] = $kec->id;
            $validatedData['desa_id'] = $desa->id;
        }

        // 2. Handle file uploads
        $biodata = Biodata::findOrFail($id);

        // Default data yang diupdate
        $data = [
            'no_kk'           => $validatedData['no_kk'],
            'no_nik'          => $validatedData['no_nik'],
            'nama'            => $validatedData['nama'],
            'tempat_lahir'    => $validatedData['tempat_lahir'],
            'tanggal_lahir'   => $validatedData['tanggal_lahir'],
            'jk'              => $validatedData['jk'],
            'agama_id'        => $validatedData['agama_id'],
            'kecamatan_id'    => $validatedData['kecamatan_id'],
            'desa_id'         => $validatedData['desa_id'],
            'alamat'          => $validatedData['alamat'],
            'status_nikah_id' => $validatedData['status_nikah_id'],
            'kategori_id'     => $validatedData['kategori_id'],
            'kondisi_id'      => $validatedData['kondisi_id'],
            'pengampu_id'     => $validatedData['pengampu_id'],
        ];

        // Handle file uploads
        if ($request->hasFile('file_ktp')) {
            // Delete old file if exists
            if ($biodata->file_ktp_url && Storage::disk('public')->exists($biodata->file_ktp_url)) {
                Storage::disk('public')->delete($biodata->file_ktp_url);
            }
            $file = $request->file('file_ktp');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('ktp', $filename, 'public');
            $data['file_ktp'] = $filename;
            $data['file_ktp_url'] = $path;
        }
        if ($request->hasFile('file_kk')) {
            // Delete old file if exists
            if ($biodata->file_kk_url && Storage::disk('public')->exists($biodata->file_kk_url)) {
                Storage::disk('public')->delete($biodata->file_kk_url);
            }
            $file = $request->file('file_kk');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('kk', $filename, 'public');
            $data['file_kk'] = $filename;
            $data['file_kk_url'] = $path;
        }
        if ($request->hasFile('file_ppks')) {
            // Delete old file if exists
            if ($biodata->file_ppks_url && Storage::disk('public')->exists($biodata->file_ppks_url)) {
                Storage::disk('public')->delete($biodata->file_ppks_url);
            }
            $file = $request->file('file_ppks');
            $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('ppks', $filename, 'public');
            $data['file_ppks'] = $filename;
            $data['file_ppks_url'] = $path;
        }

        // 3. DB Transaction + Try-Catch
        try {
            DB::beginTransaction();

            if ($biodata->approvals()->exists()) {
                return redirect()->back()
                    ->with('error', 'Data tidak bisa diupdate karena sudah memiliki minimal 1 approval.');
            }
            // status != disetujui
            if ($biodata->status == 'disetujui') {
                return redirect()->back()
                    ->with('error', 'Data tidak bisa diupdate karena sudah disetujui.');
            }

            $biodata->update($data);

            // jika status di tolak, update to revisi
            if ($biodata->status == 'ditolak') {
                $biodata->update([
                    'status' => 'revisi',
                ]);
            }

            DB::commit();
            return redirect()->route('dashboard.biodata.index')
                ->with('success', 'Data biodata berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $data = Biodata::findOrFail($id);
            $data->delete();

            // delete journey data
            Journey::where('biodata_id', $id)->delete();

            DB::commit();
            return redirect()->route('dashboard.biodata.index')
                ->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function getDesa(Request $request)
    {
        $kecamatan_id = $request->kecamatan_id;
        // find kecamatan
        $kecamatan = Kecamatan::find($kecamatan_id);
        if (!$kecamatan) {
            return response()->json(['message' => 'Kecamatan not found'], 404);
        }
        // find desa
        $desas = Desa::where('kode_kec', $kecamatan->kode_kec)->get();
        return response()->json($desas);
    }

    // reject
    public function reject(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = Biodata::findOrFail($id);
            // create journeys
            Journey::create([
                'biodata_id' => $data->id,
                'status' => 0,
                'action_by' => Auth::user()->id,
                'notes' => $request->note,
            ]);

            // update to di tolak
            $data->update([
                'status' => 'ditolak',
            ]);
            DB::commit();
            return redirect()->route('dashboard.biodata.index')
                ->with('success', 'Data berhasil di reject.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat reject data: ' . $e->getMessage());
        }
    }

    public function approve(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = Biodata::findOrFail($id);
            // create journeys
            Journey::create([
                'biodata_id' => $data->id,
                'status' => 1,
                'action_by' => Auth::user()->id,
                'notes' => $request->note,
            ]);

            // jika approval lebih dari 1, update status to disetujui
            if ($data->approvals()->count() > 1) {
                $data->update([
                    'status' => 'disetujui',
                ]);
            }
            // jika revisi update ke dalam-proses
            if ($data->status == 'revisi') {
                $data->update([
                    'status' => 'dalam-proses',
                ]);
            }
            DB::commit();
            return redirect()->route('dashboard.biodata.index')
                ->with('success', 'Data berhasil di approve.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat approve data: ' . $e->getMessage());
        }
    }
}
