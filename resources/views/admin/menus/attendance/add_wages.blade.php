@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h3 class="text-center pb-4 mt-3">Add Wages</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-lg p-4 ms-4">

                    <!-- Blade alert for success -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        {{ session()->forget('success') }} {{-- Clear session --}}
                    @endif

                    <form id="requestForm" action="{{ route('add.wages') }}" method="POST" class="container">
                        @csrf

                        <input type="hidden" name="site_id" value="{{ $siteId }}">

                        <!-- Row for Date Picker (Top-right) -->
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <div class="form-group">
                                    <label for="date" class="fw-bold">Date</label>
                                    <input type="date" class="form-control w-auto d-inline-block" name="date" />
                                </div>
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 1: Labels for Category and Amount -->
                        <div class="row align-items-center mt-4">
                            <!-- Category Label -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category" class="fw-bold">Category</label>
                                </div>
                            </div>

                            <!-- Amount Label -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="amount" class="fw-bold">Amount</label>
                                </div>
                            </div>
                        </div>

                        <!-- Category & Amount Input -->
                        @foreach (['kothanar', 'sithal', 'mesthiri', 'engineer'] as $category)
                            <div class="row align-items-center mt-3">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" for="amount_{{ $category }}" value="{{ ucfirst($category) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="amount_{{ $category }}"
                                            placeholder="Enter Amount">
                                    </div>
                                    @error('amount_' . $category)
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <!-- Submit Button -->
                        <div class="col-lg-2 ms-auto">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </div>
                    </form>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let dateInput = document.getElementById("todayDate");
            // Set default value to today's date
            let today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
            // Allow users to change the date freely
            dateInput.addEventListener("change", function() {
                console.log("Selected Date:", dateInput.value);
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            let alert = document.querySelector('.alert');
            const form = document.getElementById('requestForm');
            const spinner = document.getElementById('loadingSpinner');

            //Success alert handling
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                     const siteId = "{{ $siteId }}";
                    window.location.href = "/admin/attendance/" + siteId;
                }, 500);
            }

            //Show spinner only on job form submission
            if (form && spinner) {
                form.addEventListener('submit', function(event) {
                    spinner.classList.remove('d-none'); //Show spinner
                });
            }
        });
    </script>
@endsection
