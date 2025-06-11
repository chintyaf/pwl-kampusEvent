<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    private $apiBaseUrl;

    // public function __construct()
    // {
    //     $this->apiBaseUrl = config('app.api_base_url');
    //     $this->middleware('auth');
    //     $this->middleware('role:finance_team');
    // }

    /**
     * Show finance dashboard
     */
    public function dashboard()
    {
        try {
            $response = Http::withToken(Auth::user()->api_token)
                ->get($this->apiBaseUrl . '/finance/index');

            if ($response->successful()) {
                $data = $response->json()['data'];
                return view('finance.index', compact('data'));
            } else {
                return redirect()->back()->with('error', 'Failed to load dashboard data');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }

    /**
     * Show registrations list for payment verification
     */
    public function registrations(Request $request)
    {
        try {
            $params = [
                'page' => $request->get('page', 1),
                'limit' => $request->get('limit', 10),
                'status' => $request->get('status'),
                'eventId' => $request->get('event_id'),
                'search' => $request->get('search'),
            ];

            $response = Http::withToken(Auth::user()->api_token)
                ->get($this->apiBaseUrl . '/finance/registrations', array_filter($params));

            if ($response->successful()) {
                $data = $response->json()['data'];
                
                // Get events for filter dropdown
                $eventsResponse = Http::withToken(Auth::user()->api_token)
                    ->get($this->apiBaseUrl . '/events');
                
                $events = $eventsResponse->successful() ? $eventsResponse->json()['data'] : [];

                return view('finance.registrations', compact('data', 'events'));
            } else {
                return redirect()->back()->with('error', 'Failed to load registrations');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }

    /**
     * Show registration details
     */
    public function show($id)
    {
        try {
            $response = Http::withToken(Auth::user()->api_token)
                ->get($this->apiBaseUrl . '/finance/registrations/' . $id);

            if ($response->successful()) {
                $registration = $response->json()['data'];
                return view('finance.registration-detail', compact('registration'));
            } else {
                return redirect()->back()->with('error', 'Registration not found');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,verified,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $response = Http::withToken(Auth::user()->api_token)
                ->put($this->apiBaseUrl . '/finance/registrations/' . $id . '/payment-status', [
                    'status' => $request->status,
                    'notes' => $request->notes
                ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Payment status updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to update payment status');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update payment status
     */
    public function bulkUpdatePaymentStatus(Request $request)
    {
        $request->validate([
            'registration_ids' => 'required|array|min:1',
            'registration_ids.*' => 'string',
            'status' => 'required|in:pending,paid,verified,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $response = Http::withToken(Auth::user()->api_token)
                ->put($this->apiBaseUrl . '/finance/registrations/bulk-update', [
                    'registrationIds' => $request->registration_ids,
                    'status' => $request->status,
                    'notes' => $request->notes
                ]);

            if ($response->successful()) {
                $data = $response->json()['data'];
                return redirect()->back()->with('success', 
                    $data['modifiedCount'] . ' registrations updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to update registrations');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Connection error: ' . $e->getMessage());
        }
    }

    /**
     * Export payment report
     */
    public function exportReport(Request $request)
    {
        // This would typically generate and download a CSV/Excel file
        // For now, we'll redirect to registrations with export parameters
        return redirect()->route('finance.registrations', $request->all())
            ->with('info', 'Export functionality will be implemented');
    }
}