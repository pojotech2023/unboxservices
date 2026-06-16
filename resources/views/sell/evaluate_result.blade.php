{{-- resources/views/sell/evaluate_result.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sell {{ $model->name }} – Final Price – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #f7f8fa; font-family: 'Nunito Sans', sans-serif; }

.result-page-wrap {
  max-width: 900px;
  margin: 0 auto;
  padding: 28px 20px 80px;
}

/* Breadcrumb */
.sell-breadcrumb {
  display: flex; align-items: center; gap: 6px;
  font-size: 13px; color: #888; margin-bottom: 28px; flex-wrap: wrap;
}
.sell-breadcrumb a { color: #888; text-decoration: none; }
.sell-breadcrumb a:hover { color: #00c853; }
.sell-breadcrumb .sep { color: #ccc; }
.sell-breadcrumb .active { color: #333; font-weight: 600; }

/* ══ Device Summary Top Card ══ */
.result-device-card {
  background: #fff;
  border-radius: 16px;
  border: 1.5px solid #ebebeb;
  padding: 24px;
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 20px;
}
.result-device-img-wrap {
  width: 80px; height: 90px;
  background: #f5f5f5;
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
  overflow: hidden;
}
.result-device-img-wrap img { max-height: 82px; max-width: 72px; object-fit: contain; }
.result-device-name {
  font-family: 'Nunito', sans-serif;
  font-size: 20px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px;
}
.result-device-variant {
  font-size: 12px; color: #00c853; font-weight: 700;
  background: #f0fff5; border: 1px solid #c8f5d9;
  border-radius: 6px; display: inline-block;
  padding: 2px 10px; margin-bottom: 8px;
}
.result-base-price {
  font-size: 13px; color: #888;
}
.result-base-price strong { color: #1a1a1a; font-weight: 700; }

/* ══ Main Grid ══ */
.result-main-grid {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 20px;
  align-items: start;
}

/* ══ Answers Review Card ══ */
.result-answers-card {
  background: #fff;
  border-radius: 16px;
  border: 1.5px solid #ebebeb;
  overflow: hidden;
}
.result-answers-header {
  padding: 18px 22px;
  border-bottom: 1px solid #f0f0f0;
  font-family: 'Nunito', sans-serif;
  font-size: 15px; font-weight: 800; color: #1a1a1a;
}
.result-answers-body { padding: 8px 0; }

.result-answer-row {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 14px 22px;
  border-bottom: 1px solid #f9f9f9;
  gap: 16px;
}
.result-answer-row:last-child { border-bottom: none; }
.result-answer-question {
  font-size: 13px; color: #555; font-weight: 500; flex: 1;
  line-height: 1.5;
}
.result-answer-badge {
  font-size: 12px; font-weight: 700;
  padding: 4px 14px; border-radius: 50px;
  white-space: nowrap; flex-shrink: 0;
}
.result-answer-badge.yes {
  background: #f0fff5; color: #00a846;
  border: 1px solid #a5d6b9;
}
.result-answer-badge.no {
  background: #fff5f5; color: #d32f2f;
  border: 1px solid #ffcdd2;
}

/* ══ Price Sidebar ══ */
.result-price-card {
  background: #fff;
  border-radius: 16px;
  border: 1.5px solid #ebebeb;
  overflow: hidden;
  position: sticky;
  top: 80px;
}
.result-price-header {
  background: linear-gradient(135deg, #00c853, #00a846);
  padding: 20px 22px;
  text-align: center;
}
.result-price-header-lbl {
  font-size: 12px; font-weight: 700; color: rgba(255,255,255,.85);
  text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px;
}
.result-price-value {
  font-family: 'Nunito', sans-serif;
  font-size: 34px; font-weight: 900; color: #fff;
}
.result-price-subtext {
  font-size: 11px; color: rgba(255,255,255,.7); margin-top: 4px;
}
.result-price-body {
  padding: 20px 22px;
}
.result-pickup-info {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  background: #f9fffe;
  border: 1px solid #e0f5ec;
  border-radius: 10px;
  padding: 12px 14px;
  margin-bottom: 16px;
  font-size: 12.5px;
  color: #555;
  line-height: 1.5;
}
.result-pickup-info svg { flex-shrink: 0; margin-top: 2px; }

.result-sell-btn {
  display: flex; align-items: center; justify-content: center;
  gap: 8px; width: 100%;
  padding: 14px 24px;
  background: linear-gradient(135deg, #00c853, #00a846);
  color: #fff; border: none; border-radius: 50px;
  font-family: 'Nunito', sans-serif;
  font-size: 15px; font-weight: 800;
  cursor: pointer; transition: all .2s;
  text-decoration: none; margin-bottom: 10px;
}
.result-sell-btn:hover {
  background: linear-gradient(135deg, #00a846, #008f3a);
  box-shadow: 0 8px 24px rgba(0,200,83,.3);
  transform: translateY(-1px);
  color: #fff;
}
.result-recalc-btn {
  display: flex; align-items: center; justify-content: center;
  width: 100%; padding: 12px 24px;
  background: #fff; color: #555;
  border: 1.5px solid #e0e0e0;
  border-radius: 50px;
  font-family: 'Nunito', sans-serif;
  font-size: 13px; font-weight: 700;
  cursor: pointer; transition: all .2s;
  text-decoration: none;
}
.result-recalc-btn:hover {
  border-color: #00c853; color: #00c853;
}

@media (max-width: 768px) {
  .result-main-grid { grid-template-columns: 1fr; }
  .result-price-card { position: static; }
  .result-device-card { flex-direction: column; align-items: flex-start; gap: 14px; }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

<div class="result-page-wrap">

  {{-- Breadcrumb --}}
  <div class="sell-breadcrumb">
    <a href="{{ route('sell.index') }}">Home</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.phone') }}">Sell Old Mobile Phone</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.brand.models', $brand->slug) }}">Sell Old {{ $brand->name }}</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a>
    <span class="sep">›</span>
    <span class="active">Final Price</span>
  </div>

  {{-- Device top card --}}
  <div class="result-device-card">
    <div class="result-device-img-wrap">
      @if($model->image)
        <img src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
      @else
        <div style="font-size:36px;opacity:.3;">📱</div>
      @endif
    </div>
    <div>
      <div class="result-device-name">{{ $model->name }}</div>
      <div class="result-device-variant">{{ $variant->memory }}</div>
      <div class="result-base-price">
        Estimated Price: <strong>₹{{ number_format($variant->price, 2) }}</strong>
      </div>
    </div>
  </div>

  {{-- Main Grid --}}
  <div class="result-main-grid">

    {{-- LEFT: Answers Summary --}}
    <div class="result-answers-card">
      <div class="result-answers-header">Your Device Evaluation Summary</div>
      <div class="result-answers-body">
        @foreach($answeredList as $item)
        <div class="result-answer-row">
          <div class="result-answer-question">{{ $item['question'] }}</div>
          <div class="result-answer-badge {{ $item['answer'] }}">
            {{ $item['answer_text'] }}
          </div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- RIGHT: Price + CTA --}}
    <div>
      <div class="result-price-card">
        <div class="result-price-header">
          <div class="result-price-header-lbl">Your Device Value</div>
          <div class="result-price-value">₹{{ number_format($variant->price, 2) }}</div>
          <div class="result-price-subtext">Final price after evaluation</div>
        </div>
        <div class="result-price-body">
          <div class="result-pickup-info">
            <svg width="16" height="16" fill="none" stroke="#00c853" stroke-width="2.2" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
            <span>Free doorstep pickup available. Our executive will come to you within 24 hours.</span>
          </div>

          <a href="#" class="result-sell-btn">
            Schedule Free Pickup
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </a>

          <a href="{{ route('sell.model.variants', [$brand->slug, $model->slug]) }}"
             class="result-recalc-btn">
            ← Recalculate Price
          </a>
        </div>
      </div>
    </div>

  </div>

</div>

<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>