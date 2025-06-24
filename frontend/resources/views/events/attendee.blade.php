@extends('layouts.back')
@push('extraCSS')
    <style>
        .main-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin: 20px auto;
            /* max-width: 1200px; */
        }

        .header-section {
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

        .nav-link{
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
    <div class="main-container" style="margin-top: 40px">
        <!-- Header Section -->
        <div class="header-section">
            <h1 class="event-title">Annual Technology Conference 2025</h1>
            <p class="event-summary">A comprehensive three-day event featuring cutting-edge technology
                presentations, hands-on workshops, and networking opportunities for industry professionals.</p>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs" id="sessionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="session1-tab" data-bs-toggle="tab" data-bs-target="#session1"
                        type="button" role="tab">
                        <i class="fas fa-play-circle me-2"></i>Session 1: Opening Ceremony
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="session2-tab" data-bs-toggle="tab" data-bs-target="#session2"
                        type="button" role="tab">
                        <i class="fas fa-tools me-2"></i>Session 2: AI Workshop
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="session3-tab" data-bs-toggle="tab" data-bs-target="#session3"
                        type="button" role="tab">
                        <i class="fas fa-network-wired me-2"></i>Session 3: Networking
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="sessionTabContent">
                <!-- Session 1 -->
                <div class="tab-pane fade show active" id="session1" role="tabpanel">
                    <div class="session-panel">
                        <div class="search-export-bar">
                            <div class="search-box">
                                <input type="text" class="form-control" id="search1"
                                    placeholder="Search by name or email...">
                            </div>
                            <button class="btn btn-export" onclick="exportToCSV('session1')">
                                <i class="fas fa-download me-2"></i>Export to CSV
                            </button>
                        </div>

                        <div class="table-responsive attendance-table">
                            <table class="table table-hover mb-0" id="table1">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Check-in Time</th>
                                        <th style="width: 100px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody1">
                                    <!-- Data will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Session 2 -->
                <div class="tab-pane fade" id="session2" role="tabpanel">
                    <div class="session-panel">
                        <div class="search-export-bar">
                            <div class="search-box">
                                <input type="text" class="form-control" id="search2"
                                    placeholder="Search by name or email...">
                            </div>
                            <button class="btn btn-export" onclick="exportToCSV('session2')">
                                <i class="fas fa-download me-2"></i>Export to CSV
                            </button>
                        </div>

                        <div class="table-responsive attendance-table">
                            <table class="table table-hover mb-0" id="table2">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Check-in Time</th>
                                        <th style="width: 100px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody2">
                                    <!-- Data will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Session 3 -->
                <div class="tab-pane fade" id="session3" role="tabpanel">
                    <div class="session-panel">
                        <div class="search-export-bar">
                            <div class="search-box">
                                <input type="text" class="form-control" id="search3"
                                    placeholder="Search by name or email...">
                            </div>
                            <button class="btn btn-export" onclick="exportToCSV('session3')">
                                <i class="fas fa-download me-2"></i>Export to CSV
                            </button>
                        </div>

                        <div class="table-responsive attendance-table">
                            <table class="table table-hover mb-0" id="table3">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Check-in Time</th>
                                        <th style="width: 100px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody3">
                                    <!-- Data will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('extraJS')
@endpush
