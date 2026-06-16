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

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    {{ session()->forget('success') }}
                @endif

                <form id="quotationForm" action="{{ route('quotation.add') }}" method="POST" class="container">
                    @csrf

                    <div class="row mt-4">
                        <div class="col-md-2 fw-bold">Name</div>
                        <div class="col-md-4">
                            <input type="text" name="name" class="form-control" placeholder="Customer Name">
                            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-2 fw-bold">Mobile No</div>
                        <div class="col-md-4">
                            <input type="text" name="mobile_no" class="form-control" placeholder="Mobile Number">
                            @error('mobile_no') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-2 fw-bold">Date</div>
                        <div class="col-md-4">
                            <input type="date" name="date" class="form-control">
                            @error('date') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-2 fw-bold">Subject</div>
                        <div class="col-md-6">
                            <input type="text" name="subject" class="form-control" placeholder="Subject of Quotation">
                            @error('subject') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                     <div class="row mt-4">
                        <div class="col-md-2 fw-bold">Location</div>
                        <div class="col-md-6">
                            <input type="text" name="location" class="form-control" placeholder="Please Enter Location">
                            @error('location') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                     <div class="row mt-4">
                        <div class="col-md-2 fw-bold">Contractor:</div>
                        <div class="col-md-6">
                            <input type="text" name="contractor" class="form-control" placeholder="Please Enter Contractor">
                            @error('contractor') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <hr class="mt-5 mb-3">

                    <h5 class="mb-3">Particulars</h5>

                    <div id="particularRows">
                        @php
                            $defaults = [
                                ['Car Park 8 Ft Roof Height', 1700, 2406],
                                ['1st Floor', 2050, 2406],
                                ['2nd Floor', 2050, 2406],
                                ['3rd Floor', 2050, 2406],
                                ['Head Room 8 ft/ Lift Room', 1850, 450],
                                ['Elevation Work', 200000, 1],
                                ['Sump R C C', 23, 12000],
                                ['Specktic Tank', 18, 12000],
                                ['Water Tank R C C', 23, 6000],
                                ['Water Tank staircase Grill', 15000, 1],
                                ['E.B. DB Panel', 15000, 10],
                                ['Weathering Tiles', 160, 2406],
                                ['Safety Gate', 135000, 1],
                                ['Lift 6 Passenger', 750000, 1],
                                ['Compound Gate', 80000, 2],
                                ['Compound Wall 8 ft', 1800, 209],
                            ];
                        @endphp

                        @foreach ($defaults as $item)
                            <div class="row mb-2 particular-row">
                                <div class="col-md-2">
                                    <input type="text" name="particular[]" class="form-control" value="{{ $item[0] }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" step="any" name="rate[]" class="form-control rate" value="{{ $item[1] }}">
                                </div>
                            <div class="col-md-2">
                                <select name="unit[]" class="form-control unit">
                                <option value="sqft" {{ $item[2] == 'sqft' ? 'selected' : '' }}>sqft</option>
                                <option value="Cft" {{ $item[2] == 'Cft' ? 'selected' : '' }}>Cft</option>
                                <option value="Lit" {{ $item[2] == 'Lit' ? 'selected' : '' }}>Lit</option>
                                <option value="Nos" {{ $item[2] == 'Nos' ? 'selected' : '' }}>Nos</option>
                                <option value="Rft" {{ $item[2] == 'Rft' ? 'selected' : '' }}>Rft</option>
                                <option value="Ls" {{ $item[2] == 'Ls' ? 'selected' : '' }}>Ls</option>
                                </select>
                            </div>

                                <div class="col-md-2">
                                    <input type="number" step="any" name="sqFt[]" class="form-control sqft" value="{{ $item[2] }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" step="any" name="total_cost[]" class="form-control total_cost" value="{{ $item[1] * $item[2] }}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-row">X</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-secondary my-3" id="addRow">+ Add Row</button>

                    <div class="row justify-content-end">
                        <div class="col-md-6 text-end">
                            <h5 class="text-primary">Total: ₹ <span id="grandTotal" class="text-dark">0.00</span></h5>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-lg-4">
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary w-100" id="saveButton">Send WhatsApp</button>
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

<!-- JS Section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const successAlert = document.querySelector(".alert-success");
    if (successAlert) {
        setTimeout(() => {
            successAlert.classList.remove("show");
            successAlert.classList.add("fade");
        }, 300);
    }

    // Run once page fully loads — grand total for default values
    updateGrandTotal();
});

$(document).ready(function () {
    // Auto-calculate total cost on input
    $(document).on('input', '.rate, .sqft', function () {
        const row = $(this).closest('.particular-row');
        const rate = parseFloat(row.find('.rate').val()) || 0;
        const sqft = parseFloat(row.find('.sqft').val()) || 0;
        const total = rate * sqft;
        row.find('.total_cost').val(total.toFixed(2));
        updateGrandTotal(); // Recalculate grand total
    });

    // Add new row
    $('#addRow').on('click', function () {
      const row = `
<div class="row mb-2 particular-row">
    <div class="col-md-2">
        <input type="text" name="particular[]" class="form-control" placeholder="Particular">
    </div>
    <div class="col-md-2">
        <input type="number" step="any" name="rate[]" class="form-control rate" placeholder="Rate">
    </div>
    <div class="col-md-2">
        <select name="unit[]" class="form-control unit">
            <option value="sqft">sqft</option>
            <option value="Cft">Cft</option>
            <option value="Lit">Lit</option>
            <option value="Nos">Nos</option>
            <option value="Rft">Rft</option>
            <option value="Ls">Ls</option>
        </select>
    </div>
    <div class="col-md-2">
        <input type="number" step="any" name="sqFt[]" class="form-control sqft" placeholder="">
    </div>
    <div class="col-md-2">
        <input type="number" step="any" name="total_cost[]" class="form-control total_cost" placeholder="Total Cost" readonly>
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-danger remove-row">X</button>
    </div>
</div>`;
  $('#particularRows').append(row);
        updateGrandTotal(); // Even blank row won't change, but just in case
    });

    // Remove row
    $(document).on('click', '.remove-row', function () {
        $(this).closest('.particular-row').remove();
        updateGrandTotal();
    });

    // Ajax Submit
    $('#quotationForm').on('submit', function (e) {
        e.preventDefault();
        $('#loadingSpinner').removeClass('d-none');

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            success: function (response) {
                $('#loadingSpinner').addClass('d-none');
                if (response.status === 'success') {
                    window.open(response.whatsapp_url, '_blank');
                    form[0].reset();
                    $('#particularRows').empty();
                    updateGrandTotal(); // reset total
                }
            },
            error: function (xhr) {
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
});

//Function to calculate grand total
function updateGrandTotal() {
    let total = 0;
    $('.total_cost').each(function () {
        total += parseFloat($(this).val()) || 0;
    });
    $('#grandTotal').text(total.toFixed(2));
}
</script>

@endsection
