<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // untuk API call jika perlu
use Illuminate\Support\Facades\Log;

class FinanceController extends Controller
{
    /**
     * Tampilkan halaman daftar registrasi untuk tim keuangan.
     */
    public function index()
    {
        try {
            // Contoh jika data diambil dari API
            $response = Http::get('http://localhost:3000/api/registrations');

            if ($response->successful()) {
                $registrations = $response->json(); // Pastikan ini adalah array
            } else {
                // Jika gagal, log error dan tampilkan data kosong
                Log::error('Gagal mendapatkan data registrasi dari API: ' . $response->status());
                $registrations = [];
            }
        } catch (\Exception $e) {
            Log::error('Exception saat mengambil data registrasi: ' . $e->getMessage());
            $registrations = [];
        }

        return view('finance.registration', compact('registrations'));
    }
}
