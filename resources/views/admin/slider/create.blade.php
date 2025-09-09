@extends('layouts.admin')
@section('content-header')
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        @if($is_edit)
            <div class="col-sm-6"><h3 class="mb-0">Edit Slider</h3></div>
        @else
            <div class="col-sm-6"><h3 class="mb-0">Tambah Slider</h3></div>
        @endif
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.slider.index') }}">Slider</a></li>
            @if($is_edit)
            <li class="breadcrumb-item"><a href="{{ route('dashboard.slider.edit', $data->id) }}">Edit Slider</a></li>
            @else
            <li class="breadcrumb-item active" aria-current="page">Tambah Slider</li>
            @endif
            </ol>
        </div>
    </div>
    <!--end::Row-->
  </div>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        @if($is_edit)
                        <h3 class="card-title m-0">Form Edit Slider</h3>
                        @else
                        <h3 class="card-title m-0">Form Tambah Slider</h3>
                        @endif
                        <a href="{{ route('dashboard.slider.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan!</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($is_edit)
                        <form action="{{ route('dashboard.slider.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                    @else
                        <form action="{{ route('dashboard.slider.store') }}" method="POST" enctype="multipart/form-data">
                    @endif
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" 
                                           value="{{ old('name', $data->name ?? '') }}" 
                                           placeholder="Masukkan judul slider" 
                                           required
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
                                           required
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

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('dashboard.slider.index') }}" class="btn btn-secondary">
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
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0"><i class="fas fa-info-circle"></i> Informasi</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-lightbulb"></i> Petunjuk Pengisian:</h6>
                        <ul class="mb-0 small">
                            <li>Title wajib diisi</li>
                            <li>Deskripsi wajib diisi</li>
                            <li>File Gambar wajib diisi</li>
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#institution-row').hide();
        var is_edit = {!! json_encode($is_edit) !!};
        // when $is_edit == true, remove required on password and confirmation_password
        if (is_edit) {
            $('#password-label').text('Password');
            $('#password-confirmation-label').text('Konfirmasi Password');
            $('#password').attr('required', false);
            $('#password_confirmation').attr('required', false);
        }
    });
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Password dan konfirmasi password tidak sama!');
            return false;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            alert('Password minimal 8 karakter!');
            return false;
        }
    });
</script>
@endsection