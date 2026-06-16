{{-- resources/views/sell/laptop/partials/login-popup.blade.php --}}

{{-- ══ LOGIN / OTP MODAL ══ --}}
<div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
  <div class="cashify-modal" id="cashifyModal">

    <button class="modal-close-btn" onclick="closePopup()">
      <svg width="14" height="14" fill="none" stroke="#444" stroke-width="2.5" viewBox="0 0 24 24">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>

    {{-- LEFT GREEN PANEL --}}
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

    {{-- RIGHT WHITE PANEL --}}
    <div class="modal-right">

      {{-- Device summary --}}
      <div class="modal-device-card">
        <div class="modal-device-img">
          @if(isset($model) && $model->image)
            <img src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
          @else
            <div style="font-size:26px;opacity:.35;">💻</div>
          @endif
        </div>
        <div>
          <div class="modal-device-name">{{ $model->name ?? 'Laptop' }} @if(isset($variant)) ({{ $variant->storage }} / {{ $variant->ram }}) @endif</div>
          <div class="modal-device-price-label">Selling Price</div>
          <div class="modal-device-price-val">
            <span class="rupee">₹</span><span>{{ number_format(isset($variant) ? $variant->price : ($model->price ?? 0), 0) }}</span>
          </div>
        </div>
      </div>

      {{-- ── STEP 1 : Name + Phone ── --}}
      <div class="modal-step active" id="step1">

        <div class="modal-unlock">
          <svg width="16" height="16" fill="none" stroke="#00a846" stroke-width="2.5" viewBox="0 0 24 24">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 9.9-1"/>
          </svg>
          Login to unlock the best price
        </div>

        {{-- Name --}}
        <div class="modal-input-group">
          <div class="modal-input-label">Your Name</div>
          <div class="modal-input-wrap">
            <input type="text" id="modalName" class="modal-field"
                   placeholder="Enter your full name" maxlength="80"
                   oninput="checkStep1Ready()">
          </div>
        </div>

        {{-- Phone --}}
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
            I agree to the <a href="#">Terms and Conditions</a> & <a href="#">Privacy Policy</a>
          </label>
        </div>

        <div class="modal-msg" id="step1Msg"></div>

        <button type="button" class="modal-action-btn" id="sendOtpBtn" onclick="doSendOtp()">
          <span class="spinner"></span>
          <span class="btn-label">SEND OTP</span>
        </button>

      </div>{{-- /step1 --}}

      {{-- ── STEP 2 : OTP Verification ── --}}
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
          <span class="btn-label">VERIFY & CONTINUE</span>
        </button>

      </div>{{-- /step2 --}}

      {{-- Hidden final form (submitted only after OTP verified) --}}
      <form method="POST"
            action="{{ route('sell.laptop.final.submit', [$brand->slug, $model->slug]) }}"
            id="finalForm" style="display:none;">
        @csrf
        <input type="hidden" id="finalPhone"  name="phone"         value="">
        <input type="hidden" id="finalName"   name="name"          value="">
        <input type="hidden" id="finalVariantId" name="variant_id" value="{{ $variant ? $variant->id : '' }}">
      </form>

    </div>{{-- /modal-right --}}
  </div>{{-- /cashify-modal --}}
</div>{{-- /modal-overlay --}}

<style>
/* ══ MODAL OVERLAY ══ */
.modal-overlay { position:fixed;inset:0;background:rgba(0,0,0,.55);backdrop-filter:blur(3px);z-index:9999;display:none;align-items:center;justify-content:center;padding:16px; }
.modal-overlay.show { display:flex;animation:fadeOv .2s ease; }
@keyframes fadeOv { from{opacity:0} to{opacity:1} }

