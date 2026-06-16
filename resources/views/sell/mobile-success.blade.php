{{-- resources/views/sell/mobile-success.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Evaluation Success – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #f7f8fa; font-family: 'Nunito Sans', sans-serif; min-height: 100vh; }

.success-wrap { max-width: 760px; margin: 0 auto; padding: 48px 20px 80px; }

/* ── Confetti header ── */
.success-hero { text-align: center; margin-bottom: 40px; }
.success-icon-ring {
  width: 96px; height: 96px; border-radius: 50%;
  background: linear-gradient(135deg,#00c853,#00897b);
  display: inline-flex; align-items: center; justify-content: center;
  box-shadow: 0 8px 32px rgba(0,200,83,.35);
  margin-bottom: 20px;
  animation: popIn .6s cubic-bezier(.34,1.5,.64,1) forwards;
}
@keyframes popIn {
  0%   { transform: scale(0); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}
.success-hero h1 {
  font-family: 'Nunito', sans-serif; font-size: 28px; font-weight: 900;
  color: #1a1a1a; margin-bottom: 8px;
}
.success-hero p { font-size: 15px; color: #666; }

/* ── Cards ── */
.card {
  background: #fff; border-radius: 18px; border: 1.5px solid #ebebeb;
  overflow: hidden; margin-bottom: 20px;
}
.card-header {
  padding: 18px 24px; border-bottom: 1px solid #f0f0f0;
  font-family: 'Nunito', sans-serif; font-size: 15px; font-weight: 800; color: #1a1a1a;
  display: flex; align-items: center; gap: 10px;
}
.card-body { padding: 20px 24px; }

/* ── Device row ── */
.device-row { display: flex; align-items: center; gap: 20px; }
.device-img-box {
  width: 80px; height: 90px; background: #f5f5f5; border-radius: 12px;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden;
}
.device-img-box img { max-height: 80px; max-width: 72px; object-fit: contain; }
.device-name { font-family: 'Nunito', sans-serif; font-size: 18px; font-weight: 900; color: #1a1a1a; margin-bottom: 4px; }
.device-variant { font-size: 12px; color: #00c853; font-weight: 700; background: #f0fff5; border: 1px solid #c8f5d9; border-radius: 6px; display: inline-block; padding: 2px 8px; margin-bottom: 8px; }
.device-brand { font-size: 13px; color: #888; font-weight: 600; }

/* ── Price highlight ── */
.price-highlight {
  background: linear-gradient(135deg,#f0fff5,#e8f5e9);
  border: 2px solid #c8f5d9; border-radius: 14px;
  padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;
  margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
}
.price-label { font-size: 13px; color: #555; font-weight: 600; margin-bottom: 4px; }
.price-amount {
  font-family: 'Nunito', sans-serif; font-size: 36px; font-weight: 900; color: #00a846;
  display: flex; align-items: baseline; gap: 4px;
}
.price-amount .rs { font-size: 22px; }
.price-badge {
  background: #00c853; color: #fff; border-radius: 30px;
  padding: 10px 22px; font-family: 'Nunito', sans-serif; font-size: 14px; font-weight: 800;
  text-decoration: none; transition: background .2s;
}
.price-badge:hover { background: #00a846; }

/* ── Detail grid ── */
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.detail-item { background: #fafafa; border-radius: 10px; padding: 12px 16px; }
.detail-item-label { font-size: 11px; color: #bbb; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px; }
.detail-item-val { font-size: 14px; font-weight: 700; color: #1a1a1a; }

/* ── Eval summary ── */
.eval-row { display: flex; align-items: flex-start; gap: 8px; font-size: 13px; font-weight: 600; color: #555; padding: 7px 0; border-bottom: 1px solid #f5f5f5; }
.eval-row:last-child { border-bottom: none; }
.tag-yes { color: #00a846; }
.tag-no  { color: #e53935; }
.tag-warn { color: #f57c00; }

/* ── Steps ── */
.next-steps { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
.step-box { text-align: center; padding: 20px 12px; background: #fafafa; border-radius: 14px; border: 1px solid #f0f0f0; }
.step-box .step-icon { font-size: 32px; margin-bottom: 10px; }
.step-box h4 { font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px; }
.step-box p { font-size: 11px; color: #888; line-height: 1.5; }

/* ── Actions ── */
.action-row { display: flex; gap: 14px; flex-wrap: wrap; margin-top: 28px; justify-content: center; }
.btn-primary {
  padding: 14px 36px; background: linear-gradient(135deg,#00c853,#00a846); color: #fff;
  border: none; border-radius: 50px; font-family: 'Nunito', sans-serif;
  font-size: 15px; font-weight: 800; cursor: pointer; text-decoration: none;
  display: inline-flex; align-items: center; gap: 8px; transition: all .2s;
}
.btn-primary:hover { background: linear-gradient(135deg,#00a846,#008f3a); box-shadow: 0 8px 24px rgba(0,200,83,.3); transform: translateY(-1px); }
.btn-outline {
  padding: 14px 36px; background: #fff; color: #333; border: 2px solid #e0e0e0;
  border-radius: 50px; font-family: 'Nunito', sans-serif; font-size: 15px; font-weight: 800;
  cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all .2s;
}
.btn-outline:hover { border-color: #00c853; color: #00a846; }

.ref-badge { display: inline-block; background: #f5f5f5; border-radius: 8px; padding: 4px 12px; font-size: 12px; font-weight: 700; color: #555; margin-top: 4px; }

@media (max-width: 600px) {
  .detail-grid { grid-template-columns: 1fr; }
  .next-steps  { grid-template-columns: 1fr; }
  .device-row  { flex-direction: column; text-align: center; }
  .price-highlight { flex-direction: column; align-items: flex-start; }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

<div class="success-wrap">

  {{-- Hero --}}
  <div class="success-hero">
    <div class="success-icon-ring">
      <svg width="44" height="44" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
        <polyline points="20 6 9 17 4 12"/>
      </svg>
    </div>
    <h1>🎉 Evaluation Complete!</h1>
    <p>Hi <strong>{{ $name }}</strong>, your device has been evaluated successfully.</p>
    @if(!empty($evaluation_id))
      <div class="ref-badge">Reference ID: #{{ str_pad($evaluation_id, 6, '0', STR_PAD_LEFT) }}</div>
    @endif
  </div>

  {{-- Device + Price --}}
  <div class="card">
    <div class="card-header">
      <svg width="18" height="18" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24">
        <rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12" y2="18"/>
      </svg>
      Device Information
    </div>
    <div class="card-body">
      <div class="device-row">
        <div class="device-img-box">
          @if(!empty($model_image))
            <img src="{{ asset('storage/'.$model_image) }}" alt="{{ $model }}">
          @else
            <div style="font-size:36px;opacity:.3;">📱</div>
          @endif
        </div>
        <div>
          <div class="device-name">{{ $model }}</div>
          <div class="device-variant">{{ $variant }}</div>
          <div class="device-brand">{{ $brand }}</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Price highlight --}}
  <div class="price-highlight">
    <div>
      <div class="price-label">Your Selling Price</div>
      <div class="price-amount">
        <span class="rs">₹</span>
        <span>{{ number_format($price, 0) }}</span>
      </div>
    </div>
    <a href="{{ route('sell.index') }}" class="price-badge">Sell Another Device →</a>
  </div>

  {{-- Customer details --}}
  <div class="card">
    <div class="card-header">
      <svg width="18" height="18" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
      </svg>
      Your Details
    </div>
    <div class="card-body">
      <div class="detail-grid">
        <div class="detail-item">
          <div class="detail-item-label">Name</div>
          <div class="detail-item-val">{{ $name }}</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Mobile</div>
          <div class="detail-item-val">+91 {{ $mobile }}</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Device</div>
          <div class="detail-item-val">{{ $brand }} {{ $model }}</div>
        </div>
        <div class="detail-item">
          <div class="detail-item-label">Variant</div>
          <div class="detail-item-val">{{ $variant }}</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Evaluation summary --}}
  <div class="card">
    <div class="card-header">
      <svg width="18" height="18" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
      </svg>
      Evaluation Summary
    </div>
    <div class="card-body">

      {{-- Defects --}}
      @if(!empty($defects) && count($defects) > 0)
        @php $defectModels = \App\Models\VariantDefect::whereIn('id', $defects)->get(); @endphp
        @if($defectModels->count())
        <div style="margin-bottom:10px;">
          <div style="font-size:11px;color:#bbb;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Defects Reported</div>
          @foreach($defectModels as $d)
          <div class="eval-row">
            <svg width="14" height="14" fill="none" stroke="#e53935" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
              <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><circle cx="12" cy="16" r="1" fill="#e53935"/>
            </svg>
            <span class="tag-no">{{ $d->description }}</span>
          </div>
          @endforeach
        </div>
        @endif
      @else
        <div class="eval-row">
          <svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0"><polyline points="20 6 9 17 4 12"/></svg>
          <span class="tag-yes">No defects</span>
        </div>
      @endif

      {{-- Problems --}}
      @if(!empty($problems) && count($problems) > 0)
        @php $problemModels = \App\Models\VariantProblem::whereIn('id', $problems)->get(); @endphp
        @if($problemModels->count())
        <div style="margin-bottom:10px;">
          <div style="font-size:11px;color:#bbb;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;margin-top:14px;">Problems Reported</div>
          @foreach($problemModels as $p)
          <div class="eval-row">
            <svg width="14" height="14" fill="none" stroke="#f57c00" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
              <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            </svg>
            <span class="tag-warn">{{ $p->description }}</span>
          </div>
          @endforeach
        </div>
        @endif
      @else
        <div class="eval-row">
          <svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0"><polyline points="20 6 9 17 4 12"/></svg>
          <span class="tag-yes">No functional problems</span>
        </div>
      @endif

      {{-- Accessories --}}
      <div style="margin-top:14px;">
        <div style="font-size:11px;color:#bbb;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Accessories</div>
        @if(!empty($accessories) && count($accessories) > 0)
          @php $accModels = \App\Models\VariantAccessory::whereIn('id', $accessories)->get(); @endphp
          @foreach($accModels as $a)
          <div class="eval-row">
            <svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0"><polyline points="20 6 9 17 4 12"/></svg>
            <span class="tag-yes">{{ $a->description }}</span>
          </div>
          @endforeach
        @else
          <div class="eval-row">
            <svg width="14" height="14" fill="none" stroke="#888" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            <span style="color:#888;font-weight:600;">None of the above</span>
          </div>
        @endif
      </div>

    </div>
  </div>

  {{-- What's next --}}
  <div class="card">
    <div class="card-header">
      <svg width="18" height="18" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><circle cx="12" cy="16" r="1" fill="#00c853"/>
      </svg>
      What happens next?
    </div>
    <div class="card-body">
      <div class="next-steps">
        <div class="step-box">
          <div class="step-icon">📞</div>
          <h4>Our team calls you</h4>
          <p>We will contact you within 24 hours to confirm pickup details.</p>
        </div>
        <div class="step-box">
          <div class="step-icon">🚗</div>
          <h4>Free Doorstep Pickup</h4>
          <p>Our agent comes to your location at a time convenient to you.</p>
        </div>
        <div class="step-box">
          <div class="step-icon">💰</div>
          <h4>Instant Payment</h4>
          <p>Get paid on the spot — cash or bank transfer as you prefer.</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Actions --}}
  <div class="action-row">
    <a href="{{ route('sell.index') }}" class="btn-primary">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
      </svg>
      Sell Another Device
    </a>
    <a href="{{ route('sell.phone') }}" class="btn-outline">
      Browse More Phones
    </a>
  </div>

</div>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>