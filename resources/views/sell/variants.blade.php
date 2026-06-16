<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sell {{ $model->name }} – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
.variant-page-wrap {
  max-width: 1200px;
  margin: 0 auto;
  padding: 28px 20px 60px;
}
.sell-breadcrumb {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #888;
  margin-bottom: 24px;
  flex-wrap: wrap;
}
.sell-breadcrumb a { color: #888; text-decoration: none; }
.sell-breadcrumb a:hover { color: #00c853; }
.sell-breadcrumb .sep { color: #ccc; }
.sell-breadcrumb .active { color: #333; font-weight: 600; }

.variant-layout {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 40px;
  align-items: start;
}
.variant-phone-side {
  position: sticky;
  top: 80px;
  text-align: center;
}
.variant-phone-img-wrap {
  background: #fafafa;
  border-radius: 20px;
  padding: 30px 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 260px;
}
.variant-phone-img-wrap img {
  max-height: 240px;
  max-width: 100%;
  object-fit: contain;
}
.variant-model-name {
  font-family: 'Nunito', sans-serif;
  font-size: 26px;
  font-weight: 800;
  color: #1a1a1a;
  margin: 0 0 6px;
}
.variant-sold-count {
  font-size: 13px;
  color: #00c853;
  font-weight: 700;
  margin-bottom: 24px;
}

/* ══ Choose Box ══ */
.variant-choose-box {
  border: 1.5px solid #e0e0e0;
  border-radius: 16px;
  padding: 24px;
  margin-bottom: 20px;
}
.variant-choose-title {
  font-size: 15px;
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 16px;
}

/* ══ Radio Variant Cards (Cashify Style) ══ */
.variant-options-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}
.variant-radio-label {
  display: flex;
  align-items: center;
  gap: 10px;
  border: 1.5px solid #e0e0e0;
  border-radius: 10px;
  padding: 12px 14px;
  cursor: pointer;
  transition: all .18s ease;
  font-family: 'Nunito Sans', sans-serif;
  font-size: 14px;
  font-weight: 600;
  color: #1a1a1a;
  user-select: none;
}
.variant-radio-label:hover {
  border-color: #00c853;
  background: #f0fff5;
}
.variant-radio-label input[type="radio"] {
  width: 18px;
  height: 18px;
  accent-color: #00c853;
  cursor: pointer;
  flex-shrink: 0;
}
.variant-radio-label.selected {
  border-color: #00c853;
  background: #f0fff5;
}

/* ══ Price Display ══ */
.variant-price-box {
  background: #f8f8f8;
  border-radius: 12px;
  padding: 16px 20px;
  margin-bottom: 20px;
  display: none; /* JS show பண்ணும் */
}
.variant-price-box.show { display: block; }
.variant-price-label {
  font-size: 13px;
  color: #888;
  margin-bottom: 4px;
}
.variant-price-value {
  font-family: 'Nunito', sans-serif;
  font-size: 28px;
  font-weight: 900;
  color: #00c853;
}
.variant-price-memory {
  font-size: 13px;
  color: #555;
  margin-top: 2px;
}

/* ══ CTA Button ══ */
.variant-cta-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: 100%;
  max-width: 320px;
  padding: 15px 24px;
  background: linear-gradient(135deg, #00c853, #00a846);
  color: #fff;
  border: none;
  border-radius: 50px;
  font-family: 'Nunito', sans-serif;
  font-size: 16px;
  font-weight: 800;
  cursor: pointer;
  transition: all .2s;
  text-decoration: none;
}
.variant-cta-btn:hover {
  background: linear-gradient(135deg, #00a846, #008f3a);
  box-shadow: 0 8px 24px rgba(0,200,83,.3);
  transform: translateY(-1px);
  color: #fff;
}
.variant-cta-btn.disabled {
  background: #e0e0e0;
  color: #aaa;
  cursor: not-allowed;
  box-shadow: none;
  transform: none;
  pointer-events: none;
}
.variant-empty {
  text-align: center;
  padding: 40px 20px;
  color: #aaa;
  font-size: 14px;
  border: 1.5px dashed #e0e0e0;
  border-radius: 14px;
}

@media (max-width: 768px) {
  .variant-layout {
    grid-template-columns: 1fr;
    gap: 20px;
  }
  .variant-phone-side {
    position: static;
    display: flex;
    align-items: center;
    gap: 16px;
    text-align: left;
  }
  .variant-phone-img-wrap {
    width: 100px;
    min-height: 120px;
    padding: 14px;
    flex-shrink: 0;
    border-radius: 14px;
  }
  .variant-phone-img-wrap img { max-height: 100px; }
  .variant-model-name { font-size: 20px; }
  .variant-options-grid { grid-template-columns: repeat(2, 1fr); }
  .variant-cta-btn { max-width: 100%; }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

<div class="variant-page-wrap">

  {{-- Breadcrumb --}}
  <div class="sell-breadcrumb">
    <a href="{{ route('sell.index') }}">Home</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.phone') }}">Sell Old Mobile Phone</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.brand.models', $brand->slug) }}">Sell Old {{ $brand->name }}</a>
    <span class="sep">›</span>
    <span class="active">Sell Old {{ $model->name }}</span>
  </div>

  <div class="variant-layout">

    {{-- LEFT: Phone Image --}}
    <div class="variant-phone-side">
      <div class="variant-phone-img-wrap">
        @if($model->image)
          <img src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
        @else
          <div style="font-size:80px;opacity:.3;">📱</div>
        @endif
      </div>
      {{-- Mobile only --}}
      <div class="d-md-none d-block">
        <h1 class="variant-model-name">{{ $model->name }}</h1>
        <div class="variant-sold-count">{{ $variants->count() }} variants available</div>
      </div>
    </div>

    {{-- RIGHT: Variant Selector --}}
    <div class="variant-right-side">

      <h1 class="variant-model-name d-none d-md-block">{{ $model->name }}</h1>
      <div class="variant-sold-count d-none d-md-block">
        {{ $variants->count() }} variants available
      </div>

      @if($variants->isEmpty())
        <div class="variant-empty">
          <div style="font-size:36px;margin-bottom:10px;">🔍</div>
          No variants added yet for this model.
        </div>
      @else

        {{-- Choose Variant Box --}}
        <div class="variant-choose-box" id="variantChooseBox">
          <div class="variant-choose-title">Choose a variant</div>

          <div class="variant-options-grid">
            @foreach($variants as $variant)
            <label class="variant-radio-label" id="label-{{ $variant->id }}">
              <input type="radio"
                     name="variant_select"
                     value="{{ $variant->id }}"
                     data-memory="{{ $variant->memory }}"
                     data-price="{{ $variant->price }}"
                     onchange="selectVariant(this)">
              {{ $variant->memory }}
            </label>
            @endforeach
          </div>
        </div>

        {{-- ✅ Price Display Box --}}
        <div class="variant-price-box" id="priceBox">
          <div class="variant-price-label">Estimated Price</div>
          <div class="variant-price-value" id="priceValue">₹0</div>
          <div class="variant-price-memory" id="priceMemory"></div>
        </div>

        {{-- CTA Button --}}
        <a href="#" id="ctaBtn" class="variant-cta-btn disabled"
           onclick="return handleCTA(event)">
          Get Exact Value →
        </a>

      @endif
    </div>

  </div>
</div>

<script>
let selectedVariantId = null;

function selectVariant(radio) {
  // All labels - selected class remove
  document.querySelectorAll('.variant-radio-label').forEach(function(l) {
    l.classList.remove('selected');
  });

  // Selected label highlight
  radio.closest('label').classList.add('selected');

  selectedVariantId = radio.value;
  var memory = radio.getAttribute('data-memory');
  var price  = parseFloat(radio.getAttribute('data-price'));

  // ✅ Price Box Show
  var priceBox    = document.getElementById('priceBox');
  var priceValue  = document.getElementById('priceValue');
  var priceMemory = document.getElementById('priceMemory');

  priceBox.classList.add('show');
  priceValue.textContent  = '₹' + price.toLocaleString('en-IN', {minimumFractionDigits: 2});
  priceMemory.textContent = memory + ' variant selected';

  // CTA Button enable
  var btn = document.getElementById('ctaBtn');
  btn.classList.remove('disabled');
}

function handleCTA(e) {
  e.preventDefault();
  if (!selectedVariantId) {
    // Shake box
    var box = document.getElementById('variantChooseBox');
    box.style.border = '1.5px solid #f44336';
    setTimeout(function() {
      box.style.border = '1.5px solid #e0e0e0';
    }, 1500);
    return false;
  }
  window.location.href = '?variant=' + selectedVariantId;
  return false;
}
</script>

<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>