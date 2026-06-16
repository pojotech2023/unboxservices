@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Edit Brand</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="{{ route('brands.index') }}">Mobile Brand</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Edit Brand</a></li>
            </ul>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Brand: {{ $brand->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Brand Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $brand->name) }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Brand Logo</label>
                                @if($brand->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="Current Logo"
                                             style="max-height:80px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                        <small class="text-muted d-block mt-1">Current logo (upload new to replace)</small>
                                    </div>
                                @endif
                                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                       accept="image/*" onchange="previewImage(event, 'logoPreview')">
                                @error('logo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2">
                                    <img id="logoPreview" src="#" alt="Preview" class="d-none"
                                         style="max-height:100px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i> Update Brand
                                </button>
                                <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event, previewId) {
    const file = event.target.files[0];
    const preview = document.getElementById(previewId);
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
}
</script>
@endsection
