@extends('adminlte::page')

@section('title','Pengajuan Customer')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@stop
@section('content_header')
<h1>Pengajuan Customer</h1>
@stop

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form method="POST" action="{{ route('customer.store') }}" enctype="multipart/form-data">
                    @csrf



                    <x-adminlte-card title="Data Toko" theme="dark" icon="fas fa-md fa-store-alt">
                        <div class="row">
                            {{-- input form Customer --}}


                            {{-- Nama Toko--}}
                            <div class="col-md-6">
                                <label for="name">Nama Toko</label>
                                <x-adminlte-input name="name" value="{{old('name')}}">
                                </x-adminlte-input>
                            </div>
                            {{-- Alamat --}}
                            <div class="col-md-6">
                                <label for="alamat">Alamat Toko</label>
                                <x-adminlte-input name="alamat" value="{{old('alamat')}}">
                                </x-adminlte-input>
                            </div>
                            {{-- Patokan --}}
                            <div class="col-md-6">
                                <label for="patokan">Patokan Alamat Toko</label>
                                <x-adminlte-input name="patokan" value="{{old('patokan')}}">
                                </x-adminlte-input>
                            </div>
                            {{-- Maps --}}
                            <div class="col-md-6">

                                <label for="maps">Maps Toko</label>
                                <x-adminlte-input name="maps" value="{{old('maps')}}">
                                    <x-slot name="appendSlot">
                                        <x-adminlte-button theme="outline-dark" onclick="openGoogleMap()" title="Open Google Maps"
                                            icon="fas fa-lg fa-map-marked-alt" />
                                    </x-slot>
                                </x-adminlte-input>

                            </div>

                            {{-- Nama Pemilik--}}
                            <div class="col-md-6">
                                <label for="pemilik">Nama Pemilik</label>
                                <x-adminlte-input name="pemilik" value="{{old('pemilik')}}">
                                </x-adminlte-input>
                            </div>
                            {{-- Telepon --}}
                            <div class="col-md-6">
                                <label for="telp">No Telp.</label>
                                <x-adminlte-input name="telp" value="{{old('telp')}}">
                                </x-adminlte-input>
                            </div>
                        </div>
                        {{-- foto toko --}}
                        <div class="row">
                            <div class="col-md-6">
                                <x-adminlte-input-file id="imgInp" label="Foto Toko" name="foto_toko"
                                    placeholder="Choose a file...">
                                    <x-slot name="prependSlot">
                                        <div class="input-group-text bg-lightblue">
                                            <i class="fas fa-upload"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input-file>
                            </div>
                            <div class="col-md-6">
                                <img id="foto_toko" src="{{asset('storage/toko/'. 'shop.png')}}" alt="Foto Toko"
                                    class="rounded mx-auto d-block mt-2" width="200px">
                            </div>
                        </div>
                    </x-adminlte-card>

                    <x-adminlte-card title="Data Order" theme="dark" icon="fas fa-md fa-cart-plus ">
                        <div class="row">

                            {{-- Limit --}}
                            <div class="col-md-6">
                                <label for="limit">Limit</label>
                                <x-adminlte-input name="limit" id="limit" value="{{old('limit')}}">
                                </x-adminlte-input>
                            </div>
                            {{-- Tipe Pembayaran --}}
                            <div class="col-md-6">
                                <label for="tipe_pembayaran">Tipe Pembayaran</label>
                                <x-adminlte-input name="tipe_pembayaran" value="{{old('tipe_pembayaran')}}">
                                </x-adminlte-input>
                            </div>
                            {{-- Area --}}
                            <div class="col-md-12">
                                <label for="area">Area</label>
                                <x-adminlte-input name="area" value="{{old('area')}}">
                                </x-adminlte-input>
                            </div>
                            {{-- Order --}}
                            <div class="col-md-12">
                                <x-adminlte-text-editor name="order" label="Detail Order" value="{{old('order')}}" />

                            </div>



                            <div class="col-md-12 text-center">
                                <x-adminlte-button class="btn-flat col-sm-2" type="submit" label="Submit"
                                    theme="success" icon="fas fa-lg fa-save" />
                            </div>



                        </div>
                    </x-adminlte-card>

                </form>
            </div>



        </main>
    </div>
</div>
@stop
@include('footer')



@section('plugins.Sweetalert2', true)
@section('plugins.Summernote', true)
@section('plugins.BsCustomFileInput', true)
@section('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
    // ttd
    imgInp.onchange = evt => {
                const [file] = imgInp.files
                if (file) {
                    foto_toko.src = URL.createObjectURL(file)
                }
    }

        // Function to add commas to a number
    function addCommas(number) {
        // Check if the input is a valid number
        if (isNaN(number)) {
            return "Please enter a valid number.";
        }
        
        // Convert number to locale string with commas
        return number.toLocaleString();
    }

    // Function to format number in the input field
    function formatInput() {
        let inputElement = document.getElementById("limit");
        let userInput = inputElement.value.replace(/,/g, ''); // Remove existing commas
        let number = parseFloat(userInput);

        if (!isNaN(number)) {
            inputElement.value = addCommas(number);
        }else {
            inputElement.value = ''; // Clear input if not a valid number
        }
    }

    // Add event listener for input changes
    document.getElementById("limit").addEventListener("input", formatInput);

    // google map
    function openGoogleMap() {
    window.open('https://www.google.com/maps/@-6.8665297,109.1429739,14z?entry=ttu', '_blank');
    }
</script>

@stop