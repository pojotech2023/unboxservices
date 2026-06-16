{{-- resources/views/admin/laptop-evaluations/index.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="page-inner">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4" style="margin-top: 67px;">
        <div>
            <h3 class="fw-bold mb-1">Confirmed Orders</h3>
            <nav style="font-size:13px;color:#888;">
                <a href="{{ route('admin.dashboard') }}" style="color:#888;text-decoration:none;">🏠</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <span style="color:#333;font-weight:600;">Confirmed Orders</span>
            </nav>
        </div>
        <a href="{{ route('admin.laptop-evaluations.export') }}"
           class="btn btn-success d-flex align-items-center gap-2"
           style="border-radius:8px;font-weight:700;font-size:14px;padding:9px 18px;">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="eval-stat-card" style="background: linear-gradient(135deg,#1565c0,#1e88e5);">
                <div class="eval-stat-icon"><i class="fas fa-box-open"></i></div>
                <div class="eval-stat-val">{{ $totalCount }}</div>
                <div class="eval-stat-label">Total Orders</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="eval-stat-card" style="background: linear-gradient(135deg,#2e7d32,#43a047);">
                <div class="eval-stat-icon"><i class="fas fa-rupee-sign"></i></div>
                <div class="eval-stat-val">₹{{ number_format($totalValue, 0) }}</div>
                <div class="eval-stat-label">Total Estimated Value</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="eval-stat-card" style="background: linear-gradient(135deg,#e65100,#fb8c00);">
                <div class="eval-stat-icon"><i class="fas fa-calendar-day"></i></div>
                <div class="eval-stat-val">{{ $todayCount }}</div>
                <div class="eval-stat-label">Today's Orders</div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="eval-stat-card" style="background: linear-gradient(135deg,#6a1b9a,#9c27b0);">
                <div class="eval-stat-icon"><i class="fas fa-chart-line"></i></div>
                <div class="eval-stat-val">₹{{ number_format($avgPrice, 0) }}</div>
                <div class="eval-stat-label">Avg. Quote Price</div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="card shadow-sm border-0" style="border-radius:14px;overflow:hidden;">
        <div class="card-body p-4">

            {{-- Filters Bar --}}
            <form method="GET" action="{{ route('admin.laptop-evaluations.index') }}"
                  class="d-flex align-items-center gap-3 flex-wrap mb-4">

                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search name / mobile..."
                       class="form-control"
                       style="width:220px;border-radius:8px;font-size:14px;border:1.5px solid #e0e0e0;">

                <select name="brand_id" class="form-select"
                        style="width:160px;border-radius:8px;font-size:14px;border:1.5px solid #e0e0e0;">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="form-select"
                        style="width:140px;border-radius:8px;font-size:14px;border:1.5px solid #e0e0e0;">
                    <option value="">All Status</option>
                    <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="verified"  {{ request('status') == 'verified'  ? 'selected' : '' }}>Verified</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>

                <select name="payment_method" class="form-select"
                        style="width:150px;border-radius:8px;font-size:14px;border:1.5px solid #e0e0e0;">
                    <option value="">All Payments</option>
                    <option value="upi"  {{ request('payment_method') == 'upi'  ? 'selected' : '' }}>UPI</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                </select>

                <input type="date" name="date" value="{{ request('date') }}"
                       class="form-control"
                       style="width:160px;border-radius:8px;font-size:14px;border:1.5px solid #e0e0e0;">

                <button type="submit" class="btn btn-primary"
                        style="border-radius:8px;font-size:14px;padding:8px 20px;font-weight:600;">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.laptop-evaluations.index') }}"
                   class="btn btn-outline-secondary"
                   style="border-radius:8px;font-size:14px;padding:8px 16px;">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
            </form>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table eval-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Device</th>
                            <th>Pickup Slot</th>
                           
                            <!-- <th>Payment</th> -->
                            <th>Est. Price</th>
                            
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluations as $i => $eval)
                        <tr>
                            {{-- # --}}
                            <td style="color:#aaa;font-size:13px;">
                                {{ $evaluations->firstItem() + $i }}
                            </td>

                            {{-- Customer --}}
                            <td>
                                <div style="font-weight:700;font-size:14px;color:#1a1a1a;">
                                    {{ $eval->customer_name }}
                                </div>
                                <div style="font-size:12px;color:#888;">
                                    <i class="fas fa-phone fa-xs me-1"></i>{{ $eval->customer_mobile }}
                                </div>
                                @if($eval->otp_verified)
                                    <span class="badge-pill-custom mt-1"
                                          style="background:#e8f5e9;color:#2e7d32;font-size:10px;">
                                        <i class="fas fa-shield-alt fa-xs me-1"></i>Verified
                                    </span>
                                @endif
                            </td>

                            {{-- Device --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($eval->brand && $eval->brand->logo)
                                        <img src="{{ asset('storage/'.$eval->brand->logo) }}"
                                             style="width:28px;height:28px;object-fit:contain;border-radius:6px;border:1px solid #eee;">
                                    @else
                                        <div style="width:28px;height:28px;background:#e3f2fd;border-radius:6px;
                                                    display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-laptop" style="color:#1565c0;font-size:13px;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div style="font-weight:600;font-size:13px;color:#1a1a1a;">
                                            {{ $eval->brand->name ?? '—' }}
                                        </div>
                                        <div style="font-size:12px;color:#888;">
                                            {{ $eval->model->name ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Pickup Slot --}}
                            <td>
                                @if($eval->pickup_slot)
                                    <div style="font-size:13px;color:#333;font-weight:600;">
                                        <i class="fas fa-clock me-1 text-warning"></i>
                                        {{ $eval->pickup_slot }}
                                    </div>
                                @else
                                    <span style="color:#bbb;font-size:12px;">—</span>
                                @endif
                            </td>

                            {{-- Address --}}
                            <!-- <td>
                                @php
                                    $addressParts = array_filter([
                                        $eval->locality,
                                        $eval->city,
                                        $eval->pincode,
                                    ]);
                                @endphp
                                @if(count($addressParts))
                                    <div style="font-size:12px;color:#555;line-height:1.5;">
                                        @if($eval->flat_no)
                                            <div>{{ $eval->flat_no }}</div>
                                        @endif
                                        <div>{{ implode(', ', $addressParts) }}</div>
                                        @if($eval->address_type)
                                            <span class="badge-pill-custom mt-1"
                                                  style="background:#f3e5f5;color:#6a1b9a;font-size:10px;">
                                                {{ ucfirst($eval->address_type) }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span style="color:#bbb;font-size:12px;">—</span>
                                @endif
                            </td> -->

                            <!-- {{-- Payment --}}
                            <td>
                                @php
                                    $pmColors = [
                                        'upi'  => ['bg' => '#e3f2fd', 'color' => '#1565c0'],
                                        'cash' => ['bg' => '#e8f5e9', 'color' => '#2e7d32'],
                                        'bank' => ['bg' => '#fff3e0', 'color' => '#e65100'],
                                    ];
                                    $pm = strtolower($eval->payment_method ?? '');
                                    $pc = $pmColors[$pm] ?? ['bg' => '#f5f5f5', 'color' => '#666'];
                                @endphp
                                @if($eval->payment_method)
                                    <span class="badge-pill-custom"
                                          style="background:{{ $pc['bg'] }};color:{{ $pc['color'] }};text-transform:uppercase;font-size:11px;">
                                        {{ $eval->payment_method }}
                                    </span>
                                @else
                                    <span style="color:#bbb;font-size:12px;">—</span>
                                @endif
                            </td> -->

                            {{-- Price --}}
                            <td>
                                <div style="font-weight:700;font-size:15px;color:#2e7d32;">
                                    ₹{{ number_format($eval->estimated_price, 0) }}
                                </div>
                                <div style="font-size:11px;color:#aaa;">
                                    Base: ₹{{ number_format($eval->base_price, 0) }}
                                </div>
                            </td>

                            {{-- Status --}}
                            <!-- <td>
                                @php
                                    $statusColors = [
                                        'pending'   => ['bg' => '#fff3e0', 'color' => '#e65100'],
                                        'verified'  => ['bg' => '#e3f2fd', 'color' => '#1565c0'],
                                        'completed' => ['bg' => '#e8f5e9', 'color' => '#2e7d32'],
                                        'cancelled' => ['bg' => '#fce4e4', 'color' => '#c62828'],
                                    ];
                                    $sc = $statusColors[$eval->status] ?? $statusColors['pending'];
                                @endphp
                                <span class="badge-pill-custom"
                                      style="background:{{ $sc['bg'] }};color:{{ $sc['color'] }};text-transform:capitalize;">
                                    {{ $eval->status }}
                                </span>
                            </td> -->

                            {{-- Date --}}
                            <td>
                                <div style="font-size:13px;color:#444;">
                                    {{ $eval->created_at->format('d M Y') }}
                                </div>
                                <div style="font-size:11px;color:#aaa;">
                                    {{ $eval->created_at->format('h:i A') }}
                                </div>
                            </td>

                            {{-- Action (view only) --}}
                            <td>
                                <a href="{{ route('admin.laptop-evaluations.show', $eval->id) }}"
                                   class="bca-btn bca-view" title="View Order">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">
                                <div style="text-align:center;padding:50px 20px;color:#aaa;">
                                    <div style="font-size:48px;margin-bottom:12px;">📦</div>
                                    <p style="font-size:15px;">No confirmed orders found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($evaluations->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $evaluations->appends(request()->query())->links() }}
            </div>
            @endif

        </div>
    </div>
</div>

<style>
.eval-stat-card {
    border-radius: 14px;
    padding: 20px 20px 16px;
    color: #fff;
    position: relative;
    overflow: hidden;
    min-height: 100px;
}
.eval-stat-icon {
    font-size: 26px;
    opacity: .25;
    position: absolute;
    right: 18px;
    top: 18px;
}
.eval-stat-val   { font-size: 24px; font-weight: 800; letter-spacing: -.5px; }
.eval-stat-label { font-size: 12px; opacity: .85; margin-top: 2px; }

.eval-table thead th {
    background: #f7f8fa;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #888;
    border-bottom: 2px solid #f0f0f0;
    padding: 12px 14px;
}
.eval-table tbody td {
    padding: 14px 14px;
    border-bottom: 1px solid #f5f5f5;
    vertical-align: middle;
}
.eval-table tbody tr:hover { background: #fafbff; }
.eval-table tbody tr:last-child td { border-bottom: none; }

.badge-pill-custom {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.bca-btn {
    width: 34px; height: 34px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    border: none; cursor: pointer;
    text-decoration: none;
    transition: transform .15s ease;
}
.bca-btn:hover  { transform: scale(1.15); }
.bca-view { background: #e3f2fd; color: #1565c0; }
</style>

@endsection