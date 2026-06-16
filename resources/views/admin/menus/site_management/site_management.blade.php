@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header leads-page-header">
                <h3 class="fw-bold mb-3">Site Management</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Site Management</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-12 col-md-8">

                    <!-- Blade alert for success -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        {{ session()->forget('success') }} {{-- Clear session --}}
                    @endif

                    <form id="filterform" action="" method="GET" action="{{ route('sitemanagement.list') }}"
                        class="row mb-3">
                     
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-4">
                                <select name="status" id="statusFilter" class="form-select"
                                    onchange="document.getElementById('filterform').submit();">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                                    <option value="coated" {{ request('status') == 'coated' ? 'selected' : '' }}>coated</option>
                                    <option value="Ongoing" {{ request('status') == 'Ongoing' ? 'selected' : '' }}>Ongoing
                                    </option>
                                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                            </div>

                            <div class="col-md-8 d-flex justify-content-end">
                                <a href="{{ route('site.form') }}" class="btn btn-primary btn-round">
                                    <i class="fa fa-plus"></i> Add Site
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            @if ($sites->isEmpty())
                <p class="text-center mt-3"> No Site list found. Please create site.</p>
            @else
                <div class="row">
                    <div class="col-12 col-md-8">
                        @foreach ($sites as $site)
                            <div class="card mt-3 site-card" data-route="{{ route('site.detail', $site->id) }}"
                                onclick="redirectToLeadDetails(event, this)">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-6 d-flex align-items-center">
                                            <h6 class="card-title mb-0">Site ID: {{ $site->id }}</h6>
                                            <span class="op-7 ms-3 fw-normal">
                                                {{ \Carbon\Carbon::parse($site->created_at)->format('M, d Y h:i A') }}
                                            </span>
                                        </div>
                                        <div class="col-6 text-end">
                                            @php
    // Get status from database
    $status = $site->status ?? 'coated';

    // If database has 'new', display as 'coated'
    if ($status === 'New') {
        $status = 'coated';
    }

    // Set badge class based on status
    $badgeClass = match ($status) {
        'coated' => 'badge-info',
        'Ongoing' => 'badge-warning',
        'Completed' => 'badge-success',
        default => 'badge-secondary',
    };
@endphp

<span class="badge {{ $badgeClass }}">
    {{ ucfirst($status) }}
</span>

                                            <div class="form-button-action">
                                                <a href="{{ route('sitemanagement.edit', ['id' => $site->id]) }}"
                                                    class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-link btn-danger deleteButton"
                                                    data-id="{{ $site->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- style="width: 50%; margin: 0 auto;" --}}
                                    <div class="row justify-content-center">
                                        <img src="{{ asset('storage/' . $site->site_img) }}" alt="Site Image"
                                            class="mx-auto d-block" style="width: 30%;">
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            <p><strong>Site Name:</strong>
                                                <span class="text-muted">{{ $site->site_name }}</span>
                                            </p>
                                            <p><strong>Duration</strong>
                                                <span class="text-muted">{{ $site->duration }}</span>
                                            </p>
                                            
                                             <p><strong>Bulid Up Area:</strong>
                                                <span class="text-muted">{{ $site->built_up_area }}</span>
                                            </p>
                                            <!-- <p><strong>Settled Amount:</strong>
                                                <span class="text-muted">{{ $site->settled_amnt }}</span>
                                            </p>-->
                                           <!-- <p><strong>Settled Amount:</strong>
                                                <span class="text-muted">{{ $site->settled_amnt }}</span>
                                            </p>--> 
                                            <!--<p><strong>Expense:</strong>
                                                <span class="text-muted">{{ $site->expense ?? 0 }}</span>
                                            </p>-->
                                        </div>
                                        <div class="col-6">
                                        <p><strong>Location:</strong>
                                        @php
                                            $location = $site->location;
                                            $isMapLink = Str::startsWith($location, ['http://', 'https://']) && Str::contains($location, 'maps');
                                        @endphp

                                        @if($isMapLink)
                                            <a href="{{ $location }}" target="_blank" 
                                            class="btn btn-sm btn-outline-primary ms-2"
                                            style="padding: 2px 10px; font-size: 13px; border-radius: 8px;">
                                                <i class="bi bi-geo-alt-fill"></i> View on Map
                                            </a>
                                        @else
                                            <span class="text-muted">{{ $location }}</span>
                                        @endif
                                    </p>

                                    <p><strong>Flat Area:</strong>
                                    <span class="text-muted">{{ $site->flat_area }}</span>
                                    </p>
                                        <!-- <p><strong>Value:</strong>
                                                <span class="text-muted">{{ $site->value }}</span>
                                            </p>-->
                                           <!-- <p><strong>Pending Amount:</strong>
                                                <span class="text-muted">{{ $site->pending_amnt }}</span>
                                            </p>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal (Outside Loop) -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this record?
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End of Delete Confirmation Modal -->

    <!-- Spinner -->
    <div class="d-flex justify-content-center mt-3">
        <div class="spinner-border text-primary d-none" role="status" id="loadingSpinner">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <script>
        //redirect to leads detail page
        function redirectToLeadDetails(event, card) {
            event.stopPropagation(); // Prevents unintended clicks
            // Remove styles from all cards
            document.querySelectorAll('.site-card').forEach(item => {
                item.classList.remove('selected-card');
            });
            // Add active class to clicked card
            card.classList.add('selected-card');
            // Redirect after small delay
            let route = card.getAttribute('data-route');
            if (route) {
                window.location.href = route;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {

            //delete site
            document.querySelectorAll(".deleteButton").forEach(button => {
                button.addEventListener("click", function() {
                    event.stopPropagation();
                    const siteId = this.getAttribute("data-id");
                    const action = "{{ route('sitemanagement.delete', ':id') }}".replace(':id',
                        siteId);
                    document.getElementById("deleteForm").setAttribute("action", action);
                });
                //Auto-hide success alert after 3 seconds 
                const successAlert = document.querySelector(".alert-success");
                const form = document.getElementById('deleteForm');
                const spinner = document.getElementById('loadingSpinner');

                if (successAlert) {
                    setTimeout(() => {
                        successAlert.classList.remove("show");
                        successAlert.classList.add("fade");
                    }, 500);
                }
                //Show spinner only on site form submission
                if (form && spinner) {
                    form.addEventListener('submit', function(event) {
                        spinner.classList.remove('d-none'); //Show spinner
                    });
                }
            });
        });
    </script>

    <style>
        .site-card {
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            border: 2px solid #dee2e6;
            background: #fff;
            border-radius: 8px;
        }

        /* Hover Effect */
        .site-card:hover {
            transform: scale(1.02);
            border-color: #007bff;
            box-shadow: 0px 5px 15px rgba(0, 123, 255, 0.3);
        }
    </style>
@endsection
