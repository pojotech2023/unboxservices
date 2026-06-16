{{-- resources/views/admin/laptop/models/create.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Add Laptop Model</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('laptop.brands.index') }}">Laptop Brands</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('laptop.brands.models.index', $laptopBrand->id) }}">{{ $laptopBrand->name }}</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Add Model</a></li>
      </ul>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header"><h4 class="card-title mb-0">Add Model — {{ $laptopBrand->name }}</h4></div>
          <div class="card-body">
            <form action="{{ route('laptop.brands.models.store', $laptopBrand->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label class="form-label fw-semibold">Model Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="e.g. Dell Inspiron 15">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Max Price (₹) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', 0) }}" step="0.01" min="0" placeholder="e.g. 35000">
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <small class="text-muted">Shown as "Get Upto ₹XX,XXX" on frontend</small>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Laptop Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                       accept="image/*" onchange="previewImage(event,'imgPreview')">
                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="mt-2">
                  <img id="imgPreview" src="#" class="d-none"
                       style="max-height:150px;border-radius:8px;border:1px solid #ddd;padding:4px;">
                </div>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Model</button>
                <a href="{{ route('laptop.brands.models.index', $laptopBrand->id) }}" class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function previewImage(e, id) {
  const f = e.target.files[0], p = document.getElementById(id);
  if (f) { p.src = URL.createObjectURL(f); p.classList.remove('d-none'); }
}
</script>
@endsection