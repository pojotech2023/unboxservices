{{-- resources/views/admin/mobile/variants/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Variant')

@section('content')
<div class="container-fluid py-4">

    <div class="page-inner">
        <div class="page-header" style="margin-top:40px">
            <h3 class="fw-bold mb-3">{{ $model->name }} Variants</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('brands.index') }}">Mobile Brand</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('brands.models', $brand->id) }}">{{ $brand->name }} Models</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="#">{{ $model->name }} Variants</a>
                </li>
            </ul>
        </div>


    <div class="card shadow-sm" style="max-width:500px;">
        <div class="card-header bg-dark text-white">
            <span class="fw-bold">Edit Variant - {{ $variant->memory }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('brands.models.variants.update', [$brand->id, $model->id, $variant->id]) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-bold">Memory</label>
                    <input type="text"
                           name="memory"
                           class="form-control @error('memory') is-invalid @enderror"
                           value="{{ old('memory', $variant->memory) }}"
                           required>
                    @error('memory')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Price (₹)</label>
                    <div class="input-group">
                        <span class="input-group-text">₹</span>
                        <input type="number"
                               name="price"
                               class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $variant->price) }}"
                               min="0" step="0.01" required>
                    </div>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- <div class="mb-3">
                    <label class="form-label fw-bold">Stock</label>
                    <input type="number"
                           name="stock"
                           class="form-control @error('stock') is-invalid @enderror"
                           value="{{ old('stock', $variant->stock) }}"
                           min="0" required>
                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> -->

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('brands.models.variants', [$brand->id, $model->id]) }}"
                       class="btn btn-secondary px-4">Cancel</a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection