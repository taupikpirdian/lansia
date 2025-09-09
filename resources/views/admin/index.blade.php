@extends('layouts.admin')

@section('content-header')
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
      </div>
    </div>
    <!--end::Row-->
  </div>
@endsection

@section('content')
<div class="container-fluid">
  <!-- Ringkasan Cepat -->
  <div class="row mb-4">
    <div class="col-lg-3 col-6">
      <div class="small-box text-bg-primary">
        <div class="inner">
          <h3>11</h3>
          <p>Total Penduduk Terdaftar</p>
        </div>
        <i class="bi bi-people small-box-icon"></i>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box text-bg-success">
        <div class="inner">
          <h3>2</h3>
          <p>Penduduk Eligible</p>
        </div>
        <i class="bi bi-check-circle small-box-icon"></i>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box text-bg-warning">
        <div class="inner">
          <h3>3</h3>
          <p>Total Desa</p>
        </div>
        <i class="bi bi-geo small-box-icon"></i>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box text-bg-danger">
        <div class="inner">
          <h3>3</h3>
          <p>Kategori Khusus (Lansia/Disabilitas)</p>
        </div>
        <i class="bi bi-person-wheelchair small-box-icon"></i>
      </div>
    </div>
  </div>

  <!-- Statistik Demografi -->
  <h5 class="fw-bold mb-3">Statistik Demografi</h5>
  <div class="row mb-4">
    <div class="col-lg-3">
      <div class="card shadow-sm">
        <div class="card-header">Jenis Kelamin</div>
        <div class="card-body"><canvas id="chartJenisKelamin"></canvas></div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card shadow-sm">
        <div class="card-header">Status Nikah</div>
        <div class="card-body"><canvas id="chartStatusNikah"></canvas></div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card shadow-sm">
        <div class="card-header">Kategori</div>
        <div class="card-body"><canvas id="chartKategori"></canvas></div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card shadow-sm">
        <div class="card-header">Agama</div>
        <div class="card-body"><canvas id="chartAgama"></canvas></div>
      </div>
    </div>
  </div>

  <!-- Distribusi Wilayah -->
  <h5 class="fw-bold mb-3">Distribusi Wilayah</h5>
  <div class="row mb-4">
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header">Penduduk per Kecamatan</div>
        <div class="card-body"><canvas id="chartKecamatan"></canvas></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header">Penduduk per Desa</div>
        <div class="card-body"><canvas id="chartDesa"></canvas></div>
      </div>
    </div>
    <div class="col-12 mt-3">
      <div class="card shadow-sm">
        <div class="card-header">Top 5 Desa/Kecamatan dengan Penduduk Terbanyak</div>
        <div class="card-body">
          <table class="table table-striped table-bordered">
            <thead>
              <tr><th>Nama</th><th>Jumlah Penduduk</th></tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Kondisi & Pengampu -->
  <h5 class="fw-bold mb-3">Kondisi & Pengampu</h5>
  <div class="row mb-4">
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header">Kondisi</div>
        <div class="card-body"><canvas id="chartKondisi"></canvas></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="card-header">Pengampu</div>
        <div class="card-body"><canvas id="chartPengampu"></canvas></div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<!-- apexcharts -->
<script
    src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
    integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
    crossorigin="anonymous"
