@extends('layouts.app')
<style>
    .brand-custom-card {
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.brand-custom-card:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    transform: translateY(-5px);
}

.brand-logo-wrapper {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.brand-logo {
    max-height: 75px;
    max-width: 100%;
    object-fit: contain;
}

.brand-placeholder {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: #f1f3f5;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: bold;
    color: #6c757d;
}

.action-icon {
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
}

.action-icon:hover {
    transform: scale(1.2);
}
</style>
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Mobile Brand</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
               
                <li class="nav-item"><a href="#">Brand</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Mobile Brands</h4>
                        <div class="d-flex gap-2">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search Brand..." style="width: 200px;">
                            <a href="{{ route('brands.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Brand
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        @if($brands->isEmpty())
                            <p class="text-center mt-3">No brands found.</p>
                        @else
                            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3" id="brandsGrid">
                                @foreach($brands as $brand)
                                <div class="col brand-card">
    <div class="card brand-custom-card h-100 text-center border-0">
        <div class="card-body p-3">

            <div class="brand-logo-wrapper mb-2">
                @if($brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}"
                         alt="{{ $brand->name }}"
                         class="brand-logo">
                @else
                    <div class="brand-placeholder">
                        {{ strtoupper(substr($brand->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <h6 class="fw-bold mb-2 brand-name">{{ $brand->name }}</h6>

            <!-- Action Icons -->
            <div class="d-flex justify-content-center gap-3 mt-2">

                <a href="{{ route('brands.models', $brand->id) }}"
                   class="action-icon text-info">
                    <i class="fas fa-eye"></i>
                </a>

                <a href="{{ route('brands.edit', $brand->id) }}"
                   class="action-icon text-warning">
                    <i class="fas fa-edit"></i>
                </a>

                <form action="{{ route('brands.destroy', $brand->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this brand?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-icon text-danger border-0 bg-transparent">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.brand-card').forEach(card => {
        const name = card.querySelector('.brand-name').textContent.toLowerCase();
        card.style.display = name.includes(q) ? '' : 'none';
    });
});
</script>
@endsection
