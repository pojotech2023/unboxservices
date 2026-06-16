{{-- resources/views/admin/laptop/variants/index.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container">
  <div class="page-inner">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h3 class="fw-bold mb-0">{{ $laptopModel->name }} — Variants</h3>
        <small class="text-muted">{{ $laptopBrand->name }}</small>
      </div>
      <a href="{{ route('laptop.models.variants.create', [$laptopBrand->id, $laptopModel->id]) }}"
         class="btn btn-primary btn-sm">
        <i class="fas fa-plus me-1"></i> Add Variant
      </a>
    </div>
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow-sm">
      <div class="card-body p-0">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr><th>#</th><th>Storage</th><th>RAM</th><th>Price</th><th>Actions</th></tr>
          </thead>
          <tbody>
            @forelse($variants as $v)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $v->storage }}</td>
              <td>{{ $v->ram }}</td>
              <td class="text-success fw-bold">₹{{ number_format($v->price, 2) }}</td>
              <td>
                <a href="{{ route('laptop.models.variants.edit', [$laptopBrand->id, $laptopModel->id, $v->id]) }}"
                   class="btn btn-sm btn-warning me-1"><i class="fas fa-edit"></i></a>
                <form action="{{ route('laptop.models.variants.destroy', [$laptopBrand->id, $laptopModel->id, $v->id]) }}"
                      method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">No variants added yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection