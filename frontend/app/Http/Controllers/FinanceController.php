<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    // URL backend Node.js
    private $apiBaseUrl = 'http://localhost:3000/api';

    public function index()
    {
        // Menampilkan dashboard tim keuangan (misalnya: total pembayaran yang pending)
        return view('finance.dashboard');
    }

    public function registrations()
    {
        // Mendapatkan data pembayaran yang dilakukan peserta
        try {
            $response = Http::get($this->apiBaseUrl . '/finance/registrations');

            if ($response->successful()) {
                $registrations = $response->json();
            } else {
                $registrations = [];
            }

            return view('finance.registrations', compact('registrations'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengambil data pembayaran']);
        }
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        // Memperbarui status pembayaran peserta
        try {
            $response = Http::put($this->apiBaseUrl . "/finance/registration/{$id}/status", [
                'paymentStatus' => $request->paymentStatus,
                'paymentProof' => $request->paymentProof,
            ]);

            if ($response->successful()) {
                return redirect()->route('finance.registrations')->with('success', 'Status pembayaran diperbarui');
            } else {
                return back()->withErrors(['error' => 'Gagal memperbarui status pembayaran']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui status pembayaran']);
        }
    }
}
//    /**
//     * Menampilkan dashboard tim keuangan
//     * Menghitung statistik pembayaran dari database
//     */
//    public function index()
//    {
//        // Menghitung statistik dari tabel registrations
//        $statistics = [
//            'total_registrations' => DB::table('registrations')->count(),
//            'pending_payments' => DB::table('registrations')->where('payment_status', 'pending')->count(),
//            'approved_payments' => DB::table('registrations')->where('payment_status', 'approved')->count(),
//            'rejected_payments' => DB::table('registrations')->where('payment_status', 'rejected')->count()
//        ];
//
//        // Mengirim data statistik ke view
//        return view('finance.index', compact('statistics'));
//    }
//
//    /**
//     * Menampilkan daftar registrasi dan pembayaran
//     * Mengambil data registrasi dari database dengan join ke tabel users dan events
//     */
//    public function registrations()
//    {
//        // Query untuk mengambil data registrasi beserta data user dan event
//        $registrations = DB::table('registrations')
//            ->join('users', 'registrations.user_id', '=', 'users.id')
//            ->join('events', 'registrations.event_id', '=', 'events.id')
//            ->select(
//                'registrations.*',
//                'users.name as user_name',
//                'users.email as user_email',
//                'events.title as event_title',
//                'events.price as event_price'
//            )
//            ->orderBy('registrations.created_at', 'desc')
//            ->get();
//
//        // Mengirim data registrasi ke view
//        return view('finance.registrations', compact('registrations'));
//    }
//
//    /**
//     * Menampilkan detail registrasi tertentu
//     * Mengambil data detail dari satu registrasi berdasarkan ID
//     */
//    public function showRegistration($id)
//    {
//        // Query untuk mengambil detail registrasi
//        $registration = DB::table('registrations')
//            ->join('users', 'registrations.user_id', '=', 'users.id')
//            ->join('events', 'registrations.event_id', '=', 'events.id')
//            ->select(
//                'registrations.*',
//                'users.name as user_name',
//                'users.email as user_email',
//                'users.phone as user_phone',
//                'events.title as event_title',
//                'events.description as event_description',
//                'events.price as event_price',
//                'events.date as event_date'
//            )
//            ->where('registrations.id', $id)
//            ->first();
//
//        // Jika data tidak ditemukan, redirect dengan pesan error
//        if (!$registration) {
//            return redirect()->route('finance.registrations')
//                ->with('error', 'Data registrasi tidak ditemukan');
//        }
//
//        // Mengirim data registrasi ke view
//        return view('finance.registration-detail', compact('registration'));
//    }
//
//    /**
//     * Update status pembayaran
//     * Mengupdate status pembayaran di database
//     */
//    public function updatePaymentStatus(Request $request, $id)
//    {
//        // Validasi input dari form
//        $request->validate([
//            'status' => 'required|in:approved,rejected',
//            'notes' => 'nullable|string|max:500'
//        ]);
//
//        // Update data di database
//        $updated = DB::table('registrations')
//            ->where('id', $id)
//            ->update([
//                'payment_status' => $request->status,
//                'payment_notes' => $request->notes,
//                'verified_by' => Auth::user()->id,
//                'verified_at' => now(),
//                'updated_at' => now()
//            ]);
//
//        // Cek apakah update berhasil
//        if ($updated) {
//            $message = $request->status === 'approved'
//                ? 'Pembayaran berhasil disetujui'
//                : 'Pembayaran berhasil ditolak';
//
//            return redirect()->back()->with('success', $message);
//        } else {
//            return redirect()->back()->with('error', 'Gagal mengupdate status pembayaran');
//        }
//    }
//
//    /**
//     * Mencari registrasi berdasarkan nama atau email
//     * Fungsi untuk fitur pencarian
//     */
//    public function searchRegistrations(Request $request)
//    {
//        $search = $request->get('search');
//
//        // Query dengan kondisi pencarian
//        $registrations = DB::table('registrations')
//            ->join('users', 'registrations.user_id', '=', 'users.id')
//            ->join('events', 'registrations.event_id', '=', 'events.id')
//            ->select(
//                'registrations.*',
//                'users.name as user_name',
//                'users.email as user_email',
//                'events.title as event_title',
//                'events.price as event_price'
//            )
//            ->where('users.name', 'like', "%{$search}%")
//            ->orWhere('users.email', 'like', "%{$search}%")
//            ->orWhere('events.title', 'like', "%{$search}%")
//            ->orderBy('registrations.created_at', 'desc')
//            ->get();
//
//        return view('finance.registrations', compact('registrations', 'search'));
//    }
//
//    /**
//     * Filter registrasi berdasarkan status
//     * Fungsi untuk memfilter data berdasarkan status pembayaran
//     */
//    public function filterByStatus(Request $request)
//    {
//        $status = $request->get('status');
//
//        // Query dengan kondisi filter status
//        $query = DB::table('registrations')
//            ->join('users', 'registrations.user_id', '=', 'users.id')
//            ->join('events', 'registrations.event_id', '=', 'events.id')
//            ->select(
//                'registrations.*',
//                'users.name as user_name',
//                'users.email as user_email',
//                'events.title as event_title',
//                'events.price as event_price'
//            );
//
//        // Tambahkan kondisi filter jika status bukan 'all'
//        if ($status && $status !== 'all') {
//            $query->where('registrations.payment_status', $status);
//        }
//
//        $registrations = $query->orderBy('registrations.created_at', 'desc')->get();
//
//        return view('finance.registrations', compact('registrations', 'status'));
//    }
//}
//
//namespace App\Http\Controllers\Finance;
//
//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\Auth;
//
//class FinanceController extends Controller
//{
//    private $apiBaseUrl;
//
//    // public function __construct()
//    // {
//    //     $this->apiBaseUrl = config('app.api_base_url');
//    //     $this->middleware('auth');
//    //     $this->middleware('role:finance_team');
//    // }
//
//    /**
//     * Show finance dashboard
//     */
//    public function dashboard()
//    {
//        try {
//            $response = Http::withToken(Auth::user()->api_token)
//                ->get($this->apiBaseUrl . '/finance/index');
//
//            if ($response->successful()) {
//                $data = $response->json()['data'];
//                return view('finance.index', compact('data'));
//            } else {
//                return redirect()->back()->with('error', 'Failed to load dashboard data');
//            }
//        } catch (\Exception $e) {
//            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
//        }
//    }
//
//    /**
//     * Show registrations list for payment verification
//     */
//    public function registrations(Request $request)
//    {
//        try {
//            $params = [
//                'page' => $request->get('page', 1),
//                'limit' => $request->get('limit', 10),
//                'status' => $request->get('status'),
//                'eventId' => $request->get('event_id'),
//                'search' => $request->get('search'),
//            ];
//
//            $response = Http::withToken(Auth::user()->api_token)
//                ->get($this->apiBaseUrl . '/finance/registrations', array_filter($params));
//
//            if ($response->successful()) {
//                $data = $response->json()['data'];
//
//                // Get events for filter dropdown
//                $eventsResponse = Http::withToken(Auth::user()->api_token)
//                    ->get($this->apiBaseUrl . '/events');
//
//                $events = $eventsResponse->successful() ? $eventsResponse->json()['data'] : [];
//
//                return view('finance.registrations', compact('data', 'events'));
//            } else {
//                return redirect()->back()->with('error', 'Failed to load registrations');
//            }
//        } catch (\Exception $e) {
//            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
//        }
//    }
//
//    /**
//     * Show registration details
//     */
//    public function show($id)
//    {
//        try {
//            $response = Http::withToken(Auth::user()->api_token)
//                ->get($this->apiBaseUrl . '/finance/registrations/' . $id);
//
//            if ($response->successful()) {
//                $registration = $response->json()['data'];
//                return view('finance.registration-detail', compact('registration'));
//            } else {
//                return redirect()->back()->with('error', 'Registration not found');
//            }
//        } catch (\Exception $e) {
//            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
//        }
//    }
//
//    /**
//     * Update payment status
//     */
//    public function updatePaymentStatus(Request $request, $id)
//    {
//        $request->validate([
//            'status' => 'required|in:pending,paid,verified,rejected',
//            'notes' => 'nullable|string|max:500'
//        ]);
//
//        try {
//            $response = Http::withToken(Auth::user()->api_token)
//                ->put($this->apiBaseUrl . '/finance/registrations/' . $id . '/payment-status', [
//                    'status' => $request->status,
//                    'notes' => $request->notes
//                ]);
//
//            if ($response->successful()) {
//                return redirect()->back()->with('success', 'Payment status updated successfully');
//            } else {
//                return redirect()->back()->with('error', 'Failed to update payment status');
//            }
//        } catch (\Exception $e) {
//            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
//        }
//    }
//
//    /**
//     * Bulk update payment status
//     */
//    public function bulkUpdatePaymentStatus(Request $request)
//    {
//        $request->validate([
//            'registration_ids' => 'required|array|min:1',
//            'registration_ids.*' => 'string',
//            'status' => 'required|in:pending,paid,verified,rejected',
//            'notes' => 'nullable|string|max:500'
//        ]);
//
//        try {
//            $response = Http::withToken(Auth::user()->api_token)
//                ->put($this->apiBaseUrl . '/finance/registrations/bulk-update', [
//                    'registrationIds' => $request->registration_ids,
//                    'status' => $request->status,
//                    'notes' => $request->notes
//                ]);
//
//            if ($response->successful()) {
//                $data = $response->json()['data'];
//                return redirect()->back()->with('success',
//                    $data['modifiedCount'] . ' registrations updated successfully');
//            } else {
//                return redirect()->back()->with('error', 'Failed to update registrations');
//            }
//        } catch (\Exception $e) {
//            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
//        }
//    }
//
//    /**
//     * Export payment report
//     */
//    public function exportReport(Request $request)
//    {
//        // This would typically generate and download a CSV/Excel file
//        // For now, we'll redirect to registrations with export parameters
//        return redirect()->route('finance.registrations', $request->all())
//            ->with('info', 'Export functionality will be implemented');
//    }
//}
