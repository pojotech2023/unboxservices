@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">SubContractor Dashboard</h3>
                </div>
            </div>
            <div class="row">
                @foreach ($subcontractors as $sub)
                    <div class="col-md-4">
                        <a href="{{ route('subcontractor.paymentHistory', ['type' => $sub['type']]) }}"
                            class="text-decoration-none">
                            <div class="card card-stats card-round">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-icon">
                                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="col col-stats ms-3 ms-sm-0">
                                            <div class="numbers">
                                                <h4 class="card-title text-capitalize">{{ strtolower($sub['type']) }}</h4>
                                                <p class="card-category">
                                                    <strong>Total Amount:</strong> ₹<span
                                                        class="text-primary">{{ number_format($sub['total_amount'], 2) }}</span>
                                                </p>
                                                <p class="card-category">
                                                    <strong>Paid Amount:</strong> ₹<span
                                                        class="text-success">{{ number_format($sub['paid_amount'], 2) }}</span>
                                                </p>
                                                <p class="card-category">
                                                    <strong>Pending Amount:</strong> ₹<span
                                                        class="text-danger">{{ number_format($sub['pending_amount'], 2) }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
