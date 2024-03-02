<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->isActive == 0) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is inactive. Please contact Admin support.');
        }
        if (Auth::user()->role == 'user') {
           
            $batalCount = DB::table('customer')
                ->where('id_user', '=', Auth::user()->id)
                ->where('status', '=', 'Batal')
                ->count();
            $pendingCount = DB::table('customer')
                ->where('id_user', '=', Auth::user()->id)
                ->where('status', '=', 'Pending')
                ->count();
            $disetujuiCount = DB::table('customer')
                ->where('id_user', '=', Auth::user()->id)
                ->where('status', '=', 'Disetujui')
                ->count();
            $ditolakCount = DB::table('customer')
                ->where('id_user', '=', Auth::user()->id)
                ->where('status', '=', 'Ditolak')
                ->count();

            return view('home', compact('batalCount', 'disetujuiCount','pendingCount', 'ditolakCount'));
        } 
        if (Auth::user()->role == 'admin') {
            $batalCount = DB::table('customer')
                ->where('status', '=', 'Batal')
                ->count();
            $pendingCount = DB::table('customer')
                ->where('status', '=', 'Pending')
                ->count();
            $disetujuiCount = DB::table('customer')
                ->where('status', '=', 'Disetujui')
                ->count();
            $ditolakCount = DB::table('customer')
                ->where('status', '=', 'Ditolak')
                ->count();
            $totalUsersActive = DB::table('users')
                ->where('isActive', '=', '1')
                ->count();
            $totalUsersInActive = DB::table('users')
                ->where('isActive', '=', '0')
                ->count();

            return view('home', compact('totalUsersActive','totalUsersInActive','batalCount', 'disetujuiCount','pendingCount', 'ditolakCount'));
        } 
        if (Auth::user()->role == 'kepala') {
            
            $batalCount = DB::table('customer')
                ->where('approve_by', '=', Auth::user()->name)
                ->where('status', '=', 'Batal')
                ->count();
            $pendingCount = DB::table('customer')
                ->where('approve_by', '=', Auth::user()->name)
                ->where('status', '=', 'Pending')
                ->count();
            $disetujuiCount = DB::table('customer')
                ->where('approve_by', '=', Auth::user()->name)
                ->where('status', '=', 'Disetujui')
                ->count();
            $ditolakCount = DB::table('customer')
                ->where('approve_by', '=', Auth::user()->name)
                ->where('status', '=', 'Ditolak')
                ->count();

            return view('home', compact('batalCount', 'disetujuiCount','pendingCount', 'ditolakCount'));
        } 
    }
}
