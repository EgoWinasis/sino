<?php

namespace App\Http\Controllers;

use App\Models\ModelCustomer;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akses Ditolak ');
        }
        $customer = DB::table('customer')
            ->select('*')
            ->where('id_user', '=', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.customer_view')->with(compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('customer.customer_create_view');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $validatedData = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'alamat'    => ['required', 'string', 'max:255'],
            'patokan'   => ['required', 'string', 'max:255'],
            'maps'      => ['required', 'string', 'max:255'],
            'pemilik'   => ['required', 'string', 'max:255'],
            'telp'      => ['required', 'string', 'max:255'],
            'foto_toko' => 'image|file|mimes:png,jpg,jpeg',


            'limit'                => ['required', 'max:255'],
            'tipe_pembayaran'      => ['required', 'string', 'max:255'],
            'area'                 => ['required', 'string', 'max:255'],
            'order'                => ['required', 'string', 'max:255'],
        ]);

        if ($request->file('foto_toko')) {

            $file = $request->file('foto_toko');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $request->file('foto_toko')->storeAs('public/toko/', $fileName);
            $validatedData['foto_toko'] = $fileName;
        } else {
            $validatedData['foto_toko'] = "shop.png";
        }

        // Remove commas from the number string
        $numberStringWithoutCommas = str_replace(',', '', $validatedData['limit']);

        // Convert the string to an integer
        $validatedData['limit'] = (int)$numberStringWithoutCommas;
        $validatedData['status'] = "Pending";
        $validatedData['approve_by'] = "-";
        if (Auth::check()) {
            $validatedData['id_user'] = Auth::user()->id;
        } 
        // store to database
        ModelCustomer::create($validatedData);
        return redirect()->route('customer.index')
            ->with('success', 'Berhasil Menambahkan Customer');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer =  DB::table('customer')
            ->select('*')
            ->where('id', '=', $id)
            ->get();

        return response()->json(['customer' => $customer]);
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
        $modelCustomer = ModelCustomer::find($id);
        if ($modelCustomer) {
            $modelCustomer->status = 'Batal';
            $modelCustomer->save();
            $modelCustomer->delete();
        }
    }
}
