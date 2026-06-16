{{-- resources/views/sell/laptop/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sell Old Laptop – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
.hero-banner {
  background: linear-gradient(135deg, #1565c0 0%, #0288d1 100%);
  padding: 40px 20px; text-align: center; color: #fff;
}
.hero-banner h1 { font-family:'Nunito',sans-serif; font-size:32px; font-weight:900; margin-bottom:10px; }
.hero-banner p  { font-size:16px; opacity:.88; margin-bottom:24px; }
.hero-features  { display:flex; justify-content:center; gap:24px; flex-wrap:wrap; }
.hero-feat { display:flex; align-items:center; gap:7px; font-size:14px; font-weight:700;
             background:rgba(255,255,255,.15); padding:8px 16px; border-radius:50px; }
.sell-index-wrap { max-width:1300px; margin:0 auto; padding:36px 20px 60px; }
.sell-section-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
.sell-section-title  { font-family:'Nunito',sans-serif; font-size:22px; font-weight:800; color:#1a1a1a; }
.sell-brands-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:14px; margin-bottom:48px; }
.sell-brand-card {
  background:#fff; border:1.5px solid #ececec; border-radius:14px; padding:20px 12px 16px;
  text-align:center; cursor:pointer; transition:all .2s ease; text-decoration:none; display:block;
}
.sell-brand-card:hover { border-color:#1565c0; box-shadow:0 6px 24px rgba(21,101,192,.13); transform:translateY(-3px); }
.sell-brand-logo-wrap { height:65px; display:flex; align-items:center; justify-content:center; margin-bottom:10px; }
.sell-brand-logo-wrap img { max-height:60px; max-width:100%; object-fit:contain; }
.sell-brand-logo-placeholder {
  width:52px; height:52px; border-radius:50%;
  background:linear-gradient(135deg,#e3f2fd,#bbdefb);
  display:flex; align-items:center; justify-content:center;
  font-family:'Nunito',sans-serif; font-size:22px; font-weight:800; color:#1565c0;
}
.sell-brand-name  { font-size:13px; font-weight:700; color:#1a1a1a; }
.sell-brand-count { font-size:11px; color:#aaa; margin-top:3px; }
.how-it-works { background:#f4f9ff; border:1.5px solid #ddeeff; border-radius:20px; padding:32px 28px; margin-bottom:40px; }
.how-steps { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:20px; }
.how-step { text-align:center; }
.how-step-icon { width:56px; height:56px; border-radius:50%; background:linear-gradient(135deg,#1565c0,#0288d1);
                 display:flex; align-items:center; justify-content:center; margin:0 auto 12px; font-size:24px; }
.how-step-title { font-family:'Nunito',sans-serif; font-size:14px; font-weight:800; color:#1a1a1a; margin-bottom:6px; }
.how-step-desc  { font-size:12px; color:#888; line-height:1.5; }
@media(max-width:768px){
  .hero-banner h1{font-size:22px}
  .sell-brands-grid{grid-template-columns:repeat(3,1fr);gap:10px}
  .sell-brand-card{padding:14px 8px 12px}
  .sell-brand-logo-wrap{height:50px}
  .how-steps{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:400px){.sell-brands-grid{grid-template-columns:repeat(2,1fr)}}
</style>
</head>
<body>
@include('sell.partials.navbar')

<div class="hero-banner">
  <h1>Sell Your Old Laptop for Instant Cash</h1>
  <p>Best price guaranteed • Free doorstep pickup • Instant payment</p>
  <div class="hero-features">
    <div class="hero-feat"><svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Maximum Value</div>
    <div class="hero-feat"><svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Free Doorstep Pickup</div>
    <div class="hero-feat"><svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Instant Payment</div>
  </div>
</div>

<div class="sell-index-wrap">
  <div class="sell-section-header">
    <h2 class="sell-section-title">Sell Old Laptop</h2>
  </div>

  @if($brands->isEmpty())
    <div style="text-align:center;padding:60px 20px;color:#aaa;"><div style="font-size:48px;margin-bottom:12px;">💻</div><p>No brands available yet.</p></div>
  @else
    <div class="sell-brands-grid">
      @foreach($brands as $brand)
      <a class="sell-brand-card" href="{{ route('sell.laptop.brand.models', $brand->slug) }}">
        <div class="sell-brand-logo-wrap">
          @if($brand->logo)
            <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" loading="lazy">
          @else
            <div class="sell-brand-logo-placeholder">{{ strtoupper(substr($brand->name,0,1)) }}</div>
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

  <div class="how-it-works">
    <div class="sell-section-title">How It Works</div>
    <div class="how-steps">
      <div class="how-step"><div class="how-step-icon">💻</div><div class="how-step-title">Select Your Laptop</div><div class="how-step-desc">Choose your brand and model</div></div>
      <div class="how-step"><div class="how-step-icon">✅</div><div class="how-step-title">Get Best Price</div><div class="how-step-desc">Instant price for your device</div></div>
      <div class="how-step"><div class="how-step-icon">🚗</div><div class="how-step-title">Free Pickup</div><div class="how-step-desc">Pickup from your doorstep</div></div>
      <div class="how-step"><div class="how-step-icon">💰</div><div class="how-step-title">Instant Payment</div><div class="how-step-desc">Cash or bank transfer immediately</div></div>
    </div>
  </div>
</div>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>