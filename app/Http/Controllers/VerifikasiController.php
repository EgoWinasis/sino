<?php

namespace App\Http\Controllers;

use App\Models\ModelCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'user') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses Ditolak ');
        }
        if (Auth::user()->role == 'kepala') {

            $customer = DB::table('customer')
                ->select('*')
                ->where('bagian', '=', Auth::user()->bagian)
                ->where('name', '!=', Auth::user()->name)
                ->where('status_admin', '=', 'Disetujui')
                ->where(function ($query) {
                    $query->where('status', '=', 'Pending')
                        ->orWhere('status', '=', 'Disetujui')
                        ->orWhere('status', '=', 'Ditolak');
                })
                ->orderBy('created_at', 'desc')
                ->get();
            return view('verif_customer.verif_customer_view')->with(compact('customer'));
        }
        if (Auth::user()->role == 'admin') {

            $customer = DB::table('customer')
                ->select('*')
                ->where('name', '!=', Auth::user()->name)
                ->where(function ($query) {
                    $query->where('status', '=', 'Pending')
                        ->orWhere('status', '=', 'Disetujui')
                        ->orWhere('status', '=', 'Ditolak');
                })
                ->orderBy('created_at', 'desc')
                ->get();
            return view('verif_customer.verif_customer_admin_view')->with(compact('customer'));
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
        //
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
        $customer = ModelCustomer::find($id); // Find the record by ID
        if (Auth::user()->role == 'admin') {
            $customer->status = "Disetujui";
            $customer->approve_by = Auth::user()->name;
            $customer->save();
        }
        if (Auth::user()->role == 'kepala') {
            $customer->status = "Disetujui";
            $customer->approve_by = Auth::user()->name;
            $customer->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $modelCustomer = ModelCustomer::find($id);
        if ($modelCustomer) {
            if (Auth::user()->role == 'admin') {
                $modelCustomer->status = 'Ditolak';
                $modelCustomer->save();
                $modelCustomer->delete();
            }
            // if (Auth::user()->role == 'kepala') {
            //     $modelCustomer->status = 'Ditolak';
            //     $modelCustomer->save();
            //     $modelCustomer->delete();
            // }
        }
    }
}
