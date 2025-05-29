@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h3 class="text-center pb-4 mt-3">Generate Quotation</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-11">
                <div class="card shadow-lg p-4 ms-4">

                    <!-- Blade alert for success -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        {{ session()->forget('success') }} {{-- Clear session --}}
                    @endif

                    <form id="quotationForm" action="{{ route('quotation.add') }}" method="POST" class="container">
                        @csrf

                        <div class="row mt-4">
                            <div class="col-md-2 fw-bold">Name</div>
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="Customer Name">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-2 fw-bold">Mobile No</div>
                            <div class="col-md-4">
                                <input type="text" name="mobile_no" class="form-control" placeholder="Mobile Number">
                                @error('mobile_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-2 fw-bold">Date</div>
                            <div class="col-md-4">
                                <input type="date" name="date" class="form-control">
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-2 fw-bold">Subject</div>
                            <div class="col-md-6">
                                <input type="text" name="subject" class="form-control"
                                    placeholder="Subject of Quotation">
                                @error('subject')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="mt-5 mb-3">

                        <h5 class="mb-3">Particulars</h5>
                        <div id="particularRows">
                            <div class="row mb-2 particular-row">
                                <div class="col-md-3">
                                    <input type="text" name="particular[]" class="form-control" placeholder="Particular">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="rate[]" class="form-control" placeholder="Rate">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="sqFt[]" class="form-control" placeholder="sqFt">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="total_cost[]" class="form-control" placeholder="Total Cost">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-row">X</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary my-3" id="addRow">+ Add Row</button>

                        <div class="row justify-content-center mt-4">
                            <div class="col-lg-4">
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary w-100" id="saveButton">Send
                                        WhatsApp</button>
                                </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Your existing script
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector(".alert-success");
        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.remove("show");
                successAlert.classList.add("fade");
            }, 300);
        }
    });

    $(document).ready(function() {
        $('#quotationForm').on('submit', function(e) {
            e.preventDefault();
            $('#loadingSpinner').removeClass('d-none');

            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#loadingSpinner').addClass('d-none');
                    if (response.status === 'success') {
                        window.open(response.whatsapp_url, '_blank');
                        form[0].reset();
                        $('#particularRows').empty(); // Clear added rows too
                    }
                },
                error: function(xhr) {
                    $('#loadingSpinner').addClass('d-none');
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let message = Object.values(errors).map(e => e[0]).join("\n");
                        alert("Validation Errors:\n" + message);
                    } else {
                        alert("Something went wrong!");
                    }
                }
            });
        });

        // New: Dynamic Row Add/Remove Logic
        $('#addRow').on('click', function () {
            const row = `
            <div class="row mb-2 particular-row">
                <div class="col-md-3">
                    <input type="text" name="particular[]" class="form-control" placeholder="Particular">
                </div>
                <div class="col-md-2">
                    <input type="text" name="rate[]" class="form-control" placeholder="Rate">
                </div>
                <div class="col-md-2">
                    <input type="text" name="sqFt[]" class="form-control" placeholder="sqFt">
                </div>
                <div class="col-md-2">
                    <input type="text" name="total_cost[]" class="form-control" placeholder="Total Cost">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-row">X</button>
                </div>
            </div>`;
            $('#particularRows').append(row);
        });

        $(document).on('click', '.remove-row', function () {
            $(this).closest('.particular-row').remove();
        });
    });
</script>

@endsection
