{{-- resources/views/admin/laptop/system-configs/index.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="page-inner">

    <div class="d-flex align-items-center justify-content-between mb-4" style="margin-top:67px;">
        <div>
            <h3 class="fw-bold mb-1">System Configurations</h3>
            <nav style="font-size:13px;color:#888;">
                <a href="{{ route('admin.dashboard') }}" style="color:#888;text-decoration:none;">🏠</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <a href="{{ route('laptop.brands.index') }}" style="color:#888;text-decoration:none;">Brands</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <a href="{{ route('laptop.brands.models.index', $brand->id) }}" style="color:#888;text-decoration:none;">{{ $brand->name }}</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <span style="color:#333;font-weight:600;">{{ $model->name }} — Configs</span>
            </nav>
        </div>
        <a href="{{ route('laptop.models.system-configs.create', [$brand->id, $model->id]) }}"
           class="btn btn-primary d-flex align-items-center gap-2"
           style="border-radius:8px;font-weight:700;font-size:14px;padding:10px 20px;">
            <i class="fas fa-plus"></i> Add Config
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        @foreach(['processor' => ['🔲','#e3f2fd','#1565c0'], 'ram' => ['💾','#e8f5e9','#2e7d32'], 'storage' => ['💿','#fff8e1','#f57c00']] as $type => $meta)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius:12px;">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div style="width:48px;height:48px;background:{{ $meta[1] }};border-radius:10px;
                                display:flex;align-items:center;justify-content:center;font-size:22px;">
                        {{ $meta[0] }}
                    </div>
                    <div>
                        <div style="font-size:22px;font-weight:800;color:{{ $meta[2] }};">
                            {{ isset($configs[$type]) ? $configs[$type]->count() : 0 }}
                        </div>
                        <div style="font-size:13px;color:#888;text-transform:capitalize;">{{ $type }} options</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Config Tables --}}
    @foreach(['processor' => ['🔲 Processor', '#1565c0', '#e3f2fd'],
              'ram'       => ['💾 RAM',       '#2e7d32', '#e8f5e9'],
              'storage'   => ['💿 Storage',   '#f57c00', '#fff8e1']] as $type => $meta)

    <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;overflow:hidden;">
        <div class="card-header d-flex align-items-center justify-content-between py-3 px-4"
             style="background:{{ $meta[2] }};border-bottom:1.5px solid #e8e8e8;">
            <span style="font-size:15px;font-weight:700;color:{{ $meta[1] }};">{{ $meta[0] }}</span>
            <a href="{{ route('laptop.models.system-configs.create', [$brand->id, $model->id]) }}?type={{ $type }}"
               class="btn btn-sm"
               style="background:{{ $meta[1] }};color:#fff;border-radius:7px;font-size:13px;font-weight:700;">
                + Add {{ ucfirst($type) }}
            </a>
        </div>
        <div class="card-body p-0">
            @if(isset($configs[$type]) && $configs[$type]->count())
            <table class="table table-hover mb-0" style="font-size:14px;">
                <thead style="background:#fafafa;">
                    <tr>
                        <th class="ps-4" style="width:60px;">#</th>
                        <th>Value</th>
                        <th style="width:120px;">Sort Order</th>
                        <th style="width:100px;">Status</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($configs[$type] as $i => $cfg)
                    <tr>
                        <td class="ps-4 text-muted">{{ $i+1 }}</td>
                        <td style="font-weight:600;color:#1a1a1a;">{{ $cfg->value }}</td>
                        <td>
                            <span style="background:#f0f0f0;padding:3px 10px;border-radius:20px;font-size:12px;color:#666;">
                                {{ $cfg->sort_order }}
                            </span>
                        </td>
                        <td>
                            <span class="sc-toggle"
                                  data-id="{{ $cfg->id }}"
                                  data-url="{{ route('laptop.models.system-configs.toggle', [$brand->id, $model->id, $cfg->id]) }}"
                                  style="cursor:pointer;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;
                                         background:{{ $cfg->is_active ? '#e8f5e9' : '#fce4e4' }};
                                         color:{{ $cfg->is_active ? '#2e7d32' : '#c62828' }};">
                                {{ $cfg->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('laptop.models.system-configs.edit', [$brand->id, $model->id, $cfg->id]) }}"
                                   class="bca-btn bca-edit" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('laptop.models.system-configs.destroy', [$brand->id, $model->id, $cfg->id]) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this config?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bca-btn bca-del" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div style="text-align:center;padding:30px;color:#ccc;font-size:14px;">
                No {{ $type }} options added yet.
            </div>
            @endif
        </div>
    </div>
    @endforeach

</div>

<script>
// Toggle active via AJAX
document.querySelectorAll('.sc-toggle').forEach(el => {
    el.addEventListener('click', function () {
        fetch(this.dataset.url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.is_active) {
                this.textContent = 'Active';
                this.style.background = '#e8f5e9';
                this.style.color = '#2e7d32';
            } else {
                this.textContent = 'Inactive';
                this.style.background = '#fce4e4';
                this.style.color = '#c62828';
            }
        });
    });
});
</script>

<style>
.bca-btn {
    width:34px;height:34px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    font-size:13px;border:none;cursor:pointer;text-decoration:none;
    transition:transform .15s ease;
}
.bca-btn:hover{transform:scale(1.15);}
.bca-edit{background:#fff8e1;color:#f57c00;}
.bca-del {background:#fce4e4;color:#c62828;}
</style>

@endsection