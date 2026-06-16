{{-- resources/views/admin/laptop/brands/create.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Add Laptop Brand</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('laptop.brands.index') }}">Laptop Brands</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Add Brand</a></li>
      </ul>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header"><h4 class="card-title mb-0">Add New Laptop Brand</h4></div>
          <div class="card-body">
            <form action="{{ route('laptop.brands.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label class="form-label fw-semibold">Brand Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="e.g. Dell, HP, Lenovo">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Brand Logo</label>
                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                       accept="image/*" onchange="previewImage(event,'logoPreview')">
                @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="mt-2">
                  <img id="logoPreview" src="#" class="d-none"
                       style="max-height:100px;border-radius:8px;border:1px solid #ddd;padding:4px;">
                </div>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Brand</button>
                <a href="{{ route('laptop.brands.index') }}" class="btn btn-secondary">Cancel</a>
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