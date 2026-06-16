@extends('layouts.app')

@section('content')

<style>

/* ===== Card Styling ===== */
.model-box {
    border: 1px solid #dcdcdc;
    border-radius: 14px;
    transition: 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    background: #fff;
}
.model-box:hover {
    border-color: #4e73df;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    transform: translateY(-4px);
}
/* MODAL OPEN BLINK FIX */
.modal-open .model-box:hover {
    transform: none !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
    border-color: #dcdcdc !important;
}
.modal-open .model-box:hover .model-img {
    transform: none !important;
}

.model-img-wrapper {
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.model-img {
    max-height: 100px;
    max-width: 100%;
    object-fit: contain;
    transition: 0.3s ease;
}
.model-box:hover .model-img {
    transform: scale(1.05);
}
.no-img {
    width: 80px;
    height: 95px;
    background: #f5f5f5;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #bbb;
    font-size: 28px;
}
.icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd;
    background: #fff;
    transition: 0.2s;
    cursor: pointer;
}
.icon-btn i { font-size: 14px; }
.view-btn         { color: #17a2b8; }
.view-btn:hover   { background: #17a2b8; color: #fff; border-color:#17a2b8; }
.edit-btn         { color: #f6c23e; }
.edit-btn:hover   { background: #f6c23e; color: #fff; border-color:#f6c23e; }
.delete-btn       { color: #e74a3b; }
.delete-btn:hover { background: #e74a3b; color: #fff; border-color:#e74a3b; }
.pricing-btn      { color: #6f42c1; }
.pricing-btn:hover{ background: #6f42c1; color: #fff; border-color:#6f42c1; }
.view-price-btn   { color: #28a745; }
.view-price-btn:hover { background: #28a745; color: #fff; border-color:#28a745; }

/* Header */
.header-actions { display: flex; gap: 10px; }
@media (max-width: 768px) {
    .header-actions { flex-direction: column; width: 100%; margin-top: 10px; }
    .header-actions input { width: 100% !important; }
    .header-actions .btn { width: 100%; }
    .card-header { flex-direction: column; align-items: flex-start !important; }
    .card-header .d-flex.align-items-center { margin-bottom: 10px; }
}

/* ===== ATTRACTIVE PRICING MODAL ===== */
.pricing-modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border-radius: 12px 12px 0 0;
    padding: 20px 24px;
    border: none;
}
.pricing-modal-header .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.pricing-tier-card {
    border: 2px solid #e8ecf4;
    border-radius: 12px;
    padding: 18px;
    background: #fafbff;
    transition: 0.2s;
    position: relative;
}
.pricing-tier-card:hover {
    border-color: #667eea;
    background: #f3f0ff;
}
.pricing-tier-card .tier-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    margin-bottom: 12px;
}
.tier-positive .tier-icon { background: #e6f9f0; color: #28a745; }
.tier-negative .tier-icon { background: #fdecea; color: #e74a3b; }
.tier-mixed    .tier-icon { background: #fff3e0; color: #fd7e14; }

.pricing-tier-card label.tier-label {
    font-weight: 700;
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #555;
    margin-bottom: 4px;
    display: block;
}
.pricing-tier-card .tier-subtitle {
    font-size: 0.75rem;
    color: #999;
    margin-bottom: 10px;
}
.pricing-tier-card .input-price-wrap {
    position: relative;
}
.pricing-tier-card .input-price-wrap .rupee-sign {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-weight: 700;
    color: #667eea;
    font-size: 1rem;
    pointer-events: none;
}
.pricing-tier-card .input-price-wrap input[type="number"] {
    padding-left: 28px;
    border-radius: 8px;
    border: 1.5px solid #dde2f0;
    font-weight: 600;
    font-size: 1rem;
    color: #333;
    background: #fff;
    transition: 0.2s;
    width: 100%;
}
.pricing-tier-card .input-price-wrap input[type="number"]:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
    outline: none;
}
.pricing-tier-card input[type="text"] {
    border-radius: 8px;
    border: 1.5px solid #dde2f0;
    font-size: 0.82rem;
    color: #666;
    background: #fff;
    transition: 0.2s;
    width: 100%;
    padding: 7px 10px;
}
.pricing-tier-card input[type="text"]:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
    outline: none;
}

.btn-save-pricing {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 28px;
    font-weight: 700;
    font-size: 0.9rem;
    letter-spacing: 0.3px;
    transition: 0.2s;
    cursor: pointer;
}
.btn-save-pricing:hover {
    opacity: 0.9;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(102,126,234,0.4);
}

/* ===== VIEW PRICING MODAL ===== */
.view-pricing-header {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: #fff;
    border-radius: 12px 12px 0 0;
    padding: 20px 24px;
    border: none;
}
.view-pricing-header .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.price-view-card {
    border-radius: 14px;
    padding: 20px 16px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.price-view-card::before {
    content: '';
    position: absolute;
    top: -20px; right: -20px;
    width: 80px; height: 80px;
    border-radius: 50%;
    opacity: 0.1;
    background: #fff;
}
.price-view-card.positive { background: linear-gradient(135deg, #d4edda, #b8f0cb); border: 1.5px solid #28a745; }
.price-view-card.negative { background: linear-gradient(135deg, #fde8e8, #fbc4c4); border: 1.5px solid #e74a3b; }
.price-view-card.mixed    { background: linear-gradient(135deg, #fff3cd, #ffe08a); border: 1.5px solid #fd7e14; }

.price-view-card .pvc-icon { font-size: 22px; margin-bottom: 8px; }
.price-view-card.positive .pvc-icon { color: #28a745; }
.price-view-card.negative .pvc-icon { color: #e74a3b; }
.price-view-card.mixed    .pvc-icon { color: #fd7e14; }

.price-view-card .pvc-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #555;
    margin-bottom: 6px;
}
.price-view-card .pvc-amount {
    font-size: 1.6rem;
    font-weight: 800;
    color: #222;
    line-height: 1;
    margin-bottom: 5px;
}
.price-view-card .pvc-desc {
    font-size: 0.75rem;
    color: #555;
    font-style: italic;
    background: rgba(255,255,255,0.5);
    border-radius: 6px;
    padding: 3px 8px;
    display: inline-block;
    margin-bottom: 4px;
}
.price-view-card .pvc-subtitle {
    font-size: 0.7rem;
    color: #888;
    margin-top: 4px;
}

.btn-edit-pricing {
    background: linear-gradient(135deg, #f6c23e, #e0a800);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 9px 24px;
    font-weight: 700;
    font-size: 0.88rem;
    transition: 0.2s;
    cursor: pointer;
}
.btn-edit-pricing:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(246,194,62,0.45);
}

.edit-pricing-section {
    display: none;
    margin-top: 20px;
    border-top: 2px dashed #e0e0e0;
    padding-top: 20px;
}
.edit-pricing-section.active { display: block; }

</style>

<div class="container">
<div class="page-inner">

<div class="page-header">
    <h3 class="fw-bold mb-3">Mobile Models</h3>
    <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="{{ route('brands.index') }}">Mobile Brand</a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">{{ $brand->name }} Models</a></li>
    </ul>
</div>

<div class="row">
<div class="col-md-12">
<div class="card">

<!-- CARD HEADER -->
<div class="card-header d-flex justify-content-between align-items-center flex-wrap">
    <div class="d-flex align-items-center gap-3">
        @if($brand->logo)
            <img src="{{ asset('storage/' . $brand->logo) }}"
                 alt="{{ $brand->name }}" style="height:45px; object-fit:contain;">
        @endif
        <h4 class="card-title mb-0">{{ $brand->name }} — Models</h4>
    </div>
    <div class="header-actions">
        <input type="text" id="searchInput" class="form-control"
               placeholder="Search Model..." style="width:200px;">
        <a href="{{ route('brands.models.create', $brand->id) }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Model
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mx-3 mt-3">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mx-3 mt-3">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card-body">

@if($models->isEmpty())
    <p class="text-center mt-3">No models found for {{ $brand->name }}.</p>
@else

<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4" id="modelsGrid">

@foreach($models as $model)
<div class="col model-card">
<div class="card h-100 text-center model-box">
<div class="card-body p-3">

    <a href="{{ route('brands.models.variants', [$brand->id, $model->id]) }}"
       class="text-decoration-none">
        <div class="model-img-wrapper mb-2">
            @if($model->image)
                <img src="{{ asset('storage/' . $model->image) }}"
                     alt="{{ $model->name }}" class="model-img">
            @else
                <div class="no-img"><i class="fas fa-mobile-alt"></i></div>
            @endif
        </div>
        <h6 class="fw-bold mb-1 model-name text-dark">{{ $model->name }}</h6>
    </a>

    <small class="text-muted d-block mb-3">{{ $brand->name }}</small>

    @if($model->evaluationPricing)
        <div class="small text-success fw-semibold mb-2">
            <i class="fas fa-lock me-1"></i> Evaluation pricing added
        </div>
    @else
        <div class="small text-warning fw-semibold mb-2">
            <i class="fas fa-exclamation-circle me-1"></i> Pricing not added
        </div>
    @endif

    <div class="d-flex justify-content-center gap-2 flex-wrap">

        <a href="{{ route('brands.models.variants', [$brand->id, $model->id]) }}"
           class="icon-btn view-btn" title="View Variants">
            <i class="fas fa-eye"></i>
        </a>

        <a href="{{ route('brands.models.edit', [$brand->id, $model->id]) }}"
           class="icon-btn edit-btn" title="Edit Model">
            <i class="fas fa-edit"></i>
        </a>

        @if($model->evaluationPricing)
            {{-- Green ₹ button → View Pricing --}}
            <button type="button" class="icon-btn view-price-btn"
                    title="View / Edit Pricing"
                    data-bs-toggle="modal"
                    data-bs-target="#viewPricingModal{{ $model->id }}">
                <i class="fas fa-rupee-sign"></i>
            </button>
        @else
            {{-- Purple tag button → Add Pricing --}}
            <button type="button" class="icon-btn pricing-btn"
                    title="Add Evaluation Pricing"
                    data-bs-toggle="modal"
                    data-bs-target="#pricingModal{{ $model->id }}">
                <i class="fas fa-tags"></i>
            </button>
        @endif

        <form action="{{ route('brands.models.destroy', [$brand->id, $model->id]) }}"
              method="POST" onsubmit="return confirm('Delete this model?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="icon-btn delete-btn" title="Delete">
                <i class="fas fa-trash"></i>
            </button>
        </form>

    </div>

    {{-- =============== ADD PRICING MODAL =============== --}}
    @if(!$model->evaluationPricing)
    <div class="modal fade" id="pricingModal{{ $model->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:14px; overflow:hidden;">
          <form method="POST"
                action="{{ route('brands.models.evaluation-pricing.store', [$brand->id, $model->id]) }}">
            @csrf

            <div class="pricing-modal-header d-flex justify-content-between align-items-center">
                <div>
                    <div class="modal-title fw-bold">
                        <i class="fas fa-tags me-2"></i> Add Evaluation Pricing
                    </div>
                    <div style="font-size:0.8rem; opacity:0.82; margin-top:2px;">
                        {{ $model->name }} &mdash; {{ $brand->name }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4" style="background:#f8f9fd;">
                <div class="row g-3">

                    {{-- Full Positive --}}
                    <div class="col-md-6">
                        <div class="pricing-tier-card tier-positive h-100">
                            <div class="tier-icon"><i class="fas fa-thumbs-up"></i></div>
                            <label class="tier-label">Full Positive Price</label>
                            <div class="tier-subtitle">All answers are positive</div>
                            <div class="input-price-wrap mb-2">
                                <span class="rupee-sign">₹</span>
                                <input type="number" name="full_positive_price"
                                       min="0" step="0.01" class="form-control"
                                       placeholder="0.00" required>
                            </div>
                            <input type="text" name="full_positive_description"
                                   placeholder="e.g. Excellent condition, all working">
                        </div>
                    </div>

                    {{-- Full Negative --}}
                    <div class="col-md-6">
                        <div class="pricing-tier-card tier-negative h-100">
                            <div class="tier-icon"><i class="fas fa-thumbs-down"></i></div>
                            <label class="tier-label">Full Negative Price</label>
                            <div class="tier-subtitle">All answers are negative</div>
                            <div class="input-price-wrap mb-2">
                                <span class="rupee-sign">₹</span>
                                <input type="number" name="full_negative_price"
                                       min="0" step="0.01" class="form-control"
                                       placeholder="0.00" required>
                            </div>
                            <input type="text" name="full_negative_description"
                                   placeholder="e.g. Heavy damage, non-functional">
                        </div>
                    </div>

                    {{-- Mixed --}}
                    <div class="col-md-12">
                        <div class="pricing-tier-card tier-mixed">
                            <div class="tier-icon"><i class="fas fa-random"></i></div>
                            <label class="tier-label">Mixed Price (Positive + Negative)</label>
                            <div class="tier-subtitle">Combination of positive and negative answers</div>
                            <div class="input-price-wrap mb-2">
                                <span class="rupee-sign">₹</span>
                                <input type="number" name="mixed_price"
                                       min="0" step="0.01" class="form-control"
                                       placeholder="0.00" required>
                            </div>
                            <input type="text" name="mixed_description"
                                   placeholder="e.g. Minor wear, mostly functional">
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer border-0 px-4 pb-4" style="background:#f8f9fd;">
                <button type="button" class="btn btn-light px-4"
                        data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn-save-pricing">
                    <i class="fas fa-save me-1"></i> Save Pricing
                </button>
            </div>

          </form>
        </div>
      </div>
    </div>
    @endif
    {{-- END ADD PRICING MODAL --}}

    {{-- =============== VIEW PRICING MODAL =============== --}}
    @if($model->evaluationPricing)
    @php $ep = $model->evaluationPricing; @endphp
    <div class="modal fade" id="viewPricingModal{{ $model->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:14px; overflow:hidden;">

            <div class="view-pricing-header d-flex justify-content-between align-items-center">
                <div>
                    <div class="modal-title fw-bold fs-6">
                        <i class="fas fa-rupee-sign me-2"></i> Evaluation Pricing
                    </div>
                    <div style="font-size:0.8rem; opacity:0.82; margin-top:2px;">
                        {{ $model->name }} &mdash; {{ $brand->name }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                {{-- Price Display Cards --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="price-view-card positive">
                            <div class="pvc-icon"><i class="fas fa-thumbs-up"></i></div>
                            <div class="pvc-label">Full Positive</div>
                            <div class="pvc-amount">₹{{ number_format($ep->full_positive_price, 0) }}</div>
                            @if($ep->full_positive_description)
                                <div class="pvc-desc">{{ $ep->full_positive_description }}</div>
                            @endif
                            <div class="pvc-subtitle">All answers positive</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="price-view-card negative">
                            <div class="pvc-icon"><i class="fas fa-thumbs-down"></i></div>
                            <div class="pvc-label">Full Negative</div>
                            <div class="pvc-amount">₹{{ number_format($ep->full_negative_price, 0) }}</div>
                            @if($ep->full_negative_description)
                                <div class="pvc-desc">{{ $ep->full_negative_description }}</div>
                            @endif
                            <div class="pvc-subtitle">All answers negative</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="price-view-card mixed">
                            <div class="pvc-icon"><i class="fas fa-random"></i></div>
                            <div class="pvc-label">Mixed</div>
                            <div class="pvc-amount">₹{{ number_format($ep->mixed_price, 0) }}</div>
                            @if($ep->mixed_description)
                                <div class="pvc-desc">{{ $ep->mixed_description }}</div>
                            @endif
                            <div class="pvc-subtitle">Positive + Negative</div>
                        </div>
                    </div>
                </div>

                {{-- Edit Toggle Button --}}
                <div class="text-center mb-1">
                    <button type="button" class="btn-edit-pricing"
                            onclick="toggleEditSection({{ $model->id }})">
                        <i class="fas fa-edit me-1"></i> Edit Pricing
                    </button>
                </div>

                {{-- Edit Form (hidden by default) --}}
                <div class="edit-pricing-section" id="editSection{{ $model->id }}">
                    <form method="POST"
                          action="{{ route('brands.models.evaluation-pricing.store', [$brand->id, $model->id]) }}">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="pricing-tier-card tier-positive h-100">
                                    <div class="tier-icon"><i class="fas fa-thumbs-up"></i></div>
                                    <label class="tier-label">Full Positive Price</label>
                                    <div class="tier-subtitle">All answers are positive</div>
                                    <div class="input-price-wrap mb-2">
                                        <span class="rupee-sign">₹</span>
                                        <input type="number" name="full_positive_price"
                                               min="0" step="0.01" class="form-control"
                                               value="{{ $ep->full_positive_price }}" required>
                                    </div>
                                    <input type="text" name="full_positive_description"
                                           value="{{ $ep->full_positive_description }}"
                                           placeholder="Description">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="pricing-tier-card tier-negative h-100">
                                    <div class="tier-icon"><i class="fas fa-thumbs-down"></i></div>
                                    <label class="tier-label">Full Negative Price</label>
                                    <div class="tier-subtitle">All answers are negative</div>
                                    <div class="input-price-wrap mb-2">
                                        <span class="rupee-sign">₹</span>
                                        <input type="number" name="full_negative_price"
                                               min="0" step="0.01" class="form-control"
                                               value="{{ $ep->full_negative_price }}" required>
                                    </div>
                                    <input type="text" name="full_negative_description"
                                           value="{{ $ep->full_negative_description }}"
                                           placeholder="Description">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="pricing-tier-card tier-mixed">
                                    <div class="tier-icon"><i class="fas fa-random"></i></div>
                                    <label class="tier-label">Mixed Price</label>
                                    <div class="tier-subtitle">Combination of positive and negative answers</div>
                                    <div class="input-price-wrap mb-2">
                                        <span class="rupee-sign">₹</span>
                                        <input type="number" name="mixed_price"
                                               min="0" step="0.01" class="form-control"
                                               value="{{ $ep->mixed_price }}" required>
                                    </div>
                                    <input type="text" name="mixed_description"
                                           value="{{ $ep->mixed_description }}"
                                           placeholder="Description">
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-light px-4"
                                    onclick="toggleEditSection({{ $model->id }})">
                                Cancel
                            </button>
                            <button type="submit" class="btn-save-pricing">
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

</div>
</div>
</div>
@endforeach

</div>
@endif

</div>
</div>
</div>
</div>
</div>

<script>
// Search
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.model-card').forEach(card => {
        const name = card.querySelector('.model-name').textContent.toLowerCase();
        card.style.display = name.includes(q) ? '' : 'none';
    });
});

// Toggle inline edit section inside View Pricing modal
function toggleEditSection(modelId) {
    const sec = document.getElementById('editSection' + modelId);
    sec.classList.toggle('active');
    // Scroll into view smoothly
    if (sec.classList.contains('active')) {
        setTimeout(() => sec.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 100);
    }
}
</script>

@endsection