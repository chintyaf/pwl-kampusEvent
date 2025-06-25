@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
    <div class="container">
        <h1>Manage Events</h1>
        <p>Here you can manage events.</p>
        <a href="#">Add New Event</a>
        <!-- Display a list of events (for simplicity, this will be static for now) -->
        <table class="table">
            <thead>
            <tr>
                <th>Event Name</th>
                <th>Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Sample Event 1</td>
                <td>2023-05-20</td>
                <td>Location A</td>
                <td><a href="#">Edit</a> | <a href="#">Delete</a></td>
            </tr>
            <!-- Add more static rows as needed -->
            </tbody>
        </table>
    </div>
@endsection
