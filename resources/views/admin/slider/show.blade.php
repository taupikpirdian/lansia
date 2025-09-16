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
                                <label for="image" class="form-label">Gambar Utama <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       id="image" name="image" 
                                       disabled
                                       >
                                    @if($data && $data->image)
                                        <img src="{{ url('file/sliders/' . $data->image) }}"
                                        class="card-img-top rounded object-fit-cover img-clickable"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imageModal"
                                        data-img-src="{{ url('file/sliders/' . $data->image) }}"
                                        alt="Image" style="width: 300px; height: 300px;">
                                    @endif
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="background_image" class="form-label">Background Image</label>
                                <input type="file" class="form-control" disabled>
                                @if($data && $data->background_image)
                                    <img src="{{ url('file/sliders/' . $data->background_image) }}"
                                    class="card-img-top rounded object-fit-cover img-clickable mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#imageModal"
                                    data-img-src="{{ url('file/sliders/' . $data->background_image) }}"
                                    alt="Background Image" style="width: 300px; height: 200px;">
                                @endif
                            </div>
                        </div>

                        <!-- Person 1 -->
                        <div class="col-md-12">
                            <h6 class="fw-bold text-primary mb-3">Person 1</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="person1_name" class="form-label">Nama Person 1</label>
                                <input type="text" class="form-control" 
                                       value="{{ $data->person1_name ?? '-' }}" 
                                       readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="person1_position" class="form-label">Jabatan Person 1</label>
                                <input type="text" class="form-control" 
                                       value="{{ $data->person1_position ?? '-' }}" 
                                       readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="person1_image" class="form-label">Foto Person 1</label>
                                <input type="file" class="form-control" disabled>
                                @if($data && $data->person1_image)
                                    <img src="{{ url('file/sliders/' . $data->person1_image) }}"
                                    class="card-img-top rounded-circle object-fit-cover img-clickable mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#imageModal"
                                    data-img-src="{{ url('file/sliders/' . $data->person1_image) }}"
                                    alt="Person 1" style="width: 120px; height: 120px;">
                                @endif
                            </div>
                        </div>

                        <!-- Person 2 -->
                        <div class="col-md-12">
                            <h6 class="fw-bold text-primary mb-3">Person 2</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="person2_name" class="form-label">Nama Person 2</label>
                                <input type="text" class="form-control" 
                                       value="{{ $data->person2_name ?? '-' }}" 
                                       readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="person2_position" class="form-label">Jabatan Person 2</label>
                                <input type="text" class="form-control" 
                                       value="{{ $data->person2_position ?? '-' }}" 
                                       readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="person2_image" class="form-label">Foto Person 2</label>
                                <input type="file" class="form-control" disabled>
                                @if($data && $data->person2_image)
                                    <img src="{{ url('file/sliders/' . $data->person2_image) }}"
                                    class="card-img-top rounded-circle object-fit-cover img-clickable mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#imageModal"
                                    data-img-src="{{ url('file/sliders/' . $data->person2_image) }}"
                                    alt="Person 2" style="width: 120px; height: 120px;">
                                @endif
                            </div>
                        </div>

                        <!-- Person 3 -->
                        <div class="col-md-12">
                            <h6 class="fw-bold text-primary mb-3">Person 3</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="person3_name" class="form-label">Nama Person 3</label>
                                <input type="text" class="form-control" 
                                       value="{{ $data->person3_name ?? '-' }}" 
                                       readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="person3_position" class="form-label">Jabatan Person 3</label>
                                <input type="text" class="form-control" 
                                       value="{{ $data->person3_position ?? '-' }}" 
                                       readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="person3_image" class="form-label">Foto Person 3</label>
                                <input type="file" class="form-control" disabled>
                                @if($data && $data->person3_image)
                                    <img src="{{ url('file/sliders/' . $data->person3_image) }}"
                                    class="card-img-top rounded-circle object-fit-cover img-clickable mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#imageModal"
                                    data-img-src="{{ url('file/sliders/' . $data->person3_image) }}"
                                    alt="Person 3" style="width: 120px; height: 120px;">
                                @endif
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