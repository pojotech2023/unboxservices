@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <h3 class="fw-bold mb-3">{{ ucfirst($materialType) }} Details</h3>
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
                            <a href="#">{{ ucfirst($materialType) }} Details</a>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('material.detail', ['siteId' => $siteId]) }}"
                    class="btn btn-outline-primary rounded-pill">
                    ← Back
                </a>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h6 class="card-title mb-0 fw-bold">Site Name: {{ $siteName }}</h6>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-end pb-3"
                                style="border-bottom: 1px solid rgb(235, 236, 236) !important;">
                                <div class="col-md-2">
                                    <input type="month" id="monthPicker" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center fw-bold">
                                        <span class="badge badge-black week-btn" data-week="1">Week 1</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center fw-bold">
                                        <span class="badge badge-black week-btn" data-week="2">Week 2</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center fw-bold">
                                        <span class="badge badge-black week-btn" data-week="3">Week 3</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center fw-bold">
                                        <span class="badge badge-black week-btn" data-week="4">Week 4</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <h4 class="card-title" style="margin-right: 535px;">{{ ucfirst($materialType) }} Overview
                                </h4>
                                <div class="col-md-2 ms-3">
                                    <a href="{{ route('material.requestForm', ['siteId' => $siteId, 'materialType' => $materialType]) }}"
                                        class="btn btn-info w-100">Request</a>
                                </div>
                                <div class="col-md-2 ms-3">
                                    <a href="{{ route('material.orderForm', ['siteId' => $siteId, 'materialType' => $materialType]) }}"
                                        class="btn btn-primary w-100">Add Order</a>
                                </div>
                                {{-- <div class="col-md-2 ms-3">
                                    <a href="{{ route('bricks.payForm', ['siteId' => $siteId]) }}"
                                        class="btn btn-success w-100">Pay Details</a>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Blade alert for success -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            {{ session()->forget('success') }} {{-- Clear session --}}
                        @endif

                        @if ($materials->isEmpty())
                            <p class="text-center mt-3"> No {{ ucfirst($materialType) }} list found this Site.</p>
                        @else
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Date</th>
                                                <th>Quantity</th>
                                                <th>Vendor</th>
                                                <th>Price</th>
                                                {{-- <th>Available</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="bricksTableBody">
                                            @foreach ($materials as $index => $brick)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $brick->date }}</td>
                                                    <td>{{ $brick->quantity }}</td>
                                                    <td>{{ $brick->vendor->name }}</td>
                                                    <td>{{ $brick->price }}</td>
                                                    {{-- <td>{{ $brick->available_unit_count }}</td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-body d-flex justify-content-center">
                            <table class="table mt-3" style="width: 50%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h6 class="fw-bold text-info">TOTAL</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-bold text-info" id="totalUnits">{{ $totalUnits }} Units</h6>
                                        </td>
                                        <td>
                                            <h6 class="fw-bold text-info" id="totalAmount">{{ $totalAmount }}</h6>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-success fw-bold">Settled Amount</p>
                                        </td>
                                        <td></td>
                                        <td>
                                            <p class="text-success fw-bold" id="settledAmount">{{ $settledAmount }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="text-danger fw-bold">Pending Amount</p>
                                        </td>
                                        <td></td>
                                        <td>
                                            <p class="text-danger fw-bold" id="pendingAmount">{{ $pendingAmount }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const monthPicker = document.getElementById('monthPicker');
            const weekButtons = document.querySelectorAll('.week-btn');
            const spinner = document.getElementById('loadingSpinner');
            const tableBody = document.getElementById('bricksTableBody');

            let selectedWeek = 0;

            // Set default month
            const currentMonth = new Date().toISOString().slice(0, 7);
            monthPicker.value = currentMonth;

            // When week button clicked
            weekButtons.forEach((button, index) => {
                button.addEventListener('click', function() {
                    selectedWeek = index + 1;

                    // Highlight selected week
                    weekButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    fetchData();
                });
            });

            // When month changed
            monthPicker.addEventListener('change', function() {
                selectedWeek = 0;
                weekButtons.forEach(btn => btn.classList.remove('active'));
                fetchData();
            });

            function fetchData() {
                spinner.classList.remove('d-none');

                fetch(`{{ route('material.getData', ['siteId' => $siteId]) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            monthYear: monthPicker.value,
                            week: selectedWeek,
                            material_type: '{{ $materialType }}'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        spinner.classList.add('d-none');

                        // Update table
                        tableBody.innerHTML = '';
                        data.bricks.forEach((item, index) => {
                            tableBody.innerHTML += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.date}</td>
                                <td>${item.quantity}</td>
                                <td>${item.vendor.name}</td>
                                <td>${item.price}</td>
                            </tr>`;
                        });

                        // Update totals
                        document.getElementById('totalUnits').textContent = `${data.totalUnits} Units`;
                        document.getElementById('totalAmount').textContent = data.totalAmount;
                        document.getElementById('settledAmount').textContent = data.settledAmount;
                        document.getElementById('pendingAmount').textContent = data.pendingAmount;
                    })
                    .catch(error => {
                        spinner.classList.add('d-none');
                        console.error('Error fetching material data:', error);
                    });
            }

            // Initial fetch
            fetchData();
        });
    </script>

    <style>
        .week-btn {
            cursor: pointer;
        }

        .week-btn.active {
            background-color: #007bff;
            color: white;
        }
    </style>
@endsection
