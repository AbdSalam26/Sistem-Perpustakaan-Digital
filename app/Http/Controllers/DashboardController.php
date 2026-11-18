<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('dashboard.index', ['judul' => 'Dashboard Admin']);
    }

    public function petugas()
    {
        return view('dashboard.index', ['judul' => 'Dashboard Petugas']);
    }
}