@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Add Model</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="{{ route('brands.index') }}">Mobile Brand</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="{{ route('brands.models', $brand->id) }}">{{ $brand->name }}</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Add Model</a></li>
            </ul>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Add Model — {{ $brand->name }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('brands.models.store', $brand->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Model Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="e.g. iPhone 15 Pro, Galaxy S24">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone Image</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                       accept="image/*" onchange="previewImage(event, 'imgPreview')">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="mt-2">
                                    <img id="imgPreview" src="#" alt="Preview" class="d-none"
                                         style="max-height:150px; border-radius:8px; border:1px solid #ddd; padding:4px;">
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Save Model
                                </button>
                                <a href="{{ route('brands.models', $brand->id) }}" class="btn btn-secondary">Cancel</a>
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