></script>
<!-- ChartJS -->
<script>
    // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
    // IT'S ALL JUST JUNK FOR DEMO
    // ++++++++++++++++++++++++++++++++++++++++++

    const sales_chart_options = {
    series: [
        {
        name: 'Digital Goods',
        data: [28, 48, 40, 19, 86, 27, 90],
        },
        {
        name: 'Electronics',
        data: [65, 59, 80, 81, 56, 55, 40],
        },
    ],
    chart: {
        height: 300,
        type: 'area',
        toolbar: {
        show: false,
        },
    },
    legend: {
        show: false,
    },
    colors: ['#0d6efd', '#20c997'],
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'smooth',
    },
    xaxis: {
        type: 'datetime',
        categories: [
        '2023-01-01',
        '2023-02-01',
        '2023-03-01',
        '2023-04-01',
        '2023-05-01',
        '2023-06-01',
        '2023-07-01',
        ],
    },
    tooltip: {
        x: {
        format: 'MMMM yyyy',
        },
    },
    };

    const sales_chart = new ApexCharts(
    document.querySelector('#revenue-chart'),
    sales_chart_options,
    );
    sales_chart.render();
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // ==== Data Dummy ====
  const dataJenisKelamin = { "Laki-laki": 2700, "Perempuan": 2530 };
  const dataAgama        = [
    {label: "Islam", total: 4000}, 
    {label: "Kristen", total: 800}, 
    {label: "Hindu", total: 200}, 
    {label: "Buddha", total: 150}, 
    {label: "Lainnya", total: 80}
  ];
  const dataStatusNikah  = [
    {label: "Belum Menikah", total: 1800}, 
    {label: "Menikah", total: 3000}, 
    {label: "Cerai", total: 200}, 
    {label: "Cerai Mati", total: 230}
  ];
  const dataKategori     = [
    {label: "Miskin", total: 500}, 
    {label: "Disabilitas", total: 120}, 
    {label: "Lansia", total: 300}, 
    {label: "Lainnya", total: 100}
  ];
  const dataKecamatan    = [
    {label: "Kec. A", total: 1200}, 
    {label: "Kec. B", total: 1500}, 
    {label: "Kec. C", total: 800}, 
    {label: "Kec. D", total: 900}, 
    {label: "Kec. E", total: 830}
  ];
  const dataDesa         = [
    {label: "Desa 1", total: 400}, 
    {label: "Desa 2", total: 520}, 
    {label: "Desa 3", total: 600}, 
    {label: "Desa 4", total: 700}, 
    {label: "Desa 5", total: 350}
  ];
  const dataKondisi      = [
    {label: "Sehat", total: 4300}, 
    {label: "Sakit", total: 700}, 
    {label: "Disabilitas", total: 230}
  ];
  const dataPengampu     = [
    {label: "Orang Tua", total: 3000}, 
    {label: "Saudara", total: 800}, 
    {label: "Lembaga", total: 200}, 
    {label: "Mandiri", total: 1230}
  ];
  const dataKelahiran    = [
    {label: "2019", total: 120}, 
    {label: "2020", total: 150}, 
    {label: "2021", total: 180}, 
    {label: "2022", total: 170}, 
    {label: "2023", total: 190}
  ];
  const dataKelompokUmur = [
    {label: "0-17 (Anak)", total: 1800}, 
    {label: "18-59 (Dewasa)", total: 2800}, 
    {label: "60+ (Lansia)", total: 630}
  ];

  // ==== Chart Rendering ====
  new Chart(document.getElementById('chartJenisKelamin'), {
    type: 'pie',
    data: {
      labels: Object.keys(dataJenisKelamin),
      datasets: [{
        data: Object.values(dataJenisKelamin),
        backgroundColor: ['#0d6efd', '#dc3545']
      }]
    }
  });

  new Chart(document.getElementById('chartAgama'), {
    type: 'bar',
    data: {
      labels: dataAgama.map(d => d.label),
      datasets: [{
        label: 'Jumlah',
        data: dataAgama.map(d => d.total),
        backgroundColor: '#198754'
      }]
    }
  });

  new Chart(document.getElementById('chartStatusNikah'), {
    type: 'doughnut',
    data: {
      labels: dataStatusNikah.map(d => d.label),
      datasets: [{
        data: dataStatusNikah.map(d => d.total),
        backgroundColor: ['#0d6efd', '#198754', '#dc3545', '#ffc107']
      }]
    }
  });

  new Chart(document.getElementById('chartKategori'), {
    type: 'bar',
    data: {
      labels: dataKategori.map(d => d.label),
      datasets: [{
        label: 'Jumlah',
        data: dataKategori.map(d => d.total),
        backgroundColor: ['#6f42c1', '#20c997', '#fd7e14', '#0dcaf0']
      }]
    }
  });

  new Chart(document.getElementById('chartKecamatan'), {
    type: 'bar',
    data: {
      labels: dataKecamatan.map(d => d.label),
      datasets: [{
        label: 'Jumlah',
        data: dataKecamatan.map(d => d.total),
        backgroundColor: '#0d6efd'
      }]
    }
  });

  new Chart(document.getElementById('chartDesa'), {
    type: 'bar',
    data: {
      labels: dataDesa.map(d => d.label),
      datasets: [{
        label: 'Jumlah',
        data: dataDesa.map(d => d.total),
        backgroundColor: '#20c997'
      }]
    }
  });

  new Chart(document.getElementById('chartKondisi'), {
    type: 'pie',
    data: {
      labels: dataKondisi.map(d => d.label),
      datasets: [{
        data: dataKondisi.map(d => d.total),
        backgroundColor: ['#198754', '#ffc107', '#dc3545']
      }]
    }
  });

  new Chart(document.getElementById('chartPengampu'), {
    type: 'bar',
    data: {
      labels: dataPengampu.map(d => d.label),
      datasets: [{
        label: 'Jumlah',
        data: dataPengampu.map(d => d.total),
        backgroundColor: '#6f42c1'
      }]
    }
  });
</script>
@endsection
