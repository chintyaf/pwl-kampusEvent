<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ManageUsersController extends Controller
{
    private $nodeApiUrl = 'http://localhost:3000/api'; // Sesuaikan dengan URL Node.js API

    /**
     * Display the manage users page
     */
    public function index(Request $request)
    {
        try {
            // Get filter parameters
            $filters = [
                'role' => $request->get('role', ''),
                'status' => $request->get('status', ''),
                'search' => $request->get('search', '')
            ];

            // Fetch users from Node.js API
            $usersResponse = Http::timeout(30)->get($this->nodeApiUrl . '/users', $filters);

            if (!$usersResponse->successful()) {
                Log::error('Failed to fetch users from Node.js API', [
                    'status' => $usersResponse->status(),
                    'response' => $usersResponse->body()
                ]);
                throw new \Exception('Failed to fetch users data');
            }

            $users = $usersResponse->json()['data'] ?? [];

            // Fetch statistics from Node.js API
            $statisticsResponse = Http::timeout(30)->get($this->nodeApiUrl . '/users/statistics');

            if (!$statisticsResponse->successful()) {
                Log::error('Failed to fetch statistics from Node.js API', [
                    'status' => $statisticsResponse->status(),
                    'response' => $statisticsResponse->body()
                ]);
                throw new \Exception('Failed to fetch statistics data');
            }

            $statistics = $statisticsResponse->json()['data'] ?? [
                'total_members' => 0,
                'total_finance' => 0,
                'total_committee' => 0,
                'total_active' => 0
            ];

            return view('admin.manage-users', compact('users', 'statistics'));

        } catch (\Exception $e) {
            Log::error('Error in ManageUsersController@index', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return view with empty data if API fails
            return view('admin.manage-users', [
                'users' => [],
                'statistics' => [
                    'total_members' => 0,
                    'total_finance' => 0,
                    'total_committee' => 0,
                    'total_active' => 0
                ]
            ])->with('error', 'Gagal memuat data pengguna. Silakan coba lagi.');
        }
    }

    /**
     * Get user statistics via AJAX
     */
    public function getStatistics()
    {
        try {
            $response = Http::timeout(30)->get($this->nodeApiUrl . '/users/statistics');

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()['data']
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch statistics'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error fetching statistics', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ], 500);
        }
    }

    /**
     * Get single user detail
     */
    public function show($userId)
    {
        try {
            $response = Http::timeout(30)->get($this->nodeApiUrl . "/users/{$userId}");

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()['data']
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error fetching user detail', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ], 500);
        }
    }

    /**
     * Update user status
     */
    public function updateStatus(Request $request, $userId)
    {
        try {
            $request->validate([
                'status' => 'required|in:active,inactive'
            ]);

            $response = Http::timeout(30)->put($this->nodeApiUrl . "/users/{$userId}/status", [
                'status' => $request->status
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status updated successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error updating user status', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ], 500);
        }
    }

    /**
     * Create finance team user
     */
    public function createFinance(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:6|confirmed'
            ]);

            $response = Http::timeout(30)->post($this->nodeApiUrl . '/users/finance', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'finance_team'
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Finance team user created successfully'
                ]);
            }

            $errorData = $response->json();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'errors' => $errorData['errors'] ?? []
            ], $response->status());

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating finance user', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ], 500);
        }
    }

    /**
     * Create committee user
     */
    public function createCommittee(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:6|confirmed'
            ]);

            $response = Http::timeout(30)->post($this->nodeApiUrl . '/users/committee', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'event_committee'
            ]);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Committee user created successfully'
                ]);
            }

            $errorData = $response->json();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user',
                'errors' => $errorData['errors'] ?? []
            ], $response->status());

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating committee user', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ], 500);
        }
    }

    /**
     * Delete user
     */
    public function destroy($userId)
    {
        try {
            $response = Http::timeout(30)->delete($this->nodeApiUrl . "/users/{$userId}");

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User deleted successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error deleting user', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ], 500);
        }
    }
}
