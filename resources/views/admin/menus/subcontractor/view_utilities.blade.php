@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Site</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item">
                        <a href="{{ route('sitemanagement.list') }}">Site</a>
                    </li>
                    <li class="separator"><i class="icon-arrow-right"></i></li>
                    <li class="nav-item"><a href="#">Other Utilities</a></li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <h4 class="card-title mb-0">Other Utilities</h4>
                                {{-- <form method="GET" action="{{ route('vendor-list') }}" class="d-flex align-items-center">
                                    <div class="input-group" style="width: 280px !important;">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            class="form-control" id="searchLeads"
                                            placeholder="Search Name, Mobile, District...">
                                    </div>
                                </form> --}}
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

                        @if ($utilities->isEmpty())
                            <p class="text-center mt-3">No Other Utilities found. Please add a Others.</p>
                        @else
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="add-row" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Amount</th>
                                                <th>Remarks</th>
                                                <th>Image</th>
                                                {{-- <th style="width: 10%">Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($utilities as $index => $utility)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $utility->amount }}</td>
                                                    <td>{{ $utility->remarks }}</td>
                                                    <td><img src="{{ asset('storage/' . $utility->image)}}" alt="Uyility Image" width="75"></td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <!-- Edit Button -->
                                                            {{-- <button type="button"
                                                                class="btn btn-link btn-primary btn-lg editButton"
                                                                data-id="{{ $utility->id }}"
                                                                data-name="{{ $utility->amount }}"
                                                                data-site-utilities="{{ $utility->remarks }}"
                                                                data-bs-toggle="modal" data-bs-target="#addModal">
                                                                <i class="fa fa-edit"></i>
                                                            </button> --}}
                                                            <!-- Delete Button -->
                                                            {{-- <button type="button"
                                                                class="btn btn-link btn-danger deleteButton"
                                                                data-id="{{ $utility->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal">
                                                                <i class="fa fa-times"></i>
                                                            </button> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
