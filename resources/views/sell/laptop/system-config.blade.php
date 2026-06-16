{{-- resources/views/sell/laptop/system-config.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>System Configuration – {{ $model->name }}</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
body { background:#f4f6f8; }
.sc-wrap { max-width:1100px;margin:0 auto;padding:28px 20px 60px; }
.sc-breadcrumb { display:flex;align-items:center;gap:5px;font-size:13px;color:#888;margin-bottom:24px;flex-wrap:wrap; }
.sc-breadcrumb a { color:#888;text-decoration:none; }
.sc-breadcrumb a:hover { color:#00bfa5; }
.sc-breadcrumb .sep { color:#ccc; }
.sc-breadcrumb .active { color:#222;font-weight:600; }
.sc-layout { display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start; }
.sc-panel { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.sc-panel-header { padding:30px 36px 0; }
.sc-panel-title { font-family:'Nunito',sans-serif;font-size:24px;font-weight:900;color:#1a1a1a;margin-bottom:6px; }
.sc-panel-subtitle { font-size:14px;color:#888;margin-bottom:16px;line-height:1.5; }

/* Verified badge */
.sc-verified-badge {
    display:inline-flex;align-items:center;gap:8px;
    background:#e8f5e9;border:1px solid #c8f5d9;border-radius:10px;
    padding:9px 14px;font-size:13px;font-weight:700;color:#2e7d32;
    margin-bottom:18px;
}
.sc-verified-badge svg { flex-shrink:0; }

.sc-field { padding:0 36px;margin-bottom:24px; }
.sc-field-label { font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;color:#1a1a1a;margin-bottom:8px;display:flex;align-items:center;gap:8px; }
.sc-field-icon { font-size:18px;width:28px;text-align:center; }
.sc-select-wrap { position:relative; }
.sc-select { width:100%;padding:14px 44px 14px 16px;border:2px solid #e0e0e0;border-radius:10px;font-family:'Nunito Sans',sans-serif;font-size:15px;font-weight:600;color:#333;background:#fff;appearance:none;-webkit-appearance:none;cursor:pointer;transition:border-color .15s;outline:none; }
.sc-select:focus,.sc-select:hover { border-color:#00bfa5; }
.sc-select-arrow { position:absolute;right:14px;top:50%;transform:translateY(-50%);pointer-events:none;color:#aaa;font-size:18px; }
.sc-nav { display:flex;align-items:center;justify-content:space-between;padding:24px 36px;border-top:1.5px solid #f0f0f0;background:#fafafa;margin-top:8px; }
.sc-btn-back { background:none;border:1.5px solid #e0e0e0;border-radius:8px;padding:10px 22px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:#666;cursor:pointer;transition:all .15s;text-decoration:none;display:inline-flex;align-items:center; }
.sc-btn-back:hover { border-color:#aaa;color:#333; }
.sc-btn-next { background:#00bfa5;border:none;border-radius:8px;padding:12px 32px;font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#fff;cursor:pointer;transition:all .18s;display:flex;align-items:center;gap:8px; }
.sc-btn-next:hover { background:#00897b;box-shadow:0 4px 16px rgba(0,191,165,.3); }
.sc-btn-next:disabled { background:#e0e0e0;color:#bbb;cursor:not-allowed;box-shadow:none; }
/* Sidebar */
.sc-sidebar { position:sticky;top:20px; }
.sc-device-card { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.sc-device-top { display:flex;align-items:center;gap:14px;padding:18px 20px;border-bottom:1px solid #f0f0f0; }
.sc-device-img { width:60px;height:50px;object-fit:contain;background:#f7f9fc;border-radius:8px;padding:4px; }
.sc-device-img-placeholder { width:60px;height:50px;background:#f7f9fc;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:26px; }
.sc-device-name { font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#1a1a1a;line-height:1.2; }
.sc-device-spec { font-size:12px;color:#888;margin-top:3px; }
.sc-price-block { padding:14px 20px;border-bottom:1px solid #f0f0f0; }
.sc-price-label { font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.4px; }
.sc-price-val { font-family:'Nunito',sans-serif;font-size:28px;font-weight:900;color:#e53935;line-height:1.1; }
.sc-price-val span { font-size:16px;vertical-align:super;font-weight:800; }
.sc-price-note { font-size:11px;color:#aaa;margin-top:3px; }
.sc-summary-section { padding:12px 20px 4px;font-size:11px;font-weight:800;color:#aaa;text-transform:uppercase;letter-spacing:.5px;border-top:1px solid #f0f0f0; }
.sc-summary-list { padding:0 20px 10px; }
.sc-summary-row { display:flex;align-items:flex-start;gap:8px;padding:5px 0;font-size:13px;color:#555; }
.sc-summary-dot { width:8px;height:8px;border-radius:50%;margin-top:4px;flex-shrink:0; }
.sc-summary-dot.good { background:#4caf50; }
.sc-summary-dot.bad  { background:#ef5350; }
.sc-summary-q { color:#888;font-size:12px; }
.sc-summary-a { font-weight:700; }
.sc-summary-a.good { color:#2e7d32; }
.sc-summary-a.bad  { color:#c62828; }
.sc-config-dot { width:6px;height:6px;background:#00bfa5;border-radius:50%;flex-shrink:0;margin-top:5px; }
.sc-config-type { color:#888;font-size:12px;min-width:64px; }
.sc-config-val  { font-weight:700;color:#1a1a1a; }
.sc-empty { text-align:center;padding:40px 30px;color:#bbb; }
/* Toast */
.sc-toast { position:fixed;bottom:30px;left:50%;transform:translateX(-50%) translateY(20px);background:#333;color:#fff;padding:12px 24px;border-radius:10px;font-size:14px;font-weight:600;opacity:0;transition:all .3s;z-index:9999;pointer-events:none; }
.sc-toast.show { opacity:1;transform:translateX(-50%) translateY(0); }

/* ── LOGIN POPUP — only shown when NOT verified ── */
.lp-overlay { display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9000;align-items:center;justify-content:center; }
.lp-overlay.open { display:flex; }
.lp-modal { background:#fff;border-radius:18px;overflow:hidden;display:flex;width:720px;max-width:95vw;max-height:95vh;box-shadow:0 24px 60px rgba(0,0,0,.25);position:relative;animation:lpIn .28s ease; }
@keyframes lpIn { from{opacity:0;transform:scale(.93)} to{opacity:1;transform:scale(1)} }
.lp-close { position:absolute;top:14px;right:16px;background:rgba(255,255,255,.25);border:none;border-radius:50%;width:32px;height:32px;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;z-index:2;transition:background .15s; }
.lp-close:hover { background:rgba(255,255,255,.4); }
.lp-left { width:260px;background:linear-gradient(160deg,#00c9b1 0%,#00897b 100%);padding:40px 28px;display:flex;flex-direction:column;justify-content:space-between;flex-shrink:0; }
.lp-left-title { font-family:'Nunito',sans-serif;font-size:26px;font-weight:900;color:#fff;line-height:1.2; }
.lp-left-sub { font-size:14px;color:rgba(255,255,255,.85);margin-top:10px;line-height:1.5; }
.lp-illustration { margin-top:24px;display:flex;justify-content:center; }
.lp-right { flex:1;padding:30px 28px 28px;display:flex;flex-direction:column;overflow-y:auto; }
.lp-device-row { display:flex;align-items:center;gap:14px;background:#f8fffe;border:1.5px solid #e0f2f1;border-radius:12px;padding:14px 16px;margin-bottom:22px; }
.lp-device-img { width:56px;height:44px;object-fit:contain;background:#fff;border-radius:8px;padding:3px;flex-shrink:0; }
.lp-device-img-ph { width:56px;height:44px;background:#e0f2f1;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0; }
.lp-device-info-name { font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;color:#1a1a1a; }
.lp-device-info-sub { font-size:12px;color:#888;margin-bottom:2px; }
.lp-device-price { font-family:'Nunito',sans-serif;font-size:20px;font-weight:900;color:#e53935; }
.lp-device-price sup { font-size:12px;font-weight:800; }
.lp-unlock-banner { background:#e0f2f1;border-radius:8px;padding:11px 14px;display:flex;align-items:center;gap:10px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;color:#00695c;margin-bottom:24px; }
.lp-input-label { font-size:13px;color:#888;font-weight:600;margin-bottom:8px; }
.lp-name-wrap { display:flex;align-items:center;border-bottom:2px solid #e0e0e0;padding-bottom:8px;margin-bottom:16px;transition:border-color .15s; }
.lp-name-wrap:focus-within { border-color:#00bfa5; }
.lp-name-input { flex:1;border:none;outline:none;font-family:'Nunito Sans',sans-serif;font-size:16px;font-weight:600;color:#333;background:transparent; }
.lp-name-input::placeholder { color:#ccc;font-weight:400; }
.lp-phone-wrap { display:flex;align-items:center;border-bottom:2px solid #e0e0e0;padding-bottom:8px;margin-bottom:20px;transition:border-color .15s; }
.lp-phone-wrap:focus-within { border-color:#00bfa5; }
.lp-phone-prefix { font-family:'Nunito',sans-serif;font-size:16px;font-weight:700;color:#333;margin-right:10px; }
.lp-phone-input { flex:1;border:none;outline:none;font-family:'Nunito Sans',sans-serif;font-size:16px;font-weight:600;color:#333;background:transparent; }
.lp-phone-input::placeholder { color:#ccc;font-weight:400; }
.lp-terms { display:flex;align-items:flex-start;gap:10px;margin-bottom:20px; }
.lp-terms input[type="checkbox"] { width:16px;height:16px;margin-top:2px;flex-shrink:0;accent-color:#00bfa5;cursor:pointer; }
.lp-terms-text { font-size:12px;color:#888;line-height:1.5; }
.lp-terms-text a { color:#00bfa5;text-decoration:none; }
.lp-continue-btn { width:100%;background:#e0e0e0;color:#bbb;border:none;border-radius:10px;padding:15px;font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;cursor:not-allowed;transition:all .2s; }
.lp-continue-btn.active { background:#00bfa5;color:#fff;cursor:pointer; }
.lp-continue-btn.active:hover { background:#00897b;box-shadow:0 4px 16px rgba(0,191,165,.3); }
.lp-error { font-size:12px;color:#e53935;margin-top:-14px;margin-bottom:10px;display:none; }
.lp-error.show { display:block; }
/* OTP Step */
.lp-otp-step { display:none; }
.lp-otp-label { font-size:13px;color:#555;font-weight:600;margin-bottom:12px; }
.lp-otp-label span { color:#00bfa5;font-weight:800; }
.lp-otp-inputs { display:flex;gap:10px;justify-content:center;margin-bottom:16px; }
.lp-otp-box { width:48px;height:52px;border:2px solid #e0e0e0;border-radius:10px;text-align:center;font-family:'Nunito',sans-serif;font-size:20px;font-weight:800;color:#333;outline:none;transition:border-color .15s; }
.lp-otp-box:focus { border-color:#00bfa5; }
.lp-resend { font-size:12px;color:#888;margin-top:8px;text-align:center; }
.lp-resend a { color:#00bfa5;font-weight:700;cursor:pointer; }
.lp-otp-error { font-size:12px;color:#e53935;text-align:center;margin-top:8px;display:none; }
.lp-otp-error.show { display:block; }
.lp-spinner { display:none;width:18px;height:18px;border:2px solid rgba(255,255,255,.3);border-radius:50%;border-top-color:#fff;animation:spin 1s linear infinite;margin-left:8px; }
@keyframes spin { to { transform: rotate(360deg); } }
.btn-loading .lp-spinner { display:inline-block; }
@media(max-width:820px) { .sc-layout { grid-template-columns:1fr; } .sc-sidebar { position:static; } .sc-panel-header { padding:24px 20px 0; } .sc-field { padding:0 20px; } .sc-nav { padding:20px; } .sc-panel-title { font-size:20px; } }
@media(max-width:600px) { .lp-modal{flex-direction:column;width:96vw} .lp-left{width:100%;padding:24px 22px 20px;flex-direction:row;align-items:center} .lp-illustration{display:none} .lp-left-sub{display:none} .lp-left-title{font-size:20px} .lp-right{padding:20px} }
</style>
</head>
<body>
@include('sell.partials.navbar')

<div class="sc-wrap">
    <div class="sc-breadcrumb">
        <a href="{{ route('sell.index') }}">Home</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.index') }}">Sell Old Laptop</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.brand.models', $brand->slug) }}">{{ $brand->name }}</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.evaluate', [$brand->slug, $model->slug]) }}{{ $variant ? '?variant='.$variant->id : '' }}">Evaluation</a><span class="sep">›</span>
        <span class="active">System Configuration</span>
    </div>

    <div class="sc-layout">
        {{-- LEFT --}}
        <div class="sc-panel">
            <div class="sc-panel-header">
                <div class="sc-panel-title">System Configuration Details</div>
                <div class="sc-panel-subtitle">Choose your laptop's processor, memory (RAM), and storage.</div>

                {{-- ── FIX: Show verified badge when already logged in ── --}}
                <!-- @if($isVerified && $verifiedCustomer)
                <div class="sc-verified-badge">
                    <svg width="16" height="16" fill="none" stroke="#2e7d32" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M20 6L9 17l-5-5"/>
                    </svg>
                    Logged in as {{ $verifiedCustomer['name'] }} &nbsp;·&nbsp; {{ $verifiedCustomer['mobile'] }}
                </div>
                @endif -->
            </div>

            @if($processors->isEmpty() && $rams->isEmpty() && $storages->isEmpty())
                <div class="sc-empty"><div style="font-size:48px;margin-bottom:12px;">⚙️</div><p style="font-size:14px;">No configuration options available for this model.</p></div>
                <div class="sc-nav">
                    <a href="{{ route('sell.laptop.evaluate', [$brand->slug, $model->slug]) }}{{ $variant ? '?variant='.$variant->id : '' }}" class="sc-btn-back">← Back</a>
                </div>
            @else
                @if($processors->isNotEmpty())
                <div class="sc-field" style="margin-top:8px;">
                    <div class="sc-field-label"><span class="sc-field-icon">🔲</span>Processor</div>
                    <div class="sc-select-wrap">
                        <select class="sc-select" id="selProcessor" onchange="updateSidebar()">
                            <option value="">— Select Processor —</option>
                            @foreach($processors as $p)<option value="{{ $p->value }}">{{ $p->value }}</option>@endforeach
                        </select>
                        <span class="sc-select-arrow">▾</span>
                    </div>
                </div>
                @endif
                @if($rams->isNotEmpty())
                <div class="sc-field">
                    <div class="sc-field-label"><span class="sc-field-icon">💾</span>RAM</div>
                    <div class="sc-select-wrap">
                        <select class="sc-select" id="selRam" onchange="updateSidebar()">
                            <option value="">— Select RAM —</option>
                            @foreach($rams as $r)<option value="{{ $r->value }}">{{ $r->value }}</option>@endforeach
                        </select>
                        <span class="sc-select-arrow">▾</span>
                    </div>
                </div>
                @endif
                @if($storages->isNotEmpty())
                <div class="sc-field">
                    <div class="sc-field-label"><span class="sc-field-icon">💿</span>Hard Disk / Storage</div>
                    <div class="sc-select-wrap">
                        <select class="sc-select" id="selStorage" onchange="updateSidebar()">
                            <option value="">— Select Storage —</option>
                            @foreach($storages as $s)<option value="{{ $s->value }}">{{ $s->value }}</option>@endforeach
                        </select>
                        <span class="sc-select-arrow">▾</span>
                    </div>
                </div>
                @endif
                <div class="sc-nav">
                    <a href="{{ route('sell.laptop.evaluate', [$brand->slug, $model->slug]) }}{{ $variant ? '?variant='.$variant->id : '' }}&power_on={{ $powerOn }}"
                       class="sc-btn-back">← Back</a>
                    <button class="sc-btn-next" id="btnContinue" disabled onclick="continueNext()">
                        Continue <span>→</span>
                    </button>
                </div>
            @endif
        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="sc-sidebar">
            <div class="sc-device-card">
                <div class="sc-device-top">
                    @if($model->image)<img class="sc-device-img" src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
                    @else<div class="sc-device-img-placeholder">💻</div>@endif
                    <div>
                        <div class="sc-device-name">{{ $model->name }}</div>
                        <div class="sc-device-spec">{{ $brand->name }}@if($variant) · {{ $variant->storage }} · {{ $variant->ram }}@endif</div>
                    </div>
                </div>
                <div class="sc-price-block">
                    <div class="sc-price-label">Estimated Price</div>
                    <div class="sc-price-val"><span>₹</span>{{ number_format($variant ? $variant->price : $model->price, 0) }}</div>
                    <div class="sc-price-note">Price updates based on your answers</div>
                </div>
                <div class="sc-summary-section">Device Evaluation</div>
                <div class="sc-summary-list">
                    <div class="sc-summary-row">
                        <span class="sc-summary-dot {{ $powerOn === 'yes' ? 'good' : 'bad' }}"></span>
                        <div>
                            <div class="sc-summary-q">Does the Laptop switch on?</div>
                            <div class="sc-summary-a {{ $powerOn === 'yes' ? 'good' : 'bad' }}">
                                {{ $powerOn === 'yes' ? 'Yes, switches on fine' : 'No / Not sure' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sc-summary-section">System Configuration</div>
                <div class="sc-summary-list" id="configSummary">
                    <div style="font-size:12px;color:#ccc;padding:4px 0;">Select options to see summary</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sc-toast" id="scToast">Please select all options before continuing</div>

{{-- ── LOGIN POPUP — only rendered when NOT already verified ── --}}
@if(!$isVerified)
<div class="lp-overlay" id="lpOverlay" onclick="handleOverlayClick(event)">
  <div class="lp-modal" id="lpModal">
    <button class="lp-close" onclick="closeLoginPopup()">✕</button>
    <div class="lp-left">
      <div>
        <div class="lp-left-title">Login /<br>Signup</div>
        <div class="lp-left-sub">Login to unlock the best price for your device</div>
      </div>
      <div class="lp-illustration">
        <svg viewBox="0 0 200 200" width="150" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="100" cy="130" r="60" fill="rgba(255,255,255,.1)"/>
          <rect x="72" y="120" width="26" height="50" rx="10" fill="rgba(255,255,255,.9)"/>
          <circle cx="85" cy="108" r="16" fill="rgba(255,255,255,.9)"/>
          <circle cx="145" cy="115" r="18" fill="none" stroke="rgba(255,255,255,.85)" stroke-width="6"/>
          <circle cx="145" cy="115" r="6" fill="rgba(255,255,255,.85)"/>
          <line x1="145" y1="133" x2="145" y2="165" stroke="rgba(255,255,255,.85)" stroke-width="6" stroke-linecap="round"/>
          <line x1="145" y1="150" x2="157" y2="150" stroke="rgba(255,255,255,.85)" stroke-width="5" stroke-linecap="round"/>
          <line x1="145" y1="162" x2="155" y2="162" stroke="rgba(255,255,255,.85)" stroke-width="5" stroke-linecap="round"/>
          <path d="M98 138 Q118 130 132 120" stroke="rgba(255,255,255,.8)" stroke-width="5" stroke-linecap="round" fill="none"/>
          <rect x="58" y="60" width="28" height="24" rx="4" fill="rgba(255,255,255,.85)"/>
          <path d="M63 60 Q63 46 72 46 Q81 46 81 60" fill="none" stroke="rgba(255,255,255,.85)" stroke-width="5" stroke-linecap="round"/>
          <circle cx="72" cy="72" r="4" fill="rgba(0,191,165,.8)"/>
        </svg>
      </div>
    </div>
    <div class="lp-right">
      <div class="lp-device-row">
        @if($model->image)<img class="lp-device-img" src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
        @else<div class="lp-device-img-ph">💻</div>@endif
        <div style="flex:1;">
          <div class="lp-device-info-sub">{{ $brand->name }}</div>
          <div class="lp-device-info-name">{{ $model->name }}</div>
          <div class="lp-device-info-sub" style="margin-top:3px;">Selling Price</div>
          <div class="lp-device-price"><sup>₹</sup><span id="popupPrice">XX,XXX</span></div>
        </div>
      </div>
      <div class="lp-unlock-banner"><span style="font-size:18px;">🔓</span>Login to unlock the best price</div>

      {{-- STEP 1: Name & Phone --}}
      <div id="phoneStep">
        <div class="lp-input-label">Enter your full name</div>
        <div class="lp-name-wrap">
          <input class="lp-name-input" type="text" id="lpName" placeholder="Your Name" maxlength="50" oninput="onLpInput()">
        </div>
        <div class="lp-input-label">Enter your phone number</div>
        <div class="lp-phone-wrap">
          <span class="lp-phone-prefix">+91</span>
          <input class="lp-phone-input" type="tel" id="lpPhone" placeholder="Enter your Mobile"
                 maxlength="10" oninput="onLpInput()" onkeypress="return event.charCode>=48&&event.charCode<=57">
        </div>
        <div class="lp-error" id="lpPhoneError">Please enter a valid 10-digit mobile number.</div>
        <div class="lp-terms">
          <input type="checkbox" id="lpTerms" onchange="onLpInput()">
          <span class="lp-terms-text">I agree to the <a href="#">Terms and Conditions</a> &amp; <a href="#">Privacy Policy</a></span>
        </div>
        <button class="lp-continue-btn" id="lpSendOtpBtn" onclick="sendLpOTP()">
          <span>SEND OTP</span>
          <div class="lp-spinner"></div>
        </button>
      </div>

      {{-- STEP 2: OTP --}}
      <div id="otpStep" class="lp-otp-step">
        <div class="lp-otp-label">Enter OTP sent to +91 <span id="lpOtpPhone"></span></div>
        <div class="lp-otp-inputs">
          <input class="lp-otp-box" type="tel" maxlength="1" id="lpOtp1" oninput="lpOtpNext(this,'lpOtp2')">
          <input class="lp-otp-box" type="tel" maxlength="1" id="lpOtp2" oninput="lpOtpNext(this,'lpOtp3')">
          <input class="lp-otp-box" type="tel" maxlength="1" id="lpOtp3" oninput="lpOtpNext(this,'lpOtp4')">
          <input class="lp-otp-box" type="tel" maxlength="1" id="lpOtp4" oninput="lpOtpNext(this,'lpOtp5')">
          <input class="lp-otp-box" type="tel" maxlength="1" id="lpOtp5" oninput="lpOtpNext(this,'lpOtp6')">
          <input class="lp-otp-box" type="tel" maxlength="1" id="lpOtp6" oninput="lpOtpNext(this,null)">
        </div>
        <div class="lp-resend">Didn't receive? <a onclick="resendLpOTP()">Resend OTP</a></div>
        <div class="lp-otp-error" id="lpOtpError">Invalid OTP. Please try again.</div>
        <button class="lp-continue-btn active" style="margin-top:16px;" onclick="verifyLpOTP()">VERIFY & CONTINUE</button>
      </div>
    </div>
  </div>
</div>
@endif

<script>
const POWER_ON      = "{{ $powerOn }}";
const VARIANT_PRICE = {{ $variant ? $variant->price : $model->price }};
const variantId     = "{{ $variant ? $variant->id : '' }}";
const BRAND_SLUG    = "{{ $brand->slug }}";
const MODEL_SLUG    = "{{ $model->slug }}";
const SUBMIT_URL    = "{{ route('sell.laptop.system-config.submit', [$brand->slug, $model->slug]) }}";
const CSRF_TOKEN    = "{{ csrf_token() }}";

// ── FIX: JS knows whether user is already logged in ──────────────────────────
const IS_VERIFIED   = {{ $isVerified ? 'true' : 'false' }};

// ── Sidebar helpers ──────────────────────────────────────────────────────────

function checkAllSelected() {
    const ids = ['selProcessor', 'selRam', 'selStorage'];
    let ok = true;
    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el && el.value === '') ok = false;
    });
    document.getElementById('btnContinue').disabled = !ok;
}

function updateSidebar() {
    checkAllSelected();
    const proc    = document.getElementById('selProcessor')?.value || '';
    const ram     = document.getElementById('selRam')?.value || '';
    const storage = document.getElementById('selStorage')?.value || '';
    const rows    = [];
    if (proc)    rows.push({ type: 'Processor', val: proc });
    if (ram)     rows.push({ type: 'RAM',       val: ram });
    if (storage) rows.push({ type: 'Storage',   val: storage });
    const sum = document.getElementById('configSummary');
    if (!rows.length) {
        sum.innerHTML = '<div style="font-size:12px;color:#ccc;padding:4px 0;">Select options to see summary</div>';
        return;
    }
    sum.innerHTML = rows.map(r => `
        <div class="sc-summary-row">
            <span class="sc-config-dot"></span>
            <span class="sc-config-type">${r.type}</span>
            <span class="sc-config-val">${r.val}</span>
        </div>`).join('');
}

// ── Continue button click ────────────────────────────────────────────────────

function continueNext() {
    const ids = ['selProcessor', 'selRam', 'selStorage'];
    let allSelected = true;
    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el && el.value === '') allSelected = false;
    });
    if (!allSelected) {
        showToast('Please select all configuration options');
        return;
    }

    if (POWER_ON === 'no') {
        // ── FIX: If already verified, skip popup entirely ────────────────────
        if (IS_VERIFIED) {
            submitAndRedirect();   // directly save evaluation → quote
        } else {
            // Not logged in → show login / OTP popup
            document.getElementById('popupPrice').textContent =
                VARIANT_PRICE.toLocaleString('en-IN');
            document.getElementById('lpOverlay').classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    } else {
        // power_on = yes → always go to next step, no login needed here
        submitAndRedirect();
    }
}

// ── POST to backend then redirect ─────────────────────────────────────────────

function submitAndRedirect() {
    const proc    = document.getElementById('selProcessor')?.value || '';
    const ram     = document.getElementById('selRam')?.value || '';
    const storage = document.getElementById('selStorage')?.value || '';

    const btn = document.getElementById('btnContinue');
    btn.disabled = true;
    btn.innerHTML = 'Please wait… <span style="opacity:.5">⏳</span>';

    fetch(SUBMIT_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify({
            variant:   variantId,
            power_on:  POWER_ON,
            processor: proc,
            ram:       ram,
            storage:   storage
        })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect_url;
        } else {
            showToast(data.message || 'Something went wrong');
            btn.disabled = false;
            btn.innerHTML = 'Continue <span>→</span>';
        }
    })
    .catch(() => {
        showToast('Network error. Please try again.');
        btn.disabled = false;
        btn.innerHTML = 'Continue <span>→</span>';
    });
}

// ── Toast ────────────────────────────────────────────────────────────────────

function showToast(msg) {
    const t = document.getElementById('scToast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}

// ── Login popup helpers (only used when IS_VERIFIED === false) ────────────────

@if(!$isVerified)
function closeLoginPopup() {
    document.getElementById('lpOverlay').classList.remove('open');
    document.body.style.overflow = '';
    document.getElementById('phoneStep').style.display = 'block';
    document.getElementById('otpStep').style.display   = 'none';
    document.querySelectorAll('[id^="lpOtp"]').forEach(b => b.value = '');
    document.getElementById('lpOtpError').classList.remove('show');
}

function handleOverlayClick(e) {
    if (e.target === document.getElementById('lpOverlay')) closeLoginPopup();
}

function onLpInput() {
    const name  = document.getElementById('lpName').value.trim();
    const phone = document.getElementById('lpPhone').value;
    const terms = document.getElementById('lpTerms').checked;
    const valid = name.length >= 2 && phone.length === 10 && /^[6-9]/.test(phone) && terms;
    document.getElementById('lpSendOtpBtn').classList.toggle('active', valid);
}

function sendLpOTP() {
    const btn = document.getElementById('lpSendOtpBtn');
    if (!btn.classList.contains('active')) return;

    const name  = document.getElementById('lpName').value.trim();
    const phone = document.getElementById('lpPhone').value;

    btn.classList.add('btn-loading');

    fetch('{{ route("sell.laptop.otp.send") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ mobile: phone, name })
    })
    .then(r => r.json())
    .then(data => {
        btn.classList.remove('btn-loading');
        if (data.success) {
            document.getElementById('phoneStep').style.display = 'none';
            document.getElementById('otpStep').style.display   = 'block';
            document.getElementById('lpOtpPhone').textContent  = phone;
            setTimeout(() => document.getElementById('lpOtp1').focus(), 100);
        } else {
            document.getElementById('lpPhoneError').textContent = data.message || 'Failed to send OTP';
            document.getElementById('lpPhoneError').classList.add('show');
        }
    })
    .catch(() => {
        btn.classList.remove('btn-loading');
        showToast('Failed to send OTP. Please try again.');
    });
}

function lpOtpNext(el, nextId) {
    el.value = el.value.replace(/\D/, '');
    if (el.value.length === 1 && nextId) document.getElementById(nextId).focus();
    const otp = Array.from(document.querySelectorAll('[id^="lpOtp"]')).map(b => b.value).join('');
    if (otp.length === 6) verifyLpOTP();
}

function verifyLpOTP() {
    const otp = Array.from(document.querySelectorAll('[id^="lpOtp"]')).map(b => b.value).join('');
    if (otp.length !== 6) return;

    fetch('{{ route("sell.laptop.otp.verify") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ otp })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // OTP verified → now submit evaluation data
            closeLoginPopup();
            submitAndRedirect();
        } else {
            document.getElementById('lpOtpError').textContent = data.message || 'Invalid OTP';
            document.getElementById('lpOtpError').classList.add('show');
            document.querySelectorAll('[id^="lpOtp"]').forEach(b => b.value = '');
            document.getElementById('lpOtp1').focus();
        }
    })
    .catch(() => showToast('Verification failed. Please try again.'));
}

function resendLpOTP() {
    fetch('{{ route("sell.laptop.otp.resend") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.querySelectorAll('[id^="lpOtp"]').forEach(b => b.value = '');
            document.getElementById('lpOtp1').focus();
            document.getElementById('lpOtpError').classList.remove('show');
            showToast('OTP resent successfully');
        } else {
            showToast(data.message || 'Failed to resend OTP');
        }
    });
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLoginPopup(); });
@endif
</script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>