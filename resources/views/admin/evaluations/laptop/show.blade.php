{{-- resources/views/admin/laptop-evaluations/show.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="page-inner" style="margin-top: 67px;">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold mb-1">Order Details</h3>
            <nav style="font-size:13px;color:#888;">
                <a href="{{ route('admin.dashboard') }}" style="color:#888;text-decoration:none;">🏠</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <a href="{{ route('admin.laptop-evaluations.index') }}" style="color:#888;text-decoration:none;">Confirmed Orders</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <span style="color:#333;font-weight:600;">Order #{{ $evaluation->id }}</span>
            </nav>
        </div>
        <a href="{{ route('admin.laptop-evaluations.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Orders
        </a>
    </div>

    <div class="row g-4">

        {{-- ── LEFT COLUMN ── --}}
        <div class="col-lg-4">

            {{-- Customer Card --}}
            <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
                <div class="card-header bg-white" style="border-bottom:1px solid #f0f0f0;padding:20px;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-circle me-2 text-primary"></i>Customer Details
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="text-muted" style="font-size:12px;">Full Name</label>
                        <div class="fw-bold fs-6">{{ $evaluation->customer_name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted" style="font-size:12px;">Mobile Number</label>
                        <div class="fw-bold">
                            <i class="fas fa-phone text-success me-2"></i>+91 {{ $evaluation->customer_mobile }}
                        </div>
                    </div>
                    @if($evaluation->alternate_number)
                    <div class="mb-3">
                        <label class="text-muted" style="font-size:12px;">Alternate Number</label>
                        <div class="fw-bold">
                            <i class="fas fa-phone-alt text-secondary me-2"></i>+91 {{ $evaluation->alternate_number }}
                        </div>
                    </div>
                    @endif
                    <div class="mb-0">
                        <label class="text-muted" style="font-size:12px;">Verification Status</label>
                        <div>
                            @if($evaluation->otp_verified)
                                <span class="badge bg-success-subtle text-success px-3 py-2">
                                    <i class="fas fa-shield-alt me-1"></i> OTP Verified
                                </span>
                                <div class="text-muted mt-1" style="font-size:11px;">
                                    {{ $evaluation->otp_verified_at?->format('d M Y, h:i A') }}
                                </div>
                            @else
                                <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                    <i class="fas fa-clock me-1"></i> Not Verified
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Device Card --}}
            <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
                <div class="card-header bg-white" style="border-bottom:1px solid #f0f0f0;padding:20px;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-laptop me-2 text-info"></i>Device Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        @if($evaluation->brand->logo ?? false)
                            <img src="{{ asset('storage/'.$evaluation->brand->logo) }}"
                                 style="width:50px;height:50px;object-fit:contain;">
                        @else
                            <div style="width:50px;height:50px;background:#e3f2fd;border-radius:10px;
                                        display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-laptop text-primary" style="font-size:24px;"></i>
                            </div>
                        @endif
                        <div>
                            <div class="fw-bold fs-5">{{ $evaluation->brand->name ?? '—' }}</div>
                            <div class="text-muted">{{ $evaluation->model->name ?? '—' }}</div>
                        </div>
                    </div>

                    @if($evaluation->variant)
                    <div class="mb-3 p-3" style="background:#f8f9fa;border-radius:10px;">
                        <div class="row g-2 text-center">
                            <div class="col-4">
                                <div class="text-muted" style="font-size:11px;">RAM</div>
                                <div class="fw-bold">{{ $evaluation->variant->ram }}</div>
                            </div>
                            <div class="col-4">
                                <div class="text-muted" style="font-size:11px;">Storage</div>
                                <div class="fw-bold">{{ $evaluation->variant->storage }}</div>
                            </div>
                            <div class="col-4">
                                <div class="text-muted" style="font-size:11px;">Price</div>
                                <div class="fw-bold text-success">₹{{ number_format($evaluation->variant->price, 0) }}</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div>
                        <label class="text-muted" style="font-size:12px;">Power Status</label>
                        <div class="fw-bold">
                            @if(($evaluation->answers['power_on'] ?? '') === 'yes')
                                <span class="text-success"><i class="fas fa-power-off me-1"></i>Switches On</span>
                            @else
                                <span class="text-danger"><i class="fas fa-power-off me-1"></i>Does Not Switch On</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pickup Address Card --}}
            <div class="card shadow-sm border-0" style="border-radius:14px;">
                <div class="card-header bg-white" style="border-bottom:1px solid #f0f0f0;padding:20px;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>Pickup Address
                    </h5>
                </div>
                <div class="card-body p-4">

                    @if($evaluation->flat_no)
                    <div class="mb-2">
                        <label class="text-muted" style="font-size:12px;">Flat / House No.</label>
                        <div class="fw-bold">{{ $evaluation->flat_no }}</div>
                    </div>
                    @endif

                    @if($evaluation->locality)
                    <div class="mb-2">
                        <label class="text-muted" style="font-size:12px;">Locality</label>
                        <div class="fw-bold">{{ $evaluation->locality }}</div>
                    </div>
                    @endif

                    @if($evaluation->landmark)
                    <div class="mb-2">
                        <label class="text-muted" style="font-size:12px;">Landmark</label>
                        <div class="fw-bold">{{ $evaluation->landmark }}</div>
                    </div>
                    @endif

                    <div class="row g-2 mb-2">
                        @if($evaluation->city)
                        <div class="col-7">
                            <label class="text-muted" style="font-size:12px;">City</label>
                            <div class="fw-bold">{{ $evaluation->city }}</div>
                        </div>
                        @endif
                        @if($evaluation->pincode)
                        <div class="col-5">
                            <label class="text-muted" style="font-size:12px;">Pincode</label>
                            <div class="fw-bold">{{ $evaluation->pincode }}</div>
                        </div>
                        @endif
                    </div>

                    @if($evaluation->address_type)
                    <div class="mb-3">
                        <label class="text-muted" style="font-size:12px;">Address Type</label>
                        <div>
                            <span class="badge-pill-custom" style="background:#f3e5f5;color:#6a1b9a;">
                                <i class="fas fa-home me-1"></i>{{ ucfirst($evaluation->address_type) }}
                            </span>
                        </div>
                    </div>
                    @endif

                    @if($evaluation->pickup_slot)
                    <div class="p-3 mt-2" style="background:#fff8e1;border-radius:10px;border-left:4px solid #ffc107;">
                        <div class="text-muted mb-1" style="font-size:12px;">
                            <i class="fas fa-clock me-1"></i>Pickup Slot
                        </div>
                        <div class="fw-bold" style="color:#e65100;">{{ $evaluation->pickup_slot }}</div>
                    </div>
                    @endif

                </div>
            </div>

        </div>

        {{-- ── RIGHT COLUMN ── --}}
        <div class="col-lg-8">

            {{-- Price Summary --}}
            <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
                <div class="card-header bg-white" style="border-bottom:1px solid #f0f0f0;padding:20px;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-rupee-sign me-2 text-success"></i>Price Breakdown
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center border-end">
                            <div class="text-muted mb-1" style="font-size:12px;">Base Price</div>
                            <div class="fw-bold fs-4">₹{{ number_format($evaluation->base_price, 0) }}</div>
                        </div>
                        <div class="col-md-4 text-center border-end">
                            <div class="text-muted mb-1" style="font-size:12px;">Deductions</div>
                            <div class="fw-bold fs-4 text-danger">-₹{{ number_format($evaluation->total_deduction, 0) }}</div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="text-muted mb-1" style="font-size:12px;">Final Price</div>
                            <div class="fw-bold fs-2 text-success">₹{{ number_format($evaluation->estimated_price, 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order & Payment Info --}}
            <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
                <div class="card-header bg-white" style="border-bottom:1px solid #f0f0f0;padding:20px;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-receipt me-2 text-primary"></i>Order & Payment Info
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="text-muted" style="font-size:12px;">Order ID</label>
                            <div class="fw-bold">#{{ $evaluation->id }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted" style="font-size:12px;">Payment Method</label>
                            <div>
                                @php
                                    $pmColors = [
                                        'upi'  => ['bg'=>'#e3f2fd','color'=>'#1565c0'],
                                        'cash' => ['bg'=>'#e8f5e9','color'=>'#2e7d32'],
                                        'bank' => ['bg'=>'#fff3e0','color'=>'#e65100'],
                                    ];
                                    $pm  = strtolower($evaluation->payment_method ?? '');
                                    $pc  = $pmColors[$pm] ?? ['bg'=>'#f5f5f5','color'=>'#666'];
                                @endphp
                                @if($evaluation->payment_method)
                                    <span class="badge-pill-custom"
                                          style="background:{{ $pc['bg'] }};color:{{ $pc['color'] }};text-transform:uppercase;">
                                        <i class="fas fa-credit-card me-1"></i>{{ $evaluation->payment_method }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted" style="font-size:12px;">Order Status</label>
                            <div>
                                @php
                                    $statusColors = [
                                        'pending'   => ['bg'=>'#fff3e0','color'=>'#e65100'],
                                        'verified'  => ['bg'=>'#e3f2fd','color'=>'#1565c0'],
                                        'completed' => ['bg'=>'#e8f5e9','color'=>'#2e7d32'],
                                        'cancelled' => ['bg'=>'#fce4e4','color'=>'#c62828'],
                                    ];
                                    $sc = $statusColors[$evaluation->status] ?? $statusColors['pending'];
                                @endphp
                                <span class="badge-pill-custom"
                                      style="background:{{ $sc['bg'] }};color:{{ $sc['color'] }};text-transform:capitalize;">
                                    {{ $evaluation->status }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted" style="font-size:12px;">Order Date</label>
                            <div class="fw-bold">{{ $evaluation->created_at->format('d M Y, h:i A') }}</div>
                        </div>
                        @if($evaluation->admin_notes)
                        <div class="col-12">
                            <label class="text-muted" style="font-size:12px;">Admin Notes</label>
                            <div class="fw-bold">{{ $evaluation->admin_notes }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- System Configuration --}}
            @php $config = $evaluation->answers; @endphp
            @if(!empty($config['processor']) || !empty($config['ram']) || !empty($config['storage']))
            <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
                <div class="card-header bg-white" style="border-bottom:1px solid #f0f0f0;padding:20px;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-microchip me-2 text-warning"></i>System Configuration
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @if(!empty($config['processor']))
                        <div class="col-md-4">
                            <div class="p-3" style="background:#f8f9fa;border-radius:10px;">
                                <div class="text-muted mb-1" style="font-size:11px;"><i class="fas fa-cpu me-1"></i>Processor</div>
                                <div class="fw-bold">{{ $config['processor'] }}</div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($config['ram']))
                        <div class="col-md-4">
                            <div class="p-3" style="background:#f8f9fa;border-radius:10px;">
                                <div class="text-muted mb-1" style="font-size:11px;"><i class="fas fa-memory me-1"></i>RAM</div>
                                <div class="fw-bold">{{ $config['ram'] }}</div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($config['storage']))
                        <div class="col-md-4">
                            <div class="p-3" style="background:#f8f9fa;border-radius:10px;">
                                <div class="text-muted mb-1" style="font-size:11px;"><i class="fas fa-hdd me-1"></i>Storage</div>
                                <div class="fw-bold">{{ $config['storage'] }}</div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($config['device_age']))
                        <div class="col-md-4">
                            <div class="p-3" style="background:#f8f9fa;border-radius:10px;">
                                <div class="text-muted mb-1" style="font-size:11px;"><i class="fas fa-calendar me-1"></i>Device Age</div>
                                <div class="fw-bold">{{ $config['device_age'] }}</div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($config['screen_condition']))
                        <div class="col-md-4">
                            <div class="p-3" style="background:#f8f9fa;border-radius:10px;">
                                <div class="text-muted mb-1" style="font-size:11px;"><i class="fas fa-desktop me-1"></i>Screen Condition</div>
                                <div class="fw-bold">{{ $config['screen_condition'] }}</div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($config['accessories']))
                        <div class="col-md-4">
                            <div class="p-3" style="background:#f8f9fa;border-radius:10px;">
                                <div class="text-muted mb-1" style="font-size:11px;"><i class="fas fa-plug me-1"></i>Accessories</div>
                                <div class="fw-bold">
                                    {{ is_array($config['accessories']) ? implode(', ', $config['accessories']) : $config['accessories'] }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Additional Features --}}
            @if(!empty($additionalFeatureDetails) && is_array($additionalFeatureDetails))
            <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
                <div class="card-header bg-white" style="border-bottom:1px solid #f0f0f0;padding:20px;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>Additional Features
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($additionalFeatureDetails as $feature)
                        <div class="col-md-6">
                            <div class="p-3" style="background:#f8f9fa;border-radius:10px;">
                                <div class="text-muted mb-1" style="font-size:11px;">
                                    <i class="fas fa-check-circle me-1 text-success"></i>
                                    {{ $feature['q'] ?? 'Feature' }}
                                </div>
                                <div class="fw-bold">{{ $feature['a'] ?? '—' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Physical Condition --}}
            @if(!empty($physicalConditionDetails))
            <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
                <div class="card-header bg-white" style="border-bottom:1px solid #f0f0f0;padding:20px;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-stethoscope me-2 text-danger"></i>Physical Condition
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:55%;">Question</th>
                                    <th>Selected Condition</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($physicalConditionDetails as $detail)
                                <tr>
                                    <td class="fw-medium">{{ $detail['question'] }}</td>
                                    <td>
                                        <span class="badge"
                                              style="background:#ffeaea;color:#c62828;padding:8px 12px;font-size:13px;">
                                            <i class="fas fa-exclamation-circle me-1"></i>
                                            {{ $detail['selected'] }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            {{-- Device Issues --}}
            @if(!empty($config['device_condition']))
            <div class="card shadow-sm border-0" style="border-radius:14px;">
                <div class="card-header bg-white" style="border-bottom:1px solid #f0f0f0;padding:20px;">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Device Issues
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="fw-bold text-danger">
                        {{ is_array($config['device_condition']) ? implode(', ', $config['device_condition']) : $config['device_condition'] }}
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

<style>
.badge-pill-custom {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
</style>

@endsection