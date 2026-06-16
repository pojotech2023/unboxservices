{{-- resources/views/admin/laptop/brands/edit.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Edit Laptop Brand</h3>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header"><h4 class="card-title mb-0">Edit — {{ $laptopBrand->name }}</h4></div>
          <div class="card-body">
            <form action="{{ route('laptop.brands.update', $laptopBrand->id) }}" method="POST" enctype="multipart/form-data">
              @csrf @method('PUT')
              <div class="mb-3">
                <label class="form-label fw-semibold">Brand Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $laptopBrand->name) }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Brand Logo</label>
                @if($laptopBrand->logo)
                  <div class="mb-2">
                    <img src="{{ asset('storage/'.$laptopBrand->logo) }}" height="60"
                         style="border-radius:8px;border:1px solid #ddd;padding:4px;">
                    <small class="text-muted ms-2">Current logo</small>
                  </div>
                @endif
                <input type="file" name="logo" class="form-control" accept="image/*"
                       onchange="previewImage(event,'logoPreview')">
                <div class="mt-2">
                  <img id="logoPreview" src="#" class="d-none"
                       style="max-height:80px;border-radius:8px;border:1px solid #ddd;padding:4px;">
                </div>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Brand</button>
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