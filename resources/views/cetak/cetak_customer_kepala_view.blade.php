@extends('adminlte::page')

@section('title','Cetak Data')
@section('content_header')
<h1>Cetak Data</h1>
@stop

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
               
                <div class="row">

                    <div class="col-md-12">

                        <table id="table_cuti" class="table table-bordered table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Nama</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal Cuti</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                @endphp
                                @foreach ($cuti as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->jenis_cuti }}</td>
                                    <td>{{ $data->tgl_cuti }}</td>
                                    <td>{{ $data->hari }}</td>
                                    <td>
                                        @php
                                        $dotColor = '';
                                        switch ($data->status) {
                                        case 'Pending':
                                        $dotColor = 'yellow';
                                        break;
                                        case 'Batal':
                                        $dotColor = 'red';
                                        break;
                                        case 'Ditolak':
                                        $dotColor = 'red';
                                        break;
                                        case 'Disetujui':
                                        $dotColor = 'green';
                                        break;
                                        default:
                                        $dotColor = 'black'; // Default color
                                        break;
                                        }
                                        @endphp
                                        <span
                                            style="display: inline-block; height: 10px; width: 10px; border-radius: 50%; background-color: {{ $dotColor }}; margin-right: 5px;"></span>
                                        {{ $data->status }}
                                    </td>
                                    <td>
                                        {{-- <a class="btn btn-info" href="{{ route('cuti.show',$data->id) }}">Show</a>
                                        --}}

                                        <button class="btn btn-info btn-show"
                                            data-id_show="{{ $data->id }}">Show</button>
                            
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>


                    </div>
                </div>

            </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
            @stop
            @include('footer')


            @section('plugins.Datatables', true)
            @section('plugins.DatatablesPlugin', true)
            @section('plugins.Sweetalert2', true)

            @section('js')
            <script type="text/javascript">
                function add() {
                    window.location = "{{ route('cuti.create') }}";
                 }
                 $(function () {
                    $("#table_cuti").DataTable({
                      "paging": true,
                      "lengthChange": false,
                      "searching": true,
                      "ordering": true,
                      "info": true,
                      "autoWidth": false,
                      "responsive": true,
                      "buttons": [
                            {
                                extend: 'excelHtml5',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3 ]
                                }
                            },
                            {
                                extend: 'pdfHtml5',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3 ]
                                }
                            },
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [ 0, 1, 2, 3 ]
                                }
                            }
                        ]
                    }).buttons().container().appendTo('#table_cuti_wrapper .col-md-6:eq(0)');
                   
                  });
                

                
            </script>
            <script>
                $(document).on('click', '.btn-show', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id_show');

                    // Fetch CSRF token from the meta tag
                    var token = $('meta[name="csrf-token"]').attr('content');
                    let url = "/cuti/" + id;

                
                            $.ajax({
                                type: "GET",
                                url: url,
    
                                success: function (data) {
                                    var cuti = data.cuti;

                                    Swal.fire({
                                        title: 'Cuti Details',
                                        html: `
                                        <table style="width:100%;text-align:left;">
                                            <tr>
                                                <th>NIP</th>
                                                <td>:</td>
                                                <td>${cuti[0].nip}</td>
                                            </tr>
                                            <tr>
                                                <th>Name</th>
                                                <td>:</td>
                                                <td>${cuti[0].name}</td>
                                            </tr>
                                            <tr>
                                                <th>Bagian</th>
                                                <td>:</td>
                                                <td>${cuti[0].bagian}</td>
                                            </tr>
                                            <tr>
                                                <th>Jabatan</th>
                                                <td>:</td>
                                                <td>${cuti[0].jabatan}</td>
                                            </tr>
                                            <tr>
                                                <th>Pangkat</th>
                                                <td>:</td>
                                                <td>${cuti[0].pangkat}</td>
                                            </tr>
                                            <tr>
                                                <th>Diajukan Tgl</th>
                                                <td>:</td>
                                                <td>${cuti[0].created_at}</td>
                                            </tr>
                                            <tr>
                                                <th>Jenis Cuti</th>
                                                <td>:</td>
                                                <td>${cuti[0].jenis_cuti}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Cuti</th>
                                                <td>:</td>
                                                <td>${cuti[0].tgl_cuti}</td>
                                            </tr>
                                            <tr>
                                                <th>Jumlah Hari</th>
                                                <td>:</td>
                                                <td>${cuti[0].hari} hari</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat Cuti</th>
                                                <td>:</td>
                                                <td>${cuti[0].alamat_cuti}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>:</td>
                                                <td>${cuti[0].status}</td>
                                            </tr>
                                            <tr>
                                                <th>Approve By</th>
                                                <td>:</td>
                                                <td>${cuti[0].approve_by}</td>
                                            </tr>
                                            
                                        </table>
                                        `,
                                        showCloseButton: true,
                                        showConfirmButton: false
                                        // You can customize the modal further as needed
                                    });
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: error
                                    });
                                }
                            });
                });
            </script>
            @stop