@extends('layouts.admin')
@section('content-header')
  <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
      <div class="col-sm-6"><h3 class="mb-0">Iket Dalang</h3></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Iket Dalang</li>
        </ol>
      </div>
    </div>
    <!--end::Row-->
  </div>
@endsection
@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h3 class="card-title m-0">Data Iket Dalang</h3>
                @if (Auth::user()->roles[0]->name == 'admin' || Auth::user()->roles[0]->name == 'operator-desa')
                    <a href="{{ route('dashboard.biodata.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
        <table id="example" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>No</th>
                <th>No KK</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>JK</th>
                <th>Agama</th>
                <th>Status Nikah</th>
                <th>Kategori</th>
                <th>Kondisi</th>
                <th>Pengampu</th>
                <th>Approved (2)</th>
                <th>Status</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        </div>  
    </div>
</div>

@endsection
@section('scripts')
<script>
    var dataTable = $("#example").DataTable({
        //   "scrollX": true,
          processing: true,
          serverSide: true,
          autoWidth: true,
          orderCellsTop: true,
          fixedHeader: true,
          scrollX: true,
          fixedColumns: {
              right: 1,
              left: 0,
          },
          ajax: "{{ route('dashboard.biodata.datatable') }}",
          columns: [
              {
                  data: 'DT_RowIndex',
                  orderable: false
              },
              {
                  data: 'no_kk',
                  name: 'no_kk'
              },
              {
                  data: 'nama',
                  name: 'nama'
              },
              {
                  data: 'tempat_lahir',
                  name: 'tempat_lahir'
              },
              {
                  data: 'tanggal_lahir',
                  name: 'tanggal_lahir'
              },
              {
                  data: 'jk',
                  name: 'jk'
              },
              {
                  data: 'agama',
                  name: 'agama'
              },
              {
                  data: 'status_nikah',
                  name: 'status_nikah'
              },
              {
                  data: 'kategori',
                  name: 'kategori'
              },
              {
                  data: 'kondisi',
                  name: 'kondisi'
              },
              {
                  data: 'pengampu',
                  name: 'pengampu'
              },
              {
                  data: 'approved',
                  name: 'approved'
              },
              {
                  data: 'status',
                  name: 'status'
              },
              {
                  data: 'created_at',
                  name: 'created_at'
              },
              {
                  data: 'action',
                  orderable: false
              }
          ]
    });

    function destroy(id) {
        var url = "{{ route('dashboard.biodata.destroy', ':id') }}".replace(':id', id);
        callDataWithAjax(url, 'POST', {
            _method: "DELETE"
        }).then((data) => {
            Swal.fire({
                title: 'Success',
                text: `Data user berhasil dihapus`,
                icon: 'success',
                confirmButtonText: 'OK'
            });
            setTimeout(function() {
                location.reload();
            }, 500);
        }).catch((xhr) => {
            alert('Error: ' + xhr.responseText);
        })
    }

    function approveData(id) {
        Swal.fire({
            title: 'Approve Data',
            input: 'text', // tipe input: text
            inputLabel: 'Masukkan catatan (opsional)',
            inputPlaceholder: 'Tulis catatan di sini...',
            showCancelButton: true,
            confirmButtonText: 'Approve',
            cancelButtonText: 'Batal',
            preConfirm: (note) => {
                // kirim ajax hanya jika user klik approve
                var url = "{{ route('dashboard.biodata.approve', ':id') }}".replace(':id', id);
                return callDataWithAjax(url, 'POST', {
                    _method: "POST",
                    note: note // kirim note ke server
                }).then((data) => {
                    return data;
                }).catch((xhr) => {
                    Swal.showValidationMessage(`Request failed: ${xhr.responseText}`);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Success',
                    text: 'Data berhasil di approve',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            }
        });
    }

    function rejectData(id) {
        Swal.fire({
            title: 'Reject Data',
            input: 'textarea', // gunakan textarea supaya bisa panjang
            inputLabel: 'Masukkan catatan',
            inputPlaceholder: 'Tulis catatan di sini...',
            showCancelButton: true,
            confirmButtonText: 'Reject',
            cancelButtonText: 'Batal',
            preConfirm: (note) => {
                if (!note || note.trim() === '') {
                    Swal.showValidationMessage('Catatan wajib diisi!');
                    return false; // mencegah Swal ditutup
                }

                var url = "{{ route('dashboard.biodata.reject', ':id') }}".replace(':id', id);
                return callDataWithAjax(url, 'POST', {
                    _method: "POST",
                    note: note.trim() // kirim note ke server
                }).then((data) => {
                    return data;
                }).catch((xhr) => {
                    Swal.showValidationMessage(`Request failed: ${xhr.responseText}`);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Success',
                    text: 'Data berhasil di reject',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            }
        });
    }
</script>
@endsection
