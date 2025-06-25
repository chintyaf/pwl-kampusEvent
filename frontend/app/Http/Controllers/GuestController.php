<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client;
use Carbon\Carbon;

class GuestController extends Controller
{
    // protected $mongoClient;
    // protected $database;
    // protected $eventsCollection;

    // public function __construct()
    // {
    //     // Initialize MongoDB connection
    //     $this->mongoClient = new Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
    //     $this->database = $this->mongoClient->selectDatabase(env('MONGODB_DATABASE', 'your_database_name'));
    //     $this->eventsCollection = $this->database->selectCollection('events');
    // }

    // public function dashboard()
    // {
    //     try {
    //         // Query to get active events from MongoDB
    //         $events = $this->eventsCollection->find([
    //             'status' => ['$in' => ['active', 'published', 'open']], // adjust based on your status values
    //             'start_date' => ['$gte' => new \MongoDB\BSON\UTCDateTime()] // future events only
    //         ], [
    //             'sort' => ['start_date' => 1], // sort by start date ascending
    //             'limit' => 20 // limit results
    //         ]);

    //         // Convert cursor to array
    //         $eventsArray = $events->toArray();

    //         // Convert MongoDB documents to PHP arrays with proper data formatting
    //         $formattedEvents = [];
    //         foreach ($eventsArray as $event) {
    //             $formattedEvent = [
    //                 '_id' => (string) $event['_id'],
    //                 'name' => $event['name'] ?? 'Untitled Event',
    //                 'description' => $event['description'] ?? '',
    //                 'start_date' => isset($event['start_date']) ? $this->formatMongoDate($event['start_date']) : null,
    //                 'end_date' => isset($event['end_date']) ? $this->formatMongoDate($event['end_date']) : null,
    //                 'start_time' => $event['start_time'] ?? null,
    //                 'end_time' => $event['end_time'] ?? null,
    //                 'location' => $event['location'] ?? $event['venue'] ?? 'TBA',
    //                 'registration_fee' => $event['registration_fee'] ?? $event['price'] ?? 0,
    //                 'capacity' => $event['capacity'] ?? null,
    //                 'registered_count' => $event['registered_count'] ?? 0,
    //                 'status' => $event['status'] ?? 'active',
    //                 'category' => $event['category'] ?? 'General',
    //                 'image' => $event['image'] ?? null,
    //                 'created_at' => isset($event['created_at']) ? $this->formatMongoDate($event['created_at']) : null,
    //             ];
    //             $formattedEvents[] = $formattedEvent;
    //         }

    //         return view('guest.dashboard', [
    //             'events' => $formattedEvents,
    //             'totalEvents' => count($formattedEvents)
    //         ]);

    //     } catch (\Exception $e) {
    //         // Handle errors gracefully
    //         \Log::error('Error fetching events for guest dashboard: ' . $e->getMessage());
            
    //         return view('guest.dashboard', [
    //             'events' => [],
    //             'totalEvents' => 0,
    //             'error' => 'Unable to load events at this time.'
    //         ]);
    //     }
    // }

    // /**
    //  * Get all events (for public viewing)
    //  */
    // public function getAllEvents(Request $request)
    // {
    //     try {
    //         $limit = $request->get('limit', 12);
    //         $skip = $request->get('skip', 0);
    //         $category = $request->get('category');
            
    //         // Build query
    //         $query = [
    //             'status' => ['$in' => ['active', 'published', 'open']]
    //         ];
            
    //         // Add category filter if provided
    //         if ($category && $category !== 'all') {
    //             $query['category'] = $category;
    //         }
            
    //         // Get events
    //         $events = $this->eventsCollection->find($query, [
    //             'sort' => ['start_date' => 1],
    //             'limit' => (int) $limit,
    //             'skip' => (int) $skip
    //         ]);
            
    //         $eventsArray = [];
    //         foreach ($events as $event) {
    //             $eventsArray[] = [
    //                 '_id' => (string) $event['_id'],
    //                 'name' => $event['name'] ?? 'Untitled Event',
    //                 'description' => $event['description'] ?? '',
    //                 'start_date' => isset($event['start_date']) ? $this->formatMongoDate($event['start_date']) : null,
    //                 'end_date' => isset($event['end_date']) ? $this->formatMongoDate($event['end_date']) : null,
    //                 'start_time' => $event['start_time'] ?? null,
    //                 'end_time' => $event['end_time'] ?? null,
    //                 'location' => $event['location'] ?? $event['venue'] ?? 'TBA',
    //                 'registration_fee' => $event['registration_fee'] ?? $event['price'] ?? 0,
    //                 'category' => $event['category'] ?? 'General',
    //                 'image' => $event['image'] ?? null,
    //             ];
    //         }
            
    //         return response()->json([
    //             'success' => true,
    //             'events' => $eventsArray,
    //             'total' => count($eventsArray)
    //         ]);
            
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error fetching events: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // /**
    //  * Get event categories for filtering
    //  */
    // public function getCategories()
    // {
    //     try {
    //         $categories = $this->eventsCollection->distinct('category', [
    //             'status' => ['$in' => ['active', 'published', 'open']]
    //         ]);
            
    //         return response()->json([
    //             'success' => true,
    //             'categories' => $categories
    //         ]);
            
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error fetching categories'
    //         ], 500);
    //     }
    // }

    // /**
    //  * Format MongoDB date to readable format
    //  */
    // private function formatMongoDate($mongoDate)
    // {
    //     try {
    //         if ($mongoDate instanceof \MongoDB\BSON\UTCDateTime) {
    //             return $mongoDate->toDateTime()->format('Y-m-d H:i:s');
    //         } elseif (is_string($mongoDate)) {
    //             return Carbon::parse($mongoDate)->format('Y-m-d H:i:s');
    //         }
    //         return $mongoDate;
    //     } catch (\Exception $e) {
    //         return null;
    //     }
    // }

    // /**
    //  * Alternative method using Laravel MongoDB package (if you're using jenssegers/mongodb)
    //  */
    // public function dashboardWithEloquent()
    // {
    //     try {
    //         // If you're using Eloquent MongoDB model
    //         // $events = \App\Models\Event::where('status', 'active')
    //         //     ->where('start_date', '>=', now())
    //         //     ->orderBy('start_date', 'asc')
    //         //     ->limit(20)
    //         //     ->get();

    //         // return view('guest.dashboard', compact('events'));
            
    //     } catch (\Exception $e) {
    //         \Log::error('Error in guest dashboard: ' . $e->getMessage());
    //         return view('guest.dashboard', ['events' => []]);
    //     }
    // }
}