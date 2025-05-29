@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <h3 class="fw-bold mb-3">{{ ucfirst($type) }} Payment</h3>
                    <ul class="breadcrumbs mb-0">
                        <li class="nav-home">
                            <a href="#">
                                <i class="icon-home"></i>
                            </a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">SubContractor Details</a>
                        </li>
                        <li class="separator">
                            <i class="icon-arrow-right"></i>
                        </li>
                        <li class="nav-item">
                         <a href="#">{{ ucfirst($type) }} Payment</a>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('subcontractor.detail', ['siteId' => $siteId]) }}" class="btn btn-outline-primary rounded-pill">
                    ← Back
                </a>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <h4 class="card-title mb-0">{{ ucfirst($type) }} Payment Management</h4>
                            </div>
                            <button class="btn btn-success btn-round ms-auto" id="addButton" data-bs-toggle="modal"
                                data-bs-target="#addModal">
                                <i class="fa fa-plus"></i> Payment
                            </button>
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

                        @if ($subcontractors->isEmpty())
                            <p class="text-center mt-3"> No {{ ucfirst($type) }} Pay list found this Site.</p>
                        @else
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bricksTableBody">
                                            @foreach ($subcontractors as $index => $subcontractor)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $subcontractor->name }}</td>
                                                    <td>{{ $subcontractor->date }}</td>
                                                    <td>{{ $subcontractor->amount }}</td>
                                                    <td>{{ $subcontractor->remarks }}</td>
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
                                            <h5 class="fw-bold text-info">TOTAL AMOUNT</h5>
                                        </td>
                                        <td>
                                            <h5 class="fw-bold text-info" id="totalUnits">{{ $totalAmount }}</h5>
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

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold" id="modalTitle">Add Payment</span>
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="plumberPayForm" action="{{ route('subcontractor.payAdd') }}" method="POST">
                        @csrf
                        <input type="hidden" id="site_id" name="site_id" value="{{ $siteId }}">

                        <input type="hidden" name="subcontractor_type" value="{{ ucfirst($type) }}">

                        <!-- Name -->
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-2">
                                <label for="name">Name</label>
                            </div>
                            <div class="col-lg-10">
                                <input id="name" name="name" type="text" class="form-control"
                                    placeholder="Enter name" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-2">
                                <label for="date">Date</label>
                            </div>
                            <div class="col-lg-10">
                                <input id="date" name="date" type="date" class="form-control" />
                                @error('date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-2">
                                <label for="name">Amount</label>
                            </div>
                            <div class="col-lg-10">
                                <input id="amount" name="amount" type="text" class="form-control"
                                    placeholder="Enter amount" />
                                @error('amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- remarks -->
                        <div class="row align-items-center mb-3">
                            <div class="col-lg-2">
                                <label for="remarks">Remarks</label>
                            </div>
                            <div class="col-lg-10">
                                <textarea id="remarks" name="remarks" class="form-control" rows="2" placeholder="Enter remarks"></textarea>
                                @error('remarks')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>

                        <div class="modal-footer border-0">
                            <button type="submit" class="btn btn-primary" id="saveButton">Add</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modalTitle = document.getElementById("modalTitle");
            const plumberPayForm = document.getElementById("plumberPayForm");
            const nameInput = document.getElementById("name");
            const dateInput = document.getElementById("date");
            const amountInput = document.getElementById("amount");
            const remarksInput = document.getElementById("remarks");
            const saveButton = document.getElementById("saveButton");
            const spinner = document.getElementById("loadingSpinner");

            // Add vendor Button Click
            document.getElementById("addButton").addEventListener("click", function() {
                modalTitle.innerText = "Add Payment";
                saveButton.innerText = "Add";
                plumberPayForm.action = "{{ route('subcontractor.payAdd') }}";
                nameInput.value = "";
                dateInput.value = "";
                amountInput.value = "";
                remarksInput.value = "";
            });

            if (plumberPayForm) {
                plumberPayForm.addEventListener("submit", function() {
                    spinner.classList.remove("d-none");
                    saveButton.disabled = true;
                });
            }

            //Auto-hide success alert after 3 seconds
            const successAlert = document.querySelector(".alert-success");
            if (successAlert) {
                setTimeout(() => {
                    successAlert.classList.add("fade");
                    successAlert.classList.remove("show");
                }, 500);
            }
            //Clear validation error when modal is closed
            addModal.addEventListener('hidden.bs.modal', function() {
                // Clear form fields
                nameInput.value = "";
                dateInput.value = "";
                amountInput.value = "";
                remarksInput.value = "";

                // Remove error messages manually
                const errorMessages = addModal.querySelectorAll('.text-danger');
                errorMessages.forEach(el => el.remove());

                // Remove is-invalid class
                const errorInputs = addModal.querySelectorAll('.is-invalid');
                errorInputs.forEach(input => input.classList.remove('is-invalid'));
            });
        });
    </script>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myModal = new bootstrap.Modal(document.getElementById('addModal'));
                myModal.show();
            });
        </script>
    @endif
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
