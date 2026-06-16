@extends('layouts.app')

@section('title', 'Variants')

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

        {{-- Model Card --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                @if($model->image)
                    <img src="{{ asset('storage/'.$model->image) }}" width="80" height="80"
                         style="object-fit:cover; border-radius:8px;">
                @endif
                <div>
                    <h5 class="mb-0 fw-bold">{{ $model->name }}</h5>
                    <small class="text-muted">Brand: {{ $brand->name }}</small>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Variants Table --}}
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">Variants</span>
                <a href="{{ route('brands.models.variants.create', [$brand->id, $model->id]) }}"
                   class="btn btn-primary btn-sm">
                    + Add Variant
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>S.NO</th>
                                <th>Memory</th>
                                <th>Price (₹)</th>
                                <!-- <th>Questions</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($variants as $i => $v)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <span class="badge bg-dark px-3 py-2">{{ $v->memory }}</span>
                                </td>
                                <td>₹{{ number_format($v->price, 2) }}</td>

                                {{-- Questions & Defects button --}}
                                <!-- <td>
                                    <a href="{{ route('brands.models.variants.questions.index', [$brand->id, $model->id, $v->id]) }}"
                                       class="btn btn-info btn-sm text-white">
                                        <i class="fas fa-question-circle me-1"></i>Questions
                                        @if($v->questions_count > 0)
                                            <span class="badge bg-white text-dark ms-1">
                                                {{ $v->questions_count }}
                                            </span>
                                        @endif
                                    </a>
                                </td> -->

                                <td>
                                    <a href="{{ route('brands.models.variants.edit', [$brand->id, $model->id, $v->id]) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('brands.models.variants.destroy', [$brand->id, $model->id, $v->id]) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this variant?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    No variants found.
                                    <a href="{{ route('brands.models.variants.create', [$brand->id, $model->id]) }}">
                                        Add one!
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection