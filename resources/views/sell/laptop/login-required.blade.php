{{-- resources/views/sell/laptop/login-required.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login to Continue – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
body { background: #f4f6f8; }
.lr-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 28px 20px 60px;
}
.lr-breadcrumb {
    display: flex; align-items: center; gap: 5px;
    font-size: 13px; color: #888; margin-bottom: 24px; flex-wrap: wrap;
}
.lr-breadcrumb a { color: #888; text-decoration: none; }
.lr-breadcrumb .sep { color: #ccc; }
.lr-breadcrumb .active { color: #222; font-weight: 600; }

.lr-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 20px;
    align-items: start;
}

/* ── Main Card ── */
.lr-card {
    background: #fff;
    border: 1.5px solid #e8e8e8;
    border-radius: 16px;
    overflow: hidden;
}

/* Top teal banner */
.lr-banner {
    background: linear-gradient(135deg, #00bfa5 0%, #00897b 100%);
    padding: 36px 40px;
    display: flex;
    align-items: center;
    gap: 24px;
}
.lr-banner-icon {
    width: 72px; height: 72px;
    background: rgba(255,255,255,.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 34px;
    flex-shrink: 0;
}
.lr-banner-text h2 {
    font-family: 'Nunito', sans-serif;
    font-size: 22px; font-weight: 900;
    color: #fff; margin: 0 0 6px;
}
.lr-banner-text p {
    font-size: 14px; color: rgba(255,255,255,.85); margin: 0;
    line-height: 1.5;
}

/* Device info row */
.lr-device-row {
    display: flex; align-items: center; gap: 14px;
    padding: 18px 40px;
    border-bottom: 1.5px solid #f0f0f0;
    background: #fafafa;
}
.lr-device-img {
    width: 52px; height: 44px; object-fit: contain;
    background: #f0f0f0; border-radius: 8px; padding: 4px;
}
.lr-device-img-placeholder {
    width: 52px; height: 44px;
    background: #f0f0f0; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; font-size: 22px;
}
.lr-device-name { font-weight: 700; color: #1a1a1a; font-size: 14px; }
.lr-device-sub  { font-size: 12px; color: #888; }

/* Price hidden block */
.lr-price-row {
    display: flex; align-items: center; gap: 16px;
    padding: 20px 40px;
    border-bottom: 1.5px solid #f0f0f0;
}
.lr-price-label { font-size: 13px; color: #555; font-weight: 600; }
.lr-price-hidden {
    font-family: 'Nunito', sans-serif;
    font-size: 28px; font-weight: 900; color: #e53935;
    letter-spacing: 4px;
}
.lr-lock-badge {
    background: #e0f2f1; color: #00695c;
    font-size: 12px; font-weight: 700;
    padding: 4px 12px; border-radius: 20px;
    display: flex; align-items: center; gap: 5px;
}

/* Form area */
.lr-form-area { padding: 30px 40px; }
.lr-form-title {
    font-family: 'Nunito', sans-serif;
    font-size: 16px; font-weight: 800; color: #1a1a1a;
    margin-bottom: 20px;
    display: flex; align-items: center; gap: 8px;
}
.lr-input-group { margin-bottom: 18px; }
.lr-input-group label {
    font-size: 13px; font-weight: 700; color: #555;
    display: block; margin-bottom: 7px;
}
.lr-phone-wrap {
    display: flex; align-items: center;
    border: 2px solid #e0e0e0;
    border-radius: 10px; overflow: hidden;
    transition: border-color .15s;
}
.lr-phone-wrap:focus-within { border-color: #00bfa5; }
.lr-phone-prefix {
    background: #f4f6f8;
    padding: 13px 14px;
    font-size: 15px; font-weight: 700; color: #333;
    border-right: 1.5px solid #e0e0e0;
    white-space: nowrap;
}
.lr-phone-input {
    flex: 1; border: none; outline: none;
    padding: 13px 14px;
    font-family: 'Nunito Sans', sans-serif;
    font-size: 15px; font-weight: 600; color: #333;
    background: transparent;
}
.lr-phone-input::placeholder { color: #bbb; font-weight: 400; }

.lr-terms {
    display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 22px;
    font-size: 13px; color: #666;
}
.lr-terms input[type=checkbox] {
    width: 17px; height: 17px; margin-top: 1px;
    accent-color: #00bfa5; cursor: pointer; flex-shrink: 0;
}
.lr-terms a { color: #00897b; text-decoration: none; font-weight: 600; }
.lr-terms a:hover { text-decoration: underline; }

.lr-submit-btn {
    width: 100%;
    background: #e0e0e0; color: #bbb;
    border: none; border-radius: 10px;
    padding: 15px;
    font-family: 'Nunito', sans-serif;
    font-size: 16px; font-weight: 800;
    cursor: not-allowed;
    transition: all .2s;
    letter-spacing: .3px;
}
.lr-submit-btn.active {
    background: #00bfa5; color: #fff; cursor: pointer;
}
.lr-submit-btn.active:hover {
    background: #00897b;
    box-shadow: 0 6px 20px rgba(0,191,165,.3);
}

.lr-divider {
    display: flex; align-items: center; gap: 12px;
    margin: 18px 0; color: #ccc; font-size: 12px;
}
.lr-divider::before,
.lr-divider::after {
    content: ''; flex: 1; height: 1px; background: #eee;
}

/* ── Right Sidebar ── */
.lr-sidebar { position: sticky; top: 20px; }
.lr-side-card {
    background: #fff; border: 1.5px solid #e8e8e8;
    border-radius: 16px; overflow: hidden;
}
.lr-side-top {
    display: flex; align-items: center; gap: 14px;
    padding: 18px 20px; border-bottom: 1px solid #f0f0f0;
}
.lr-side-img {
    width: 60px; height: 50px; object-fit: contain;
    background: #f7f9fc; border-radius: 8px; padding: 4px;
}
.lr-side-img-ph {
    width: 60px; height: 50px; background: #f7f9fc;
    border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 26px;
}
.lr-side-name { font-family: 'Nunito', sans-serif; font-size: 15px; font-weight: 800; color: #1a1a1a; }
.lr-side-sub  { font-size: 12px; color: #888; margin-top: 3px; }
.lr-side-price-block { padding: 14px 20px; border-bottom: 1px solid #f0f0f0; }
.lr-side-price-label { font-size: 11px; color: #aaa; font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }
.lr-side-price-val {
    font-family: 'Nunito', sans-serif; font-size: 28px; font-weight: 900; color: #e53935;
    letter-spacing: 4px;
}
.lr-side-price-note { font-size: 11px; color: #aaa; margin-top: 3px; }
.lr-side-eval-title {
    padding: 14px 20px 8px;
    font-size: 12px; font-weight: 800; color: #aaa;
    text-transform: uppercase; letter-spacing: .5px;
}
.lr-side-eval-row {
    display: flex; align-items: flex-start; gap: 8px;
    padding: 5px 20px; font-size: 13px;
}
.lr-side-eval-dot { width: 8px; height: 8px; border-radius: 50%; margin-top: 4px; flex-shrink: 0; background: #ef5350; }
.lr-side-eval-q { color: #888; font-size: 12px; }
.lr-side-eval-a { font-weight: 700; color: #c62828; }

@media(max-width:820px) {
    .lr-layout { grid-template-columns: 1fr; }
    .lr-sidebar { position: static; }
    .lr-banner { padding: 24px 20px; }
    .lr-device-row, .lr-price-row, .lr-form-area { padding: 16px 20px; }
    .lr-banner-text h2 { font-size: 18px; }
}
</style>
</head>
<body>
@include('sell.partials.navbar')

<div class="lr-wrap">

    <div class="lr-breadcrumb">
        <a href="{{ route('sell.index') }}">Home</a>
        <span class="sep">›</span>
        <a href="{{ route('sell.laptop.index') }}">Sell Old Laptop</a>
        <span class="sep">›</span>
        <a href="{{ route('sell.laptop.brand.models', $brand->slug) }}">{{ $brand->name }}</a>
        <span class="sep">›</span>
        <a href="{{ route('sell.laptop.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a>
        <span class="sep">›</span>
        <span class="active">Login to Continue</span>
    </div>

    <div class="lr-layout">

        {{-- LEFT: Login Card --}}
        <div class="lr-card">

            {{-- Banner --}}
            <div class="lr-banner">
                <div class="lr-banner-icon">🔐</div>
                <div class="lr-banner-text">
                    <h2>Login to Unlock the Best Price</h2>
                    <p>Your selling price is ready. Login with your mobile number to see your offer and book a free pickup.</p>
                </div>
            </div>

            {{-- Device row --}}
            <div class="lr-device-row">
                @if($model->image)
                    <img class="lr-device-img"
                         src="{{ asset('storage/'.$model->image) }}"
                         alt="{{ $model->name }}">
                @else
                    <div class="lr-device-img-placeholder">💻</div>
                @endif
                <div>
                    <div class="lr-device-name">{{ $model->name }}</div>
                    <div class="lr-device-sub">
                        {{ $brand->name }}
                        @if($variant) · {{ $variant->storage }} · {{ $variant->ram }} @endif
                        · Selling Price
                    </div>
                </div>
            </div>

            {{-- Hidden Price Row --}}
            <div class="lr-price-row">
                <div>
                    <div class="lr-price-label">Selling Price</div>
                    <div class="lr-price-hidden">₹ XX,XXX</div>
                </div>
                <div class="lr-lock-badge">
                    🔒 Login to unlock
                </div>
            </div>

            {{-- Form --}}
            <div class="lr-form-area">
                <div class="lr-form-title">
                    📱 Enter your phone number
                </div>

                <form id="loginForm" action="{{ route('login') }}" method="POST">
                    @csrf

                    {{-- Hidden fields to preserve context --}}
                    <input type="hidden" name="redirect_after_login"
                           value="{{ route('sell.laptop.system-config', [$brand->slug, $model->slug]) }}?power_on=no{{ $variant ? '&variant='.$variant->id : '' }}">

                    <div class="lr-input-group">
                        <label>Mobile Number <span style="color:#ef5350;">*</span></label>
                        <div class="lr-phone-wrap">
                            <span class="lr-phone-prefix">🇮🇳 +91</span>
                            <input type="tel"
                                   name="phone"
                                   id="phoneInput"
                                   class="lr-phone-input"
                                   placeholder="Enter your Mobile"
                                   maxlength="10"
                                   pattern="[0-9]{10}"
                                   autocomplete="tel"
                                   oninput="checkForm()">
                        </div>
                    </div>

                    <div class="lr-terms">
                        <input type="checkbox" id="termsCheck" onchange="checkForm()">
                        <label for="termsCheck">
                            I agree to the
                            <a href="#">Terms and Conditions</a> &
                            <a href="#">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="lr-submit-btn" id="submitBtn" disabled>
                        CONTINUE
                    </button>

                </form>

                <div class="lr-divider">or</div>

                <a href="{{ route('sell.laptop.system-config', [$brand->slug, $model->slug]) }}?power_on=no{{ $variant ? '&variant='.$variant->id : '' }}"
                   style="display:block;text-align:center;font-size:13px;color:#00897b;font-weight:700;text-decoration:none;padding:8px;">
                    Skip for now →
                </a>

            </div>
        </div>

        {{-- RIGHT: Sidebar --}}
        <div class="lr-sidebar">
            <div class="lr-side-card">

                <div class="lr-side-top">
                    @if($model->image)
                        <img class="lr-side-img"
                             src="{{ asset('storage/'.$model->image) }}"
                             alt="{{ $model->name }}">
                    @else
                        <div class="lr-side-img-ph">💻</div>
                    @endif
                    <div>
                        <div class="lr-side-name">{{ $model->name }}</div>
                        <div class="lr-side-sub">{{ $brand->name }}</div>
                    </div>
                </div>

                <div class="lr-side-price-block">
                    <div class="lr-side-price-label">Selling Price</div>
                    <div class="lr-side-price-val">₹ XX,XXX</div>
                    <div class="lr-side-price-note">Login to see your price</div>
                </div>

                <div class="lr-side-eval-title">Device Evaluation</div>
                <div class="lr-side-eval-row">
                    <span class="lr-side-eval-dot"></span>
                    <div>
                        <div class="lr-side-eval-q">Does the Laptop switch on?</div>
                        <div class="lr-side-eval-a">No / Not sure</div>
                    </div>
                </div>
                <div style="padding:0 20px 16px;"></div>

            </div>
        </div>

    </div>
</div>

<script>
function checkForm() {
    const phone = document.getElementById('phoneInput').value;
    const terms = document.getElementById('termsCheck').checked;
    const btn   = document.getElementById('submitBtn');

    if (phone.length === 10 && /^[0-9]+$/.test(phone) && terms) {
        btn.classList.add('active');
        btn.disabled = false;
    } else {
        btn.classList.remove('active');
        btn.disabled = true;
    }
}
</script>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>