@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">{{ $is_edit ? 'Edit Data Iket Dalang' : 'Tambah Data Iket Dalang' }}</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.biodata.index') }}">Iket Dalang</a></li>
                <li class="breadcrumb-item active">{{ $is_edit ? 'Edit Data' : 'Tambah Data' }}</li>
            </ol>
        </div>
    </div>
</div>
<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Preview">
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">{{ $is_edit ? 'Form Edit' : 'Form Tambah' }}</h3>
        </div>
        <div class="card-body">
            @if($is_edit)
                <form action="{{ route('dashboard.biodata.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
            @else
                <form action="{{ route('dashboard.biodata.store') }}" method="POST" enctype="multipart/form-data">
            @endif
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No KK <span class="text-danger">*</span></label>
                        <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $data->no_kk ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No NIK <span class="text-danger">*</span></label>
                        <input type="text" name="no_nik" class="form-control" value="{{ old('no_nik', $data->no_nik ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $data->tempat_lahir ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control datepicker" value="{{ old('tanggal_lahir', $data->tanggal_lahir ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jk" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jk', $data->jk ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jk', $data->jk ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Agama <span class="text-danger">*</span></label>
                        <select name="agama_id" class="form-select" required>
                            <option value="">-- Pilih Agama --</option>
                            @foreach($agamas as $agama)
                                <option value="{{ $agama->id }}" {{ old('agama_id', $data->agama_id ?? '') == $agama->id ? 'selected' : '' }}>
                                    {{ $agama->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                        <select name="kecamatan_id" class="form-select select2" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($kecamatans as $kecamatan)
                                <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $data->kecamatan_id ?? '') == $kecamatan->id ? 'selected' : '' }}>
                                    {{ $kecamatan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Desa <span class="text-danger">*</span></label>
                        <select name="desa_id" class="form-select select2" required>
                            <option value="">-- Pilih Desa --</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" required>{{ old('alamat', $data->alamat ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status Nikah <span class="text-danger">*</span></label>
                        <select name="status_nikah_id" class="form-select" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach($statusNikahs as $status)
                                <option value="{{ $status->id }}" {{ old('status_nikah_id', $data->status_nikah_id ?? '') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $data->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                        <select name="kondisi_id" class="form-select" required>
                            <option value="">-- Pilih Kondisi --</option>
                            @foreach($kondisis as $kondisi)
                                <option value="{{ $kondisi->id }}" {{ old('kondisi_id', $data->kondisi_id ?? '') == $kondisi->id ? 'selected' : '' }}>
                                    {{ $kondisi->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Pengampu <span class="text-danger">*</span></label>
                        <select name="pengampu_id" class="form-select" required>
                            <option value="">-- Pilih Pengampu --</option>
                            @foreach($pengampus as $pengampu)
                                <option value="{{ $pengampu->id }}" {{ old('pengampu_id', $data->pengampu_id ?? '') == $pengampu->id ? 'selected' : '' }}>
                                    {{ $pengampu->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- File Upload Fields -->
                    <div class="col-12 mb-3">
                        <h5 class="mb-3">Upload Dokumen (Opsional)</h5>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Upload KTP</label>
                        <input type="file" name="file_ktp" class="form-control" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this, 'ktp-preview')">
                        @if($is_edit && isset($data->file_ktp) && $data->file_ktp)
                            <div class="mt-2">
                                <img id="ktp-preview" src="/file/ktp/{{ $data->file_ktp }}" 
                                     class="img-thumbnail img-clickable" 
                                     style="max-width: 200px; max-height: 150px; cursor: pointer;"
                                     data-bs-toggle="modal" data-bs-target="#imageModal" 
                                     data-img-src="/file/ktp/{{ $data->file_ktp }}" 
                                     alt="KTP Preview">
                                <br><small class="text-muted">File saat ini: <a href="/file/ktp/{{ $data->file_ktp }}" target="_blank">Lihat File</a></small>
                            </div>
                        @else
                            <div class="mt-2">
                                <img id="ktp-preview" style="max-width: 200px; max-height: 150px; display: none;" class="img-thumbnail img-clickable" data-bs-toggle="modal" data-bs-target="#imageModal">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Upload KK</label>
                        <input type="file" name="file_kk" class="form-control" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this, 'kk-preview')">
                        @if($is_edit && isset($data->file_kk) && $data->file_kk)
                            <div class="mt-2">
                                <img id="kk-preview" src="/file/kk/{{ $data->file_kk }}" 
                                     class="img-thumbnail img-clickable" 
                                     style="max-width: 200px; max-height: 150px; cursor: pointer;"
                                     data-bs-toggle="modal" data-bs-target="#imageModal" 
                                     data-img-src="/file/kk/{{ $data->file_kk }}" 
                                     alt="KK Preview">
                                <br><small class="text-muted">File saat ini: <a href="/file/kk/{{ $data->file_kk }}" target="_blank">Lihat File</a></small>
                            </div>
                        @else
                            <div class="mt-2">
                                <img id="kk-preview" style="max-width: 200px; max-height: 150px; display: none;" class="img-thumbnail img-clickable" data-bs-toggle="modal" data-bs-target="#imageModal">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Upload PPKS</label>
                        <input type="file" name="file_ppks" class="form-control" accept=".pdf,.jpg,.jpeg,.png" onchange="previewFile(this, 'ppks-preview')">
                        @if($is_edit && isset($data->file_ppks) && $data->file_ppks)
                            <div class="mt-2">
                                <img id="ppks-preview" src="/file/ppks/{{ $data->file_ppks }}" 
                                     class="img-thumbnail img-clickable" 
                                     style="max-width: 200px; max-height: 150px; cursor: pointer;"
                                     data-bs-toggle="modal" data-bs-target="#imageModal" 
                                     data-img-src="/file/ppks/{{ $data->file_ppks }}" 
                                     alt="PPKS Preview">
                                <br><small class="text-muted">File saat ini: <a href="/file/ppks/{{ $data->file_ppks }}" target="_blank">Lihat File</a></small>
                            </div>
                        @else
                            <div class="mt-2">
                                <img id="ppks-preview" style="max-width: 200px; max-height: 150px; display: none;" class="img-thumbnail img-clickable" data-bs-toggle="modal" data-bs-target="#imageModal">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard.biodata.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        let kecamatanId = $('select[name="kecamatan_id"]').val();
        let desaId = "{{ old('desa_id', $data->desa_id ?? '') }}";

        if(kecamatanId) {
            $.ajax({
                url: '/dashboard/biodata/get-desa/' + kecamatanId,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    let desaSelect = $('select[name="desa_id"]');
                    desaSelect.empty();
                    $.each(data, function(key, value) {
                        let selected = value.id == desaId ? 'selected' : '';
                        desaSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.nama + '</option>');
                    });
                }
            });
        }
        // options desa dependent to kecamatan
        $(document).on('change', 'select[name="kecamatan_id"]', function() {
            console.log("masuk")
            var kecamatanId = $(this).val();
            if (kecamatanId) {
                $.ajax({
                    url: '/dashboard/biodata/get-desa/' + kecamatanId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="desa_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="desa_id"]').append('<option value="' + value.id + '">' + value.nama + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="desa_id"]').empty();
            }
        });
    </script>

    <script>
        // Function to preview uploaded files
        function previewFile(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            
            if (file) {
                // Check if file is an image
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        preview.setAttribute('data-img-src', e.target.result);
                        preview.style.cursor = 'pointer';
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    // For non-image files (PDF), hide preview
                    preview.style.display = 'none';
                }
            } else {
                preview.style.display = 'none';
            }
        }
        
        // Handle image modal
        $(document).ready(function() {
            $('.img-clickable').on('click', function() {
                const imgSrc = $(this).attr('data-img-src') || $(this).attr('src');
                $('#modalImage').attr('src', imgSrc);
            });
            
            // Update modal image when dynamically added images are clicked
            $(document).on('click', '.img-clickable', function() {
                const imgSrc = $(this).attr('data-img-src') || $(this).attr('src');
                $('#modalImage').attr('src', imgSrc);
            });
        });
    </script>
@endsection