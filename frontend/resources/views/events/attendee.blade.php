@extends('layouts.back')
@push('extraCSS')
    <style>
        /* .main-container {
                            background: white;
                            border-radius: 12px;
                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
                            margin: 20px auto;
                            /* max-width: 1200px; */
        }

        */ .header-section {
            /* background: #fffdff; */
            color: white;
            padding: 2rem;
            border-radius: 12px 12px 0 0;
        }

        .event-title {
            font-size: 2.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .event-summary {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .content-section {
            padding: 2rem;
        }

        .nav-tabs {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 2rem;
            gap: 10px;

        }

        .nav-link {
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 8px 8px 0 0;
            margin-right: 0.25rem;


        }

        .nav-tabs .nav-link.active {
            background: rgba(105, 108, 255, 0.16);
            color: #696cff;
            border: none;
        }

        .session-panel {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;

        }

        .search-export-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
        }

        .search-box {
            max-width: 300px;
            flex-grow: 1;
        }

        .search-box input {
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
        }

        .btn-export {
            background: #28a745;
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            white-space: nowrap;
        }

        .btn-export:hover {
            background: #218838;
            color: white;
        }

        .attendance-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .attendance-table th {
            background: #f1f3f4;
            color: #495057;
            font-weight: 600;
            padding: 1rem 0.75rem;
            border: none;
        }

        .attendance-table td {
            padding: 0.75rem;
            vertical-align: middle;
            border-top: 1px solid #e9ecef;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-present {
            background: #d4edda;
            color: #155724;
        }

        .status-absent {
            background: #f8d7da;
            color: #721c24;
        }

        .table-responsive {
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .search-export-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                max-width: none;
                margin-bottom: 1rem;
            }

            .event-title {
                font-size: 1.8rem;
            }

            .content-section {
                padding: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    @foreach ($event as $event)
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card" style="margin-top: 40px">
                @foreach ($event['session'] as $session)
                    <a href="{{ route('events.view-attendacesess', [
                        'id' => (string) $event['_id'],
                        'session_id' => (string) $session['_id'],
                    ]) }}">
                        Session: {{ $session['title'] }}
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection



