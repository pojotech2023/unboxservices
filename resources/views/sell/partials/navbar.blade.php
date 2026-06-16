{{-- resources/views/sell/partials/navbar.blade.php --}}
@php $customer = session('customer'); @endphp

<style>
/* ── Drawer styles (unchanged) ── */
.ts-mobile-drawer {
  display: none; position: fixed; inset: 0; z-index: 9999;
}
.ts-mobile-drawer.open { display: block; }
.ts-drawer-overlay {
  position: absolute; inset: 0; background: rgba(0,0,0,.5);
}
.ts-drawer-panel {
  position: absolute; top: 0; left: 0; width: 300px; height: 100%;
  background: #fff; overflow-y: auto; box-shadow: 4px 0 20px rgba(0,0,0,.15); z-index: 1;
}
.ts-drawer-header {
  display: flex; align-items: center; justify-content: space-between;
  padding: 16px; border-bottom: 1px solid #f0f0f0;
  font-family: 'Nunito', sans-serif; font-size: 16px; font-weight: 800; color: #1a1a1a;
  position: sticky; top: 0; background: #fff; z-index: 2;
}
.ts-drawer-header button {
  background: none; border: none; font-size: 18px; color: #666; cursor: pointer;
  padding: 4px 8px; line-height: 1;
}
.ts-drawer-header button:hover { color: #333; }
.ts-drawer-header strong { color: #00c853; }
.ts-drawer-section {
  padding: 10px 16px 6px; font-family: 'Nunito', sans-serif;
  font-size: 11px; font-weight: 800; color: #aaa; text-transform: uppercase;
  letter-spacing: .6px; background: #fafafa;
  border-top: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0;
}
.ts-drawer-item {
  display: flex; align-items: center; padding: 12px 16px;
  font-family: 'Nunito Sans', sans-serif; font-size: 14px; font-weight: 600; color: #333;
  border-bottom: 1px solid #f9f9f9; cursor: pointer; text-decoration: none;
}
.ts-drawer-item:hover { background: #f9fff9; color: #00c853; }
.ts-drawer-item.ts-has-sub { justify-content: space-between; }
.ts-di-arr { font-size: 16px; color: #ccc; transition: transform .2s; flex-shrink: 0; }
.ts-drawer-item.ts-has-sub.open .ts-di-arr { transform: rotate(90deg); color: #00c853; }
.ts-drawer-sub { display: none; background: #fafffe; }
.ts-drawer-sub.open { display: block; }
.ts-drawer-sub .ts-drawer-item {
  padding-left: 30px; font-size: 13px; font-weight: 500; color: #555;
}
.ts-green { color: #00c853 !important; font-weight: 700 !important; }

/* ── User menu (logged-in state) ── */
.ts-user-wrap {
  position: relative; display: flex; align-items: center;
}
.ts-btn-user {
  display: flex; align-items: center; gap: 7px;
  background: #f0fff5; border: 1.5px solid #00c853; border-radius: 8px;
  padding: 6px 13px; cursor: pointer; font-family: 'Nunito', sans-serif;
  font-size: 14px; font-weight: 700; color: #1a1a1a; transition: background .15s;
}
.ts-btn-user:hover { background: #d6ffe8; }
.ts-btn-user svg { flex-shrink: 0; }
.ts-btn-user .ts-uname {
  max-width: 110px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.ts-btn-user .ts-uchev { font-size: 11px; color: #888; margin-left: 2px; }

.ts-user-dropdown {
  display: none; position: absolute; top: calc(100% + 8px); right: 0;
  background: #fff; border: 1px solid #e8e8e8; border-radius: 10px;
  box-shadow: 0 8px 24px rgba(0,0,0,.12); min-width: 160px; z-index: 9000;
  overflow: hidden;
}
.ts-user-dropdown.open { display: block; }
.ts-user-dropdown a {
  display: flex; align-items: center; gap: 9px; padding: 12px 16px;
  font-family: 'Nunito', sans-serif; font-size: 14px; font-weight: 600; color: #333;
  text-decoration: none; transition: background .12s;
}
.ts-user-dropdown a:hover { background: #fff5f5; color: #e53935; }
.ts-user-dropdown a svg { flex-shrink: 0; }

/* ── Login / OTP Modal ── */
.ts-modal-backdrop {
  display: none; position: fixed; inset: 0;
  background: rgba(0,0,0,.55); z-index: 99999;
  align-items: center; justify-content: center;
}
.ts-modal-backdrop.open { display: flex; }

.ts-login-modal {
  width: 100%; max-width: 820px; border-radius: 18px;
  overflow: hidden; display: flex; box-shadow: 0 24px 60px rgba(0,0,0,.22);
  margin: 16px;
}

/* Left decorative panel */
.ts-lm-left {
  width: 42%; background: linear-gradient(145deg, #00c853, #00897b);
  padding: 40px 32px; display: flex; flex-direction: column;
  align-items: flex-start; justify-content: space-between; color: #fff;
}
.ts-lm-left h2 { font-family: 'Nunito', sans-serif; font-size: 26px; font-weight: 900; line-height: 1.2; }
.ts-lm-left p  { font-family: 'Nunito Sans', sans-serif; font-size: 14px; opacity: .88; margin-top: 10px; }
.ts-lm-illus { font-size: 72px; margin-top: auto; }

/* Right form panel */
.ts-lm-right {
  flex: 1; background: #fff; padding: 36px 32px; display: flex;
  flex-direction: column; justify-content: center;
}
.ts-lm-close {
  position: absolute; top: 18px; right: 22px; background: none; border: none;
  font-size: 22px; color: #888; cursor: pointer; line-height: 1; z-index: 1;
}
.ts-lm-close:hover { color: #333; }

/* Product preview strip */
.ts-lm-product {
  display: flex; align-items: center; gap: 12px; padding: 12px 14px;
  border: 1px solid #e8e8e8; border-radius: 10px; margin-bottom: 20px; background: #fafafa;
}
.ts-lm-product img { width: 44px; height: 44px; object-fit: contain; border-radius: 6px; }
.ts-lm-product .ts-lmp-info { flex: 1; }
.ts-lm-product .ts-lmp-brand { font-size: 11px; color: #888; font-family: 'Nunito', sans-serif; }
.ts-lm-product .ts-lmp-name  { font-size: 14px; font-weight: 700; color: #1a1a1a; font-family: 'Nunito', sans-serif; }
.ts-lm-product .ts-lmp-price { font-size: 18px; font-weight: 800; color: #e53935; font-family: 'Nunito', sans-serif; }

.ts-lm-unlock {
  display: flex; align-items: center; gap: 8px; background: #e8f5e9;
  border-radius: 8px; padding: 10px 14px; margin-bottom: 22px;
  font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 700; color: #2e7d32;
}

/* Step indicator */
.ts-lm-steps { display: flex; gap: 8px; margin-bottom: 22px; }
.ts-lm-step-dot {
  width: 8px; height: 8px; border-radius: 50%; background: #e0e0e0; transition: background .2s;
}
.ts-lm-step-dot.active { background: #00c853; width: 22px; border-radius: 4px; }

/* Form fields */
.ts-lm-label {
  font-family: 'Nunito', sans-serif; font-size: 12px; font-weight: 700;
  color: #888; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px;
}
.ts-lm-input {
  width: 100%; border: 1.5px solid #e0e0e0; border-radius: 8px;
  padding: 11px 14px; font-family: 'Nunito Sans', sans-serif;
  font-size: 14px; color: #1a1a1a; outline: none; transition: border .15s;
  box-sizing: border-box; margin-bottom: 16px;
}
.ts-lm-input:focus { border-color: #00c853; }
.ts-lm-input.error { border-color: #e53935; }

.ts-phone-row { display: flex; gap: 8px; margin-bottom: 16px; }
.ts-phone-prefix {
  border: 1.5px solid #e0e0e0; border-radius: 8px; padding: 11px 12px;
  font-family: 'Nunito Sans', sans-serif; font-size: 14px; font-weight: 700;
  color: #555; background: #fafafa; white-space: nowrap;
}
.ts-phone-row .ts-lm-input { margin-bottom: 0; flex: 1; }

.ts-lm-check {
  display: flex; align-items: flex-start; gap: 9px; margin-bottom: 20px;
}
.ts-lm-check input[type=checkbox] { margin-top: 2px; accent-color: #00c853; width: 15px; height: 15px; }
.ts-lm-check label {
  font-family: 'Nunito Sans', sans-serif; font-size: 12px; color: #666; line-height: 1.5;
}
.ts-lm-check label a { color: #00c853; text-decoration: none; }

.ts-lm-btn {
  width: 100%; padding: 13px; background: #00c853; color: #fff;
  border: none; border-radius: 10px; font-family: 'Nunito', sans-serif;
  font-size: 15px; font-weight: 800; letter-spacing: .4px; cursor: pointer;
  transition: background .15s; text-transform: uppercase;
}
.ts-lm-btn:hover:not(:disabled) { background: #00a846; }
.ts-lm-btn:disabled { background: #c8e6c9; cursor: not-allowed; }

/* OTP boxes */
.ts-otp-row { display: flex; gap: 10px; margin-bottom: 16px; }
.ts-otp-box {
  flex: 1; text-align: center; border: 1.5px solid #e0e0e0;
  border-radius: 10px; padding: 13px 4px; font-size: 22px; font-weight: 800;
  font-family: 'Nunito', sans-serif; color: #1a1a1a; outline: none;
  transition: border .15s; -moz-appearance: textfield;
}
.ts-otp-box::-webkit-inner-spin-button,
.ts-otp-box::-webkit-outer-spin-button { -webkit-appearance: none; }
.ts-otp-box:focus { border-color: #00c853; background: #f0fff5; }

.ts-resend-row {
  font-family: 'Nunito Sans', sans-serif; font-size: 13px;
  color: #888; margin-bottom: 20px;
}
.ts-resend-row button {
  background: none; border: none; color: #00c853; font-weight: 700;
  cursor: pointer; padding: 0; font-size: 13px;
}
.ts-resend-row button:disabled { color: #aaa; cursor: not-allowed; }

.ts-lm-msg {
  font-family: 'Nunito', sans-serif; font-size: 13px; padding: 9px 14px;
  border-radius: 8px; margin-bottom: 14px; display: none;
}
.ts-lm-msg.success { background: #e8f5e9; color: #2e7d32; display: block; }
.ts-lm-msg.error   { background: #ffebee; color: #c62828; display: block; }

.ts-back-link {
  background: none; border: none; color: #888; cursor: pointer;
  font-family: 'Nunito', sans-serif; font-size: 13px; padding: 0;
  display: flex; align-items: center; gap: 5px; margin-bottom: 18px;
}
.ts-back-link:hover { color: #333; }

/* Responsive */
@media (max-width: 600px) {
  .ts-lm-left { display: none; }
  .ts-login-modal { max-width: 96vw; }
  .ts-lm-right { padding: 28px 20px; }
}
</style>

{{-- ══════════════════════════════════════════════════════
     HEADER
══════════════════════════════════════════════════════ --}}
<header class="ts-navbar-top" >
  <a href="{{ route('sell.index') }}" class="ts-logo">
    <div class="ts-logo-icon">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
           stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
        <path d="M2 17l10 5 10-5"/>
        <path d="M2 12l10 5 10-5"/>
      </svg>
    </div>
    <span>Unbox <strong>Service Center</strong></span>
  </a>

  <div class="ts-search-bar">
    <svg width="15" height="15" fill="none" stroke="#999" stroke-width="2" viewBox="0 0 24 24">
      <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" id="tsSearch" name="q"
           placeholder="Search for mobiles, accessories & More" autocomplete="off">
  </div>

  <div class="ts-nav-right">
    @if($customer)
      {{-- ── Logged-in user pill ── --}}
      <div class="ts-user-wrap" id="tsUserWrap">
        <button class="ts-btn-user" id="tsUserBtn" type="button">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#00c853"
               stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
          </svg>
          <span class="ts-uname">{{ $customer['name'] }}</span>
          <span class="ts-uchev">▾</span>
        </button>
        <div class="ts-user-dropdown" id="tsUserDropdown">
          <a href="{{ route('sell.logout') }}" id="tsLogoutLink">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#e53935"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
              <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Logout
          </a>
        </div>
      </div>
    @else
      {{-- ── Login button ── --}}
      <button class="ts-btn-login" id="tsLoginBtn" type="button">Login</button>
    @endif
  </div>

  <button class="ts-hamburger" id="tsHamburger">
    <span></span><span></span><span></span>
  </button>
</header>

{{-- ══════════════════════════════════════════════════════
     NAV MENU (unchanged)
══════════════════════════════════════════════════════ --}}
<nav class="ts-navbar-menu">

  {{-- Sell Phone --}}
  <div class="ts-menu-item" id="tsMiSell">
    <button class="ts-menu-btn">Sell Phone <span class="ts-chev">▾</span></button>
    <div class="ts-dropdown ts-mega">
      <div class="ts-dd-left">
        <div class="ts-dd-section-lbl">By Brand</div>
        @foreach($brands as $b)
        <div class="ts-dd-left-item {{ $loop->first ? 'active' : '' }}" data-panel="brand-{{ $b->id }}">
          @if($b->logo)
            <img src="{{ asset('storage/'.$b->logo) }}" alt="{{ $b->name }}"
                 style="height:16px;width:16px;object-fit:contain;margin-right:7px;border-radius:3px;flex-shrink:0;">
          @endif
          {{ $b->name }} <span class="ts-arr">›</span>
        </div>
        @endforeach
        <div class="ts-dd-divider"></div>
        <a class="ts-dd-left-link" href="{{ route('sell.phone') }}">View All Brands →</a>
      </div>
      @foreach($brands as $b)
      <div class="ts-dd-right {{ $loop->first ? 'active' : '' }}" id="brand-{{ $b->id }}">
        <div class="ts-dd-right-header">Sell {{ $b->name }}</div>
        <div class="ts-dd-section-title">Top Models</div>
        @foreach($b->models()->take(7)->get() as $m)
          <a class="ts-dd-right-link"
             href="{{ route('sell.model.variants', [$b->slug, $m->slug]) }}">{{ $m->name }}</a>
        @endforeach
        <a class="ts-dd-right-link ts-green"
           href="{{ route('sell.brand.models', $b->slug) }}">All {{ $b->name }} Models →</a>
      </div>
      @endforeach
    </div>
  </div>

  {{-- Sell Laptop --}}
  <div class="ts-menu-item" id="tsMiLaptop">
    <button class="ts-menu-btn">Sell Laptop <span class="ts-chev">▾</span></button>
    <div class="ts-dropdown ts-mega">
      <div class="ts-dd-left">
        <div class="ts-dd-section-lbl">By Brand</div>
        @foreach($laptopBrands as $lb)
        <div class="ts-dd-left-item {{ $loop->first ? 'active' : '' }}" data-panel="laptop-brand-{{ $lb->id }}">
          @if($lb->logo)
            <img src="{{ asset('storage/'.$lb->logo) }}" alt="{{ $lb->name }}"
                 style="height:16px;width:16px;object-fit:contain;margin-right:7px;border-radius:3px;flex-shrink:0;">
          @endif
          {{ $lb->name }} <span class="ts-arr">›</span>
        </div>
        @endforeach
        <div class="ts-dd-divider"></div>
        <a class="ts-dd-left-link" href="{{ route('sell.laptop.index') }}">View All Brands →</a>
      </div>
      @foreach($laptopBrands as $lb)
      <div class="ts-dd-right {{ $loop->first ? 'active' : '' }}" id="laptop-brand-{{ $lb->id }}">
        <div class="ts-dd-right-header">Sell {{ $lb->name }}</div>
        <div class="ts-dd-section-title">Top Models</div>
        @foreach($lb->models()->take(7)->get() as $lm)
          <a class="ts-dd-right-link"
             href="{{ route('sell.laptop.model.variants', [$lb->slug, $lm->slug]) }}">{{ $lm->name }}</a>
        @endforeach
        <a class="ts-dd-right-link ts-green"
           href="{{ route('sell.laptop.brand.models', $lb->slug) }}">All {{ $lb->name }} Models →</a>
      </div>
      @endforeach
    </div>
  </div>

  <div class="ts-menu-item">
    <button class="ts-menu-btn">More <span class="ts-chev">▾</span></button>
    <div class="ts-dropdown ts-simple">
      <a class="ts-simple-item" href="#">Repair Service</a>
      <a class="ts-simple-item" href="#">About Us</a>
    </div>
  </div>
</nav>

{{-- ══════════════════════════════════════════════════════
     MOBILE DRAWER (unchanged)
══════════════════════════════════════════════════════ --}}
<div class="ts-mobile-drawer" id="tsMobileDrawer">
  <div class="ts-drawer-overlay" id="tsDrawerOverlay"></div>
  <div class="ts-drawer-panel">
    <div class="ts-drawer-header">
      <span>Unbox <strong>Service Center</strong></span>
      <button id="tsDrawerClose">✕</button>
    </div>

    <div class="ts-drawer-section">📱 Sell Phone</div>
    @foreach($brands as $b)
    <div class="ts-drawer-item ts-has-sub" data-sub="dsb-{{ $b->id }}">
      <a href="{{ route('sell.brand.models', $b->slug) }}"
         style="text-decoration:none;color:inherit;flex:1;"
         onclick="event.stopPropagation()">{{ $b->name }}</a>
      <span class="ts-di-arr">›</span>
    </div>
    <div class="ts-drawer-sub" id="dsb-{{ $b->id }}">
      @foreach($b->models()->take(5)->get() as $m)
        <a class="ts-drawer-item" style="text-decoration:none;"
           href="{{ route('sell.model.variants', [$b->slug, $m->slug]) }}">{{ $m->name }}</a>
      @endforeach
      <a class="ts-drawer-item ts-green" style="text-decoration:none;"
         href="{{ route('sell.brand.models', $b->slug) }}">All {{ $b->name }} Models →</a>
    </div>
    @endforeach
    <a class="ts-drawer-item ts-green" href="{{ route('sell.phone') }}"
       style="text-decoration:none;background:#f0fff5;">View All Phone Brands →</a>

    <div class="ts-drawer-section">💻 Sell Laptop</div>
    @foreach($laptopBrands as $lb)
    <div class="ts-drawer-item ts-has-sub" data-sub="dslb-{{ $lb->id }}">
      <a href="{{ route('sell.laptop.brand.models', $lb->slug) }}"
         style="text-decoration:none;color:inherit;flex:1;"
         onclick="event.stopPropagation()">{{ $lb->name }}</a>
      <span class="ts-di-arr">›</span>
    </div>
    <div class="ts-drawer-sub" id="dslb-{{ $lb->id }}">
      @foreach($lb->models()->take(5)->get() as $lm)
        <a class="ts-drawer-item" style="text-decoration:none;"
           href="{{ route('sell.laptop.model.variants', [$lb->slug, $lm->slug]) }}">{{ $lm->name }}</a>
      @endforeach
      <a class="ts-drawer-item ts-green" style="text-decoration:none;"
         href="{{ route('sell.laptop.brand.models', $lb->slug) }}">All {{ $lb->name }} Models →</a>
    </div>
    @endforeach
    <a class="ts-drawer-item ts-green" href="{{ route('sell.laptop.index') }}"
       style="text-decoration:none;background:#f0fff5;">View All Laptop Brands →</a>

    <div class="ts-drawer-section">More</div>
    <a class="ts-drawer-item" href="#" style="text-decoration:none;">Repair Service</a>
    <a class="ts-drawer-item" href="#" style="text-decoration:none;">About Us</a>
  </div>
</div>

{{-- ══════════════════════════════════════════════════════
     LOGIN MODAL
══════════════════════════════════════════════════════ --}}
@if(!$customer)
<div class="ts-modal-backdrop" id="tsLoginModal">
  <div class="ts-login-modal" style="position:relative;">

    {{-- Close button --}}
    <button class="ts-lm-close" id="tsModalClose" type="button">✕</button>

    {{-- Left panel --}}
    <div class="ts-lm-left">
      <div>
        <h2>Login /<br>Signup</h2>
        <p>Login to unlock the best price for your device</p>
      </div>
      <div class="ts-lm-illus">🔐</div>
    </div>

    {{-- Right panel --}}
    <div class="ts-lm-right">

      {{-- Optional: product preview (shown only if redirect_after_login set) --}}
      <div id="tsLmProduct" style="display:none;">
        {{-- Populated dynamically via JS if needed --}}
      </div>

      <div class="ts-lm-unlock">
        🔒 &nbsp; Login to unlock the best price
      </div>

      {{-- Step dots --}}
      <div class="ts-lm-steps">
        <div class="ts-lm-step-dot active" id="tsDot1"></div>
        <div class="ts-lm-step-dot" id="tsDot2"></div>
      </div>

      {{-- Message box --}}
      <div class="ts-lm-msg" id="tsLmMsg"></div>

      {{-- ── STEP 1: Name + Phone ── --}}
      <div id="tsStep1">
        <div class="ts-lm-label">Full Name</div>
        <input class="ts-lm-input" id="tsLmName" type="text"
               placeholder="Your Name" autocomplete="name">

        <div class="ts-lm-label">Phone Number</div>
        <div class="ts-phone-row">
          <div class="ts-phone-prefix">+91</div>
          <input class="ts-lm-input" id="tsLmPhone" type="tel"
                 placeholder="Enter your mobile" maxlength="10" autocomplete="tel">
        </div>

        <div class="ts-lm-check">
          <input type="checkbox" id="tsLmAgree">
          <label for="tsLmAgree">
            I agree to the <a href="#">Terms and Conditions</a> &amp; <a href="#">Privacy Policy</a>
          </label>
        </div>

        <button class="ts-lm-btn" id="tsSendOtpBtn" disabled type="button">SEND OTP</button>
      </div>

      {{-- ── STEP 2: OTP Entry ── --}}
      <div id="tsStep2" style="display:none;">
        <button class="ts-back-link" id="tsBackBtn" type="button">← Change number</button>

        <div class="ts-lm-label">Enter OTP sent to +91 <span id="tsOtpTarget"></span></div>

        <div class="ts-otp-row">
          <input class="ts-otp-box" id="otp1" type="number" maxlength="1" min="0" max="9">
          <input class="ts-otp-box" id="otp2" type="number" maxlength="1" min="0" max="9">
          <input class="ts-otp-box" id="otp3" type="number" maxlength="1" min="0" max="9">
          <input class="ts-otp-box" id="otp4" type="number" maxlength="1" min="0" max="9">
          <input class="ts-otp-box" id="otp5" type="number" maxlength="1" min="0" max="9">
          <input class="ts-otp-box" id="otp6" type="number" maxlength="1" min="0" max="9">
        </div>

        <div class="ts-resend-row">
          Didn't receive?
          <button id="tsResendBtn" type="button" disabled>
            Resend OTP (<span id="tsCountdown">30</span>s)
          </button>
        </div>

        <button class="ts-lm-btn" id="tsVerifyOtpBtn" disabled type="button">VERIFY OTP</button>
      </div>

    </div>{{-- end ts-lm-right --}}
  </div>{{-- end ts-login-modal --}}
</div>{{-- end ts-modal-backdrop --}}
@endif

{{-- ══════════════════════════════════════════════════════
     JAVASCRIPT
══════════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── 1. Hamburger ────────────────────────────────────────
  var hamburger = document.getElementById('tsHamburger');
  var drawer    = document.getElementById('tsMobileDrawer');
  var overlay   = document.getElementById('tsDrawerOverlay');
  var closeBtn  = document.getElementById('tsDrawerClose');

  function openDrawer()  { if (drawer) drawer.classList.add('open'); }
  function closeDrawer() { if (drawer) drawer.classList.remove('open'); }

  if (hamburger) hamburger.addEventListener('click', openDrawer);
  if (overlay)   overlay.addEventListener('click',   closeDrawer);
  if (closeBtn)  closeBtn.addEventListener('click',  closeDrawer);

  // ── 2. Desktop mega-menu hover ──────────────────────────
  ['tsMiSell', 'tsMiLaptop'].forEach(function (id) {
    var menu = document.getElementById(id);
    if (!menu) return;
    menu.querySelectorAll('.ts-dd-left-item[data-panel]').forEach(function (item) {
      item.addEventListener('mouseenter', function () {
        menu.querySelectorAll('.ts-dd-left-item').forEach(function (i) { i.classList.remove('active'); });
        this.classList.add('active');
        menu.querySelectorAll('.ts-dd-right').forEach(function (p) { p.classList.remove('active'); });
        var panel = document.getElementById(this.dataset.panel);
        if (panel) panel.classList.add('active');
      });
    });
  });

  // ── 3. Mobile drawer accordion ──────────────────────────
  document.querySelectorAll('.ts-drawer-item.ts-has-sub').forEach(function (item) {
    item.addEventListener('click', function () {
      var subId = this.dataset.sub;
      var sub   = subId ? document.getElementById(subId) : null;
      if (!sub) return;
      var isOpen = sub.classList.contains('open');
      document.querySelectorAll('.ts-drawer-sub').forEach(function (s) { s.classList.remove('open'); });
      document.querySelectorAll('.ts-drawer-item.ts-has-sub').forEach(function (s) { s.classList.remove('open'); });
      if (!isOpen) { sub.classList.add('open'); this.classList.add('open'); }
    });
  });

  // ── 4. User dropdown (logged-in state) ──────────────────
  var userBtn      = document.getElementById('tsUserBtn');
  var userDropdown = document.getElementById('tsUserDropdown');

  if (userBtn && userDropdown) {
    userBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      userDropdown.classList.toggle('open');
    });
    document.addEventListener('click', function () {
      if (userDropdown) userDropdown.classList.remove('open');
    });
  }

  // ── 5. Login modal open / close ─────────────────────────
  var loginBtn   = document.getElementById('tsLoginBtn');
  var modal      = document.getElementById('tsLoginModal');
  var modalClose = document.getElementById('tsModalClose');

  function openModal() {
    if (modal) {
      modal.classList.add('open');
      resetModal();
    }
  }
  function closeModal() {
    if (modal) modal.classList.remove('open');
  }

  if (loginBtn)   loginBtn.addEventListener('click', openModal);
  if (modalClose) modalClose.addEventListener('click', closeModal);

  // Close on backdrop click
  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) closeModal();
    });
  }

  // ── 6. Login form state ─────────────────────────────────
  var nameInput    = document.getElementById('tsLmName');
  var phoneInput   = document.getElementById('tsLmPhone');
  var agreeChk     = document.getElementById('tsLmAgree');
  var sendOtpBtn   = document.getElementById('tsSendOtpBtn');
  var verifyOtpBtn = document.getElementById('tsVerifyOtpBtn');
  var step1        = document.getElementById('tsStep1');
  var step2        = document.getElementById('tsStep2');
  var msgBox       = document.getElementById('tsLmMsg');
  var dot1         = document.getElementById('tsDot1');
  var dot2         = document.getElementById('tsDot2');
  var backBtn      = document.getElementById('tsBackBtn');
  var otpTarget    = document.getElementById('tsOtpTarget');
  var resendBtn    = document.getElementById('tsResendBtn');
  var countdownEl  = document.getElementById('tsCountdown');
  var otpBoxes     = [
    document.getElementById('otp1'), document.getElementById('otp2'),
    document.getElementById('otp3'), document.getElementById('otp4'),
    document.getElementById('otp5'), document.getElementById('otp6'),
  ];
  var countdownTimer = null;

  // Enable/disable Send OTP button
  function updateSendBtn() {
    if (!sendOtpBtn) return;
    var nameOk  = nameInput  && nameInput.value.trim().length >= 2;
    var phoneOk = phoneInput && /^\d{10}$/.test(phoneInput.value.trim());
    var agreed  = agreeChk   && agreeChk.checked;
    sendOtpBtn.disabled = !(nameOk && phoneOk && agreed);
  }

  if (nameInput)  nameInput.addEventListener('input', updateSendBtn);
  if (phoneInput) {
    phoneInput.addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '').slice(0, 10);
      updateSendBtn();
    });
  }
  if (agreeChk)   agreeChk.addEventListener('change', updateSendBtn);

  // OTP boxes — auto-advance & enable verify
  function updateVerifyBtn() {
    if (!verifyOtpBtn) return;
    var full = otpBoxes.every(function (b) { return b && b.value.length === 1; });
    verifyOtpBtn.disabled = !full;
  }

  otpBoxes.forEach(function (box, idx) {
    if (!box) return;
    box.addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '').slice(-1);
      if (this.value && idx < otpBoxes.length - 1) otpBoxes[idx + 1].focus();
      updateVerifyBtn();
    });
    box.addEventListener('keydown', function (e) {
      if (e.key === 'Backspace' && !this.value && idx > 0) otpBoxes[idx - 1].focus();
    });
  });

  // Show message
  function showMsg(text, type) {
    if (!msgBox) return;
    msgBox.textContent = text;
    msgBox.className = 'ts-lm-msg ' + type;
  }
  function hideMsg() {
    if (!msgBox) return;
    msgBox.className = 'ts-lm-msg';
    msgBox.textContent = '';
  }

  // Countdown timer for resend
  function startCountdown(seconds) {
    if (!resendBtn || !countdownEl) return;
    resendBtn.disabled = true;
    var remaining = seconds;
    countdownEl.textContent = remaining;
    resendBtn.textContent = 'Resend OTP (' + remaining + 's)';
    clearInterval(countdownTimer);
    countdownTimer = setInterval(function () {
      remaining--;
      if (remaining <= 0) {
        clearInterval(countdownTimer);
        resendBtn.disabled = false;
        resendBtn.textContent = 'Resend OTP';
      } else {
        resendBtn.textContent = 'Resend OTP (' + remaining + 's)';
      }
    }, 1000);
  }

  // Switch to Step 2
  function goToStep2() {
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'block';
    if (dot1)  { dot1.classList.remove('active'); }
    if (dot2)  { dot2.classList.add('active'); }
    if (otpTarget && phoneInput) otpTarget.textContent = phoneInput.value.trim();
    otpBoxes.forEach(function (b) { if (b) b.value = ''; });
    updateVerifyBtn();
    if (otpBoxes[0]) otpBoxes[0].focus();
    startCountdown(30);
  }

  // Back to Step 1
  if (backBtn) {
    backBtn.addEventListener('click', function () {
      if (step1) step1.style.display = 'block';
      if (step2) step2.style.display = 'none';
      if (dot1)  dot1.classList.add('active');
      if (dot2)  dot2.classList.remove('active');
      hideMsg();
      clearInterval(countdownTimer);
    });
  }

  // Reset modal state
  function resetModal() {
    if (step1) step1.style.display = 'block';
    if (step2) step2.style.display = 'none';
    if (dot1)  dot1.classList.add('active');
    if (dot2)  dot2.classList.remove('active');
    if (nameInput)  nameInput.value  = '';
    if (phoneInput) phoneInput.value = '';
    if (agreeChk)   agreeChk.checked = false;
    otpBoxes.forEach(function (b) { if (b) b.value = ''; });
    hideMsg();
    updateSendBtn();
    updateVerifyBtn();
    clearInterval(countdownTimer);
    if (sendOtpBtn)   sendOtpBtn.disabled   = true;
    if (verifyOtpBtn) verifyOtpBtn.disabled = true;
  }

  // ── SEND OTP ────────────────────────────────────────────
  function doSendOtp() {
    if (!sendOtpBtn) return;
    hideMsg();
    sendOtpBtn.disabled = true;
    sendOtpBtn.textContent = 'Sending…';

    fetch('{{ route("sell.send-otp") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        name:   nameInput  ? nameInput.value.trim()  : '',
        mobile: phoneInput ? phoneInput.value.trim() : ''
      })
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
      if (data.success) {
        showMsg(data.message || 'OTP sent!', 'success');
        goToStep2();
      } else {
        showMsg(data.message || 'Failed to send OTP. Try again.', 'error');
        updateSendBtn();
      }
    })
    .catch(function () {
      showMsg('Network error. Please try again.', 'error');
      updateSendBtn();
    })
    .finally(function () {
      if (sendOtpBtn) sendOtpBtn.textContent = 'SEND OTP';
    });
  }

  if (sendOtpBtn) sendOtpBtn.addEventListener('click', doSendOtp);

  // Resend OTP
  if (resendBtn) {
    resendBtn.addEventListener('click', function () {
      hideMsg();
      fetch('{{ route("sell.send-otp") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          name:   nameInput  ? nameInput.value.trim()  : '',
          mobile: phoneInput ? phoneInput.value.trim() : ''
        })
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          showMsg('OTP resent!', 'success');
          otpBoxes.forEach(function (b) { if (b) b.value = ''; });
          updateVerifyBtn();
          if (otpBoxes[0]) otpBoxes[0].focus();
          startCountdown(30);
        } else {
          showMsg(data.message || 'Failed to resend OTP.', 'error');
        }
      })
      .catch(function () {
        showMsg('Network error. Please try again.', 'error');
      });
    });
  }

  // ── VERIFY OTP ──────────────────────────────────────────
  if (verifyOtpBtn) {
    verifyOtpBtn.addEventListener('click', function () {
      hideMsg();
      verifyOtpBtn.disabled = true;
      verifyOtpBtn.textContent = 'Verifying…';

      var otp = otpBoxes.map(function (b) { return b ? b.value : ''; }).join('');

      fetch('{{ route("sell.verify-otp") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ otp: otp })
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          showMsg('Login successful! Welcome ' + (data.name || '') + ' 🎉', 'success');
          clearInterval(countdownTimer);

          // Reload page after short delay so navbar re-renders with session
          setTimeout(function () {
            window.location.reload();
          }, 900);
        } else {
          showMsg(data.message || 'Invalid OTP. Please try again.', 'error');
          verifyOtpBtn.disabled = false;
          verifyOtpBtn.textContent = 'VERIFY OTP';
          otpBoxes.forEach(function (b) { if (b) { b.value = ''; b.classList.add('error'); } });
          setTimeout(function () {
            otpBoxes.forEach(function (b) { if (b) b.classList.remove('error'); });
          }, 600);
          if (otpBoxes[0]) otpBoxes[0].focus();
        }
      })
      .catch(function () {
        showMsg('Network error. Please try again.', 'error');
        verifyOtpBtn.disabled = false;
        verifyOtpBtn.textContent = 'VERIFY OTP';
      });
    });
  }

  // Allow Enter key on phone input to trigger send
  if (phoneInput) {
    phoneInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && !sendOtpBtn.disabled) doSendOtp();
    });
  }

}); // end DOMContentLoaded
</script>