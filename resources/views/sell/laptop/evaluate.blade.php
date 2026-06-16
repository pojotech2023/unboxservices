{{-- resources/views/sell/laptop/evaluate.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Evaluate {{ $model->name }} – Laptop Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #f4f6f8; font-family: 'Nunito Sans', sans-serif; }
.ev-wrap { max-width: 1100px; margin: 0 auto; padding: 28px 20px 60px; }
.ev-breadcrumb { display:flex;align-items:center;gap:5px;font-size:13px;color:#888;margin-bottom:24px;flex-wrap:wrap; }
.ev-breadcrumb a { color:#888;text-decoration:none; }
.ev-breadcrumb a:hover { color:#00bfa5; }
.ev-breadcrumb .sep { color:#ccc; }
.ev-breadcrumb .active { color:#222;font-weight:600; }
.ev-layout { display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start; }
.ev-question-panel { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.ev-progress-bar { height:5px;background:#f0f0f0; }
.ev-progress-fill { height:100%;background:linear-gradient(90deg,#00bfa5,#00897b);border-radius:0 3px 3px 0;transition:width .4s ease; }
.ev-q-header { padding:24px 30px 0;display:flex;align-items:center;gap:14px; }
.ev-q-step-badge { background:#e0f2f1;color:#00897b;font-family:'Nunito',sans-serif;font-size:12px;font-weight:800;padding:4px 10px;border-radius:20px;white-space:nowrap; }
.ev-q-category { font-size:12px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.5px; }
.ev-q-text { padding:16px 30px 8px;font-family:'Nunito',sans-serif;font-size:22px;font-weight:900;color:#1a1a1a;line-height:1.3; }
.ev-q-hint { padding:0 30px 24px;font-size:13px;color:#aaa;line-height:1.5; }
.ev-options { display:grid;grid-template-columns:1fr 1fr;gap:12px;padding:0 30px 30px; }
.ev-option { border:2px solid #e0e0e0;border-radius:12px;padding:18px 20px;cursor:pointer;transition:all .18s ease;display:flex;align-items:center;gap:12px;font-family:'Nunito Sans',sans-serif;font-size:15px;font-weight:600;color:#333;background:#fff;user-select:none; }
.ev-option:hover { border-color:#00bfa5;background:#f0fffe;color:#00897b; }
.ev-option.selected-yes { border-color:#00bfa5;background:#e0f2f1;color:#00695c; }
.ev-option.selected-no  { border-color:#ef5350;background:#fff5f5;color:#c62828; }
.ev-opt-icon  { font-size:22px;width:30px;text-align:center;flex-shrink:0; }
.ev-opt-label { flex:1; }
.ev-opt-tick  { width:22px;height:22px;border:2px solid #ccc;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:12px;color:transparent;transition:all .15s; }
.ev-option.selected-yes .ev-opt-tick { background:#00bfa5;border-color:#00bfa5;color:#fff; }
.ev-option.selected-no  .ev-opt-tick { background:#ef5350;border-color:#ef5350;color:#fff; }
.ev-nav { display:flex;align-items:center;justify-content:space-between;padding:20px 30px;border-top:1.5px solid #f0f0f0;background:#fafafa; }
.ev-btn-next { background:#00bfa5;border:none;border-radius:8px;padding:12px 30px;font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#fff;cursor:pointer;transition:all .18s;display:flex;align-items:center;gap:8px; }
.ev-btn-next:hover { background:#00897b;box-shadow:0 4px 16px rgba(0,191,165,.3); }
.ev-btn-next:disabled { background:#e0e0e0;color:#bbb;cursor:not-allowed;box-shadow:none; }
.ev-sidebar { position:sticky;top:20px; }
.ev-device-card { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.ev-device-top { display:flex;align-items:center;gap:14px;padding:18px 20px;border-bottom:1px solid #f0f0f0; }
.ev-device-img { width:60px;height:50px;object-fit:contain;background:#f7f9fc;border-radius:8px;padding:4px; }
.ev-device-img-placeholder { width:60px;height:50px;background:#f7f9fc;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:26px; }
.ev-device-name { font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#1a1a1a;line-height:1.2; }
.ev-device-spec { font-size:12px;color:#888;margin-top:3px; }
.ev-price-block { padding:14px 20px;border-bottom:1px solid #f0f0f0; }
.ev-price-label { font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.4px; }
.ev-price-val { font-family:'Nunito',sans-serif;font-size:28px;font-weight:900;color:#e53935;line-height:1.1; }
.ev-price-val span { font-size:16px;vertical-align:super;font-weight:800; }
@media(max-width:820px) { .ev-layout { grid-template-columns:1fr; } .ev-sidebar { position:static; } .ev-options { grid-template-columns:1fr; } .ev-q-text { font-size:18px; } }

/* Login Popup Styles */
.lp-overlay { display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9000;align-items:center;justify-content:center; }
.lp-overlay.open { display:flex; }
.lp-modal { background:#fff;border-radius:18px;overflow:hidden;display:flex;width:720px;max-width:95vw;max-height:95vh;box-shadow:0 24px 60px rgba(0,0,0,.25);position:relative;animation:lpIn .28s ease; }
@keyframes lpIn { from{opacity:0;transform:scale(.93)} to{opacity:1;transform:scale(1)} }
.lp-close { position:absolute;top:14px;right:16px;background:rgba(255,255,255,.25);border:none;border-radius:50%;width:32px;height:32px;font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#fff;z-index:2; }
.lp-left { width:260px;background:linear-gradient(160deg,#00c9b1 0%,#00897b 100%);padding:40px 28px;display:flex;flex-direction:column;justify-content:space-between;flex-shrink:0; }
.lp-left-title { font-family:'Nunito',sans-serif;font-size:26px;font-weight:900;color:#fff;line-height:1.2; }
.lp-right { flex:1;padding:30px 28px 28px;display:flex;flex-direction:column; }
.lp-input-group { margin-bottom:20px; }
.lp-input-label { font-size:13px;color:#888;font-weight:600;margin-bottom:8px; }
.lp-input { width:100%;padding:12px 16px;border:2px solid #e0e0e0;border-radius:10px;font-family:'Nunito Sans',sans-serif;font-size:15px;outline:none;transition:border-color .15s; }
.lp-input:focus { border-color:#00bfa5; }
.lp-phone-wrap { display:flex;align-items:center;border:2px solid #e0e0e0;border-radius:10px;padding:12px 16px; }
.lp-phone-prefix { font-family:'Nunito',sans-serif;font-size:15px;font-weight:700;color:#555;margin-right:10px;padding-right:10px;border-right:1px solid #ddd; }
.lp-phone-input { flex:1;border:none;outline:none;font-size:15px;font-weight:600;color:#333;background:transparent; }
.lp-terms { display:flex;align-items:flex-start;gap:10px;margin:20px 0;font-size:12px;color:#888; }
.lp-terms input { width:16px;height:16px;margin-top:2px;accent-color:#00bfa5; }
.lp-continue-btn { width:100%;background:#e0e0e0;color:#bbb;border:none;border-radius:10px;padding:15px;font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;cursor:not-allowed;transition:all .2s; }
.lp-continue-btn.active { background:#00bfa5;color:#fff;cursor:pointer; }
.lp-continue-btn.active:hover { background:#00897b; }
.lp-otp-inputs { display:flex;gap:10px;margin:10px 0; }
.lp-otp-box { width:50px;height:56px;border:2px solid #e0e0e0;border-radius:10px;text-align:center;font-family:'Nunito',sans-serif;font-size:22px;font-weight:800;outline:none; }
.lp-otp-box:focus { border-color:#00bfa5; }
.lp-error { color:#e53935;font-size:12px;margin-top:-10px;margin-bottom:10px;display:none; }
.lp-error.show { display:block; }
.lp-resend { font-size:12px;color:#888;margin-top:10px; }
.lp-resend a { color:#00bfa5;font-weight:700;cursor:pointer; }
@media(max-width:600px) { .lp-modal{flex-direction:column;width:96vw} .lp-left{width:100%;padding:24px;flex-direction:row;} .lp-left-title{font-size:20px} }
</style>
</head>
<body>

<div class="ev-wrap">
    <div class="ev-breadcrumb">
        <a href="{{ route('sell.index') }}">Home</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.index') }}">Sell Old Laptop</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.brand.models', $brand->slug) }}">{{ $brand->name }}</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a><span class="sep">›</span>
        <span class="active">Device Evaluation</span>
    </div>

    <div class="ev-layout">
        <div class="ev-question-panel">
            <div class="ev-progress-bar">
                <div class="ev-progress-fill" style="width:10%"></div>
            </div>
            <div class="ev-q-header">
                <span class="ev-q-step-badge">Step 1</span>
                <span class="ev-q-category">Basic Check</span>
            </div>
            <div class="ev-q-text">Does the Laptop switch on?</div>
            <div class="ev-q-hint">We currently only accept devices that switch on without any issues.</div>
            <div class="ev-options">
                <div class="ev-option" id="opt-yes" onclick="selectAnswer('yes')">
                    <span class="ev-opt-icon">✅</span>
                    <span class="ev-opt-label">Yes, switches on fine</span>
                    <span class="ev-opt-tick" id="tick-yes"></span>
                </div>
                <div class="ev-option" id="opt-no" onclick="selectAnswer('no')">
                    <span class="ev-opt-icon">❌</span>
                    <span class="ev-opt-label">No / Not sure</span>
                    <span class="ev-opt-tick" id="tick-no"></span>
                </div>
            </div>
            <div class="ev-nav">
                <span></span>
                <button class="ev-btn-next" id="btnNext" disabled onclick="goNext()">
                    Next <span>→</span>
                </button>
            </div>
        </div>

        <div class="ev-sidebar">
            <div class="ev-device-card">
                <div class="ev-device-top">
                    @if($model->image)
                        <img class="ev-device-img" src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
                    @else
                        <div class="ev-device-img-placeholder">💻</div>
                    @endif
                    <div>
                        <div class="ev-device-name">{{ $model->name }}</div>
                        <div class="ev-device-spec">{{ $brand->name }}@if($variant) · {{ $variant->storage }} · {{ $variant->ram }}@endif</div>
                    </div>
                </div>
                <div class="ev-price-block">
                    <div class="ev-price-label">Estimated Price</div>
                    <div class="ev-price-val"><span>₹</span>{{ number_format($variant ? $variant->price : $model->price, 0) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- LOGIN POPUP FOR "NO" FLOW --}}
<div class="lp-overlay" id="lpOverlay">
    <div class="lp-modal">
        <button class="lp-close" onclick="closePopup()">✕</button>
        <div class="lp-left">
            <div class="lp-left-title">Login /<br>Signup</div>
            <div style="color:rgba(255,255,255,.7);font-size:13px;">Unlock best price for your device</div>
        </div>
        <div class="lp-right">
            <div class="lp-input-group">
                <div class="lp-input-label">Your Name</div>
                <input type="text" id="userName" class="lp-input" placeholder="Enter your full name" oninput="checkForm()">
            </div>
            
            <div class="lp-input-group">
                <div class="lp-input-label">Mobile Number</div>
                <div class="lp-phone-wrap">
                    <span class="lp-phone-prefix">+91</span>
                    <input type="tel" id="userMobile" class="lp-phone-input" placeholder="10-digit mobile number" 
                           maxlength="10" oninput="onMobileInput(this)" onkeypress="return event.charCode>=48&&event.charCode<=57">
                </div>
            </div>
            <div class="lp-error" id="mobileError">Please enter valid 10-digit mobile number</div>
            
            {{-- OTP Section --}}
            <div id="otpSection" style="display:none;">
                <div class="lp-input-label">Enter OTP</div>
                <div class="lp-otp-inputs">
                    <input type="tel" class="lp-otp-box" maxlength="1" id="otp1" oninput="otpInput(this, 'otp2')">
                    <input type="tel" class="lp-otp-box" maxlength="1" id="otp2" oninput="otpInput(this, 'otp3')">
                    <input type="tel" class="lp-otp-box" maxlength="1" id="otp3" oninput="otpInput(this, 'otp4')">
                    <input type="tel" class="lp-otp-box" maxlength="1" id="otp4" oninput="otpInput(this, 'otp5')">
                    <input type="tel" class="lp-otp-box" maxlength="1" id="otp5" oninput="otpInput(this, 'otp6')">
                    <input type="tel" class="lp-otp-box" maxlength="1" id="otp6" oninput="otpInput(this, null)">
                </div>
                <div class="lp-error" id="otpError">Invalid OTP. Please try again.</div>
                <div class="lp-resend">Didn't receive? <a onclick="sendOTP()">Resend OTP</a></div>
            </div>
            
            <div class="lp-terms">
                <input type="checkbox" id="termsCheck" onchange="checkForm()">
                <label for="termsCheck">I agree to the <a href="#">Terms and Conditions</a> & <a href="#">Privacy Policy</a></label>
            </div>
            
            <button class="lp-continue-btn" id="continueBtn" onclick="handleContinue()">
                <span id="btnText">GET OTP</span>
            </button>
        </div>
    </div>
</div>

<script>
let selectedAnswer = null;
let isOtpSent = false;
let verifiedCustomer = null;

const BASE_URL = "{{ route('sell.laptop.system-config', [$brand->slug, $model->slug]) }}";
const CSRF_TOKEN = "{{ csrf_token() }}";

function selectAnswer(answer) {
    selectedAnswer = answer;
    
    // Reset styles
    document.getElementById('opt-yes').className = 'ev-option';
    document.getElementById('opt-no').className = 'ev-option';
    document.getElementById('tick-yes').textContent = '';
    document.getElementById('tick-no').textContent = '';
    
    // Apply selected style
    document.getElementById('opt-'+answer).classList.add('selected-'+answer);
    document.getElementById('tick-'+answer).textContent = '✓';
    
    document.getElementById('btnNext').disabled = false;
}

function goNext() {
    if (!selectedAnswer) return;

    // YES or NO — இரண்டுமே system-config page-க்கு போகும்
    const params = new URLSearchParams();
    @if($variant) params.set('variant', '{{ $variant->id }}'); @endif
    params.set('power_on', selectedAnswer);

    window.location.href = BASE_URL + '?' + params.toString();
}
// Popup Functions
function closePopup() {
    document.getElementById('lpOverlay').classList.remove('open');
    document.body.style.overflow = '';
    // Reset if not verified
    if (!verifiedCustomer) {
        isOtpSent = false;
        document.getElementById('otpSection').style.display = 'none';
        document.getElementById('btnText').textContent = 'GET OTP';
        document.querySelectorAll('.lp-otp-box').forEach(b => b.value = '');
    }
}

function onMobileInput(input) {
    input.value = input.value.replace(/\D/g, '').slice(0, 10);
    document.getElementById('mobileError').classList.remove('show');
    checkForm();
}

function checkForm() {
    const name = document.getElementById('userName').value.trim();
    const mobile = document.getElementById('userMobile').value;
    const terms = document.getElementById('termsCheck').checked;
    const valid = name.length >= 2 && mobile.length === 10 && /^[6-9]/.test(mobile) && terms;
    
    const btn = document.getElementById('continueBtn');
    if (valid && !isOtpSent) {
        btn.classList.add('active');
        btn.disabled = false;
    } else if (isOtpSent) {
        // Check OTP filled
        const otp = getOTP();
        if (otp.length === 6) {
            btn.classList.add('active');
            btn.disabled = false;
        } else {
            btn.classList.remove('active');
        }
    } else {
        btn.classList.remove('active');
        btn.disabled = true;
    }
}

function handleContinue() {
    if (!isOtpSent) {
        sendOTP();
    } else {
        verifyOTP();
    }
}

async function sendOTP() {
    const name = document.getElementById('userName').value.trim();
    const mobile = document.getElementById('userMobile').value;
    
    if (!/^[6-9]\d{9}$/.test(mobile)) {
        document.getElementById('mobileError').classList.add('show');
        return;
    }
    
    try {
        const response = await fetch("{{ route('sell.laptop.otp.send') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({ name, mobile })
        });
        
        const data = await response.json();
        
        if (data.success) {
            isOtpSent = true;
            document.getElementById('otpSection').style.display = 'block';
            document.getElementById('btnText').textContent = 'VERIFY & CONTINUE';
            document.getElementById('continueBtn').classList.remove('active');
            document.getElementById('otp1').focus();
            startResendTimer();
        } else {
            alert(data.message || 'Failed to send OTP');
        }
    } catch (err) {
        alert('Network error. Please try again.');
    }
}

function otpInput(el, nextId) {
    el.value = el.value.replace(/\D/, '');
    if (el.value && nextId) {
        document.getElementById(nextId).focus();
    }
    checkForm();
    if (!nextId && el.value) verifyOTP(); // Auto verify on last digit
}

function getOTP() {
    return ['otp1','otp2','otp3','otp4','otp5','otp6']
        .map(id => document.getElementById(id).value).join('');
}

async function verifyOTP() {
    const otp = getOTP();
    if (otp.length !== 6) return;
    
    try {
        const response = await fetch("{{ route('sell.laptop.otp.verify') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({ otp })
        });
        
        const data = await response.json();
        
        if (data.success) {
            verifiedCustomer = data.customer;
            // Proceed to system config with verified user
            const params = new URLSearchParams();
            @if($variant) params.set('variant', '{{ $variant->id }}'); @endif
            params.set('power_on', 'no');
            params.set('verified_name', verifiedCustomer.name);
            params.set('verified_mobile', verifiedCustomer.mobile);
            
            window.location.href = BASE_URL + '?' + params.toString();
        } else {
            document.getElementById('otpError').classList.add('show');
            // Clear OTP boxes
            document.querySelectorAll('.lp-otp-box').forEach(b => {
                b.value = '';
                b.classList.add('error');
            });
            document.getElementById('otp1').focus();
        }
    } catch (err) {
        alert('Verification failed. Please try again.');
    }
}

function startResendTimer() {
    // Implement 30s timer if needed
}

// Close on escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closePopup();
});
</script>
</body>
</html>