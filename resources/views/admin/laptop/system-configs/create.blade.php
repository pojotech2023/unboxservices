{{-- resources/views/admin/laptop/system-configs/create.blade.php --}}
{{-- (Edit view is nearly identical — just change form action & fill values) --}}
@extends('layouts.app')
@section('content')

<div class="page-inner">

    <div class="d-flex align-items-center justify-content-between mb-4" style="margin-top:67px;">
        <div>
            <h3 class="fw-bold mb-1">Add System Config</h3>
            <nav style="font-size:13px;color:#888;">
                <a href="{{ route('laptop.models.system-configs.index', [$brand->id, $model->id]) }}"
                   style="color:#888;text-decoration:none;">← Back to Configs</a>
            </nav>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="max-width:560px;border-radius:14px;overflow:hidden;">
        <div class="card-body p-4">

            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
                </div>
            @endif

            <form action="{{ route('laptop.models.system-configs.store', [$brand->id, $model->id]) }}" method="POST">
                @csrf

                {{-- Config Type --}}
                <div class="mb-4">
                    <label class="form-label fw-700" style="font-weight:700;">Config Type <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        @foreach($types as $type)
                        <label class="sc-type-pill {{ old('config_type', request('type')) === $type ? 'active' : '' }}">
                            <input type="radio" name="config_type" value="{{ $type }}"
                                   {{ old('config_type', request('type')) === $type ? 'checked' : '' }}>
                            <span class="sc-pill-icon">
                                @if($type === 'processor') 🔲
                                @elseif($type === 'ram') 💾
                                @else 💿 @endif
                            </span>
                            <span>{{ ucfirst($type) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Value --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Value <span class="text-danger">*</span></label>
                    <input type="text"
                           name="value"
                           class="form-control @error('value') is-invalid @enderror"
                           value="{{ old('value') }}"
                           placeholder="e.g. Intel Core i5, 8GB DDR4, 512GB SSD"
                           style="border-radius:8px;border:1.5px solid #e0e0e0;padding:11px 14px;">
                    @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div style="font-size:12px;color:#aaa;margin-top:5px;">
                        Processor: "Intel Core i5 11th Gen" | RAM: "8GB DDR4" | Storage: "512GB SSD"
                    </div>
                </div>

                {{-- Sort Order --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Sort Order</label>
                    <input type="number"
                           name="sort_order"
                           class="form-control"
                           value="{{ old('sort_order', 0) }}"
                           min="0"
                           style="border-radius:8px;border:1.5px solid #e0e0e0;padding:11px 14px;width:120px;">
                    <div style="font-size:12px;color:#aaa;margin-top:5px;">Lower number = shown first in dropdown</div>
                </div>

                {{-- Active --}}
                <div class="mb-4 d-flex align-items-center gap-3">
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox"
                               name="is_active" value="1" id="isActive"
                               {{ old('is_active', '1') ? 'checked' : '' }}
                               style="width:44px;height:22px;cursor:pointer;">
                        <label class="form-check-label fw-bold ms-2" for="isActive" style="font-size:14px;">
                            Active (show in frontend dropdown)
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary"
                            style="border-radius:8px;font-weight:700;padding:11px 28px;">
                        <i class="fas fa-save me-2"></i>Save Config
                    </button>
                    <a href="{{ route('laptop.models.system-configs.index', [$brand->id, $model->id]) }}"
                       class="btn btn-outline-secondary"
                       style="border-radius:8px;font-weight:600;padding:11px 22px;">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.sc-type-pill {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 14px 22px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 700;
    color: #555;
    transition: all .15s;
    user-select: none;
}
.sc-type-pill input { display: none; }
.sc-type-pill:hover { border-color: #1565c0; color: #1565c0; background: #e3f2fd; }
.sc-type-pill.active { border-color: #1565c0; background: #e3f2fd; color: #1565c0; }
.sc-pill-icon { font-size: 24px; }
</style>

<script>
document.querySelectorAll('.sc-type-pill').forEach(pill => {
    pill.addEventListener('click', function () {
        document.querySelectorAll('.sc-type-pill').forEach(p => p.classList.remove('active'));
        this.classList.add('active');
        this.querySelector('input[type=radio]').checked = true;
    });
});
</script>

@endsection