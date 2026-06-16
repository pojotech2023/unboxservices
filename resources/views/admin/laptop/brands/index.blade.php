{{-- resources/views/admin/laptop/brands/index.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="page-inner">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4" style="margin-top: 67px;">
        <div>
            <h3 class="fw-bold mb-1">Laptop Brands</h3>
            <nav style="font-size:13px;color:#888;">
                <a href="{{ route('admin.dashboard') }}" style="color:#888;text-decoration:none;">🏠</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <span style="color:#333;font-weight:600;">Laptop Brands</span>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card --}}
    <div class="card shadow-sm border-0" style="border-radius:14px;overflow:hidden;">
        <div class="card-body p-4">

            {{-- Card top bar --}}
            <div class="d-flex align-items-center justify-content-between mb-4 gap-3 flex-wrap">
                <div class="d-flex align-items-center gap-2">
                    <div style="width:38px;height:38px;background:#1a2942;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-laptop" style="color:#fff;font-size:16px;"></i>
                    </div>
                    <span style="font-size:17px;font-weight:700;color:#1a1a1a;">Laptop Brands</span>
                </div>
                <div class="d-flex gap-2 align-items-center flex-wrap">
                    <input type="text" id="brandSearch" placeholder="Search Brand..."
                        class="form-control"
                        style="width:220px;border-radius:8px;font-size:14px;border:1.5px solid #e0e0e0;">
                    <a href="{{ route('laptop.brands.create') }}"
                        class="btn btn-primary d-flex align-items-center gap-2"
                        style="border-radius:8px;font-weight:700;font-size:14px;padding:9px 18px;white-space:nowrap;">
                        <i class="fas fa-plus"></i> Add Brand
                    </a>
                </div>
            </div>

            {{-- Grid --}}
            <div class="row g-3" id="brandsGrid">
                @forelse($brands as $brand)
                <div class="col-lg-3 col-md-4 col-sm-6 brand-card-col"
                     data-name="{{ strtolower($brand->name) }}">
                    <div class="brand-card">
                        {{-- Image --}}
                        <div class="brand-card-img">
                            @if($brand->logo)
                                <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}">
                            @else
                                <div class="brand-card-placeholder">
                                    <i class="fas fa-laptop"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Name --}}
                        <div class="brand-card-name">{{ $brand->name }}</div>
                        <div class="brand-card-sub">
                            <a href="{{ route('laptop.brands.models.index', $brand->id) }}"
                               style="color:#1565c0;text-decoration:none;font-weight:600;">
                                {{ $brand->models_count }} Models
                            </a>
                        </div>

                        {{-- Actions --}}
                        <div class="brand-card-actions">
                            <a href="{{ route('laptop.brands.models.index', $brand->id) }}"
                               class="bca-btn bca-view" title="View Models">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('laptop.brands.edit', $brand->id) }}"
                               class="bca-btn bca-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('laptop.brands.destroy', $brand->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete {{ $brand->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bca-btn bca-del" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div style="text-align:center;padding:50px 20px;color:#aaa;">
                        <div style="font-size:48px;margin-bottom:12px;">💻</div>
                        <p style="font-size:15px;">No brands added yet.</p>
                        <a href="{{ route('laptop.brands.create') }}" class="btn btn-primary btn-sm">Add First Brand</a>
                    </div>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

{{-- Search JS --}}
<script>
document.getElementById('brandSearch').addEventListener('input', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('.brand-card-col').forEach(col => {
        col.style.display = col.dataset.name.includes(q) ? '' : 'none';
    });
});
</script>

<style>
.brand-card {
    background: #fff;
    border: 1.5px solid #e8e8e8;
    border-radius: 14px;
    padding: 20px 16px 16px;
    text-align: center;
    transition: all .2s ease;
    cursor: default;
    height: 100%;
}
.brand-card:hover {
    border-color: #1565c0;
    box-shadow: 0 4px 18px rgba(21,101,192,.10);
    transform: translateY(-2px);
}
.brand-card-img {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
}
.brand-card-img img {
    max-height: 90px;
    max-width: 100%;
    object-fit: contain;
}
.brand-card-placeholder {
    width: 70px; height: 70px;
    background: #f0f4ff;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 28px; color: #aaa;
}
.brand-card-name {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.brand-card-sub {
    font-size: 12px;
    color: #888;
    margin-bottom: 14px;
}
.brand-card-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
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
.bca-btn:hover { transform: scale(1.15); }
.bca-view { background: #e3f2fd; color: #1565c0; }
.bca-edit { background: #fff8e1; color: #f57c00; }
.bca-del  { background: #fce4e4; color: #c62828; }
</style>

@endsection