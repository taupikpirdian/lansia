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
                <form action="{{ route('dashboard.biodata.update', $data->id) }}" method="POST">
                @method('PUT')
            @else
                <form action="{{ route('dashboard.biodata.store') }}" method="POST">
            @endif
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No KK <span class="text-danger">*</span></label>
                        <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk', $data->no_kk ?? '') }}" required>
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
@endsection