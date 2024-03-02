@extends('adminlte::page')

@section('title','Customer')
@section('content_header')
<h1>Customer</h1>
@stop

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
                @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="row my-3">
                    <div class="col-md-12">
                        <x-adminlte-button onclick="return add();" label="Tambah" theme="primary" icon="fas fa-plus" />
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-12">

                        <table id="table_cuti" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama Toko</th>
                                    <th>Pemilik</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                @endphp
                                @foreach ($customer as $data)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    @php
                                    // Create a DateTime object from the string
                                    $dateTime = new DateTime($data->created_at);

                                    // Set the timezone to Indonesia (Jakarta)
                                    $dateTime->setTimezone(new DateTimeZone('Asia/Jakarta'));

                                    // Set the locale to Indonesian
                                    setlocale(LC_TIME, 'id_ID');

                                    // Format the date in the desired format for Indonesia
                                    $dateFormatted = strftime('%d %B %Y', $dateTime->getTimestamp());

                                    @endphp
                                    <td>{{ $dateFormatted }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->pemilik }}</td>
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
                                        @if (empty($data->deleted_at) && $data->status == 'Pending')
                                        <a class="btn btn-danger btn-delete" data-id="{{$data->id}}">Batal</a>
                                        @endif

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
                    window.location = "{{ route('customer.create') }}";
                 }
                $(function () {
                    $("#table_cuti").DataTable({
                      "responsive": true, "lengthChange": false, "autoWidth": false,
                    //   "buttons": ["excel", "pdf", "print"],
                      "paging": true,
                      "lengthChange": false,
                      "searching": true,
                      "ordering": true,
                      "info": true,
                      "autoWidth": false,
                      "responsive": true,
                    })
                   
                  });
                
                  $(document).on('click', '.btn-delete', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');

                    // Fetch CSRF token from the meta tag
                    var token = $('meta[name="csrf-token"]').attr('content');
                    let url = "/customer/" + id;

                  
                    Swal.fire({
                        title: 'Batalkan Permintaan ?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                
                        if (result.value) {
                
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                data: {
                                    '_token': token
                                },
                                success: function (data) {
                                    console.log(data);
                                    Swal.fire({
                                        title: 'Berhasil Dibatalkan!',
                                        type: "success"
                                    }
                                    );
                                    window.location.reload();
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: error
                                    });
                                }
                            });
                        }
                    });
                });
                
            </script>
            <script>
                $(document).on('click', '.btn-show', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id_show');

                    // Fetch CSRF token from the meta tag
                    var token = $('meta[name="csrf-token"]').attr('content');
                    let url = "/customer/" + id;

                
                            $.ajax({
                                type: "GET",
                                url: url,
    
                                success: function (data) {
                                    var customer = data.customer;

                                    Swal.fire({
                                        title: 'Customer Details',
                                        width: '65%',
                                        html: `
                                        <div class="container">
                                        <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                        <table style="width:100%;text-align:left;" class="custom-table">
                                            <tr>
                                                <th width="25%">Nama</th>
                                                <td width="3%">:</td>
                                                <td>${customer[0].name}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>:</td>
                                                <td>${customer[0].alamat}</td>
                                            </tr>
                                            <tr>
                                                <th>Patokan</th>
                                                <td>:</td>
                                                <td>${customer[0].patokan}</td>
                                            </tr>
                                            <tr>
                                                <th>Maps</th>
                                                <td>:</td>
                                                <td> 
                                                    <a target="_blank" href="/maps/${customer[0].id}">Lihat Maps</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Pemilik</th>
                                                <td>:</td>
                                                <td>${customer[0].pemilik}</td>
                                            </tr>
                                            <tr>
                                                <th>Diajukan Tgl</th>
                                                <td>:</td>
                                                <td>${customer[0].created_at}</td>
                                            </tr>
                                            <tr>
                                                <th>No. Telp</th>
                                                <td>:</td>
                                                <td>${customer[0].telp}</td>
                                            </tr>
                                            <tr>
                                                <th>Foto Toko</th>
                                                <td>:</td>
                                                <td>
                                                    <img  src="storage/toko/${customer[0].foto_toko}" alt="Foto Toko"
                                                    class="rounded mx-auto d-block mt-2" width="200px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Limit</th>
                                                <td>:</td>
                                                <td>Rp. ${customer[0].limit}</td>
                                            </tr>
                                            <tr>
                                                <th>Tipe Pembayaran</th>
                                                <td>:</td>
                                                <td>${customer[0].tipe_pembayaran}</td>
                                            </tr>
                                            <tr>
                                                <th>Order</th>
                                                <td>:</td>
                                                <td>${customer[0].order}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>:</td>
                                                <td>${customer[0].status}</td>
                                            </tr>
                                            <tr>
                                                <th>Approve By</th>
                                                <td>:</td>
                                                <td>${customer[0].approve_by}</td>
                                            </tr>
                                            
                                        </table>
                                        </div>
                                        </div>
                                        </div>
                                        `,
                                        showCloseButton: true,
                                        showConfirmButton: false,
                                        // You can customize the modal further as needed
                                        customClass: {
                                            container: 'custom-swal-container'
                                        }
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