.cashify-modal { background:#fff;border-radius:20px;max-width:720px;width:100%;overflow:hidden;display:flex;box-shadow:0 32px 80px rgba(0,0,0,.28);animation:slideM .32s cubic-bezier(.34,1.4,.64,1);position:relative; }
@keyframes slideM { from{transform:translateY(60px) scale(.95);opacity:0} to{transform:translateY(0) scale(1);opacity:1} }

.modal-close-btn { position:absolute;top:14px;right:14px;width:32px;height:32px;border-radius:50%;background:rgba(0,0,0,.08);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;z-index:10;transition:background .2s; }
.modal-close-btn:hover { background:rgba(0,0,0,.18); }

/* LEFT GREEN PANEL */
.modal-left { width:240px;flex-shrink:0;background:linear-gradient(160deg,#00bfa5 0%,#00897b 100%);display:flex;flex-direction:column;align-items:center;justify-content:space-between;padding:28px 16px 0;overflow:hidden;position:relative; }
.modal-left-title { font-family:'Nunito',sans-serif;font-size:24px;font-weight:900;color:#fff;text-align:center;line-height:1.2; }

/* RIGHT WHITE PANEL */
.modal-right { flex:1;padding:28px 28px 24px;display:flex;flex-direction:column;gap:16px; }

.modal-device-card { background:#f8f9fa;border-radius:14px;padding:14px 16px;display:flex;align-items:center;gap:14px; }
.modal-device-img { width:56px;height:64px;background:#fff;border-radius:10px;border:1px solid #eee;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden; }
.modal-device-img img { max-height:58px;max-width:50px;object-fit:contain; }
.modal-device-name { font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;color:#1a1a1a;margin-bottom:2px; }
.modal-device-price-label { font-size:11px;color:#888;font-weight:500;margin-bottom:2px; }
.modal-device-price-val { font-family:'Nunito',sans-serif;font-size:26px;font-weight:900;color:#e53935;display:flex;align-items:baseline;gap:3px; }
.modal-device-price-val .rupee { font-size:18px; }

.modal-unlock { display:flex;align-items:center;gap:8px;background:#f0fff5;border:1px solid #c8f5d9;border-radius:10px;padding:10px 14px;font-size:13px;font-weight:700;color:#00a846; }

/* Input rows */
.modal-input-group { display:flex;flex-direction:column;gap:6px; }
.modal-input-label { font-size:13px;font-weight:600;color:#555; }
.modal-input-wrap { display:flex;align-items:center;border-bottom:2px solid #e0e0e0;padding-bottom:6px;transition:border-color .2s; }
.modal-input-wrap:focus-within { border-color:#00bfa5; }
.modal-phone-prefix { font-size:15px;font-weight:700;color:#555;padding-right:10px;border-right:1px solid #ddd;margin-right:10px;flex-shrink:0; }
.modal-field { flex:1;border:none;outline:none;font-size:15px;font-weight:600;color:#1a1a1a;background:transparent;font-family:'Nunito Sans',sans-serif; }
.modal-field::placeholder { color:#bbb;font-weight:400; }

/* OTP step */
.modal-step { display:none; }
.modal-step.active { display:flex;flex-direction:column;gap:16px; }

.otp-header { display:flex;align-items:center;gap:10px; }
.otp-back-btn { width:30px;height:30px;border-radius:50%;background:#f5f5f5;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background .2s; }
.otp-back-btn:hover { background:#e0e0e0; }
.otp-header-text h3 { font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;color:#1a1a1a; }
.otp-header-text p { font-size:12px;color:#888;margin-top:2px; }

.otp-boxes { display:flex;gap:10px;justify-content:center;margin:4px 0; }
.otp-box { width:48px;height:52px;border:2px solid #e0e0e0;border-radius:10px;font-family:'Nunito',sans-serif;font-size:22px;font-weight:800;color:#1a1a1a;text-align:center;outline:none;transition:border-color .2s,box-shadow .2s;background:#fff; }
.otp-box:focus { border-color:#00bfa5;box-shadow:0 0 0 3px rgba(0,191,165,.15); }
.otp-box.filled { border-color:#00bfa5; }
.otp-box.error { border-color:#f44336;box-shadow:0 0 0 3px rgba(244,67,54,.12); }

.resend-row { display:flex;justify-content:space-between;align-items:center;font-size:12px;color:#888; }
.resend-btn { background:none;border:none;cursor:pointer;font-size:12px;font-weight:700;color:#00bfa5;font-family:'Nunito Sans',sans-serif;padding:0; }
.resend-btn:disabled { color:#bbb;cursor:not-allowed; }

/* Error / success banners */
.modal-msg { font-size:12px;font-weight:600;padding:8px 12px;border-radius:8px;display:none; }
.modal-msg.error { background:#fff5f5;color:#e53935;border:1px solid #ffcdd2;display:block; }
.modal-msg.success { background:#f0fff5;color:#00a846;border:1px solid #c8f5d9;display:block; }

/* Terms */
.modal-terms { display:flex;align-items:flex-start;gap:8px;font-size:12px;color:#777;line-height:1.5; }
.modal-terms input { margin-top:2px;accent-color:#00bfa5;width:15px;height:15px;flex-shrink:0; }
.modal-terms a { color:#00bfa5;font-weight:600;text-decoration:none; }
.modal-terms a:hover { text-decoration:underline; }

/* Action button */
.modal-action-btn { width:100%;padding:15px;background:#e0e0e0;color:#aaa;border:none;border-radius:10px;font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;cursor:not-allowed;letter-spacing:.8px;transition:all .25s;text-transform:uppercase;display:flex;align-items:center;justify-content:center;gap:8px; }
.modal-action-btn.ready { background:linear-gradient(135deg,#00bfa5,#00897b);color:#fff;cursor:pointer;box-shadow:0 6px 20px rgba(0,191,165,.3); }
.modal-action-btn.ready:hover { background:linear-gradient(135deg,#00897b,#00695c);transform:translateY(-1px); }
.modal-action-btn .spinner { width:16px;height:16px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;display:none; }
.modal-action-btn.loading .spinner { display:block; }
.modal-action-btn.loading .btn-label { display:none; }
@keyframes spin { to { transform:rotate(360deg); } }

@media (max-width:600px) {
  .cashify-modal { flex-direction:column; }
  .modal-left { width:100%;min-height:120px;flex-direction:row;padding:16px 20px;justify-content:space-between; }
  .modal-left-title { font-size:18px; }
  .otp-box { width:42px;height:46px;font-size:20px; }
}
</style>

<script>
(function () {

  /* ── Popup open / close ──────────────────────────────────── */
  window.openPopup = function () {
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

  /* ── Step 1 : name + phone ───────────────────────────────── */
  window.onPhoneInput = function (input) {
    input.value = input.value.replace(/\D/g, '').slice(0, 10);
    checkStep1Ready();
  };

  window.checkStep1Ready = function () {
    var nameOk  = document.getElementById('modalName').value.trim().length >= 2;
    var phoneOk = document.getElementById('modalPhone').value.length === 10;
    var termsOk = document.getElementById('modalTerms').checked;
    var btn = document.getElementById('sendOtpBtn');
    btn.classList.toggle('ready', nameOk && phoneOk && termsOk);
  };

  window.doSendOtp = function () {
    var btn = document.getElementById('sendOtpBtn');
    if (!btn.classList.contains('ready')) return;
    var name   = document.getElementById('modalName').value.trim();
    var mobile = document.getElementById('modalPhone').value;

    setLoading(btn, true);
    setMsg('step1Msg', '', '');

    fetch('{{ route("sell.laptop.otp.send") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
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

  /* ── Step 2 : OTP boxes ──────────────────────────────────── */
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
    var ready = getOtpValue().length === 6;
    document.getElementById('verifyOtpBtn').classList.toggle('ready', ready);
  }

  function clearOtpBoxes() {
    if (!document.querySelector('.otp-box')) return;
    getBoxes().forEach(function (b) { b.value = ''; b.classList.remove('filled', 'error'); });
    checkOtpReady();
  }

  window.doVerifyOtp = function () {
    var btn = document.getElementById('verifyOtpBtn');
    if (!btn.classList.contains('ready')) return;
    var otp = getOtpValue();

    setLoading(btn, true);
    setMsg('step2Msg', '', '');

    fetch('{{ route("sell.laptop.otp.verify") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ otp: otp })
    })
    .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, data: d }; }); })
    .then(function (res) {
      setLoading(btn, false);
      if (res.ok && res.data.success) {
        setMsg('step2Msg', '✔ Verified! Submitting…', 'success');
        // Populate hidden form and submit
        document.getElementById('finalPhone').value = document.getElementById('modalPhone').value;
        document.getElementById('finalName').value  = document.getElementById('modalName').value.trim();
        setTimeout(function () { document.getElementById('finalForm').submit(); }, 600);
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

  /* ── Resend timer ────────────────────────────────────────── */
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

    fetch('{{ route("sell.laptop.otp.send") }}', {
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

  /* ── Helpers ─────────────────────────────────────────────── */
  function setMsg(id, text, type) {
    var el = document.getElementById(id);
    el.textContent = text;
    el.className = 'modal-msg' + (type ? ' ' + type : '');
  }

  function setLoading(btn, on) {
    btn.classList.toggle('loading', on);
    if (on) btn.classList.remove('ready');
  }

})();
</script>
