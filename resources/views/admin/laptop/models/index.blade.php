{{-- resources/views/admin/laptop/models/index.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="page-inner">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4" style="margin-top: 67px;">
        <div>
            <h3 class="fw-bold mb-1">Laptop Models</h3>
            <nav style="font-size:13px;color:#888;">
                <a href="{{ route('admin.dashboard') }}" style="color:#888;text-decoration:none;">🏠</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <a href="{{ route('laptop.brands.index') }}" style="color:#888;text-decoration:none;">Laptop Brands</a>
                <span style="margin:0 6px;color:#ccc;">›</span>
                <span style="color:#333;font-weight:600;">{{ $laptopBrand->name }} Models</span>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card --}}
    <div class="card shadow-sm border-0" style="border-radius:14px;overflow:hidden;">
        <div class="card-body p-4">

            {{-- Card top bar --}}
            <div class="d-flex align-items-center justify-content-between mb-4 gap-3 flex-wrap">
                <div class="d-flex align-items-center gap-3">
                    @if($laptopBrand->logo)
                    <div style="width:44px;height:44px;border:1.5px solid #e8e8e8;border-radius:10px;
                                display:flex;align-items:center;justify-content:center;background:#f8f8f8;overflow:hidden;">
                        <img src="{{ asset('storage/'.$laptopBrand->logo) }}"
                             style="max-width:36px;max-height:36px;object-fit:contain;">
                    </div>
                    @else
                    <div style="width:44px;height:44px;background:#1a2942;border-radius:10px;
                                display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-laptop" style="color:#fff;font-size:18px;"></i>
                    </div>
                    @endif
                    <span style="font-size:17px;font-weight:700;color:#1a1a1a;">
                        {{ $laptopBrand->name }} — Models
                    </span>
                </div>
                <div class="d-flex gap-2 align-items-center flex-wrap">
                    <input type="text" id="modelSearch" placeholder="Search Model..."
                        class="form-control"
                        style="width:220px;border-radius:8px;font-size:14px;border:1.5px solid #e0e0e0;">
                    <a href="{{ route('laptop.brands.models.create', $laptopBrand->id) }}"
                        class="btn btn-primary d-flex align-items-center gap-2"
                        style="border-radius:8px;font-weight:700;font-size:14px;padding:9px 18px;white-space:nowrap;">
                        <i class="fas fa-plus"></i> Add Model
                    </a>
                </div>
            </div>

            {{-- Grid --}}
            <div class="row g-3" id="modelsGrid">
                @forelse($models as $model)
                <div class="col-lg-3 col-md-4 col-sm-6 model-card-col"
                     data-name="{{ strtolower($model->name) }}">
                    <div class="model-card">

                        {{-- Image --}}
                        <div class="model-card-img">
                            @if($model->image)
                                <img src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
                            @else
                                <div class="model-card-placeholder">💻</div>
                            @endif
                        </div>

                        {{-- Name & Brand --}}
                        <div class="model-card-name">{{ $model->name }}</div>
                        <div class="model-card-brand">{{ $laptopBrand->name }}</div>

                        {{-- Price & Variants --}}
                        <!-- <div class="model-card-meta">
                            <span class="model-meta-price">
                                ₹{{ number_format($model->price, 0) }}
                            </span>
                            <a href="{{ route('laptop.models.variants', [$laptopBrand->id, $model->id]) }}"
                               class="model-meta-variants">
                                {{ $model->variants()->count() }} Variants
                            </a>
                        </div> -->

                        {{-- Pricing Status Badge --}}
                        @if($model->evaluationPricing)
                            <div class="pricing-badge pricing-badge-done">
                                <i class="fas fa-check-circle me-1"></i> Evaluation Pricing Added
                            </div>
                        @else
                            <div class="pricing-badge pricing-badge-pending">
                                <i class="fas fa-exclamation-circle me-1"></i> Pricing Not Added
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="model-card-actions">
                            <!-- <a href="{{ route('laptop.models.variants', [$laptopBrand->id, $model->id]) }}"
                               class="bca-btn bca-view" title="View Variants">
                                <i class="fas fa-eye"></i>
                            </a> -->
                            <a href="{{ route('laptop.models.system-configs.index', [$laptopBrand->id, $model->id]) }}"
                               class="bca-btn bca-config" title="System Config">
                                <i class="fas fa-sliders-h"></i>
                            </a>
                            <a href="{{ route('laptop.brands.models.edit', [$laptopBrand->id, $model->id]) }}"
                               class="bca-btn bca-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>

                            {{-- Pricing Button --}}
                            @if($model->evaluationPricing)
                                <button type="button"
                                        class="bca-btn bca-price-view"
                                        title="View / Edit Pricing"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewPricingModal{{ $model->id }}">
                                    <i class="fas fa-rupee-sign"></i>
                                </button>
                            @else
                                <button type="button"
                                        class="bca-btn bca-price-add"
                                        title="Add Evaluation Pricing"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addPricingModal{{ $model->id }}">
                                    <i class="fas fa-tags"></i>
                                </button>
                            @endif

                            <form action="{{ route('laptop.brands.models.destroy', [$laptopBrand->id, $model->id]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete {{ $model->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bca-btn bca-del" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

                {{-- ===== ADD PRICING MODAL ===== --}}
                @if(!$model->evaluationPricing)
                <div class="modal fade" id="addPricingModal{{ $model->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius:14px;overflow:hidden;">
                            <form method="POST"
                                  action="{{ route('laptop.brands.models.evaluation-pricing.store', [$laptopBrand->id, $model->id]) }}">
                                @csrf

                                {{-- Header --}}
                                <div class="lp-modal-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold" style="font-size:15px;">
                                            <i class="fas fa-tags me-2"></i> Add Evaluation Pricing
                                        </div>
                                        <div style="font-size:12px;opacity:0.82;margin-top:2px;">
                                            {{ $model->name }} &mdash; {{ $laptopBrand->name }}
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            style="filter:brightness(0) invert(1);opacity:.8;"></button>
                                </div>

                                {{-- Body --}}
                                <div class="modal-body p-4" style="background:#f8f9fd;">
                                    <div class="row g-3">

                                        {{-- Full Positive --}}
                                        <div class="col-md-6">
                                            <div class="lp-tier-card lp-tier-positive h-100">
                                                <div class="lp-tier-icon"><i class="fas fa-thumbs-up"></i></div>
                                                <label class="lp-tier-label">Full Positive Price</label>
                                                <div class="lp-tier-sub">All answers are positive</div>
                                                <div class="lp-price-wrap mb-2">
                                                    <span class="lp-rupee">₹</span>
                                                    <input type="number" name="full_positive_price"
                                                           min="0" step="0.01" class="form-control"
                                                           placeholder="0.00" required>
                                                </div>
                                                <input type="text" name="full_positive_description"
                                                       class="lp-desc-input"
                                                       placeholder="e.g. Excellent condition, all working">
                                            </div>
                                        </div>

                                        {{-- Full Negative --}}
                                        <div class="col-md-6">
                                            <div class="lp-tier-card lp-tier-negative h-100">
                                                <div class="lp-tier-icon"><i class="fas fa-thumbs-down"></i></div>
                                                <label class="lp-tier-label">Full Negative Price</label>
                                                <div class="lp-tier-sub">All answers are negative</div>
                                                <div class="lp-price-wrap mb-2">
                                                    <span class="lp-rupee">₹</span>
                                                    <input type="number" name="full_negative_price"
                                                           min="0" step="0.01" class="form-control"
                                                           placeholder="0.00" required>
                                                </div>
                                                <input type="text" name="full_negative_description"
                                                       class="lp-desc-input"
                                                       placeholder="e.g. Heavy damage, non-functional">
                                            </div>
                                        </div>

                                        {{-- Mixed --}}
                                        <div class="col-md-12">
                                            <div class="lp-tier-card lp-tier-mixed">
                                                <div class="lp-tier-icon"><i class="fas fa-random"></i></div>
                                                <label class="lp-tier-label">Mixed Price</label>
                                                <div class="lp-tier-sub">Combination of positive and negative answers</div>
                                                <div class="lp-price-wrap mb-2">
                                                    <span class="lp-rupee">₹</span>
                                                    <input type="number" name="mixed_price"
                                                           min="0" step="0.01" class="form-control"
                                                           placeholder="0.00" required>
                                                </div>
                                                <input type="text" name="mixed_description"
                                                       class="lp-desc-input"
                                                       placeholder="e.g. Minor wear, mostly functional">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- Footer --}}
                                <div class="modal-footer border-0 px-4 pb-4" style="background:#f8f9fd;">
                                    <button type="button" class="btn btn-light px-4"
                                            data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="lp-btn-save">
                                        <i class="fas fa-save me-1"></i> Save Pricing
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                @endif
                {{-- END ADD PRICING MODAL --}}

                {{-- ===== VIEW / EDIT PRICING MODAL ===== --}}
                @if($model->evaluationPricing)
                @php $ep = $model->evaluationPricing; @endphp
                <div class="modal fade" id="viewPricingModal{{ $model->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg" style="border-radius:14px;overflow:hidden;">

                            {{-- Header --}}
                            <div class="lp-view-header d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold" style="font-size:15px;">
                                        <i class="fas fa-rupee-sign me-2"></i> Evaluation Pricing
                                    </div>
                                    <div style="font-size:12px;opacity:0.82;margin-top:2px;">
                                        {{ $model->name }} &mdash; {{ $laptopBrand->name }}
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        style="filter:brightness(0) invert(1);opacity:.8;"></button>
                            </div>

                            <div class="modal-body p-4">

                                {{-- Price Display Cards --}}
                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <div class="lp-view-card lp-vc-positive">
                                            <div class="lp-vc-icon"><i class="fas fa-thumbs-up"></i></div>
                                            <div class="lp-vc-label">Full Positive</div>
                                            <div class="lp-vc-amount">₹{{ number_format($ep->full_positive_price, 0) }}</div>
                                            @if($ep->full_positive_description)
                                                <div class="lp-vc-desc">{{ $ep->full_positive_description }}</div>
                                            @endif
                                            <div class="lp-vc-sub">All answers positive</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="lp-view-card lp-vc-negative">
                                            <div class="lp-vc-icon"><i class="fas fa-thumbs-down"></i></div>
                                            <div class="lp-vc-label">Full Negative</div>
                                            <div class="lp-vc-amount">₹{{ number_format($ep->full_negative_price, 0) }}</div>
                                            @if($ep->full_negative_description)
                                                <div class="lp-vc-desc">{{ $ep->full_negative_description }}</div>
                                            @endif
                                            <div class="lp-vc-sub">All answers negative</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="lp-view-card lp-vc-mixed">
                                            <div class="lp-vc-icon"><i class="fas fa-random"></i></div>
                                            <div class="lp-vc-label">Mixed</div>
                                            <div class="lp-vc-amount">₹{{ number_format($ep->mixed_price, 0) }}</div>
                                            @if($ep->mixed_description)
                                                <div class="lp-vc-desc">{{ $ep->mixed_description }}</div>
                                            @endif
                                            <div class="lp-vc-sub">Positive + Negative</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit Toggle --}}
                                <div class="text-center mb-1">
                                    <button type="button" class="lp-btn-edit-toggle"
                                            onclick="toggleLaptopEdit({{ $model->id }})">
                                        <i class="fas fa-edit me-1"></i> Edit Pricing
                                    </button>
                                </div>

                                {{-- Edit Form (hidden by default) --}}
                                <div class="lp-edit-section" id="laptopEditSection{{ $model->id }}">
                                    <form method="POST"
                                          action="{{ route('laptop.brands.models.evaluation-pricing.store', [$laptopBrand->id, $model->id]) }}">
                                        @csrf
                                        <div class="row g-3">

                                            <div class="col-md-6">
                                                <div class="lp-tier-card lp-tier-positive h-100">
                                                    <div class="lp-tier-icon"><i class="fas fa-thumbs-up"></i></div>
                                                    <label class="lp-tier-label">Full Positive Price</label>
                                                    <div class="lp-tier-sub">All answers are positive</div>
                                                    <div class="lp-price-wrap mb-2">
                                                        <span class="lp-rupee">₹</span>
                                                        <input type="number" name="full_positive_price"
                                                               min="0" step="0.01" class="form-control"
                                                               value="{{ $ep->full_positive_price }}" required>
                                                    </div>
                                                    <input type="text" name="full_positive_description"
                                                           class="lp-desc-input"
                                                           value="{{ $ep->full_positive_description }}"
                                                           placeholder="Description">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="lp-tier-card lp-tier-negative h-100">
                                                    <div class="lp-tier-icon"><i class="fas fa-thumbs-down"></i></div>
                                                    <label class="lp-tier-label">Full Negative Price</label>
                                                    <div class="lp-tier-sub">All answers are negative</div>
                                                    <div class="lp-price-wrap mb-2">
                                                        <span class="lp-rupee">₹</span>
                                                        <input type="number" name="full_negative_price"
                                                               min="0" step="0.01" class="form-control"
                                                               value="{{ $ep->full_negative_price }}" required>
                                                    </div>
                                                    <input type="text" name="full_negative_description"
                                                           class="lp-desc-input"
                                                           value="{{ $ep->full_negative_description }}"
                                                           placeholder="Description">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="lp-tier-card lp-tier-mixed">
                                                    <div class="lp-tier-icon"><i class="fas fa-random"></i></div>
                                                    <label class="lp-tier-label">Mixed Price</label>
                                                    <div class="lp-tier-sub">Combination of positive and negative</div>
                                                    <div class="lp-price-wrap mb-2">
                                                        <span class="lp-rupee">₹</span>
                                                        <input type="number" name="mixed_price"
                                                               min="0" step="0.01" class="form-control"
                                                               value="{{ $ep->mixed_price }}" required>
                                                    </div>
                                                    <input type="text" name="mixed_description"
                                                           class="lp-desc-input"
                                                           value="{{ $ep->mixed_description }}"
                                                           placeholder="Description">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="d-flex justify-content-end gap-2 mt-3">
                                            <button type="button" class="btn btn-light px-4"
                                                    onclick="toggleLaptopEdit({{ $model->id }})">Cancel</button>
                                            <button type="submit" class="lp-btn-save">
                                                <i class="fas fa-save me-1"></i> Update Pricing
                                            </button>
                                        </div>

                                    </form>
                                </div>
                                {{-- END Edit Form --}}

                            </div>

                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>
                @endif
                {{-- END VIEW PRICING MODAL --}}

                @empty
                <div class="col-12">
                    <div style="text-align:center;padding:50px 20px;color:#aaa;">
                        <div style="font-size:48px;margin-bottom:12px;">💻</div>
                        <p style="font-size:15px;">No models added yet for {{ $laptopBrand->name }}.</p>
                        <a href="{{ route('laptop.brands.models.create', $laptopBrand->id) }}"
                           class="btn btn-primary btn-sm">Add First Model</a>
                    </div>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

