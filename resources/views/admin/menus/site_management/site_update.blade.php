@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Update Site</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Site</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Site Form</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <h4 class="card-title">Site Form</h4>
                            </div>
                        </div>
                        <div class="card-body">

                            <!-- Blade alert for success -->
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                {{ session()->forget('success') }} {{-- Clear session --}}
                            @endif

                            <div class="row">
                                <form id="siteForm" action="{{ route('sitemanagement.update', $site->id) }}" method="POST"
                                    enctype="multipart/form-data" class="container">
                                    @csrf

                                    @method('PATCH')

                                    <!-- Site Name -->
                                    <div class="row align-items-center mt-3">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="site_name">Site Name</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="site_name"
                                                    placeholder="Enter Name"
                                                    value="{{ old('site_name', $site->site_name ?? '') }}">
                                            </div>
                                            @error('site_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Site Images -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="site_img">Site Image</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input type="file" name="site_img" id="site_img" class="form-control">
                                                <img src="{{ asset('storage/' . $site->site_img) }}" width="100">
                                            </div>
                                            @error('site_img')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Location & Value -->
                                    <div class="row align-items-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="location">Location</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <textarea id="location" name="location" class="form-control" rows="4">{{ old('location', $site->location ?? '') }}</textarea>
                                            </div>
                                            @error('location')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Valaue -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="value">Value</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input type="text" name="value" id="value" class="form-control"
                                                    value="{{ old('value', $site->value ?? '') }}">
                                            </div>
                                            @error('value')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Duration & Settled Amount -->
                                    <div class="row align-items-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="duration">Duration</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input type="text" name="duration" class="form-control"
                                                    value="{{ old('duration', $site->duration ?? '') }}">
                                            </div>
                                            @error('duration')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Settled Amount -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="settled_amnt">Settled Amount</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input type="text" name="settled_amnt" id="value"
                                                    class="form-control"
                                                    value="{{ old('settled_amnt', $site->settled_amnt ?? '') }}">
                                            </div>
                                            @error('settled_amnt')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Pending Amount -->
                                    <div class="row align-items-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="pending_amnt">Pending Amount</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <input type="text" name="pending_amnt" class="form-control"
                                                    value="{{ old('pending_amnt', $site->pending_amnt ?? '') }}">
                                            </div>
                                            @error('pending_amnt')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Customer Form --}}
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between w-100">
                                            <h4 class="card-title">Update Status</h4>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-3 border-bottom pb-3">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label for="status">Change Status</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-select form-control" name="status" id="status">
                                                <option value="">Select Status</option>
                                                <option value="New" {{ $site->status == 'New' ? 'selected' : '' }}>New</option>
                                                <option value="Ongoing" {{ $site->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                                                <option value="Completed" {{ $site->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="card-action text-end">
                                        <button class="btn btn-success">Submit</button>
                                        <button class="btn btn-danger">Cancel</button>
                                    </div>
                                </form>
                            </div>
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
        //Spinner and Alert
        document.addEventListener("DOMContentLoaded", function() {
            let alert = document.querySelector('.alert');
            const form = document.getElementById('siteForm');
            const spinner = document.getElementById('loadingSpinner');

            //Success alert handling
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    window.location.href = "{{ route('sitemanagement.list') }}";
                }, 500);
            }

            //Show spinner only on site form submission
            if (form && spinner) {
                form.addEventListener('submit', function(event) {
                    spinner.classList.remove('d-none'); //Show spinner
                });
            }
        });
    </script>
@endsection
