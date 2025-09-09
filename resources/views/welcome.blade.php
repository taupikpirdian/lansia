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
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ url('file/sliders/' . $slider->image) }}" class="d-block w-100" alt="{{ $slider->name }}" style="height:500px; object-fit:cover;">
                @if($slider->name || $slider->description)
                <div class="carousel-caption d-none d-md-block" style="background-color: rgba(0,0,0,0.5); padding: 20px;">
                    @if($slider->name) <h2>{{ $slider->name }}</h2> @endif
                    @if($slider->description) <p>{{ $slider->description }}</p> @endif
                </div>
                @endif
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
            <h2 class="fw-bold">Sistem Informasi Pendataan Lansia</h2>
            <p class="lead">Pendataan warga lanjut usia untuk meningkatkan pelayanan dan kesejahteraan</p>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill text-primary" style="font-size: 3rem;"></i>
                    <h4 class="card-title mt-3">Pendataan</h4>
                    <p class="card-text">Sistem pendataan warga lansia yang akurat dan terintegrasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-heart-pulse-fill text-danger" style="font-size: 3rem;"></i>
                    <h4 class="card-title mt-3">Kesehatan</h4>
                    <p class="card-text">Pemantauan kesehatan dan riwayat medis warga lansia</p>
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