{{-- Search JS --}}
<script>
document.getElementById('modelSearch').addEventListener('input', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('.model-card-col').forEach(col => {
        col.style.display = col.dataset.name.includes(q) ? '' : 'none';
    });
});

function toggleLaptopEdit(modelId) {
    const sec = document.getElementById('laptopEditSection' + modelId);
    sec.classList.toggle('active');
    if (sec.classList.contains('active')) {
        setTimeout(() => sec.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 100);
    }
}
</script>

<style>
/* ===== Model Card ===== */
.model-card {
    background: #fff;
    border: 1.5px solid #e8e8e8;
    border-radius: 14px;
    padding: 20px 16px 16px;
    text-align: center;
    transition: all .2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.model-card:hover {
    border-color: #1565c0;
    box-shadow: 0 4px 18px rgba(21,101,192,.10);
    transform: translateY(-2px);
}
.modal-open .model-card:hover {
    transform: none !important;
    box-shadow: none !important;
    border-color: #e8e8e8 !important;
}
.model-card-img {
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    width: 100%;
}
.model-card-img img { max-height: 100px; max-width: 100%; object-fit: contain; }
.model-card-placeholder { font-size: 52px; opacity: .25; }
.model-card-name {
    font-size: 15px; font-weight: 700; color: #1a1a1a;
    margin-bottom: 2px;
    white-space: nowrap; overflow: hidden;
    text-overflow: ellipsis; max-width: 100%;
}
.model-card-brand { font-size: 12px; color: #888; margin-bottom: 10px; }
.model-card-meta {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 10px; flex-wrap: wrap; justify-content: center;
}
.model-meta-price {
    font-size: 13px; font-weight: 700; color: #2e7d32;
    background: #e8f5e9; padding: 3px 10px; border-radius: 20px;
}
.model-meta-variants {
    font-size: 12px; font-weight: 600; color: #1565c0;
    background: #e3f2fd; padding: 3px 10px; border-radius: 20px; text-decoration: none;
}
.model-meta-variants:hover { background: #bbdefb; color: #0d47a1; }

/* Pricing badge */
.pricing-badge {
    font-size: 11px; font-weight: 600;
    padding: 3px 10px; border-radius: 20px;
    margin-bottom: 12px;
}
.pricing-badge-done    { background: #e8f5e9; color: #2e7d32; }
.pricing-badge-pending { background: #fff8e1; color: #f57f17; }

/* Action buttons */
.model-card-actions {
    display: flex; align-items: center;
    justify-content: center; gap: 8px; margin-top: auto; flex-wrap: wrap;
}
.bca-btn {
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; border: none; cursor: pointer;
    text-decoration: none; transition: transform .15s ease;
}
.bca-btn:hover      { transform: scale(1.15); }
.bca-view           { background: #e3f2fd; color: #1565c0; }
.bca-edit           { background: #fff8e1; color: #f57c00; }
.bca-del            { background: #fce4e4; color: #c62828; }
.bca-config         { background: #f3e5f5; color: #7b1fa2; }
.bca-price-add      { background: #ede7f6; color: #4527a0; }
.bca-price-view     { background: #e8f5e9; color: #2e7d32; }

/* ===== Pricing Modal — Add ===== */
.lp-modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 20px 24px;
}
.lp-view-header {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: #fff;
    padding: 20px 24px;
}

/* Tier cards */
.lp-tier-card {
    border: 2px solid #e8ecf4;
    border-radius: 12px;
    padding: 18px;
    background: #fafbff;
    transition: .2s;
}
.lp-tier-card:hover { border-color: #667eea; background: #f3f0ff; }

.lp-tier-icon {
    width: 42px; height: 42px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; margin-bottom: 12px;
}
.lp-tier-positive .lp-tier-icon { background: #e6f9f0; color: #28a745; }
.lp-tier-negative .lp-tier-icon { background: #fdecea; color: #e74a3b; }
.lp-tier-mixed    .lp-tier-icon { background: #fff3e0; color: #fd7e14; }

.lp-tier-label {
    font-weight: 700; font-size: 0.82rem;
    text-transform: uppercase; letter-spacing: .8px;
    color: #555; margin-bottom: 4px; display: block;
}
.lp-tier-sub { font-size: .75rem; color: #999; margin-bottom: 10px; }

.lp-price-wrap { position: relative; }
.lp-rupee {
    position: absolute; left: 12px; top: 50%;
    transform: translateY(-50%);
    font-weight: 700; color: #667eea;
    font-size: 1rem; pointer-events: none;
}
.lp-price-wrap input[type="number"] {
    padding-left: 28px; border-radius: 8px;
    border: 1.5px solid #dde2f0;
    font-weight: 600; font-size: 1rem; color: #333;
    background: #fff; width: 100%;
}
.lp-price-wrap input[type="number"]:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,.12);
    outline: none;
}
.lp-desc-input {
    width: 100%; border-radius: 8px;
    border: 1.5px solid #dde2f0;
    font-size: .82rem; color: #666;
    padding: 7px 10px; background: #fff;
}
.lp-desc-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,.12);
    outline: none;
}

/* Save button */
.lp-btn-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff; border: none; border-radius: 10px;
    padding: 10px 28px; font-weight: 700;
    font-size: .9rem; cursor: pointer; transition: .2s;
}
.lp-btn-save:hover {
    opacity: .9; color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(102,126,234,.4);
}

/* Edit toggle button */
.lp-btn-edit-toggle {
    background: linear-gradient(135deg, #f6c23e, #e0a800);
    color: #fff; border: none; border-radius: 10px;
    padding: 9px 24px; font-weight: 700;
    font-size: .88rem; cursor: pointer; transition: .2s;
}
.lp-btn-edit-toggle:hover {
    color: #fff; transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(246,194,62,.45);
}

/* View price cards */
.lp-view-card {
    border-radius: 14px; padding: 20px 16px;
    text-align: center; position: relative; overflow: hidden;
}
.lp-vc-positive { background: linear-gradient(135deg, #d4edda, #b8f0cb); border: 1.5px solid #28a745; }
.lp-vc-negative { background: linear-gradient(135deg, #fde8e8, #fbc4c4); border: 1.5px solid #e74a3b; }
.lp-vc-mixed    { background: linear-gradient(135deg, #fff3cd, #ffe08a); border: 1.5px solid #fd7e14; }

.lp-vc-icon { font-size: 22px; margin-bottom: 8px; }
.lp-vc-positive .lp-vc-icon { color: #28a745; }
.lp-vc-negative .lp-vc-icon { color: #e74a3b; }
.lp-vc-mixed    .lp-vc-icon { color: #fd7e14; }

.lp-vc-label {
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 1px;
    color: #555; margin-bottom: 6px;
}
.lp-vc-amount  { font-size: 1.6rem; font-weight: 800; color: #222; line-height: 1; margin-bottom: 5px; }
.lp-vc-desc    { font-size: .75rem; color: #555; font-style: italic;
                 background: rgba(255,255,255,.5); border-radius: 6px;
                 padding: 3px 8px; display: inline-block; margin-bottom: 4px; }
.lp-vc-sub     { font-size: .7rem; color: #888; margin-top: 4px; }

/* Inline edit section */
.lp-edit-section {
    display: none;
    margin-top: 20px;
    border-top: 2px dashed #e0e0e0;
    padding-top: 20px;
}
.lp-edit-section.active { display: block; }
</style>

@endsection