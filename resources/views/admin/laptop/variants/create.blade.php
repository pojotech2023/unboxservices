{{-- resources/views/admin/laptop/variants/create.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
  <div class="page-inner">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header">
            <h4 class="card-title mb-0">Add Variant — {{ $laptopModel->name }}</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('laptop.models.variants.store', [$laptopBrand->id, $laptopModel->id]) }}"
                  method="POST">
              @csrf
              <div class="mb-3">
                <label class="form-label fw-semibold">Storage <span class="text-danger">*</span></label>
                <input type="text" name="storage" class="form-control @error('storage') is-invalid @enderror"
                       value="{{ old('storage') }}" placeholder="e.g. 512GB SSD">
                @error('storage') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">RAM <span class="text-danger">*</span></label>
                <input type="text" name="ram" class="form-control @error('ram') is-invalid @enderror"
                       value="{{ old('ram') }}" placeholder="e.g. 16GB">
                @error('ram') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Price (₹) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', 0) }}" step="0.01" min="0">
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Variant</button>
                <a href="{{ route('laptop.models.variants', [$laptopBrand->id, $laptopModel->id]) }}"
                   class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection