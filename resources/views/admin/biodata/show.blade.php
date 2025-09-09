@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Detail Iket Dalang</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.biodata.index') }}">Iket Dalang</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Informasi Biodata -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h3 class="card-title m-0">Informasi Iket Dalang</h3>
                        <div>
                            <a href="{{ route('dashboard.biodata.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">No KK</label>
                            <p class="form-control-plaintext">{{ $data->no_kk }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama</label>
                            <p class="form-control-plaintext">{{ $data->nama }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tempat Lahir</label>
                            <p class="form-control-plaintext">{{ $data->tempat_lahir }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lahir</label>
                            <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Kelamin</label>
                            <p class="form-control-plaintext">{{ $data->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Agama</label>
                            <p class="form-control-plaintext">{{ $data->agama->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kecamatan</label>
                            <p class="form-control-plaintext">{{ $data->kecamatan->nama ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Desa</label>
                            <p class="form-control-plaintext">{{ $data->desa->nama ?? '-' }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <p class="form-control-plaintext">{{ $data->alamat }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status Nikah</label>
                            <p class="form-control-plaintext">{{ $data->statusNikah->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <p class="form-control-plaintext">{{ $data->kategori->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kondisi</label>
                            <p class="form-control-plaintext">{{ $data->kondisi->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pengampu</label>
                            <p class="form-control-plaintext">{{ $data->pengampu->name ?? '-' }}</p>
                        </div>

                        <div class="col-12 mt-3">
                            <h5 class="fw-bold mb-3">Journey Data Approval</h5>
                            <ul class="list-group">
                                @forelse($data->journeyApprovals as $approval)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            Status: 
                                            @if($approval->status == '1')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($approval->status == '0')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-secondary">Pending</span>
                                            @endif
                                            <div class="text-muted small mt-1">
                                                {{ $approval->user->name ?? 'System' }} - 
                                                {{ $approval->updated_at ? \Carbon\Carbon::parse($approval->updated_at)->format('d/m/Y H:i') : '-' }}
                                                <br>
                                                Catatan: {{ $approval->notes ?? '-' }}
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">Belum ada data approval</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Avatar, Statistik, Aksi -->
        <div class="col-md-4">
            <!-- Statistik Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title m-0">Statistik</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Dibuat:</span>
                        <span class="text-muted">{{ $data->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Terakhir Update:</span>
                        <span class="text-muted">{{ $data->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
            @if (Auth::user()->roles[0]->name == 'admin' || Auth::user()->roles[0]->name == 'operator-desa')
            {{-- status != disetujui --}}
                @if ($data->status != 'disetujui')
                <!-- Actions Card -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title m-0">Aksi</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('dashboard.biodata.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit Data
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $data->id }})">
                                <i class="fas fa-trash"></i> Hapus Data
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
