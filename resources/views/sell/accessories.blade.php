{{-- resources/views/sell/accessories.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accessories – {{ $model->name }} – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #f7f8fa; font-family: 'Nunito Sans', sans-serif; }
.eval-page-wrap { max-width: 1100px; margin: 0 auto; padding: 28px 20px 80px; }

.sell-breadcrumb { display:flex;align-items:center;gap:6px;font-size:13px;color:#888;margin-bottom:28px;flex-wrap:wrap; }
.sell-breadcrumb a { color:#888;text-decoration:none; }
.sell-breadcrumb a:hover { color:#00c853; }
.sell-breadcrumb .sep { color:#ccc; }
.sell-breadcrumb .active { color:#333;font-weight:600; }

.eval-layout { display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start; }

.eval-questions-panel { background:#fff;border-radius:16px;border:1.5px solid #ebebeb;overflow:hidden; }
.eval-questions-header { padding:24px 28px 20px;border-bottom:1.5px solid #f0f0f0; }
.eval-questions-header h2 { font-family:'Nunito',sans-serif;font-size:20px;font-weight:800;color:#1a1a1a;margin-bottom:4px; }
.eval-questions-header p { font-size:13px;color:#888; }

.accessories-grid { display:grid;grid-template-columns:repeat(4,1fr);gap:16px;padding:24px 28px; }

.acc-card { border:2px solid #e0e0e0;border-radius:14px;overflow:hidden;cursor:pointer;transition:all .2s ease;position:relative;background:#fff;user-select:none; }
.acc-card:hover { border-color:#00c853;box-shadow:0 4px 16px rgba(0,200,83,.12);transform:translateY(-2px); }
.acc-card.selected { border-color:#00c853;background:#f0fff5;box-shadow:0 4px 16px rgba(0,200,83,.18); }
.acc-check { position:absolute;top:8px;right:8px;width:22px;height:22px;background:#e0e0e0;border-radius:50%;display:flex;align-items:center;justify-content:center;transition:all .2s; }
.acc-card.selected .acc-check { background:#00c853; }
.acc-check svg { display:none; }
.acc-card.selected .acc-check svg { display:block; }
.acc-img-wrap { width:100%;aspect-ratio:1;background:#f8f8f8;display:flex;align-items:center;justify-content:center;overflow:hidden; }
.acc-img-wrap img { width:100%;height:100%;object-fit:cover; }
.acc-desc { padding:10px 12px 4px;font-size:13px;font-weight:600;color:#333;text-align:center;line-height:1.4; }
.acc-small-desc { padding:0 12px 10px;font-size:11px;color:#888;text-align:center;line-height:1.3; }

.no-acc-option { margin:0 28px 24px; }
.no-acc-label { display:flex;align-items:center;gap:10px;border:2px solid #e0e0e0;border-radius:12px;padding:14px 20px;cursor:pointer;transition:all .18s;font-size:14px;font-weight:600;color:#555; }
.no-acc-label:hover { border-color:#00c853;background:#f0fff5; }
.no-acc-label.selected { border-color:#00c853;background:#f0fff5;color:#00a846; }
.no-acc-label input { accent-color:#00c853;width:18px;height:18px; }

.eval-continue-wrap { padding:0 28px 28px; }
.eval-continue-btn { display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:15px 40px;background:linear-gradient(135deg,#00c853,#00a846);color:#fff;border:none;border-radius:50px;font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;cursor:pointer;transition:all .2s; }
.eval-continue-btn:hover { background:linear-gradient(135deg,#00a846,#008f3a);box-shadow:0 8px 24px rgba(0,200,83,.3);transform:translateY(-1px); }
.eval-continue-btn:disabled { background:#e0e0e0;color:#aaa;cursor:not-allowed;box-shadow:none;transform:none; }

/* Logged-in banner */
.logged-in-banner { display:flex;align-items:center;gap:10px;background:#f0fff5;border:1.5px solid #c8f5d9;border-radius:12px;padding:12px 18px;margin:0 28px 20px;font-size:13px;font-weight:600;color:#00a846; }
.logged-in-banner svg { flex-shrink:0; }

/* Sidebar */
.eval-sidebar { position:sticky;top:80px; }
.eval-device-card { background:#fff;border-radius:16px;border:1.5px solid #ebebeb;padding:20px;margin-bottom:16px; }
.eval-device-row { display:flex;align-items:center;gap:14px; }
.eval-device-img-wrap { width:70px;height:80px;background:#f5f5f5;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden; }
.eval-device-img-wrap img { max-height:72px;max-width:64px;object-fit:contain; }
.eval-device-info h3 { font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;color:#1a1a1a;margin-bottom:4px; }
.eval-device-variant { font-size:12px;color:#00c853;font-weight:700;background:#f0fff5;border:1px solid #c8f5d9;border-radius:6px;display:inline-block;padding:2px 8px;margin-bottom:6px; }
.eval-device-base-price { font-size:12px;color:#888; }
.eval-device-base-price strong { color:#1a1a1a;font-weight:700; }

/* Price blur/lock styles */
.price-locked { filter:blur(6px);user-select:none;pointer-events:none;transition:filter .4s ease; }
.price-unlocked { filter:blur(0);transition:filter .4s ease; }

.price-lock-badge {
    display:inline-flex;align-items:center;gap:6px;
    background:#fff8e1;border:1px solid #ffe082;border-radius:8px;
    padding:5px 12px;font-size:12px;font-weight:700;color:#f57c00;
    margin-top:6px;
}
.price-lock-badge svg { flex-shrink:0; }

.eval-summary-card { background:#fff;border-radius:16px;border:1.5px solid #ebebeb;overflow:hidden; }
.eval-summary-header { padding:16px 20px;border-bottom:1px solid #f0f0f0;font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;color:#1a1a1a; }
.eval-summary-body { padding:16px 20px; }
.eval-summary-section-lbl { font-size:11px;font-weight:700;color:#bbb;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;margin-top:14px; }
.eval-summary-section-lbl:first-child { margin-top:0; }
.eval-summary-item { display:flex;align-items:flex-start;gap:8px;font-size:13px;color:#555;margin-bottom:6px;font-weight:500; }
.eval-summary-sub-item { display:flex;align-items:flex-start;gap:8px;font-size:12px;color:#555;margin-bottom:4px;font-weight:500;padding-left:20px; }

/* MODAL OVERLAY */
.modal-overlay { position:fixed;inset:0;background:rgba(0,0,0,.55);backdrop-filter:blur(3px);z-index:9999;display:none;align-items:center;justify-content:center;padding:16px; }
.modal-overlay.show { display:flex;animation:fadeOv .2s ease; }
@keyframes fadeOv { from{opacity:0} to{opacity:1} }

.cashify-modal { background:#fff;border-radius:20px;max-width:720px;width:100%;overflow:hidden;display:flex;box-shadow:0 32px 80px rgba(0,0,0,.28);animation:slideM .32s cubic-bezier(.34,1.4,.64,1);position:relative; }
@keyframes slideM { from{transform:translateY(60px) scale(.95);opacity:0} to{transform:translateY(0) scale(1);opacity:1} }

.modal-close-btn { position:absolute;top:14px;right:14px;width:32px;height:32px;border-radius:50%;background:rgba(0,0,0,.08);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:10;transition:background .2s; }
.modal-close-btn:hover { background:rgba(0,0,0,.18); }

.modal-left { width:240px;flex-shrink:0;background:linear-gradient(160deg,#00c853 0%,#00897b 100%);display:flex;flex-direction:column;align-items:center;justify-content:space-between;padding:28px 16px 0;overflow:hidden;position:relative; }
.modal-left-title { font-family:'Nunito',sans-serif;font-size:24px;font-weight:900;color:#fff;text-align:center;line-height:1.2; }

.modal-right { flex:1;padding:28px 28px 24px;display:flex;flex-direction:column;gap:16px; }

.modal-device-card { background:#f8f9fa;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:14px; }
.modal-device-img { width:56px;height:64px;background:#fff;border-radius:10px;border:1px solid #eee;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden; }
.modal-device-img img { max-height:58px;max-width:50px;object-fit:contain; }
.modal-device-name { font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;color:#1a1a1a;margin-bottom:2px; }
.modal-device-price-label { font-size:11px;color:#888;font-weight:500;margin-bottom:2px; }

.modal-device-price-val { font-family:'Nunito',sans-serif;font-size:26px;font-weight:900;color:#e53935;display:flex;align-items:baseline;gap:3px;transition:all .4s; }
.modal-device-price-val .rupee { font-size:18px; }
.modal-price-locked-badge {
    display:flex;align-items:center;gap:6px;
    font-family:'Nunito',sans-serif;font-size:22px;font-weight:900;
    color:#bbb;letter-spacing:2px;
}
.modal-price-locked-badge .lock-icon { font-size:18px; }

.modal-unlock { display:flex;align-items:center;gap:8px;background:#f0fff5;border:1px solid #c8f5d9;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;color:#00a846; }

.modal-input-group { display:flex;flex-direction:column;gap:6px; }
.modal-input-label { font-size:13px;font-weight:600;color:#555; }
.modal-input-wrap { display:flex;align-items:center;border-bottom:2px solid #e0e0e0;padding-bottom:6px;transition:border-color .2s; }
.modal-input-wrap:focus-within { border-color:#00c853; }
.modal-phone-prefix { font-size:15px;font-weight:700;color:#555;padding-right:10px;border-right:1px solid #ddd;margin-right:10px;flex-shrink:0; }
.modal-field { flex:1;border:none;outline:none;font-size:15px;font-weight:600;color:#1a1a1a;background:transparent;font-family:'Nunito Sans',sans-serif; }
.modal-field::placeholder { color:#bbb;font-weight:400; }

.modal-step { display:none; }
.modal-step.active { display:flex;flex-direction:column;gap:16px; }

.otp-header { display:flex;align-items:center;gap:10px; }
.otp-back-btn { width:30px;height:30px;border-radius:50%;background:#f5f5f5;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .2s; }
.otp-back-btn:hover { background:#e0e0e0; }
.otp-header-text h3 { font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;color:#1a1a1a; }
.otp-header-text p { font-size:12px;color:#888;margin-top:2px; }

.otp-boxes { display:flex;gap:10px;justify-content:center;margin:4px 0; }
.otp-box { width:48px;height:52px;border:2px solid #e0e0e0;border-radius:10px;font-family:'Nunito',sans-serif;font-size:22px;font-weight:800;color:#1a1a1a;text-align:center;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff; }
.otp-box:focus { border-color:#00c853;box-shadow:0 0 0 3px rgba(0,200,83,.15); }
.otp-box.filled { border-color:#00c853; }
.otp-box.error { border-color:#f44336;box-shadow:0 0 0 3px rgba(244,67,54,.12); }

.resend-row { display:flex;justify-content:space-between;align-items:center;font-size:12px;color:#888; }
.resend-btn { background:none;border:none;cursor:pointer;font-size:12px;font-weight:700;color:#00c853;font-family:'Nunito Sans',sans-serif;padding:0; }
.resend-btn:disabled { color:#bbb;cursor:not-allowed; }

.modal-msg { font-size:12px;font-weight:600;padding:8px 12px;border-radius:8px;display:none; }
.modal-msg.error { background:#fff5f5;color:#e53935;border:1px solid #ffcdd2;display:block; }
.modal-msg.success { background:#f0fff5;color:#00a846;border:1px solid #c8f5d9;display:block; }

.modal-terms { display:flex;align-items:flex-start;gap:8px;font-size:12px;color:#777;line-height:1.5; }
.modal-terms input { margin-top:2px;accent-color:#00c853;width:15px;height:15px;flex-shrink:0;cursor:pointer; }
.modal-terms a { color:#00c853;font-weight:600;text-decoration:none; }
.modal-terms a:hover { text-decoration:underline; }

.modal-action-btn { width:100%;padding:15px;background:#e0e0e0;color:#aaa;border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;cursor:not-allowed;letter-spacing:.8px;transition:all .25s;text-transform:uppercase;display:flex;align-items:center;justify-content:center;gap:8px; }
.modal-action-btn.ready { background:linear-gradient(135deg,#00c853,#00a846);color:#fff;cursor:pointer;box-shadow:0 6px 20px rgba(0,200,83,.3); }
.modal-action-btn.ready:hover { background:linear-gradient(135deg,#00a846,#008f3a);transform:translateY(-1px); }
.modal-action-btn .spinner { width:16px;height:16px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none; }
.modal-action-btn.loading .spinner { display:block; }
.modal-action-btn.loading .btn-label { display:none; }
@keyframes spin { to { transform:rotate(360deg); } }

@keyframes priceReveal {
    0%   { transform:scale(1.3);opacity:0; }
    60%  { transform:scale(0.95); }
    100% { transform:scale(1);opacity:1; }
}
.price-reveal { animation:priceReveal .5s cubic-bezier(.34,1.4,.64,1) forwards; }

/* Submitting overlay */
.submit-overlay { position:fixed;inset:0;background:rgba(255,255,255,.85);backdrop-filter:blur(4px);z-index:99999;display:none;align-items:center;justify-content:center;flex-direction:column;gap:16px; }
.submit-overlay.show { display:flex; }
.submit-spinner { width:48px;height:48px;border:4px solid #e0e0e0;border-top-color:#00c853;border-radius:50%;animation:spin .8s linear infinite; }
.submit-overlay p { font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;color:#333; }

@media (max-width:900px) {
  .eval-layout { grid-template-columns:1fr; }
  .eval-sidebar { position:static;order:-1; }
  .accessories-grid { grid-template-columns:repeat(2,1fr);padding:18px 20px; }
  .eval-questions-header,.eval-continue-wrap { padding-left:20px;padding-right:20px; }
  .no-acc-option { margin-left:20px;margin-right:20px; }
  .logged-in-banner { margin-left:20px;margin-right:20px; }
}
@media (max-width:600px) {
  .cashify-modal { flex-direction:column; }
  .modal-left { width:100%;min-height:120px;flex-direction:row;padding:16px 20px;justify-content:space-between; }
  .modal-left-title { font-size:18px; }
  .otp-box { width:42px;height:46px;font-size:20px; }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

{{-- Submitting overlay --}}
<div class="submit-overlay" id="submitOverlay">
  <div class="submit-spinner"></div>
  <p>Saving your evaluation…</p>
</div>

<div class="eval-page-wrap">

  <div class="sell-breadcrumb">
    <a href="{{ route('sell.index') }}">Home</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.phone') }}">Sell Old Mobile Phone</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.brand.models', $brand->slug) }}">{{ $brand->name }}</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a>
    <span class="sep">›</span>
    <span class="active">Accessories</span>
  </div>

  <div class="eval-layout">

    {{-- MAIN PANEL --}}
    <div>
      <div class="eval-questions-panel">
        <div class="eval-questions-header">
          <h2>Do you have the following?</h2>
          <p>Please select accessories which are available with your device.</p>
        </div>

        {{-- ✅ Show logged-in banner if already logged in --}}
        @if(session('customer'))
        <div class="logged-in-banner">
          <svg width="16" height="16" fill="none" stroke="#00a846" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="20 6 9 17 4 12"/>
          </svg>
          Logged in as <strong>{{ session('customer.name') }}</strong> ({{ session('customer.mobile') }}) &nbsp;—&nbsp; Price will be revealed on next page
        </div>
        @endif

        @if($accessories->isNotEmpty())
        <div class="accessories-grid">
          @foreach($accessories as $acc)
          <div class="acc-card" id="acc-card-{{ $acc->id }}"
               onclick="toggleAccessory({{ $acc->id }}, '{{ addslashes($acc->description) }}')">
            <div class="acc-check">
              <svg width="12" height="12" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
            </div>
            <div class="acc-img-wrap">
              <img src="{{ asset('storage/' . $acc->image) }}" alt="{{ $acc->description }}">
            </div>
            <div class="acc-desc">{{ $acc->description }}</div>
            @if($acc->small_description)
              <div class="acc-small-desc">{{ $acc->small_description }}</div>
            @endif
          </div>
          @endforeach
        </div>
        @else
        <div style="text-align:center;padding:40px 20px;color:#aaa;">
          <div style="font-size:40px;margin-bottom:10px;">📦</div>
          <p>No accessories configured.</p>
        </div>
        @endif

        <div class="no-acc-option">
          <label class="no-acc-label" id="noAccLabel">
            <input type="radio" name="no_accessories" id="noAccRadio" value="1"
                   onchange="selectNoAccessories(this)">
            None of the above
          </label>
        </div>

        <div class="eval-continue-wrap">
          <button type="button" class="eval-continue-btn" id="accContinueBtn"
                  disabled onclick="handleContinue()">
            Continue
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <line x1="5" y1="12" x2="19" y2="12"/>
              <polyline points="12 5 19 12 12 19"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    {{-- SIDEBAR --}}
    <div class="eval-sidebar">

      <div class="eval-device-card">
        <div class="eval-device-row">
          <div class="eval-device-img-wrap">
            @if($model->image)
              <img src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
            @else
              <div style="font-size:32px;opacity:.3;">📱</div>
            @endif
          </div>
          <div class="eval-device-info">
            <h3>{{ $model->name }}</h3>
            <div class="eval-device-variant">{{ $variant->memory }}</div>
            <div class="eval-device-base-price">
              Evaluation Price:
              @if(session('customer'))
                {{-- Already logged in: show price directly --}}
                <strong id="sidebarPriceDisplay" class="price-unlocked">
                  ₹{{ number_format($evaluationPrice, 0) }}
                </strong>
              @else
                <strong id="sidebarPriceDisplay" class="price-locked">
                  ₹{{ number_format($evaluationPrice, 0) }}
                </strong>
              @endif
            </div>
            @if(!session('customer'))
            <div class="price-lock-badge" id="sidebarLockBadge">
              <svg width="12" height="12" fill="none" stroke="#f57c00" stroke-width="2.5" viewBox="0 0 24 24">
                <rect x="3" y="11" width="18" height="11" rx="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
              Login to unlock price
            </div>
            @endif
          </div>
        </div>
      </div>

      <div class="eval-summary-card">
        <div class="eval-summary-header">Device Evaluation</div>
        <div class="eval-summary-body">

          @if(!empty($savedAnswers))
          <div class="eval-summary-section-lbl">Device Details</div>
          @foreach($evalQuestions as $q)
            @if(isset($savedAnswers[$q->id]))
              @php $ans = $savedAnswers[$q->id]; @endphp
              <div class="eval-summary-item">
                @if($ans === 'yes')
                  <svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><polyline points="20 6 9 17 4 12"/></svg>
                  <span style="color:#00c853;font-weight:600;">{{ $q->yes_answer }}</span>
                @else
                  <svg width="14" height="14" fill="none" stroke="#f44336" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                  <span style="color:#f44336;font-weight:600;">{{ $q->no_answer }}</span>
                @endif
              </div>
            @endif
          @endforeach
          @endif

          @if(isset($selectedDefects) && $selectedDefects->isNotEmpty())
          <div class="eval-summary-section-lbl">Defects</div>
          @foreach($selectedDefects as $def)
            <div class="eval-summary-item">
              <svg width="14" height="14" fill="none" stroke="#f44336" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
              </svg>
              <span style="color:#f44336;font-weight:600;">{{ $def->description }}</span>
            </div>
            @if(isset($sectionAnswers[$def->id]) && !empty($sectionAnswers[$def->id]))
              @foreach($sectionAnswers[$def->id] as $sectionId => $imageId)
                @php $img = \App\Models\DefectSectionImage::find($imageId); @endphp
                @if($img)
                  <div class="eval-summary-sub-item">
                    <svg width="12" height="12" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><polyline points="20 6 9 17 4 12"/></svg>
                    <span style="color:#00c853;font-weight:600;">{{ $img->description }}</span>
                  </div>
                @endif
              @endforeach
            @endif
          @endforeach
          @endif

          @if(isset($selectedProblems) && $selectedProblems->isNotEmpty())
          <div class="eval-summary-section-lbl">Problems</div>
          @foreach($selectedProblems as $prob)
            <div class="eval-summary-item">
              <svg width="14" height="14" fill="none" stroke="#f44336" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
              </svg>
              <span style="color:#f44336;font-weight:600;">{{ $prob->description }}</span>
            </div>
          @endforeach
          @endif

          <div class="eval-summary-section-lbl">Accessories</div>
          <div id="accSummary">
            <div style="font-size:12px;color:#bbb;font-style:italic;">No accessories selected yet</div>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

{{-- LOGIN / OTP MODAL — only shown when NOT logged in --}}
@if(!session('customer'))
<div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
  <div class="cashify-modal" id="cashifyModal">

    <button class="modal-close-btn" onclick="closePopup()">
      <svg width="14" height="14" fill="none" stroke="#444" stroke-width="2.5" viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>

    <div class="modal-left">
      <div class="modal-left-title" id="modalLeftTitle">Login/<br>Signup</div>
      <svg width="200" height="190" viewBox="0 0 200 190" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-top:auto;display:block;">
        <circle cx="100" cy="160" r="70" fill="rgba(255,255,255,0.07)"/>
        <circle cx="100" cy="160" r="46" fill="rgba(255,255,255,0.08)"/>
        <ellipse cx="100" cy="174" rx="52" ry="8" fill="rgba(0,0,0,0.15)"/>
        <rect x="72" y="90" width="40" height="60" rx="10" fill="#fff" opacity=".96"/>
        <circle cx="92" cy="72" r="20" fill="#FDBCB4"/>
        <path d="M72 68 Q74 50 92 48 Q110 50 112 68 Q105 58 92 58 Q79 58 72 68Z" fill="#4E342E"/>
        <rect x="112" y="98" width="11" height="36" rx="5.5" fill="#fff" opacity=".9" transform="rotate(-25 112 98)"/>
        <circle cx="144" cy="84" r="12" fill="#FFD54F" stroke="#F9A825" stroke-width="2.5"/>
        <circle cx="144" cy="84" r="6" fill="none" stroke="#F9A825" stroke-width="2.5"/>
        <rect x="152" y="82" width="28" height="5" rx="2.5" fill="#FFD54F" stroke="#F9A825" stroke-width="1.5"/>
        <rect x="173" y="87" width="5" height="8" rx="2" fill="#FFD54F" stroke="#F9A825" stroke-width="1.5"/>
        <rect x="166" y="87" width="5" height="6" rx="2" fill="#FFD54F" stroke="#F9A825" stroke-width="1.5"/>
        <rect x="62" y="100" width="11" height="30" rx="5.5" fill="#fff" opacity=".9" transform="rotate(20 62 100)"/>
        <rect x="78" y="146" width="13" height="30" rx="6" fill="#1565C0"/>
        <rect x="97" y="146" width="13" height="30" rx="6" fill="#1565C0"/>
        <rect x="74" y="170" width="20" height="9" rx="4.5" fill="#212121"/>
        <rect x="93" y="170" width="20" height="9" rx="4.5" fill="#212121"/>
        <rect x="18" y="100" width="32" height="26" rx="6" fill="#FFD54F" stroke="#F9A825" stroke-width="2"/>
        <path d="M25 100 Q25 88 34 88 Q43 88 43 100" stroke="#F9A825" stroke-width="3" fill="none" stroke-linecap="round"/>
        <circle cx="34" cy="113" r="4" fill="#F9A825"/>
      </svg>
    </div>

    <div class="modal-right">

      <div class="modal-device-card">
        <div class="modal-device-img">
          @if($model->image)
            <img src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
          @else
            <div style="font-size:26px;opacity:.35;">📱</div>
          @endif
        </div>
        <div>
          <div class="modal-device-name">{{ $model->name }} ({{ $variant->memory }})</div>
          <div class="modal-device-price-label">Selling Price</div>
          <div id="modalPriceLocked" class="modal-price-locked-badge">
            <span class="lock-icon">🔒</span>
            <span>₹ X X X X</span>
          </div>
          <div id="modalPriceUnlocked" class="modal-device-price-val" style="display:none;">
            <span class="rupee">₹</span>
            <span id="modalPriceValue">{{ number_format($evaluationPrice, 0) }}</span>
          </div>
        </div>
      </div>

      {{-- STEP 1: Name + Phone --}}
      <div class="modal-step active" id="step1">

        <div class="modal-unlock">
          <svg width="16" height="16" fill="none" stroke="#00a846" stroke-width="2.5" viewBox="0 0 24 24">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
          </svg>
          Login to unlock the best price
        </div>

        <div class="modal-input-group">
          <div class="modal-input-label">Your Name</div>
          <div class="modal-input-wrap">
            <input type="text" id="modalName" class="modal-field"
                   placeholder="Enter your full name" maxlength="80"
                   oninput="checkStep1Ready()">
          </div>
        </div>

        <div class="modal-input-group">
          <div class="modal-input-label">Mobile Number</div>
          <div class="modal-input-wrap">
            <span class="modal-phone-prefix">+91</span>
            <input type="tel" id="modalPhone" class="modal-field"
                   placeholder="10-digit mobile number" maxlength="10"
                   oninput="onPhoneInput(this)">
          </div>
        </div>

        <div class="modal-terms">
          <input type="checkbox" id="modalTerms" onchange="checkStep1Ready()">
          <label for="modalTerms">
            I agree to the <a href="#">Terms and Conditions</a> &amp; <a href="#">Privacy Policy</a>
          </label>
        </div>

        <div class="modal-msg" id="step1Msg"></div>

        <button type="button" class="modal-action-btn" id="sendOtpBtn" onclick="doSendOtp()">
          <span class="spinner"></span>
          <span class="btn-label">SEND OTP</span>
        </button>

      </div>

      {{-- STEP 2: OTP Verification --}}
      <div class="modal-step" id="step2">

        <div class="otp-header">
          <button class="otp-back-btn" onclick="goToStep1()" title="Back">
            <svg width="14" height="14" fill="none" stroke="#555" stroke-width="2.5" viewBox="0 0 24 24">
              <polyline points="15 18 9 12 15 6"/>
            </svg>
          </button>
          <div class="otp-header-text">
            <h3>Verify your number</h3>
            <p id="otpSentMsg">OTP sent to +91 XXXXXXXXXX</p>
          </div>
        </div>

        <div class="otp-boxes">
          <input type="tel" class="otp-box" maxlength="1" oninput="otpInput(this,0)" onkeydown="otpKey(event,0)">
          <input type="tel" class="otp-box" maxlength="1" oninput="otpInput(this,1)" onkeydown="otpKey(event,1)">
          <input type="tel" class="otp-box" maxlength="1" oninput="otpInput(this,2)" onkeydown="otpKey(event,2)">
          <input type="tel" class="otp-box" maxlength="1" oninput="otpInput(this,3)" onkeydown="otpKey(event,3)">
          <input type="tel" class="otp-box" maxlength="1" oninput="otpInput(this,4)" onkeydown="otpKey(event,4)">
          <input type="tel" class="otp-box" maxlength="1" oninput="otpInput(this,5)" onkeydown="otpKey(event,5)">
        </div>

        <div class="resend-row">
          <span id="resendTimer" style="color:#888;font-size:12px;">Resend in <strong id="timerCount">30</strong>s</span>
          <button class="resend-btn" id="resendBtn" disabled onclick="doResendOtp()">Resend OTP</button>
        </div>

        <div class="modal-msg" id="step2Msg"></div>

        <button type="button" class="modal-action-btn" id="verifyOtpBtn" onclick="doVerifyOtp()">
          <span class="spinner"></span>
          <span class="btn-label">VERIFY &amp; CONTINUE</span>
        </button>

      </div>

      {{-- Hidden form — submitted after OTP verify --}}
      <form method="POST"
            action="{{ route('sell.final.submit', [$brand->slug, $model->slug, $variant->id]) }}"
            id="finalForm" style="display:none;">
        @csrf
        <input type="hidden" id="finalPhone"  name="phone"         value="">
        <input type="hidden" id="finalName"   name="name"          value="">
        <input type="hidden" id="finalAccIds" name="accessory_ids" value="">
      </form>

    </div>
  </div>
</div>
@else
{{-- ✅ Already logged in: direct submit form --}}
<form method="POST"
      action="{{ route('sell.final.submit', [$brand->slug, $model->slug, $variant->id]) }}"
      id="finalForm" style="display:none;">
  @csrf
  <input type="hidden" id="finalPhone"  name="phone"         value="{{ session('customer.mobile') }}">
  <input type="hidden" id="finalName"   name="name"          value="{{ session('customer.name') }}">
  <input type="hidden" id="finalAccIds" name="accessory_ids" value="">
</form>
@endif

<script>
(function () {

  var REAL_PRICE_FORMATTED = '{{ number_format($evaluationPrice, 0) }}';
  var IS_LOGGED_IN = {{ session('customer') ? 'true' : 'false' }};

  var selectedAcc = {};

  window.toggleAccessory = function (id, description) {
    var noRad = document.getElementById('noAccRadio');
    if (noRad) { noRad.checked = false; }
    var noLabel = document.getElementById('noAccLabel');
    if (noLabel) noLabel.classList.remove('selected');

    var card = document.getElementById('acc-card-' + id);
    if (selectedAcc[id]) {
      delete selectedAcc[id];
      card.classList.remove('selected');
    } else {
      selectedAcc[id] = description;
      card.classList.add('selected');
    }
    updateAccSummary();
    checkCanContinue();
  };

  window.selectNoAccessories = function (radio) {
    if (!radio.checked) return;
    Object.keys(selectedAcc).forEach(function (id) {
      delete selectedAcc[id];
      var c = document.getElementById('acc-card-' + id);
      if (c) c.classList.remove('selected');
    });
    document.getElementById('noAccLabel').classList.add('selected');
    updateAccSummary();
    checkCanContinue();
  };

  function updateAccSummary() {
    var container = document.getElementById('accSummary');
    var noAccRadio = document.getElementById('noAccRadio');
    var noAcc = noAccRadio && noAccRadio.checked;
    var keys = Object.keys(selectedAcc);
    if (noAcc) {
      container.innerHTML = '<div class="eval-summary-item"><svg width="14" height="14" fill="none" stroke="#888" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg><span style="color:#888;font-weight:600;">None of the above</span></div>';
      return;
    }
    if (!keys.length) {
      container.innerHTML = '<div style="font-size:12px;color:#bbb;font-style:italic;">No accessories selected yet</div>';
      return;
    }
    container.innerHTML = keys.map(function (id) {
      return '<div class="eval-summary-item"><svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg><span style="color:#00c853;font-weight:600;">' + escapeHtml(selectedAcc[id]) + '</span></div>';
    }).join('');
  }

  function checkCanContinue() {
    var noAccRadio = document.getElementById('noAccRadio');
    var noChecked = noAccRadio && noAccRadio.checked;
    var ok = Object.keys(selectedAcc).length > 0 || noChecked;
    document.getElementById('accContinueBtn').disabled = !ok;
  }

  /* ── Main continue handler ─────────────────────────────────────────────── */
  window.handleContinue = function () {
    // Set accessory IDs in hidden form
    document.getElementById('finalAccIds').value = Object.keys(selectedAcc).join(',');

    if (IS_LOGGED_IN) {
      // ✅ Already logged in → directly submit evaluation
      document.getElementById('submitOverlay').classList.add('show');
      document.getElementById('finalForm').submit();
    } else {
      // Not logged in → open login modal
      openPopup();
    }
  };

  /* ── Popup open / close ─────────────────────────────────────────────────── */
  window.openPopup = function () {
    document.getElementById('finalAccIds').value = Object.keys(selectedAcc).join(',');
    resetModal();
    document.getElementById('modalOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
    setTimeout(function () { document.getElementById('modalName').focus(); }, 300);
  };

  window.closePopup = function () {
    document.getElementById('modalOverlay').classList.remove('show');
    document.body.style.overflow = '';
    clearResendTimer();
  };

  window.handleOverlayClick = function (e) {
    if (e.target === document.getElementById('modalOverlay')) closePopup();
  };

  function resetModal() {
    showStep(1);
    document.getElementById('modalName').value = '';
    document.getElementById('modalPhone').value = '';
    document.getElementById('modalTerms').checked = false;
    setMsg('step1Msg', '', '');
    setMsg('step2Msg', '', '');
    clearOtpBoxes();
    document.getElementById('sendOtpBtn').classList.remove('ready', 'loading');
    document.getElementById('verifyOtpBtn').classList.remove('ready', 'loading');
    document.getElementById('modalPriceLocked').style.display = 'flex';
    document.getElementById('modalPriceUnlocked').style.display = 'none';
  }

  function showStep(n) {
    document.getElementById('step1').classList.toggle('active', n === 1);
    document.getElementById('step2').classList.toggle('active', n === 2);
    document.getElementById('modalLeftTitle').innerHTML = n === 1 ? 'Login/<br>Signup' : 'Verify<br>OTP';
  }

  window.goToStep1 = function () {
    clearResendTimer();
    showStep(1);
  };

  /* ── Step 1 ─────────────────────────────────────────────────────────────── */
  window.onPhoneInput = function (input) {
    input.value = input.value.replace(/\D/g, '').slice(0, 10);
    checkStep1Ready();
  };

  window.checkStep1Ready = function () {
    var nameOk  = document.getElementById('modalName').value.trim().length >= 2;
    var phoneOk = document.getElementById('modalPhone').value.length === 10;
    var termsOk = document.getElementById('modalTerms').checked;
    document.getElementById('sendOtpBtn').classList.toggle('ready', nameOk && phoneOk && termsOk);
  };

  window.doSendOtp = function () {
    var btn = document.getElementById('sendOtpBtn');
    if (!btn.classList.contains('ready')) return;
    var name   = document.getElementById('modalName').value.trim();
    var mobile = document.getElementById('modalPhone').value;

    setLoading(btn, true);
    setMsg('step1Msg', '', '');

    fetch('{{ route("sell.send-otp") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: JSON.stringify({ name: name, mobile: mobile })
    })
    .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
    .then(function (res) {
      setLoading(btn, false);
      if (res.ok && res.data.success) {
        document.getElementById('otpSentMsg').textContent = 'OTP sent to +91 ' + mobile;
        showStep(2);
        startResendTimer();
        setTimeout(function () { document.querySelectorAll('.otp-box')[0].focus(); }, 300);
      } else {
        setMsg('step1Msg', res.data.message || 'Failed to send OTP.', 'error');
      }
    })
    .catch(function () {
      setLoading(btn, false);
      setMsg('step1Msg', 'Network error. Please try again.', 'error');
    });
  };

  /* ── Step 2: OTP ─────────────────────────────────────────────────────────── */
  var otpBoxes = null;
  function getBoxes() {
    if (!otpBoxes) otpBoxes = Array.from(document.querySelectorAll('.otp-box'));
    return otpBoxes;
  }

  window.otpInput = function (el, idx) {
    el.value = el.value.replace(/\D/g, '').slice(-1);
    el.classList.toggle('filled', el.value.length === 1);
    el.classList.remove('error');
    if (el.value && idx < 5) getBoxes()[idx + 1].focus();
    checkOtpReady();
  };

  window.otpKey = function (e, idx) {
    if (e.key === 'Backspace' && !e.target.value && idx > 0) {
      getBoxes()[idx - 1].focus();
    }
  };

  function getOtpValue() {
    return getBoxes().map(function (b) { return b.value; }).join('');
  }

  function checkOtpReady() {
    document.getElementById('verifyOtpBtn').classList.toggle('ready', getOtpValue().length === 6);
  }

  function clearOtpBoxes() {
    if (!document.querySelector('.otp-box')) return;
    getBoxes().forEach(function (b) { b.value = ''; b.classList.remove('filled', 'error'); });
    checkOtpReady();
  }

  window.doVerifyOtp = function () {
    var btn = document.getElementById('verifyOtpBtn');
    if (!btn.classList.contains('ready')) return;

    setLoading(btn, true);
    setMsg('step2Msg', '', '');

    fetch('{{ route("sell.verify-otp") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: JSON.stringify({ otp: getOtpValue() })
    })
    .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
    .then(function (res) {
      setLoading(btn, false);
      if (res.ok && res.data.success) {
        revealPrice();
        revealSidebarPrice();
        setMsg('step2Msg', '✔ Verified! Submitting…', 'success');

        document.getElementById('finalPhone').value = document.getElementById('modalPhone').value;
        document.getElementById('finalName').value  = document.getElementById('modalName').value.trim();

        setTimeout(function () {
          closePopup();
          document.getElementById('submitOverlay').classList.add('show');
          document.getElementById('finalForm').submit();
        }, 900);
      } else {
        setMsg('step2Msg', res.data.message || 'Invalid OTP.', 'error');
        getBoxes().forEach(function (b) { b.classList.add('error'); });
      }
    })
    .catch(function () {
      setLoading(btn, false);
      setMsg('step2Msg', 'Network error. Please try again.', 'error');
    });
  };

  /* ── Price reveal ─────────────────────────────────────────────────────── */
  function revealPrice() {
    var locked   = document.getElementById('modalPriceLocked');
    var unlocked = document.getElementById('modalPriceUnlocked');
    var priceVal = document.getElementById('modalPriceValue');
    if (!locked) return;
    locked.style.display = 'none';
    priceVal.textContent = REAL_PRICE_FORMATTED;
    unlocked.style.display = 'flex';
    unlocked.classList.add('price-reveal');
  }

  function revealSidebarPrice() {
    var sidebarPrice = document.getElementById('sidebarPriceDisplay');
    var lockBadge    = document.getElementById('sidebarLockBadge');
    if (sidebarPrice) {
      sidebarPrice.classList.remove('price-locked');
      sidebarPrice.classList.add('price-unlocked', 'price-reveal');
    }
    if (lockBadge) lockBadge.style.display = 'none';
  }

  /* ── Resend timer ───────────────────────────────────────────────────────── */
  var resendInterval = null;

  function startResendTimer(seconds) {
    seconds = seconds || 30;
    clearResendTimer();
    var resendBtn   = document.getElementById('resendBtn');
    var timerCount  = document.getElementById('timerCount');
    var resendTimer = document.getElementById('resendTimer');
    resendBtn.disabled = true;
    resendTimer.style.display = 'inline';
    timerCount.textContent = seconds;

    resendInterval = setInterval(function () {
      seconds--;
      timerCount.textContent = seconds;
      if (seconds <= 0) {
        clearResendTimer();
        resendTimer.style.display = 'none';
        resendBtn.disabled = false;
      }
    }, 1000);
  }

  function clearResendTimer() {
    if (resendInterval) { clearInterval(resendInterval); resendInterval = null; }
  }

  window.doResendOtp = function () {
    var name   = document.getElementById('modalName').value.trim();
    var mobile = document.getElementById('modalPhone').value;
    clearOtpBoxes();
    setMsg('step2Msg', '', '');
    document.getElementById('resendBtn').disabled = true;

    fetch('{{ route("sell.send-otp") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: JSON.stringify({ name: name, mobile: mobile })
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
      if (d.success) {
        setMsg('step2Msg', 'OTP resent successfully.', 'success');
        startResendTimer(30);
        setTimeout(function () { getBoxes()[0].focus(); }, 200);
      } else {
        setMsg('step2Msg', d.message || 'Failed to resend OTP.', 'error');
        document.getElementById('resendBtn').disabled = false;
      }
    })
    .catch(function () {
      setMsg('step2Msg', 'Network error.', 'error');
      document.getElementById('resendBtn').disabled = false;
    });
  };

  /* ── Helpers ────────────────────────────────────────────────────────────── */
  function setMsg(id, text, type) {
    var el = document.getElementById(id);
    if (!el) return;
    el.textContent = text;
    el.className = 'modal-msg' + (type ? ' ' + type : '');
  }

  function setLoading(btn, on) {
    btn.classList.toggle('loading', on);
    if (on) btn.classList.remove('ready');
  }

  function escapeHtml(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

})();
</script>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>