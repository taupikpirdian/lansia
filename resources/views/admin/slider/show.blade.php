@extends('layouts.admin')

@section('content-header')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Detail Slider</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard.slider.index') }}">Slider</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <h3 class="card-title m-0">Informasi Slider</h3>
                        <div>
                            <a href="{{ route('dashboard.slider.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" 
                                       value="{{ old('name', $data->name ?? '') }}" 
                                       placeholder="Masukkan judul slider" 
                                       readonly
                                       >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                       id="description" 
                                       name="description" 
                                       placeholder="Masukkan deskripsi slider" 
                                       readonly
                                >{{ old('description', $data->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="image" class="form-label">Gambar <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" 
                                       disabled
                                       >
                                    @if($data)
                                        <img src="{{ url('file/sliders/' . $data->image) }}"
                                        class="card-img-top rounded object-fit-cover img-clickable"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imageModal"
                                        data-img-src="{{ url('file/slider/' . $data->image) }}"
                                        alt="Image" style="width: 300px; height: 300px;">
                                    @endif
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- User Statistics Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title m-0">Statistik</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Bergabung:</span>
                        <span class="text-muted">{{ $data->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Terakhir Update:</span>
                        <span class="text-muted">{{ $data->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Actions Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title m-0">Aksi</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('dashboard.slider.edit', $data->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit Slider
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $data->id }})">
                            <i class="fas fa-trash"></i> Hapus Slider
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Form -->
<form id="delete-form-{{ $data->id }}" action="{{ route('dashboard.slider.destroy', $data->id) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data user akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }
</script>
@endsection