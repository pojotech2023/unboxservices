{{-- resources/views/admin/evaluations/mobile/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="page-inner">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4" style="margin-top: 67px;">
        <div>
            <h3 class="fw-bold mb-1">Order Details</h3>
            <nav style="font-size:13px;color:#888;">
                <a href="{{ route('admin.dashboard') }}" style="color:#888;text-decoration:none;">🏠</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <a href="{{ route('admin.evaluations.mobile.index') }}"
                   style="color:#888;text-decoration:none;">Confirmed Orders</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <span style="color:#333;font-weight:600;">Order #{{ $evaluation->id }}</span>
            </nav>
        </div>
        <a href="{{ route('admin.evaluations.mobile.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="row g-4">

        {{-- ── LEFT: all evaluation detail cards (unchanged) ── --}}
        <div class="col-lg-8">

            {{-- Customer Info --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-user-circle text-primary me-2"></i>Customer Information
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase">Name</small>
                                <div class="fw-bold">{{ $evaluation->customer_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase">Mobile</small>
                                <div class="fw-bold">{{ $evaluation->customer_mobile }}</div>
                            </div>
                        </div>
                        {{-- ✅ Alternate number --}}
                        @if($evaluation->alternate_number)
                        <div class="col-md-6 mt-3">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase">Alternate Number</small>
                                <div class="fw-bold">{{ $evaluation->alternate_number }}</div>
                            </div>
                        </div>
                        @endif
                        {{-- ✅ OTP status --}}
                        <div class="col-md-6 mt-3">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase">OTP Verification</small>
                                <div class="mt-1">
                                    @if($evaluation->otp_verified)
                                        <span class="badge bg-success">
                                            <i class="fas fa-shield-alt me-1"></i> OTP Verified
                                        </span>
                                        <div class="text-muted mt-1" style="font-size:11px;">
                                            {{ $evaluation->otp_verified_at?->format('d M Y, h:i A') }}
                                        </div>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i> Not Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Device Info --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-mobile-alt text-primary me-2"></i>Device Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase">Brand</small>
                                <div class="fw-bold">{{ $evaluation->brand->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase">Model</small>
                                <div class="fw-bold">{{ $evaluation->model->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <small class="text-muted text-uppercase">Variant</small>
                                <div class="fw-bold">{{ $evaluation->variant->memory ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Evaluation Answers --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-clipboard-check text-primary me-2"></i>Device Evaluation Answers
                    </h5>
                    @if(!empty($questionsMap))
                        <div class="row g-3">
                            @foreach($questionsMap as $item)
                            <div class="col-md-6">
                                <div class="p-3 border rounded">
                                    <div class="text-muted small mb-1">{{ $item['question_text'] }}</div>
                                    @if($item['answer'] === 'yes')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>{{ $item['answer_text'] }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>{{ $item['answer_text'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No evaluation answers found.</p>
                    @endif
                </div>
            </div>

            {{-- Defects --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-exclamation-circle text-danger me-2"></i>Defects
                    </h5>
                    @if(!empty($defectsMap))
                        @foreach($defectsMap as $defect)
                        <div class="mb-3 p-3 border rounded border-danger-subtle bg-danger-subtle">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-times-circle text-danger me-2"></i>
                                <strong class="text-danger">{{ $defect['defect_name'] }}</strong>
                            </div>
                            @if(!empty($defect['sections']))
                                <div class="ms-4 mt-2">
                                    @foreach($defect['sections'] as $section)
                                    <div class="small mb-1">
                                        <span class="text-muted">{{ $section['section_name'] }}:</span>
                                        <span class="badge bg-success ms-1">
                                            <i class="fas fa-check me-1"></i>{{ $section['image_description'] }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <div class="p-3 bg-success-subtle rounded text-success">
                            <i class="fas fa-check-circle me-2"></i>No Defects Reported
                        </div>
                    @endif
                </div>
            </div>

            {{-- Problems --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Functional Problems
                    </h5>
                    @if(!empty($problemsMap))
                        <div class="row g-2">
                            @foreach($problemsMap as $problem)
                            <div class="col-12">
                                <div class="p-2 border rounded border-warning-subtle bg-warning-subtle text-warning-emphasis">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ $problem['problem_name'] }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-3 bg-success-subtle rounded text-success">
                            <i class="fas fa-check-circle me-2"></i>No Problems Reported
                        </div>
                    @endif
                </div>
            </div>

            {{-- Accessories --}}
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-box text-primary me-2"></i>Accessories
                    </h5>
                    @if(!empty($accessoriesMap))
                        <div class="row g-2">
                            @foreach($accessoriesMap as $accessory)
                            <div class="col-md-6">
                                <div class="p-2 border rounded border-primary-subtle bg-primary-subtle text-primary-emphasis">
                                    <i class="fas fa-check me-2"></i>
                                    {{ $accessory['accessory_name'] }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-3 bg-light rounded text-muted">
                            <i class="fas fa-box-open me-2"></i>No Accessories
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ── RIGHT SIDEBAR ── --}}
        <div class="col-lg-4">

            {{-- ✅ Price & Order Info (replaces old price-only card) --}}
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="fw-bold mb-3">Order Summary</h5>
                    <div class="p-4 bg-success text-white rounded mb-3">
                        <div class="small opacity-75">Final Quote</div>
                        <div class="fs-2 fw-bold">₹{{ number_format($evaluation->estimated_price, 0) }}</div>
                    </div>

                    {{-- Payment Method --}}
                    @php
                        $pmColors = [
                            'upi'  => ['bg'=>'#e3f2fd','color'=>'#1565c0'],
                            'cash' => ['bg'=>'#e8f5e9','color'=>'#2e7d32'],
                            'bank' => ['bg'=>'#fff3e0','color'=>'#e65100'],
                        ];
                        $pm = strtolower($evaluation->payment_method ?? '');
                        $pc = $pmColors[$pm] ?? ['bg'=>'#f5f5f5','color'=>'#666'];
                    @endphp
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="text-muted" style="font-size:13px;">Payment</span>
                        @if($evaluation->payment_method)
                            <span style="background:{{ $pc['bg'] }};color:{{ $pc['color'] }};
                                         padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;
                                         text-transform:uppercase;">
                                <i class="fas fa-credit-card me-1"></i>{{ $evaluation->payment_method }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </div>

                    {{-- Status --}}
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="text-muted" style="font-size:13px;">Status</span>
                        <span style="background:#e8f5e9;color:#2e7d32;padding:4px 12px;
                                     border-radius:20px;font-size:12px;font-weight:600;text-transform:capitalize;">
                            <i class="fas fa-check-circle me-1"></i>{{ $evaluation->status }}
                        </span>
                    </div>

                    {{-- Order ID --}}
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="text-muted" style="font-size:13px;">Order ID</span>
                        <span class="fw-bold">#{{ $evaluation->id }}</span>
                    </div>

                    {{-- Date --}}
                    <div class="text-start mt-3">
                        <small class="text-muted text-uppercase">Order Placed</small>
                        <div class="fw-bold">{{ $evaluation->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>

            {{-- ✅ Pickup Address card (new) --}}
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>Pickup Address
                    </h5>

                    @if($evaluation->flat_no)
                    <div class="mb-2">
                        <small class="text-muted text-uppercase">Flat / House No.</small>
                        <div class="fw-bold">{{ $evaluation->flat_no }}</div>
                    </div>
                    @endif

                    @if($evaluation->locality)
                    <div class="mb-2">
                        <small class="text-muted text-uppercase">Locality</small>
                        <div class="fw-bold">{{ $evaluation->locality }}</div>
                    </div>
                    @endif

                    @if($evaluation->landmark)
                    <div class="mb-2">
                        <small class="text-muted text-uppercase">Landmark</small>
                        <div class="fw-bold">{{ $evaluation->landmark }}</div>
                    </div>
                    @endif

                    <div class="row g-2 mb-2">
                        @if($evaluation->city)
                        <div class="col-7">
                            <small class="text-muted text-uppercase">City</small>
                            <div class="fw-bold">{{ $evaluation->city }}</div>
                        </div>
                        @endif
                        @if($evaluation->pincode)
                        <div class="col-5">
                            <small class="text-muted text-uppercase">Pincode</small>
                            <div class="fw-bold">{{ $evaluation->pincode }}</div>
                        </div>
                        @endif
                    </div>

                    @if($evaluation->address_type)
                    <div class="mb-3">
                        <small class="text-muted text-uppercase">Address Type</small>
                        <div class="mt-1">
                            <span style="background:#f3e5f5;color:#6a1b9a;padding:4px 12px;
                                         border-radius:20px;font-size:12px;font-weight:600;">
                                <i class="fas fa-home me-1"></i>{{ ucfirst($evaluation->address_type) }}
                            </span>
                        </div>
                    </div>
                    @endif

                    {{-- Pickup Slot highlighted --}}
                    @if($evaluation->pickup_slot)
                    <div class="p-3 mt-2"
                         style="background:#fff8e1;border-radius:10px;border-left:4px solid #ffc107;">
                        <small class="text-muted"><i class="fas fa-clock me-1"></i>Pickup Slot</small>
                        <div class="fw-bold mt-1" style="color:#e65100;">
                            {{ $evaluation->pickup_slot }}
                        </div>
                    </div>
                    @endif

                    @if(!$evaluation->flat_no && !$evaluation->locality && !$evaluation->city && !$evaluation->pincode)
                    <p class="text-muted mb-0">No address provided.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection