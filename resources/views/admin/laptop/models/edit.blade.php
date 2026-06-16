{{-- resources/views/admin/laptop/models/edit.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
  <div class="page-inner">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header"><h4 class="card-title mb-0">Edit Model — {{ $laptopModel->name }}</h4></div>
          <div class="card-body">
            <form action="{{ route('laptop.brands.models.update', [$laptopBrand->id, $laptopModel->id]) }}"
                  method="POST" enctype="multipart/form-data">
              @csrf @method('PUT')
              <div class="mb-3">
                <label class="form-label fw-semibold">Model Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $laptopModel->name) }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Max Price (₹) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $laptopModel->price) }}" step="0.01" min="0">
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Laptop Image</label>
                @if($laptopModel->image)
                  <div class="mb-2">
                    <img src="{{ asset('storage/'.$laptopModel->image) }}" height="80"
                         style="border-radius:8px;border:1px solid #ddd;padding:4px;">
                    <small class="text-muted ms-2">Current image</small>
                  </div>
                @endif
                <input type="file" name="image" class="form-control" accept="image/*"
                       onchange="previewImage(event,'imgPreview')">
                <div class="mt-2">
                  <img id="imgPreview" src="#" class="d-none"
                       style="max-height:150px;border-radius:8px;border:1px solid #ddd;padding:4px;">
                </div>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Model</button>
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