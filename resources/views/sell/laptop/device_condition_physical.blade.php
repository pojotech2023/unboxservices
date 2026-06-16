{{-- resources/views/sell/laptop/device_condition_physical.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Physical Condition – {{ $model->name }}</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing:border-box; margin:0; padding:0; }
body { background:#f7f8fa; font-family:'Nunito Sans',sans-serif; }
.eval-wrap { max-width:1100px;margin:0 auto;padding:28px 20px 80px; }

.ac-breadcrumb { display:flex;align-items:center;gap:5px;font-size:13px;color:#888;margin-bottom:24px;flex-wrap:wrap; }
.ac-breadcrumb a { color:#888;text-decoration:none; }
.ac-breadcrumb a:hover { color:#00bfa5; }
.ac-breadcrumb .sep { color:#ccc; }
.ac-breadcrumb .active { color:#222;font-weight:600; }

.eval-layout { display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start; }

.eval-panel { background:#fff;border:1.5px solid #ebebeb;border-radius:16px;overflow:hidden; }
.eval-panel-header { padding:28px 32px 22px;border-bottom:1.5px solid #f0f0f0; }
.eval-panel-header h2 { font-family:'Nunito',sans-serif;font-size:22px;font-weight:800;color:#1a1a1a;margin-bottom:6px; }
.eval-panel-header p { font-size:13px;color:#888;line-height:1.5; }

.question-block { padding:24px 32px;border-bottom:1.5px solid #f5f5f5; }
.question-block:last-of-type { border-bottom:none; }
.question-title { font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;color:#1a1a1a;margin-bottom:4px; }
.question-sub { font-size:12px;color:#888;margin-bottom:16px; }

.options-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:14px; }
.opt-card {
    border:2px solid #e0e0e0;border-radius:14px;overflow:hidden;
    cursor:pointer;transition:all .2s ease;background:#fff;
    user-select:none;position:relative;
}
.opt-card:hover { border-color:#00bfa5;box-shadow:0 4px 16px rgba(0,191,165,.12);transform:translateY(-2px); }
.opt-card.selected { border-color:#00bfa5;background:#f0fff5;box-shadow:0 4px 16px rgba(0,191,165,.18); }
.opt-card-check {
    position:absolute;top:8px;right:8px;
    width:22px;height:22px;background:#e0e0e0;
    border-radius:50%;display:flex;align-items:center;justify-content:center;
    transition:all .2s;z-index:2;
}
.opt-card.selected .opt-card-check { background:#00bfa5; }
.opt-card-check svg { display:none; }
.opt-card.selected .opt-card-check svg { display:block; }
.opt-img-wrap {
    width:100%;aspect-ratio:4/3;background:#f8f8f8;
    display:flex;align-items:center;justify-content:center;overflow:hidden;padding:10px;
}
.opt-img-wrap img { max-width:100%;max-height:100%;object-fit:contain; }
.opt-img-wrap .opt-emoji { font-size:44px; }
.opt-label { padding:10px 12px 4px;font-size:13px;font-weight:700;color:#1a1a1a;text-align:center;line-height:1.3; }

.eval-continue-wrap { padding:24px 32px 28px; }
.eval-continue-btn {
    display:inline-flex;align-items:center;justify-content:center;gap:8px;
    padding:14px 40px;background:#00bfa5;color:#fff;border:none;border-radius:8px;
    font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;
    cursor:pointer;transition:all .2s;
}
.eval-continue-btn:hover { background:#00897b;box-shadow:0 8px 24px rgba(0,191,165,.3);transform:translateY(-1px); }
.eval-continue-btn:disabled { background:#e0e0e0;color:#aaa;cursor:not-allowed;box-shadow:none;transform:none; }

/* Verified badge */
.verified-badge {
    display:inline-flex;align-items:center;gap:6px;
    background:#e8f5e9;border:1px solid #c8f5d9;border-radius:8px;
    padding:8px 14px;font-size:13px;font-weight:700;color:#2e7d32;
    margin-top:12px;
}

/* Sidebar */
.eval-sidebar { position:sticky;top:20px; }
.ac-device-card { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.ac-device-top { display:flex;align-items:center;gap:14px;padding:18px 20px;border-bottom:1px solid #f0f0f0; }
.ac-device-img { width:60px;height:50px;object-fit:contain;background:#f7f9fc;border-radius:8px;padding:4px; }
.ac-device-img-ph { width:60px;height:50px;background:#f7f9fc;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:26px; }
.ac-device-name { font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#1a1a1a;line-height:1.2; }
.ac-device-spec { font-size:12px;color:#888;margin-top:3px; }
.ac-price-block { padding:14px 20px;border-bottom:1px solid #f0f0f0; }
.ac-price-label { font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.4px; }
.ac-price-val-live { font-family:'Nunito',sans-serif;font-size:28px;font-weight:900;color:#e53935;line-height:1.1; }
.ac-price-note { font-size:11px;color:#aaa;margin-top:3px; }
.ac-sb-section { padding:12px 20px 4px;font-size:11px;font-weight:800;color:#aaa;text-transform:uppercase;letter-spacing:.5px;border-top:1px solid #f0f0f0; }
.ac-sb-list { padding:0 20px 10px; }
.ac-sb-row { display:flex;align-items:flex-start;gap:8px;padding:5px 0;font-size:13px;color:#555; }
.ac-sb-dot { width:8px;height:8px;border-radius:50%;margin-top:4px;flex-shrink:0; }
.ac-sb-dot.good { background:#4caf50; }
.ac-sb-dot.bad  { background:#ef5350; }
.ac-sb-dot.info { background:#00bfa5; }
.ac-sb-q { color:#888;font-size:12px; }
.ac-sb-a { font-weight:700; }
.ac-sb-a.good { color:#2e7d32; }
.ac-sb-a.bad  { color:#c62828; }
.ac-sb-a.info { color:#00695c; }

/* ══ LOGIN POPUP WITH OTP ══ */
.modal-overlay {
    position:fixed;inset:0;background:rgba(0,0,0,.55);
    backdrop-filter:blur(3px);z-index:9999;
    display:none;align-items:center;justify-content:center;padding:16px;
}
.modal-overlay.show { display:flex;animation:fadeOv .2s ease; }
@keyframes fadeOv { from{opacity:0} to{opacity:1} }
.cashify-modal {
    background:#fff;border-radius:20px;max-width:720px;width:100%;
    overflow:hidden;display:flex;
    box-shadow:0 32px 80px rgba(0,0,0,.28);
    animation:slideM .32s cubic-bezier(.34,1.4,.64,1);
    position:relative;
}
@keyframes slideM { from{transform:translateY(60px) scale(.95);opacity:0} to{transform:translateY(0) scale(1);opacity:1} }
.modal-close-btn {
    position:absolute;top:14px;right:14px;width:32px;height:32px;
    border-radius:50%;background:rgba(0,0,0,.08);border:none;
    cursor:pointer;display:flex;align-items:center;justify-content:center;
    z-index:10;transition:background .2s;
}
.modal-close-btn:hover { background:rgba(0,0,0,.18); }
.modal-left {
    width:240px;flex-shrink:0;
    background:linear-gradient(160deg,#00bfa5 0%,#00897b 100%);
    display:flex;flex-direction:column;align-items:center;
    justify-content:space-between;padding:28px 16px 0;
    overflow:hidden;position:relative;
}
.modal-left-title { font-family:'Nunito',sans-serif;font-size:24px;font-weight:900;color:#fff;text-align:center;line-height:1.2; }
.modal-right { flex:1;padding:28px 28px 24px;display:flex;flex-direction:column;gap:16px; }
.modal-device-card { background:#f8f9fa;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:14px; }
.modal-device-img { width:56px;height:64px;background:#fff;border-radius:10px;border:1px solid #eee;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden; }
.modal-device-img img { max-height:58px;max-width:50px;object-fit:contain; }
.modal-device-name { font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;color:#1a1a1a;margin-bottom:2px; }
.modal-device-price-label { font-size:11px;color:#888;font-weight:500;margin-bottom:2px; }
.modal-device-price-val { font-family:'Nunito',sans-serif;font-size:26px;font-weight:900;color:#e53935;display:flex;align-items:baseline;gap:3px; }
.modal-device-price-val .rupee { font-size:18px; }
.modal-unlock { display:flex;align-items:center;gap:8px;background:#f0fff5;border:1px solid #c8f5d9;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;color:#00a846; }
.modal-name-label,.modal-phone-label { font-size:13px;font-weight:600;color:#555;margin-bottom:8px; }
.modal-name-wrap,.modal-phone-wrap { display:flex;align-items:center;border-bottom:2px solid #e0e0e0;padding-bottom:6px;transition:border-color .2s;margin-bottom:16px; }
.modal-name-wrap:focus-within,.modal-phone-wrap:focus-within { border-color:#00bfa5; }
.modal-name-input,.modal-phone-input { flex:1;border:none;outline:none;font-size:15px;font-weight:600;color:#1a1a1a;background:transparent;font-family:'Nunito Sans',sans-serif; }
.modal-name-input::placeholder,.modal-phone-input::placeholder { color:#bbb;font-weight:400; }
.modal-phone-prefix { font-size:15px;font-weight:700;color:#555;padding-right:10px;border-right:1px solid #ddd;margin-right:10px;flex-shrink:0; }
.modal-terms { display:flex;align-items:flex-start;gap:8px;font-size:12px;color:#777;line-height:1.5; }
.modal-terms input { margin-top:2px;accent-color:#00bfa5;width:15px;height:15px;flex-shrink:0; }
.modal-terms a { color:#00bfa5;font-weight:600;text-decoration:none; }
.modal-continue-btn {
    width:100%;padding:15px;background:#e0e0e0;color:#aaa;
    border:none;border-radius:10px;font-family:'Nunito',sans-serif;
    font-size:15px;font-weight:800;cursor:not-allowed;
    letter-spacing:.8px;transition:all .25s;text-transform:uppercase;
}
.modal-continue-btn.ready { background:#00bfa5;color:#fff;cursor:pointer;box-shadow:0 6px 20px rgba(0,191,165,.3); }
.modal-continue-btn.ready:hover { background:#00897b;transform:translateY(-1px); }
.otp-step { display:none; }
.otp-label { font-size:13px;font-weight:600;color:#555;margin-bottom:12px; }
.otp-label span { color:#00bfa5;font-weight:800; }
.otp-inputs { display:flex;gap:12px;justify-content:center;margin-bottom:16px; }
.otp-box { width:50px;height:56px;border:2px solid #e0e0e0;border-radius:12px;text-align:center;font-size:24px;font-weight:800;color:#333;outline:none;transition:all .2s; }
.otp-box:focus { border-color:#00bfa5;box-shadow:0 0 0 4px rgba(0,191,165,.1); }
.otp-resend { text-align:center;font-size:13px;color:#888; }
.otp-resend a { color:#00bfa5;font-weight:700;cursor:pointer;text-decoration:none; }
.otp-timer { color:#666;font-size:12px;margin-top:8px;text-align:center; }
.otp-error { color:#e53935;font-size:12px;text-align:center;margin-top:8px;display:none; }
.otp-error.show { display:block; }
.spinner { display:none;width:20px;height:20px;border:3px solid rgba(255,255,255,.3);border-radius:50%;border-top-color:#fff;animation:spin 1s ease-in-out infinite;margin-left:8px; }
@keyframes spin { to { transform: rotate(360deg); } }
.btn-loading .spinner { display:inline-block; }
.btn-loading { pointer-events:none;opacity:.8; }

@media(max-width:900px){
    .eval-layout { grid-template-columns:1fr; }
    .eval-sidebar { position:static; }
    .options-grid { grid-template-columns:repeat(2,1fr); }
    .question-block,.eval-panel-header,.eval-continue-wrap { padding-left:20px;padding-right:20px; }
}
@media(max-width:600px){
    .cashify-modal { flex-direction:column; }
    .modal-left { width:100%;min-height:120px;flex-direction:row;padding:18px 20px; }
    .modal-left-title { font-size:18px; }
    .options-grid { grid-template-columns:1fr 1fr; }
    .otp-box { width:44px;height:50px;font-size:20px; }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

<div class="eval-wrap">

    <div class="ac-breadcrumb">
        <a href="{{ route('sell.index') }}">Home</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.index') }}">Sell Old Laptop</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.brand.models', $brand->slug) }}">{{ $brand->name }}</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a><span class="sep">›</span>
        <span class="active">Physical Condition</span>
    </div>

    <div class="eval-layout">

        <div>
            <div class="eval-panel">
                <div class="eval-panel-header">
                    <h2>Select the physical condition of your device?</h2>
                    <p>The better condition your device is in, we will pay you more</p>

                    {{-- ── FIX: Show verified badge — uses $verifiedCustomer from controller ── --}}
                    @if($isVerified && $verifiedCustomer)
                    <!-- <div class="verified-badge">
                        <svg width="16" height="16" fill="none" stroke="#2e7d32" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M20 6L9 17l-5-5"/>
                        </svg>
                        Logged in as {{ $verifiedCustomer['name'] }} &nbsp;·&nbsp; {{ $verifiedCustomer['mobile'] }}
                    </div>
                    @endif
                </div> -->

                @forelse($questions as $q)
                <div class="question-block">
                    <div class="question-title">{{ $q->question }}</div>
                    @if($q->small_description)
                    <div class="question-sub">{{ $q->small_description }}</div>
                    @endif
                    <div class="options-grid" id="opts-{{ $q->id }}">
                        @foreach($q->options->sortBy('sort_order') as $opt)
                        <div class="opt-card"
                             id="opt-card-{{ $opt->id }}"
                             data-question="{{ $q->id }}"
                             data-option="{{ $opt->id }}"
                             data-label="{{ $opt->label }}"
                             data-deduction="{{ $opt->deduction ?? 0 }}"
                             data-input="{{ $q->input_type }}"
                             onclick="selectOption({{ $q->id }}, {{ $opt->id }}, '{{ $q->input_type }}', this)">
                            <div class="opt-card-check">
                                <svg width="10" height="10" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                            <div class="opt-img-wrap">
                                @if($opt->option_image)
                                    <img src="{{ asset('storage/'.$opt->option_image) }}" alt="{{ $opt->label }}">
                                @elseif($opt->icon_emoji)
                                    <span class="opt-emoji">{{ $opt->icon_emoji }}</span>
                                @else
                                    <span class="opt-emoji">🖥️</span>
                                @endif
                            </div>
                            <div class="opt-label">{{ $opt->label }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:40px 20px;color:#aaa;">
                    <div style="font-size:40px;margin-bottom:10px;">🔧</div>
                    <p>No condition questions configured yet.</p>
                </div>
                @endforelse

                <div class="eval-continue-wrap">
                    <button class="eval-continue-btn" id="condContinueBtn" disabled onclick="handleGetBestPrice()">
                        Get Best Price
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="eval-sidebar">
            <div class="ac-device-card">
                <div class="ac-device-top">
                    @if($model->image)
                        <img class="ac-device-img" src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
                    @else
                        <div class="ac-device-img-ph">💻</div>
                    @endif
                    <div>
                        <div class="ac-device-name">{{ $model->name }}</div>
                        <div class="ac-device-spec">
                            {{ $brand->name }}
                            @if($variant) · {{ $variant->storage }} · {{ $variant->ram }} @endif
                        </div>
                    </div>
                </div>
                <div class="ac-price-block">
                    <div class="ac-price-label">Estimated Price</div>
                    <div class="ac-price-val-live" id="pricePreview">₹ XXXXX</div>
                    <div class="ac-price-note">
                        @if($isVerified) Your evaluation price @else Revealed after login @endif
                    </div>
                </div>
                @foreach($summary as $sec)
                <div class="ac-sb-section">{{ $sec['section'] }}</div>
                <div class="ac-sb-list">
                    @foreach($sec['items'] as $item)
                    <div class="ac-sb-row">
                        <span class="ac-sb-dot {{ $item['type'] }}"></span>
                        <div>
                            <div class="ac-sb-q">{{ $item['q'] }}</div>
                            <div class="ac-sb-a {{ $item['type'] }}">{{ $item['a'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
                <div class="ac-sb-section">Physical Condition</div>
                <div class="ac-sb-list">
                    <div id="condSummary">
                        <div class="ac-sb-row" style="color:#bbb;font-style:italic;font-size:13px;">
                            <span>Select options above</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden form for direct submit (used when already verified OR after OTP verify) --}}
<form method="POST"
      action="{{ route('sell.laptop.physical-condition.submit', [$brand->slug, $model->slug]) }}"
      id="directSubmitForm" style="display:none;">
    @csrf
    <input type="hidden" id="ds_answers"   name="answers"   value="">
    <input type="hidden" id="ds_deduction" name="deduction" value="0">
    @foreach(request()->except(['_token']) as $key => $val)
        @if($key !== '_token')
            <input type="hidden" name="{{ $key }}" value="{{ is_array($val) ? implode(',', $val) : $val }}">
        @endif
    @endforeach
</form>

{{-- ══ LOGIN POPUP — only rendered when NOT already verified ══ --}}
@if(!$isVerified)
<div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
    <div class="cashify-modal" id="cashifyModal">
        <button class="modal-close-btn" onclick="closePopup()">
            <svg width="14" height="14" fill="none" stroke="#444" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <div class="modal-left">
            <div class="modal-left-title">Login/<br>Signup</div>
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
                        <div style="font-size:26px;opacity:.35;">💻</div>
                    @endif
                </div>
                <div>
                    <div class="modal-device-name">{{ $model->name }}</div>
                    <div class="modal-device-price-label">Your Selling Price</div>
                    <div class="modal-device-price-val">
                        <span class="rupee">₹</span>
                        <span>XXXXX</span>
                    </div>
                </div>
            </div>
            <div class="modal-unlock">
                <svg width="16" height="16" fill="none" stroke="#00a846" stroke-width="2.5" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
                </svg>
                Login to unlock the best price
            </div>
            {{-- STEP 1 --}}
            <div id="phoneStep">
                <div>
                    <div class="modal-name-label">Enter your full name</div>
                    <div class="modal-name-wrap">
                        <input type="text" id="modalName" class="modal-name-input" placeholder="Your Name" maxlength="50" oninput="onFormInput()">
                    </div>
                </div>
                <div>
                    <div class="modal-phone-label">Enter your phone number</div>
                    <div class="modal-phone-wrap">
                        <span class="modal-phone-prefix">+91</span>
                        <input type="tel" id="modalPhone" class="modal-phone-input" placeholder="Enter your Mobile" maxlength="10" oninput="onFormInput()">
                    </div>
                </div>
                <div class="modal-terms">
                    <input type="checkbox" id="modalTerms" onchange="onFormInput()">
                    <label for="modalTerms">I agree to the <a href="#">Terms and Conditions</a> &amp; <a href="#">Privacy Policy</a></label>
                </div>
                <button type="button" class="modal-continue-btn" id="sendOtpBtn" onclick="sendOTP()">
                    <span>SEND OTP</span><div class="spinner"></div>
                </button>
            </div>
            {{-- STEP 2 --}}
            <div id="otpStep" class="otp-step">
                <div class="otp-label">Enter OTP sent to +91 <span id="otpPhoneDisplay"></span></div>
                <div class="otp-inputs">
                    <input type="tel" class="otp-box" id="otp1" maxlength="1" oninput="handleOtpInput(this,'otp2')" onkeydown="handleOtpKeydown(this,event)">
                    <input type="tel" class="otp-box" id="otp2" maxlength="1" oninput="handleOtpInput(this,'otp3')" onkeydown="handleOtpKeydown(this,event)">
                    <input type="tel" class="otp-box" id="otp3" maxlength="1" oninput="handleOtpInput(this,'otp4')" onkeydown="handleOtpKeydown(this,event)">
                    <input type="tel" class="otp-box" id="otp4" maxlength="1" oninput="handleOtpInput(this,'otp5')" onkeydown="handleOtpKeydown(this,event)">
                    <input type="tel" class="otp-box" id="otp5" maxlength="1" oninput="handleOtpInput(this,'otp6')" onkeydown="handleOtpKeydown(this,event)">
                    <input type="tel" class="otp-box" id="otp6" maxlength="1" oninput="handleOtpInput(this,null)"  onkeydown="handleOtpKeydown(this,event)">
                </div>
                <div class="otp-error" id="otpError">Invalid OTP. Please try again.</div>
                <div class="otp-resend">Didn't receive? <a onclick="resendOTP()" id="resendLink">Resend OTP</a></div>
                <div class="otp-timer" id="otpTimer">Resend available in 30s</div>
                <button type="button" class="modal-continue-btn ready" id="verifyOtpBtn" onclick="verifyOTP()">
                    VERIFY & GET PRICE
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
(function () {
    const isAlreadyVerified = {{ $isVerified ? 'true' : 'false' }};
    const answers  = {};
    const multiAns = {};

    window.selectOption = function (qId, optId, inputType, el) {
        if (inputType === 'radio') {
            document.querySelectorAll('#opts-' + qId + ' .opt-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            answers[qId] = { optionId: optId, label: el.dataset.label, deduction: parseInt(el.dataset.deduction) || 0, isMulti: false };
        } else {
            if (!multiAns[qId]) multiAns[qId] = {};
            if (multiAns[qId][optId]) {
                delete multiAns[qId][optId];
                el.classList.remove('selected');
            } else {
                multiAns[qId][optId] = { label: el.dataset.label, deduction: parseInt(el.dataset.deduction) || 0 };
                el.classList.add('selected');
            }
            answers[qId] = { isMulti: true, items: multiAns[qId] };
        }
        updateCondSummary();
        checkCanContinue();
    };

    function getTotalDeduction() {
        let total = 0;
        Object.values(answers).forEach(a => {
            if (a.isMulti) Object.values(a.items || {}).forEach(i => { total += i.deduction || 0; });
            else total += a.deduction || 0;
        });
        return total;
    }

    function buildPayload() {
        const payload = {};
        Object.entries(answers).forEach(([qId, a]) => {
            if (a.isMulti) payload[qId] = Object.keys(a.items || {});
            else payload[qId] = [a.optionId];
        });
        return payload;
    }

    function updateCondSummary() {
        const container = document.getElementById('condSummary');
        const items     = [];
        Object.values(answers).forEach(a => {
            if (a.isMulti) Object.values(a.items || {}).forEach(i => items.push(i.label));
            else if (a.label) items.push(a.label);
        });
        if (!items.length) {
            container.innerHTML = '<div class="ac-sb-row" style="color:#bbb;font-style:italic;font-size:13px;"><span>Select options above</span></div>';
            return;
        }
        container.innerHTML = items.map(l =>
            `<div class="ac-sb-row"><span class="ac-sb-dot good"></span><div><div class="ac-sb-a good">${esc(l)}</div></div></div>`
        ).join('');
    }

    function checkCanContinue() {
        let answered = 0;
        @foreach($questions->where('input_type','radio') as $rq)
        if (answers[{{ $rq->id }}] && !answers[{{ $rq->id }}].isMulti) answered++;
        @endforeach
        document.getElementById('condContinueBtn').disabled =
            (answered < {{ $questions->where('input_type','radio')->count() }});
    }

    function esc(s) {
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    // ── Main CTA handler ─────────────────────────────────────────────────────
    window.handleGetBestPrice = function () {
        const payload   = buildPayload();
        const deduction = getTotalDeduction();

        if (isAlreadyVerified) {
            // ── Already logged in: submit form directly, no popup needed ──────
            document.getElementById('ds_answers').value   = JSON.stringify(payload);
            document.getElementById('ds_deduction').value = deduction;
            document.getElementById('directSubmitForm').submit();
            return;
        }

        // Not verified → show login popup
        openPopup(payload, deduction);
    };

    let pendingPayload   = null;
    let pendingDeduction = 0;
    let currentPhone     = '';
    let resendTimer      = null;

    window.openPopup = function (payload, deduction) {
        pendingPayload   = payload;
        pendingDeduction = deduction;

        document.getElementById('phoneStep').style.display = 'block';
        document.getElementById('otpStep').style.display   = 'none';
        document.getElementById('modalName').value         = '';
        document.getElementById('modalPhone').value        = '';
        document.getElementById('modalTerms').checked      = false;
        document.getElementById('sendOtpBtn').classList.remove('ready');
        document.querySelectorAll('.otp-box').forEach(b => { b.value = ''; b.style.borderColor = '#e0e0e0'; });

        document.getElementById('modalOverlay').classList.add('show');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('modalName').focus(), 300);
    };

    window.closePopup = function () {
        document.getElementById('modalOverlay').classList.remove('show');
        document.body.style.overflow = '';
        clearInterval(resendTimer);
    };

    window.handleOverlayClick = function (e) {
        if (e.target === document.getElementById('modalOverlay')) closePopup();
    };

    window.onFormInput = function () {
        const name  = document.getElementById('modalName').value.trim();
        const phone = document.getElementById('modalPhone').value.replace(/\D/g,'');
        document.getElementById('modalPhone').value = phone.slice(0,10);
        const terms = document.getElementById('modalTerms').checked;
        const valid = name.length >= 2 && phone.length === 10 && /^[6-9]/.test(phone) && terms;
        document.getElementById('sendOtpBtn').classList.toggle('ready', valid);
    };

    window.sendOTP = function () {
        const btn = document.getElementById('sendOtpBtn');
        if (!btn.classList.contains('ready')) return;
        currentPhone = document.getElementById('modalPhone').value;
        const name   = document.getElementById('modalName').value.trim();
        btn.classList.add('btn-loading');
        fetch('{{ route("sell.laptop.otp.send") }}', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body: JSON.stringify({ mobile: currentPhone, name })
        })
        .then(r => r.json())
        .then(data => {
            btn.classList.remove('btn-loading');
            if (data.success) showOtpStep();
            else alert(data.message || 'Failed to send OTP');
        })
        .catch(() => { btn.classList.remove('btn-loading'); alert('Network error. Please try again.'); });
    };

    function showOtpStep() {
        document.getElementById('phoneStep').style.display = 'none';
        document.getElementById('otpStep').style.display   = 'block';
        document.getElementById('otpPhoneDisplay').textContent = currentPhone;
        document.getElementById('otpError').classList.remove('show');
        document.getElementById('otp1').focus();
        startResendTimer();
    }

    window.handleOtpInput = function (el, nextId) {
        el.value = el.value.replace(/\D/,'');
        if (el.value && nextId) document.getElementById(nextId).focus();
    };

    window.handleOtpKeydown = function (el, e) {
        if (e.key === 'Backspace' && !el.value) {
            const prev = el.previousElementSibling;
            if (prev && prev.classList.contains('otp-box')) prev.focus();
        }
    };

    window.verifyOTP = function () {
        const otp = Array.from(document.querySelectorAll('.otp-box')).map(b => b.value).join('');
        if (otp.length !== 6) return;
        const btn = document.getElementById('verifyOtpBtn');
        btn.classList.add('btn-loading');
        fetch('{{ route("sell.laptop.otp.verify") }}', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
            body: JSON.stringify({ otp })
        })
        .then(r => r.json())
        .then(data => {
            btn.classList.remove('btn-loading');
            if (data.success) {
                // OTP verified → submit form directly
                closePopup();
                document.getElementById('ds_answers').value   = JSON.stringify(pendingPayload || {});
                document.getElementById('ds_deduction').value = pendingDeduction || 0;
                document.getElementById('directSubmitForm').submit();
            } else {
                document.getElementById('otpError').textContent = data.message || 'Invalid OTP';
                document.getElementById('otpError').classList.add('show');
                document.querySelectorAll('.otp-box').forEach(b => { b.style.borderColor='#e53935'; b.value=''; });
                document.getElementById('otp1').focus();
            }
        })
        .catch(() => { btn.classList.remove('btn-loading'); alert('Verification failed. Please try again.'); });
    };

    window.resendOTP = function () {
        const link = document.getElementById('resendLink');
        if (link.style.pointerEvents === 'none') return;
        fetch('{{ route("sell.laptop.otp.resend") }}', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                startResendTimer();
                document.querySelectorAll('.otp-box').forEach(b => { b.value=''; b.style.borderColor='#e0e0e0'; });
                document.getElementById('otp1').focus();
                document.getElementById('otpError').classList.remove('show');
            }
        });
    };

    function startResendTimer() {
        const link  = document.getElementById('resendLink');
        const timer = document.getElementById('otpTimer');
        let seconds = 30;
        link.style.pointerEvents = 'none';
        link.style.opacity       = '0.5';
        timer.style.display      = 'block';
        clearInterval(resendTimer);
        resendTimer = setInterval(() => {
            seconds--;
            timer.textContent = `Resend available in ${seconds}s`;
            if (seconds <= 0) {
                clearInterval(resendTimer);
                link.style.pointerEvents = 'auto';
                link.style.opacity       = '1';
                timer.style.display      = 'none';
            }
        }, 1000);
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closePopup(); });
})();
</script>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>