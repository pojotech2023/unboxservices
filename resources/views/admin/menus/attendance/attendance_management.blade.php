@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
             <div class="page-header d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <h3 class="fw-bold mb-3">Attendance Details</h3>
                    <ul class="breadcrumbs mb-0">
                         <li class="nav-home">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sitemanagement.list') }}">Site</a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                         <a href="#">Attendance Details</a>
                        </li>
                    </ul>
                </div>
                    <a href="{{ route('site.detail', ['id' => $siteId]) }}" class="btn btn-outline-primary rounded-pill">
                    ← Back
                </a>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <h6 class="card-title mb-0 fw-bold">Site Name: {{ $siteName }}</h6>

                            <!-- Month Picker -->
                            <div class="row mb-2 align-items-end pb-3" style="border-bottom: 1px solid #ebecec;">
                                <div class="col-md-2">
    <input type="month" id="monthPicker" class="form-control"
        value="{{ request('month') ?? '' }}">
</div>
                                <!-- Week Buttons -->
                                <div class="row justify-content-center">
                                    @for ($i = 1; $i <= $totalWeeks; $i++)
                                        <div class="col-auto mb-2">
                                            <div class="text-center fw-bold">
                                                <span
                                                    class="badge badge-black week-btn {{ request('week') == $i ? 'active' : '' }}"
                                                    data-week="{{ $i }}">
                                                    Week {{ $i }}
                                                </span>
                                            </div>
                                        </div>
                                    @endfor
                                </div>

                            </div>

                            <!-- Week Days Box -->
                            <div id="weekDaysBox" class="mb-2">
                                <div class="row g-2 justify-content-center mb-2" id="weekBoxRow"
                                    style="border-bottom: 1px solid #ebecec;">
                                    @if (!empty($weekDays))
                                        @foreach ($weekDays as $day)
                                            <div class="col-auto">
                                                <div class="text-center border p-2 rounded day-box mb-2
                                            {{ request('date') === $day['value'] ? 'selected-day' : 'bg-success' }}"
                                                    data-date="{{ $day['value'] }}" style="cursor:pointer; width:70px;">
                                                    <div class="fw-bold">
                                                        {{ \Carbon\Carbon::parse($day['value'])->format('D') }}
                                                    </div>
                                                    <div>{{ \Carbon\Carbon::parse($day['value'])->format('d') }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- Total Workers Section -->
                            <div class="d-flex align-items-center mt-3">
                                <h4 class="card-title" style="margin-right: 302px;">Total Workers</h4>
                                <div class="col-md-2 ms-3">
                                    <a href="{{ route('wages.form', ['siteId' => $siteId]) }}"
                                        class="btn btn-info w-100">Add Wages</a>
                                </div>
                                <div class="col-md-2 ms-3">
                                    <a href="{{ route('attendance.form', ['siteId' => $siteId]) }}"
                                        class="btn btn-primary w-100">Add Attendance</a>
                                </div>
                                <div class="col-md-2 ms-3">
    <a href="{{ route('attendance.export', ['siteId' => $siteId, 'month' => request('month'), 'week' => request('week')]) }}"
       class="btn btn-success">
        Export to Excel
    </a>
</div>
                            </div>
                        </div>

                        <!-- Success message -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            {{ session()->forget('success') }}
                        @endif

                        <!-- Attendance list -->
                        @if ($attendances->isEmpty())
                            <p class="text-center mt-3">No Attendance list.</p>
                        @else
                            @if (!empty(request('month')) && empty(request('date')))
                                <!-- Display Table for Monthly or Month+Week View -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    @foreach ($allCategories as $cat)
                                                        <th>{{ ucfirst($cat) }}</th>
                                                    @endforeach
                                                    <th>Total Amount (₹)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($groupedByDate as $day)
                                                    <tr>
                                                        <td>{{ $day['date'] }}</td>
                                                        @foreach ($allCategories as $cat)
                                                            <td>{{ $day[$cat] ?? '--' }}</td>
                                                        @endforeach
                                                        <td>₹{{ $day['total'] }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <!-- Display Data in Cards for Daily View -->
                                <div class="card-body">
                                    <div class="row mt-3">
                                        @php
                                            $wagesByCategory = $wages->keyBy(function ($item) {
                                                return $item->category .
                                                    '|' .
                                                    \Carbon\Carbon::parse($item->date)->toDateString();
                                            });
                                        @endphp

                                       @foreach ($attendances as $attendance)
    @php
        $attendanceDate = \Carbon\Carbon::parse($attendance->date);
        $category = $attendance->category;

        // Get latest applicable wage
        $amount = 0;
        $categoryWages = $wages->where('category', $category)
                                ->where('date', '<=', $attendanceDate->toDateString())
                                ->sortByDesc('date');
        if ($categoryWages->isNotEmpty()) {
            $amount = $categoryWages->first()->amount;
        }

        $categoryWage = $attendance->count * $amount;
    @endphp
    <div class="col-sm-6 col-md-4">
        <div class="card card-stats card-round border border-info">
            <div class="card-body">
                <div class="row">
                    <div class="col-7 col-stats">
                        <div class="numbers">
                            <h4 class="card-title">{{ $attendance->count ?? 0 }}</h4>
                            <div style="display: flex; align-items: center; gap: 5px;">
                                <h6 class="card-title mb-0">{{ ucfirst($attendance->category) }}</h6>
                                <p class="card-category mb-0" style="white-space: nowrap;">
                                    X ₹{{ $amount }} = <strong>₹{{ $categoryWage }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="icon-big text-center">
                            <i class="fas fa-users text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="row justify-content-center mt-4" id="addButton">
                                <div class="col-12 col-md-8 col-lg-6">
                                    <div class="card border border-primary shadow" style="min-height: 140px;">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-6 text-center">
                                                    <img src="{{ asset('images/sri/wages.jpg') }}"
                                                        style="width: 100px; height: 100px; object-fit: cover;">
                                                </div>
                                                <div class="col-6 text-start">
                                                    <h4 class="mb-0 text-uppercase text-center">Total Wages</h4>
                                                    <h3 class="fw-bold mb-0 text-center">₹{{ $totalWages ?? 0 }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Spinner -->
    <div class="d-flex justify-content-center mt-3">
        <div class="spinner-border text-primary d-none" role="status" id="loadingSpinner">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- JS script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthPicker = document.getElementById('monthPicker');
            const weekButtons = document.querySelectorAll('.week-btn');
            const weekBoxRow = document.getElementById('weekBoxRow');
            const siteId = '{{ $siteId }}';

            let currentSelectedMonth = monthPicker.value;

            // Month change => Load entire month data
            monthPicker.addEventListener('change', function() {
                currentSelectedMonth = this.value;
                if (currentSelectedMonth) {
                    window.location.href = `/admin/public/admin/attendance/${siteId}?month=${currentSelectedMonth}`;
                }
            });

            // Week button click => Load week data for currentSelectedMonth
            weekButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    weekButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    const selectedWeek = this.getAttribute('data-week');

                    if (currentSelectedMonth && selectedWeek) {
                        window.location.href =
                            `/admin/public/admin/attendance/${siteId}?month=${currentSelectedMonth}&week=${selectedWeek}`;
                    }
                });
            });

            // Day box click => Load specific date view
            weekBoxRow.addEventListener('click', function(event) {
                const target = event.target.closest('.day-box');
                if (target) {
                    const selectedDateStr = target.getAttribute('data-date');
                    const selectedMonth = getQueryParam('month');
                    const selectedWeek = getQueryParam('week');

                    if (selectedDateStr) {
                        let url = `/admin/public/admin/attendance/${siteId}?date=${selectedDateStr}`;
                        if (selectedMonth) url += `&month=${selectedMonth}`;
                        if (selectedWeek) url += `&week=${selectedWeek}`;
                        window.location.href = url;
                    }
                }
            });

        });

        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Highlight selected week and day on page load
        const selectedWeek = getQueryParam('week');
        const selectedDate = getQueryParam('date');

        // Highlight the selected week button
        if (selectedWeek) {
            document.querySelectorAll('.week-btn').forEach(btn => {
                if (btn.getAttribute('data-week') === selectedWeek) {
                    btn.classList.add('active');
                }
            });
        }

        // Highlight the selected day box
        if (selectedDate) {
            document.querySelectorAll('.day-box').forEach(box => {
                if (box.getAttribute('data-date') === selectedDate) {
                    box.classList.add('selected-day');
                }
            });
        }
    </script>

    <!-- CSS -->
    <style>
        .week-btn {
            cursor: pointer;
        }

        .week-btn.active {
            background-color: #007bff;
            color: white;
        }

        .day-box:hover {
            background-color: #28a745 !important;
            color: white;
        }

        .day-box {
            width: 60px;
            height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .day-box div:first-child {
            font-weight: bold;
            font-size: 14px;
        }

        .day-box div:last-child {
            font-size: 12px;
        }

        .selected-day {
            background-color: #007bff !important;
            color: white !important;
        }

        .selected-week {
            background-color: #3399ff !important;
            color: white !important;
        }
    </style>
@endsection
