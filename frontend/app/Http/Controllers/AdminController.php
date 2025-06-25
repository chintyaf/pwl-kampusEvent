<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Base URL untuk API Node.js
    private $apiBaseUrl = 'http://localhost:3000/api';

    /**
     * Menampilkan dashboard admin
     * Method ini akan mengambil statistik dasar untuk dashboard
     */
    public function index()
    {
        try {
            // Mengambil data statistik dari API Node.js
            $response = Http::get($this->apiBaseUrl . '/admin/statistics');

            if ($response->successful()) {
                $statistics = $response->json();
            } else {
                $statistics = [
                    'total_users' => 0,
                    'total_events' => 0,
                    'total_registrations' => 0,
                    'pending_payments' => 0
                ];
            }

            return view('admin.index', compact('statistics'));

        } catch (\Exception $e) {
            Log::error('Error fetching admin statistics: ' . $e->getMessage());

            // Fallback data jika API tidak tersedia
            $statistics = [
                'total_users' => 0,
                'total_events' => 0,
                'total_registrations' => 0,
                'pending_payments' => 0
            ];

            return view('admin.index', compact('statistics'));
        }
    }

    /**
     * Menampilkan halaman manajemen user
     * Mengambil daftar semua user dari database
     */
    public function manageUsers()
    {
        try {
            // Mengambil daftar semua user dari API
            $response = Http::get($this->apiBaseUrl . '/admin/users');

            if ($response->successful()) {
                $users = $response->json()['data'];
            } else {
                $users = [];
            }

            return view('admin.manage-users', compact('users'));

        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return view('admin.manage-users', ['users' => []]);
        }
    }

    /**
     * Menampilkan daftar member
     * Filter user berdasarkan role 'member'
     */
    public function listMembers()
    {
        try {
            // Mengambil daftar member dari API
            $response = Http::get($this->apiBaseUrl . '/admin/users/members');

            if ($response->successful()) {
                $members = $response->json()['data'];
            } else {
                $members = [];
            }

            return view('admin.list-member', compact('members'));

        } catch (\Exception $e) {
            Log::error('Error fetching members: ' . $e->getMessage());
            return view('admin.list-member', ['members' => []]);
        }
    }

    /**
     * Membuat akun tim keuangan baru
     * Method POST untuk menambah user dengan role 'finance_team'
     */
    public function createFinanceUser(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Mengirim data ke API Node.js untuk membuat user finance
            $response = Http::post($this->apiBaseUrl . '/admin/users/finance', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'finance_team'
            ]);

            if ($response->successful()) {
                return redirect()->route('admin.manage-users')
                    ->with('success', 'Akun Tim Keuangan berhasil dibuat!');
            } else {
                return back()->withErrors(['error' => 'Gagal membuat akun tim keuangan']);
            }

        } catch (\Exception $e) {
            Log::error('Error creating finance user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem']);
        }
    }

    /**
     * Membuat akun panitia kegiatan baru
     * Method POST untuk menambah user dengan role 'event_committee'
     */
    public function createCommitteeUser(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Mengirim data ke API Node.js untuk membuat user committee
            $response = Http::post($this->apiBaseUrl . '/admin/users/committee', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'event_committee'
            ]);

            if ($response->successful()) {
                return redirect()->route('admin.manage-users')
                    ->with('success', 'Akun Panitia Kegiatan berhasil dibuat!');
            } else {
                return back()->withErrors(['error' => 'Gagal membuat akun panitia kegiatan']);
            }

        } catch (\Exception $e) {
            Log::error('Error creating committee user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem']);
        }
    }

    /**
     * Update status user (aktif/nonaktif)
     * Method untuk mengaktifkan atau menonaktifkan user
     */
    public function updateUserStatus(Request $request, $userId)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        try {
            // Mengirim request update status ke API
            $response = Http::put($this->apiBaseUrl . '/admin/users/' . $userId . '/status', [
                'status' => $request->status
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status user berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate status user'
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Error updating user status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    /**
     * Hapus user
     * Method untuk menghapus user dari sistem
     */
    public function deleteUser($userId)
    {
        try {
            // Mengirim request delete ke API
            $response = Http::delete($this->apiBaseUrl . '/admin/users/' . $userId);

            if ($response->successful()) {
                return redirect()->back()
                    ->with('success', 'User berhasil dihapus!');
            } else {
                return back()->withErrors(['error' => 'Gagal menghapus user']);
            }

        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem']);
        }
    }

    /**
     * Menampilkan detail user
     * Method untuk melihat informasi lengkap user
     */
    public function showUser($userId)
    {
        try {
            // Mengambil detail user dari API
            $response = Http::get($this->apiBaseUrl . '/admin/users/' . $userId);

            if ($response->successful()) {
                $user = $response->json()['data'];
                return view('admin.user-detail', compact('user'));
            } else {
                return redirect()->route('admin.manage-users')
                    ->withErrors(['error' => 'User tidak ditemukan']);
            }

        } catch (\Exception $e) {
            Log::error('Error fetching user detail: ' . $e->getMessage());
            return redirect()->route('admin.manage-users')
                ->withErrors(['error' => 'Terjadi kesalahan sistem']);
        }
    }

    public function getAllUsers()
    {
        $response = Http::get('http://localhost:3000/api/users');
        $users = $response->successful() ? $response->json() : [];

        return view('manage-users', compact('users'));
    }
}
