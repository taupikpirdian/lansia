@extends('layouts.app')

@section('content')
<!-- Hero Section with Slider -->
<div class="container-fluid p-0">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            @foreach($sliders as $key => $slider)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($sliders as $key => $slider)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="position: relative; height: 650px;">
                <!-- Background Image -->
                @if($slider->background_image)
                    <img src="/file/sliders/{{ $slider->background_image }}" class="d-block w-100 h-100" alt="Background" style="object-fit: cover; position: absolute; top: 0; left: 0; z-index: 1;">
                @else
                    <img src="{{ url('file/sliders/' . $slider->image) }}" class="d-block w-100 h-100" alt="{{ $slider->name }}" style="object-fit: cover; position: absolute; top: 0; left: 0; z-index: 1;">
                @endif
                
                <!-- Overlay -->
                <div class="position-absolute w-100 h-100" style="background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%); z-index: 2;"></div>
                
                <!-- Content Container -->
                <div class="position-absolute w-100 h-100 d-flex align-items-center" style="z-index: 3;">
                    <div class="container">
                        <div class="row align-items-center h-100">
                            <!-- Left Side: Title and Description -->
                            <div class="col-md-6">
                                @if($slider->name)
                                    <h1 class="text-white fw-bold mb-4" style="font-size: 3.5rem; line-height: 1.2;">{{ $slider->name }}</h1>
                                @endif
                                @if($slider->description)
                                    <p class="text-white fs-5 mb-4" style="line-height: 1.6;">{{ $slider->description }}</p>
                                @endif
                            </div>
                            
                            <!-- Right Side: Three People -->
                            <div class="col-md-6">
                                <div class="row justify-content-end">
                                    @if($slider->person1_image)
                                    <div class="col-4 text-center mb-3">
                                        <div class="person-card">
                                            <img src="/file/sliders/{{ $slider->person1_image }}" 
                                                 class="rounded-circle mb-3" 
                                                 alt="{{ $slider->person1_name }}" 
                                                 style="width: 200px; height: 200px; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                                            @if($slider->person1_name)
                                                <h5 class="text-white fw-bold mb-1">{{ $slider->person1_name }}</h5>
                                            @endif
                                            @if($slider->person1_position)
                                                <p class="text-white-50 small mb-0">{{ $slider->person1_position }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($slider->person2_image)
                                    <div class="col-4 text-center mb-3">
                                        <div class="person-card">
                                            <img src="/file/sliders/{{ $slider->person2_image }}" 
                                                 class="rounded-circle mb-3" 
                                                 alt="{{ $slider->person2_name }}" 
                                                 style="width: 200px; height: 200px; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                                            @if($slider->person2_name)
                                                <h5 class="text-white fw-bold mb-1">{{ $slider->person2_name }}</h5>
                                            @endif
                                            @if($slider->person2_position)
                                                <p class="text-white-50 small mb-0">{{ $slider->person2_position }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($slider->person3_image)
                                    <div class="col-4 text-center mb-3">
                                        <div class="person-card">
                                            <img src="/file/sliders/{{ $slider->person3_image }}" 
                                                 class="rounded-circle mb-3" 
                                                 alt="{{ $slider->person3_name }}" 
                                                 style="width: 200px; height: 200px; object-fit: cover; border: 4px solid white; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
                                            @if($slider->person3_name)
                                                <h5 class="text-white fw-bold mb-1">{{ $slider->person3_name }}</h5>
                                            @endif
                                            @if($slider->person3_position)
                                                <p class="text-white-50 small mb-0">{{ $slider->person3_position }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>      
</div>

<!-- Main Content -->
<div class="container my-5">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">SISTEM PENGELOLAAN DATA WARGA</h2>
            <p class="lead">Pendataan data keterlantaran anak disabilitas, lansia, gepeng (iket dalang) dinsos ppkb dan p3a kabupaten tasikmalaya</p>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill text-primary" style="font-size: 3rem;"></i>
                    <h4 class="card-title mt-3">Pendataan</h4>
                    <p class="card-text">Sistem pendataan warga anak disabilitas, lansia, gepeng (iket dalang) dinsos ppkb dan p3a yang akurat dan terintegrasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-heart-pulse-fill text-danger" style="font-size: 3rem;"></i>
                    <h4 class="card-title mt-3">Kesehatan</h4>
                    <p class="card-text">Pemantauan kesehatan dan riwayat medis warga</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up-arrow text-success" style="font-size: 3rem;"></i>
                    <h4 class="card-title mt-3">Statistik</h4>
                    <p class="card-text">Analisis data dan statistik untuk pengambilan keputusan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection