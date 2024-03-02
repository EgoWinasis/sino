<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use PDF;
use Carbon\Carbon;

class CetakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $customer = DB::table('customer')
                ->select('*')
                ->where('status', '=', 'Disetujui')
                ->orderBy('created_at', 'desc')
                ->get();
            return view('cetak.cetak_customer_admin_view')->with(compact('customer'));
        }

        if (Auth::user()->role == 'user') {
            $customer = DB::table('customer')
                ->select('*')
                ->where('id_user', '=', Auth::user()->id)
                ->where('status', '=', 'Disetujui')
                ->orderBy('created_at', 'desc')
                ->get();


            return view('cetak.cetak_customer_view')->with(compact('customer'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // Create an instance of mPDF
        $mpdf = new Mpdf();
        $customers = DB::table('customer')
            ->select('*')
            ->where('id', '=', $id)
            ->get();
        // Your content - replace this with your HTML content or view rendering
        foreach ($customers as $customer) {
            $sales = DB::table('users')
            ->select('name')
            ->where('id', '=', $customer->id_user)
            ->get();
            $sales =  $sales->first();
            $sales = $sales->name;
            $tglPengajuan = $customer->created_at;
            $namaToko = $customer->name;
            $alamatToko = $customer->alamat;
            $patokanToko = $customer->patokan;
            $pemilikToko = $customer->pemilik;
            $telpToko = $customer->telp;
            $fotoToko =  "<img src=" . asset('storage/toko/'.$customer->foto_toko) . " class='foto-toko'>"; 
            $limit = $customer->limit;
            $tipePembayaran = $customer->tipe_pembayaran;
            $status = $customer->status;
            $approve_by = $customer->approve_by;
            $order = $customer->order;
        }
        $image = "<img src=" . asset('vendor/adminlte/dist/img/logo.png') . " alt='Corner Image' class='inline-image'>";


        $htmlContent = "
        <!DOCTYPE html>
        <html lang='en'>
        
        <head>
            <meta charset='UTF-8'>
            <title>Report</title>
            <style>
                /* Add your custom styles for the PDF here */
                body {
                    font-family: Arial, sans-serif;
                }
        
                  .inline-image{
                    max-width:100px;
                  }
                  .header{
                    text-align:center;

                  }
                  .foto-toko{
                    width:200px;
                  } 

                  .content{
                    margin-top:20px;
                  } 
                  /* Add padding to all cells in the table */
                    table {
                        border-spacing: 0;
                        border-collapse: collapse;
                    }

                    

                    th, td {
                        padding: 10px; /* Adjust the padding as needed */
                        text-align: left;
                    }
            </style>
        </head>
        
        <body>
       
       

        <table width='100%' style='border-bottom:1px solid black'>
                <tr>
                    <td width='40%'>$image</td>
                    <td width='60%'>
                        <div class='header'>
                            <h1>Laporan Pemesanan</h1>
                            <span style='text-align:center;'>
                                <p>PT. JALADARA HARJA MANDIRI</p>
                            </span>
                        </div>
                    </td>
                </tr>
        </table>
       
      </div>
        
            <div class='content'>
                
                <table width='100%'>
                  <tr >
                    <td width='40%'>Nama Sales</td> 
                    <td width='5%'>:</td> 
                    <td width='55%'>$sales</td> 
                  </tr>
                  <tr >
                    <td width='40%'>Tanggal Pengajuan</td> 
                    <td width='5%'>:</td> 
                    <td width='55%'>$tglPengajuan</td> 
                  </tr>
                 
                </table>
                <h2>Detail Toko</h2>
                <table width='100%'>
                  <tr >
                    <td width='40%'>Nama Toko</td> 
                    <td width='5%'>:</td> 
                    <td width='55%'>$namaToko</td> 
                  </tr>
                  <tr>
                    <td>Alamat Toko</td> 
                    <td>:</td> 
                    <td>$alamatToko</td> 
                  </tr>
                  <tr >
                    <td>Patokan Toko</td> 
                    <td>:</td> 
                    <td>$patokanToko</td> 
                  </tr>
                  <tr >
                    <td>Pemilik Toko</td> 
                    <td>:</td> 
                    <td>$pemilikToko</td> 
                  </tr>
                  <tr >
                    <td>Nomor Telepon</td> 
                    <td>:</td> 
                    <td>$telpToko</td> 
                  </tr>
                  <tr >
                    <td>Foto Toko</td> 
                    <td>:</td> 
                    <td>$fotoToko</td> 
                  </tr>
                </table>
        
                <h2>Detail Pemesanan</h2>
                <table width='100%'>
                <tr>
                  <td width='40%'>Limit</td> 
                  <td width='5%'>:</td> 
                  <td width='55%'>Rp. $limit</td> 
                </tr>
                <tr>
                  <td>Tipe Pemabayaran</td> 
                  <td>:</td> 
                  <td>$tipePembayaran</td> 
                </tr>
                <tr >
                  <td>Order</td> 
                  <td>:</td> 
                  <td>$order</td> 
                </tr>
                <tr >
                  <td>Status</td> 
                  <td>:</td> 
                  <td>$status</td> 
                </tr>
                <tr >
                  <td>Disetujui Oleh</td> 
                  <td>:</td> 
                  <td>$approve_by</td> 
                </tr>
                
              </table>
        
            </div>
        </body>
        
        </html>
        
        ";

        // Add your HTML content to mPDF
        $mpdf->WriteHTML($htmlContent);

        // Output the PDF as a download
        $mpdf->Output('document.pdf', 'I'); // 'D' forces download, 'I' opens in the browser

        exit;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
