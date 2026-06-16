{{-- resources/views/sell/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sell Old Mobile Phone – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
/* ══ INDEX PAGE STYLES ══ */
* { box-sizing: border-box; margin: 0; padding: 0; }

/* ── Hero Banner ── */
.hero-banner {
  background: linear-gradient(135deg, #00c853 0%, #00897b 100%);
  padding: 40px 20px;
  text-align: center;
  color: #fff;
}
.hero-banner h1 {
  font-family: 'Nunito', sans-serif;
  font-size: 32px;
  font-weight: 900;
  margin-bottom: 10px;
}
.hero-banner p {
  font-family: 'Nunito Sans', sans-serif;
  font-size: 16px;
  opacity: .88;
  margin-bottom: 24px;
}
.hero-features {
  display: flex;
  justify-content: center;
  gap: 24px;
  flex-wrap: wrap;
}
.hero-feat {
  display: flex;
  align-items: center;
  gap: 7px;
  font-family: 'Nunito Sans', sans-serif;
  font-size: 14px;
  font-weight: 700;
  background: rgba(255,255,255,.15);
  padding: 8px 16px;
  border-radius: 50px;
}
.hero-feat svg { flex-shrink: 0; }

/* ── Page Wrap ── */
.sell-index-wrap {
  max-width: 1300px;
  margin: 0 auto;
  padding: 36px 20px 60px;
}

/* ── Section Header ── */
.sell-section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
.sell-section-title {
  font-family: 'Nunito', sans-serif;
  font-size: 22px;
  font-weight: 800;
  color: #1a1a1a;
}
.sell-view-all {
  font-size: 13px;
  font-weight: 700;
  color: #00c853;
  text-decoration: none;
}
.sell-view-all:hover { text-decoration: underline; }

/* ── Brands Grid ── */
.sell-brands-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 14px;
  margin-bottom: 48px;
}
.sell-brand-card {
  background: #fff;
  border: 1.5px solid #ececec;
  border-radius: 14px;
  padding: 20px 12px 16px;
  text-align: center;
  cursor: pointer;
  transition: all .2s ease;
  text-decoration: none;
  display: block;
}
.sell-brand-card:hover {
  border-color: #00c853;
  box-shadow: 0 6px 24px rgba(0,200,83,.13);
  transform: translateY(-3px);
}
.sell-brand-logo-wrap {
  height: 65px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 10px;
}
.sell-brand-logo-wrap img {
  max-height: 60px;
  max-width: 100%;
  object-fit: contain;
}
.sell-brand-logo-placeholder {
  width: 52px; height: 52px;
  border-radius: 50%;
  background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Nunito', sans-serif;
  font-size: 22px;
  font-weight: 800;
  color: #00c853;
}
.sell-brand-name {
  font-family: 'Nunito Sans', sans-serif;
  font-size: 13px;
  font-weight: 700;
  color: #1a1a1a;
}
.sell-brand-count {
  font-size: 11px;
  color: #aaa;
  margin-top: 3px;
}

/* ── How It Works ── */
.how-it-works {
  background: #f9fffe;
  border: 1.5px solid #e0f5ec;
  border-radius: 20px;
  padding: 32px 28px;
  margin-bottom: 40px;
}
.how-it-works .sell-section-title { margin-bottom: 24px; }
.how-steps {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 20px;
}
.how-step {
  text-align: center;
}
.how-step-icon {
  width: 56px; height: 56px;
  border-radius: 50%;
  background: linear-gradient(135deg, #00c853, #00a846);
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 12px;
  font-size: 24px;
}
.how-step-title {
  font-family: 'Nunito', sans-serif;
  font-size: 14px;
  font-weight: 800;
  color: #1a1a1a;
  margin-bottom: 6px;
}
.how-step-desc {
  font-family: 'Nunito Sans', sans-serif;
  font-size: 12px;
  color: #888;
  line-height: 1.5;
}

/* ── Empty state ── */
.sell-empty {
  text-align: center;
  padding: 60px 20px;
  color: #aaa;
}

/* ── Mobile ── */
@media (max-width: 768px) {
  .hero-banner h1 { font-size: 22px; }
  .hero-banner p  { font-size: 14px; }
  .sell-brands-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; }
  .sell-brand-card { padding: 14px 8px 12px; }
  .sell-brand-logo-wrap { height: 50px; }
  .sell-brand-logo-wrap img { max-height: 46px; }
  .sell-brand-name { font-size: 11px; }
  .how-steps { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 400px) {
  .sell-brands-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

{{-- Hero Banner --}}
<div class="hero-banner">
  <h1>Sell Your Old Phone for Instant Cash</h1>
  <p>Best price guaranteed • Free doorstep pickup • Instant payment</p>
  <div class="hero-features">
    <div class="hero-feat">
      <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="20 6 9 17 4 12"/>
      </svg>
      Maximum Value
    </div>
    <div class="hero-feat">
      <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="20 6 9 17 4 12"/>
      </svg>
      Free Doorstep Pickup
    </div>
    <div class="hero-feat">
      <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="20 6 9 17 4 12"/>
      </svg>
      Instant Payment
    </div>
  </div>
</div>

{{-- Main Content --}}
<div class="sell-index-wrap">

  {{-- Sell Old Mobile Phone — Brands --}}
  <div class="sell-section-header">
    <h2 class="sell-section-title">Sell Old Mobile Phone</h2>
  </div>

  @if($brands->isEmpty())
    <div class="sell-empty">
      <div style="font-size:48px;margin-bottom:12px;">📱</div>
      <p>No brands available yet.</p>
    </div>
  @else
    <div class="sell-brands-grid">
      @foreach($brands as $brand)
      <a class="sell-brand-card"
         href="{{ route('sell.brand.models', $brand->slug) }}">
        <div class="sell-brand-logo-wrap">
          @if($brand->logo)
            <img src="{{ asset('storage/'.$brand->logo) }}"
                 alt="{{ $brand->name }}" loading="lazy">
          @else
            <div class="sell-brand-logo-placeholder">
              {{ strtoupper(substr($brand->name, 0, 1)) }}
            </div>
          @endif
        </div>
        <div class="sell-brand-name">{{ $brand->name }}</div>
        @if($brand->models_count > 0)
          <div class="sell-brand-count">{{ $brand->models_count }} models</div>
        @endif
      </a>
      @endforeach
    </div>
  @endif

  {{-- How It Works --}}
  <div class="how-it-works">
    <div class="sell-section-title">How It Works</div>
    <div class="how-steps">
      <div class="how-step">
        <div class="how-step-icon">📱</div>
        <div class="how-step-title">Select Your Phone</div>
        <div class="how-step-desc">Choose your brand, model and variant</div>
      </div>
      <div class="how-step">
        <div class="how-step-icon">✅</div>
        <div class="how-step-title">Get Best Price</div>
        <div class="how-step-desc">Instant price based on your device condition</div>
      </div>
      <div class="how-step">
        <div class="how-step-icon">🚗</div>
        <div class="how-step-title">Free Pickup</div>
        <div class="how-step-desc">Our executive picks up from your doorstep</div>
      </div>
      <div class="how-step">
        <div class="how-step-icon">💰</div>
        <div class="how-step-title">Instant Payment</div>
        <div class="how-step-desc">Get cash or bank transfer immediately</div>
      </div>
    </div>
  </div>

</div>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
