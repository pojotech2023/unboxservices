{{-- index1.blade.php --}}
@php $customer = session('customer'); @endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sell Old Mobile Phone – Unboxing Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
body { background: #f7f8fa; }
.sell-wrap {
  max-width: 1300px;
  margin: 0 auto;
  padding: 32px 20px 60px;
}
.sell-section-hdr {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
.sell-section-ttl {
  font-family: 'Nunito', sans-serif;
  font-size: 20px;
  font-weight: 800;
  color: #1a1a1a;
}
.sell-brands-grid {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 14px;
  margin-bottom: 40px;
}
.sell-brand-card {
  background: #fff;
  border: 1.5px solid #ececec;
  border-radius: 14px;
  padding: 18px 10px 14px;
  text-align: center;
  text-decoration: none;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: all .2s ease;
}
.sell-brand-card:hover {
  border-color: #00c853;
  box-shadow: 0 6px 20px rgba(0,200,83,.12);
  transform: translateY(-3px);
}
.sell-brand-logo-wrap {
  width: 80px; height: 60px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 10px;
  overflow: hidden; border-radius: 10px;
  background: #f5f5f5;
}
.sell-brand-logo-wrap img {
  max-height: 56px; max-width: 76px; object-fit: contain;
}
.sell-brand-logo-placeholder {
  width: 48px; height: 48px;
  border-radius: 50%;
  background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
  display: flex; align-items: center; justify-content: center;
  font-family: 'Nunito', sans-serif;
  font-size: 20px; font-weight: 800; color: #00c853;
}
.sell-brand-name {
  font-family: 'Nunito Sans', sans-serif;
  font-size: 13px; font-weight: 700; color: #1a1a1a; margin-bottom: 3px;
}
.sell-brand-count { font-size: 11px; color: #aaa; }

.how-wrap {
  background: #fff;
  border: 1.5px solid #e8f5e9;
  border-radius: 16px;
  padding: 28px 24px;
}
.how-title {
  font-family: 'Nunito', sans-serif;
  font-size: 18px; font-weight: 800; color: #1a1a1a; margin-bottom: 20px;
}
.how-steps {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}
.how-step { text-align: center; }
.how-step-icon {
  width: 52px; height: 52px;
  border-radius: 50%;
  background: linear-gradient(135deg, #00c853, #00a846);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 10px; font-size: 22px;
}
.how-step-title {
  font-family: 'Nunito', sans-serif;
  font-size: 13px; font-weight: 800; color: #1a1a1a; margin-bottom: 5px;
}
.how-step-desc {
  font-family: 'Nunito Sans', sans-serif;
  font-size: 11px; color: #999; line-height: 1.5;
}

/* ── Sell Phone Mega Dropdown ── */
#tsMiSell { position: relative; }
#tsMiSell .ts-dropdown {
  display: none;
  position: absolute;
  top: 100%; left: 0;
  background: #fff;
  border: 1px solid #ebebeb;
  border-radius: 12px;
  box-shadow: 0 12px 40px rgba(0,0,0,.12);
  z-index: 1001;
  width: 560px;
}
#tsMiSell:hover .ts-dropdown { display: flex; }

/* ── Sell Laptop Mega Dropdown ── */
#mi-laptop { position: relative; }
#mi-laptop .ts-dropdown {
  display: none;
  position: absolute;
  top: 100%; left: 0;
  background: #fff;
  border: 1px solid #ebebeb;
  border-radius: 12px;
  box-shadow: 0 12px 40px rgba(0,0,0,.12);
  z-index: 1001;
  width: 560px;
}
#mi-laptop:hover .ts-dropdown { display: flex; }

/* ── Shared dropdown styles ── */
.ts-dd-left {
  width: 180px;
  border-right: 1px solid #f0f0f0;
  padding: 12px 0;
  flex-shrink: 0;
  overflow-y: auto;
  max-height: 340px;
}
.ts-dd-section-lbl {
  font-size: 11px; font-weight: 700; color: #bbb;
  text-transform: uppercase; letter-spacing: .6px;
  padding: 0 14px 8px;
}
.ts-dd-left-item {
  display: flex; align-items: center;
  padding: 9px 14px;
  font-family: 'Nunito Sans', sans-serif;
  font-size: 13px; font-weight: 600; color: #333;
  cursor: pointer; transition: background .12s;
}
.ts-dd-left-item:hover,
.ts-dd-left-item.ts-active { background: #f0fff5; color: #00c853; }
.ts-arr { margin-left: auto; color: #ccc; font-size: 11px; }
.ts-dd-divider { margin: 6px 14px; border: none; border-top: 1px solid #f0f0f0; }
.ts-dd-left-link {
  display: block; padding: 8px 14px;
  font-size: 12px; color: #00c853; font-weight: 700; text-decoration: none;
}
.ts-dd-left-link:hover { text-decoration: underline; }
.ts-dd-right {
  display: none; flex: 1; padding: 16px;
  flex-direction: column;
  overflow-y: auto; max-height: 340px;
}
.ts-dd-right.ts-active { display: flex; }
.ts-dd-right-header {
  font-family: 'Nunito', sans-serif;
  font-size: 15px; font-weight: 800; color: #1a1a1a; margin-bottom: 10px;
}
.ts-dd-section-title {
  font-size: 10px; font-weight: 700; color: #bbb;
  text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px;
}
.ts-dd-right-link {
  display: block; padding: 5px 0;
  font-family: 'Nunito Sans', sans-serif;
  font-size: 13px; color: #444; text-decoration: none; font-weight: 500;
  transition: color .12s;
}
.ts-dd-right-link:hover { color: #00c853; }
.ts-green { color: #00c853 !important; font-weight: 700; margin-top: 6px; }

/* ── Responsive ── */
@media (max-width: 1100px) { .sell-brands-grid { grid-template-columns: repeat(5, 1fr); } }
@media (max-width: 900px)  { .sell-brands-grid { grid-template-columns: repeat(4, 1fr); } .how-steps { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  {
  .sell-brands-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; }
  .sell-brand-logo-wrap { width: 64px; height: 50px; }
  .sell-brand-name { font-size: 11px; }
  .how-steps { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 400px) { .sell-brands-grid { grid-template-columns: repeat(2, 1fr); } }

.location-btn svg { display: inline-block; vertical-align: middle; }
.location-btn svg path,
.location-btn svg circle { stroke: #00c853 !important; }

/* ── Mobile Drawer ── */
.mobile-drawer {
  display: none;
  position: fixed; inset: 0;
  z-index: 2000;
}
.mobile-drawer.open { display: block; }
.drawer-overlay {
  position: absolute; inset: 0;
  background: rgba(0,0,0,.5);
}
.drawer-panel {
  position: absolute;
  top: 0; left: 0;
  width: 300px; height: 100%;
  background: #fff;
  overflow-y: auto;
  box-shadow: 4px 0 20px rgba(0,0,0,.15);
}
.drawer-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 16px;
  border-bottom: 1px solid #f0f0f0;
  background: #fff;
  position: sticky; top: 0; z-index: 1;
}
.drawer-logo { font-family: 'Nunito', sans-serif; font-size: 16px; font-weight: 800; color: #1a1a1a; }
.drawer-logo span { color: #00c853; }
.drawer-close {
  background: none; border: none;
  font-size: 18px; color: #666; cursor: pointer; padding: 4px 8px;
}
.drawer-close:hover { color: #333; }
.drawer-loc-row {
  display: flex; align-items: center; gap: 8px;
  padding: 12px 16px;
  border-bottom: 1px solid #f5f5f5;
  cursor: pointer;
}
.drawer-loc-label { font-size: 12px; color: #999; }
.drawer-loc-city  { font-size: 13px; font-weight: 700; color: #1a1a1a; flex: 1; }
.drawer-loc-arrow { color: #ccc; font-size: 14px; }
.drawer-section {
  padding: 10px 16px 6px;
  font-family: 'Nunito', sans-serif;
  font-size: 11px; font-weight: 800;
  color: #aaa;
  text-transform: uppercase;
  letter-spacing: .6px;
  background: #fafafa;
  border-top: 1px solid #f0f0f0;
  border-bottom: 1px solid #f0f0f0;
}
.drawer-item {
  display: flex;
  align-items: center;
  padding: 12px 16px;
  font-family: 'Nunito Sans', sans-serif;
  font-size: 14px;
  font-weight: 600;
  color: #333;
  border-bottom: 1px solid #f9f9f9;
  cursor: pointer;
  text-decoration: none;
}
.drawer-item:hover { background: #f9fff9; color: #00c853; }
.drawer-item.has-sub { justify-content: space-between; }
.drawer-item.has-sub .di-arr {
  font-size: 16px; color: #ccc;
  transition: transform .2s;
}
.drawer-item.has-sub.open .di-arr { transform: rotate(90deg); color: #00c853; }
.drawer-sub { display: none; background: #fafffe; }
.drawer-sub.open { display: block; }
.drawer-sub .drawer-item {
  padding-left: 30px;
  font-size: 13px;
  font-weight: 500;
  color: #555;
  border-bottom: 1px solid #f2f2f2;
}
.drawer-sub .drawer-item:hover { color: #00c853; }
.drawer-sub .drawer-item.drawer-all-link {
  color: #00c853;
  font-weight: 700;
}

/* ════════════════════════════════════════════
   USER PILL (logged-in state)
   ════════════════════════════════════════════ */
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

/* ════════════════════════════════════════════
   LOGIN / OTP MODAL
   ════════════════════════════════════════════ */
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
.ts-lm-left {
  width: 42%; background: linear-gradient(145deg, #00c853, #00897b);
  padding: 40px 32px; display: flex; flex-direction: column;
  align-items: flex-start; justify-content: space-between; color: #fff;
}
.ts-lm-left h2 { font-family: 'Nunito', sans-serif; font-size: 26px; font-weight: 900; line-height: 1.2; }
.ts-lm-left p  { font-family: 'Nunito Sans', sans-serif; font-size: 14px; opacity: .88; margin-top: 10px; }
.ts-lm-illus { font-size: 72px; margin-top: auto; }
.ts-lm-right {
  flex: 1; background: #fff; padding: 36px 32px; display: flex;
  flex-direction: column; justify-content: center;
}
.ts-lm-close {
  position: absolute; top: 18px; right: 22px; background: none; border: none;
  font-size: 22px; color: #888; cursor: pointer; line-height: 1; z-index: 1;
}
.ts-lm-close:hover { color: #333; }
.ts-lm-unlock {
  display: flex; align-items: center; gap: 8px; background: #e8f5e9;
  border-radius: 8px; padding: 10px 14px; margin-bottom: 22px;
  font-family: 'Nunito', sans-serif; font-size: 13px; font-weight: 700; color: #2e7d32;
}
.ts-lm-steps { display: flex; gap: 8px; margin-bottom: 22px; }
.ts-lm-step-dot {
  width: 8px; height: 8px; border-radius: 50%; background: #e0e0e0; transition: background .2s;
}
.ts-lm-step-dot.active { background: #00c853; width: 22px; border-radius: 4px; }
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
@media (max-width: 600px) {
  .ts-lm-left { display: none; }
  .ts-login-modal { max-width: 96vw; }
  .ts-lm-right { padding: 28px 20px; }
}
</style>
</head>
<body>

{{-- ══════════════════════════════════════════
     TOP NAVBAR
══════════════════════════════════════════ --}}
<header class="navbar-top">
  <a href="{{ route('sell.index') }}" class="logo">
    <div class="logo-icon">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
        <path d="M2 17l10 5 10-5"/>
        <path d="M2 12l10 5 10-5"/>
      </svg>
    </div>
    <span class="logo-text"> Unbox  <span>Service Center</span></span>
  </a>

  <div class="search-bar">
    <svg class="search-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" placeholder="Search for mobiles, accessories & More">
  </div>

  <div class="navbar-right">
    <button class="location-btn" id="locationBtn">
      <svg width="13" height="13" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24">
        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
        <circle cx="12" cy="10" r="3"/>
      </svg>
      <span id="desktopCityName">Salem</span>
      <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="6 9 12 15 18 9"/>
      </svg>
    </button>

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
      <button class="btn-login" id="tsLoginBtn" type="button">Login</button>
    @endif
  </div>

  <button class="hamburger" id="hamburger"><span></span><span></span><span></span></button>
</header>

{{-- ══════════════════════════════════════════
     DESKTOP MENU BAR
══════════════════════════════════════════ --}}
<nav class="navbar-menu" id="navMenu">

  <!-- ALL Mega Menu -->
  <div class="menu-item" id="mi-all">
    <button class="menu-btn">All <span class="chevron">▾</span></button>
    <div class="dropdown mega">
      <div class="dd-left">
        <div class="dd-section-lbl">Sell</div>
        <div class="dd-left-item active" data-panel="ap-phone">Phone <span class="arr">›</span></div>
        <div class="dd-left-item" data-panel="ap-laptop">Laptop <span class="arr">›</span></div>
      </div>
      <div class="dd-right" id="ap-phone">
        <div class="dd-right-header">Sell Phone</div>
        <div class="dd-section-title">Top Brands</div>
        <div class="dd-right-cols">
          @foreach($brands->take(6) as $b)
            <a class="dd-right-link" href="{{ route('sell.brand.models', $b->slug) }}">{{ $b->name }}</a>
          @endforeach
        </div>
        <a class="dd-right-link green" href="{{ route('sell.phone') }}">More Phone Brands →</a>
      </div>
      <div class="dd-right" id="ap-laptop">
        <div class="dd-right-header">Sell Laptop</div>
        <div class="dd-section-title">Top Brands</div>
        <div class="dd-right-cols">
          @foreach($laptopBrands->take(6) as $lb)
            <a class="dd-right-link" href="{{ route('sell.laptop.brand.models', $lb->slug) }}">{{ $lb->name }}</a>
          @endforeach
        </div>
        <a class="dd-right-link green" href="{{ route('sell.laptop.index') }}">All Laptop Brands →</a>
      </div>
    </div>
  </div>

  <!-- SELL PHONE Mega Menu -->
  <div class="menu-item" id="tsMiSell">
    <button class="menu-btn">Sell Phone <span class="chevron">▾</span></button>
    <div class="ts-dropdown">
      <div class="ts-dd-left">
        <div class="ts-dd-section-lbl">By Brand</div>
        @foreach($brands as $b)
        <div class="ts-dd-left-item {{ $loop->first ? 'ts-active' : '' }}"
             data-panel="brand-{{ $b->id }}">
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
      <div class="ts-dd-right {{ $loop->first ? 'ts-active' : '' }}" id="brand-{{ $b->id }}">
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

  <!-- SELL LAPTOP Mega Menu -->
  <div class="menu-item" id="mi-laptop">
    <button class="menu-btn">Sell Laptop <span class="chevron">▾</span></button>
    <div class="ts-dropdown">
      <div class="ts-dd-left">
        <div class="ts-dd-section-lbl">By Brand</div>
        @foreach($laptopBrands as $lb)
        <div class="ts-dd-left-item {{ $loop->first ? 'ts-active' : '' }}"
             data-panel="lb-{{ $lb->id }}">
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
      <div class="ts-dd-right {{ $loop->first ? 'ts-active' : '' }}" id="lb-{{ $lb->id }}">
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

  <div class="menu-item" id="mi-more">
    <button class="menu-btn">More <span class="chevron">▾</span></button>
    <div class="dropdown simple">
      <a class="simple-item" href="#">Repair Service</a>
      <a class="simple-item" href="#">About Us</a>
    </div>
  </div>

</nav>

<!-- MOBILE SEARCH -->
<div class="mobile-search-bar">
  <div class="msb-inner">
    <svg width="15" height="15" fill="none" stroke="#999" stroke-width="2" viewBox="0 0 24 24">
      <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" placeholder="Search for mobiles, accessories & More">
  </div>
</div>

<!-- SLIDER -->
<div class="slider-wrapper">
  <div class="slider-inner">
    <div class="slides-track" id="track">
      <div class="slide slide-1">
        <div class="slide-content">
          <span class="slide-tag">Best Price</span>
          <h2 class="slide-title">Sell Your Old Phone<br>Get Instant Cash</h2>
          <p class="slide-sub">Get <strong>best price guaranteed</strong> + <strong>free doorstep pickup</strong></p>
          <button class="btn-book">Sell Now</button>
        </div>
        <div class="slide-image">
          <svg class="phone-img" viewBox="0 0 200 250" fill="none">
            <rect x="15" y="8" width="170" height="234" rx="28" fill="#7986cb" opacity=".9"/>
            <rect x="24" y="18" width="152" height="214" rx="22" fill="#5c6bc0"/>
            <rect x="70" y="22" width="60" height="10" rx="5" fill="rgba(255,255,255,.3)"/>
            <circle cx="100" cy="216" r="10" fill="rgba(255,255,255,.2)"/>
          </svg>
        </div>
      </div>
      <div class="slide slide-2">
        <div class="slide-content">
          <span class="slide-tag">Top Exchange</span>
          <h2 class="slide-title">Samsung Galaxy<br>Best Exchange Price</h2>
          <p class="slide-sub"><strong>Instant payment</strong> + <strong>free doorstep service</strong></p>
          <button class="btn-book">Get Price</button>
        </div>
        <div class="slide-image">
          <svg class="phone-img" viewBox="0 0 200 250" fill="none">
            <rect x="15" y="8" width="170" height="234" rx="28" fill="#64b5f6" opacity=".9"/>
            <rect x="24" y="18" width="152" height="214" rx="22" fill="#42a5f5"/>
          </svg>
        </div>
      </div>
      <div class="slide slide-3">
        <div class="slide-content">
          <span class="slide-tag">iPhone Deal</span>
          <h2 class="slide-title">iPhone Exchange<br>at Ts Service Center</h2>
          <p class="slide-sub">Get <strong>best exchange value</strong> + <strong>instant cash</strong></p>
          <button class="btn-book">Sell iPhone</button>
        </div>
        <div class="slide-image">
          <svg class="phone-img" viewBox="0 0 200 250" fill="none">
            <rect x="18" y="8" width="164" height="234" rx="32" fill="#a5d6a7" opacity=".9"/>
            <rect x="27" y="18" width="146" height="214" rx="25" fill="#81c784"/>
          </svg>
        </div>
      </div>
    </div>
    <button class="arrow arrow-left" id="prev">&#8249;</button>
    <button class="arrow arrow-right" id="next">&#8250;</button>
  </div>
</div>
<div class="dots" id="dotsWrap">
  <div class="dot active" data-i="0"></div>
  <div class="dot" data-i="1"></div>
  <div class="dot" data-i="2"></div>
</div>

{{-- ══════════════════════════════════════════
     MOBILE DRAWER
══════════════════════════════════════════ --}}
<div class="mobile-drawer" id="mobileDrawer">
  <div class="drawer-overlay" id="drawerOverlay"></div>
  <div class="drawer-panel">
    <div class="drawer-header">
      <span class="drawer-logo">Ts <span>Service Center</span></span>
      <button class="drawer-close" id="drawerClose">✕</button>
    </div>
    <div class="drawer-loc-row" id="drawerLocBtn">
      <svg width="15" height="15" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24">
        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
        <circle cx="12" cy="10" r="3"/>
      </svg>
      <span class="drawer-loc-label">Your Location</span>
      <span class="drawer-loc-city" id="drawerCityName">Salem</span>
      <span class="drawer-loc-arrow">›</span>
    </div>

    <div class="drawer-section">📱 Sell Phone</div>
    @foreach($brands as $b)
    <div class="drawer-item has-sub" data-sub="dsb-{{ $b->id }}">
      <a href="{{ route('sell.brand.models', $b->slug) }}"
         style="text-decoration:none; color:inherit; flex:1;"
         onclick="event.stopPropagation()">{{ $b->name }}</a>
      <span class="di-arr">›</span>
    </div>
    <div class="drawer-sub" id="dsb-{{ $b->id }}">
      @foreach($b->models()->take(5)->get() as $m)
        <a class="drawer-item"
           href="{{ route('sell.model.variants', [$b->slug, $m->slug]) }}"
           style="text-decoration:none;">{{ $m->name }}</a>
      @endforeach
      <a class="drawer-item drawer-all-link"
         href="{{ route('sell.brand.models', $b->slug) }}"
         style="text-decoration:none;">All {{ $b->name }} Models →</a>
    </div>
    @endforeach
    <a class="drawer-item drawer-all-link"
       href="{{ route('sell.phone') }}"
       style="text-decoration:none; background:#f0fff5;">View All Phone Brands →</a>

    <div class="drawer-section">💻 Sell Laptop</div>
    @foreach($laptopBrands as $lb)
    <div class="drawer-item has-sub" data-sub="dslb-{{ $lb->id }}">
      <a href="{{ route('sell.laptop.brand.models', $lb->slug) }}"
         style="text-decoration:none; color:inherit; flex:1;"
         onclick="event.stopPropagation()">{{ $lb->name }}</a>
      <span class="di-arr">›</span>
    </div>
    <div class="drawer-sub" id="dslb-{{ $lb->id }}">
      @foreach($lb->models()->take(5)->get() as $lm)
        <a class="drawer-item"
           href="{{ route('sell.laptop.model.variants', [$lb->slug, $lm->slug]) }}"
           style="text-decoration:none;">{{ $lm->name }}</a>
      @endforeach
      <a class="drawer-item drawer-all-link"
         href="{{ route('sell.laptop.brand.models', $lb->slug) }}"
         style="text-decoration:none;">All {{ $lb->name }} Models →</a>
    </div>
    @endforeach
    <a class="drawer-item drawer-all-link"
       href="{{ route('sell.laptop.index') }}"
       style="text-decoration:none; background:#f0fff5;">View All Laptop Brands →</a>

    <div class="drawer-section">More</div>
    <a class="drawer-item" href="#" style="text-decoration:none;">Repair Service</a>
    <a class="drawer-item" href="#" style="text-decoration:none;">About Us</a>
  </div>
</div>

{{-- ══════════════════════════════════════════
     LOGIN MODAL  (only shown when guest)
══════════════════════════════════════════ --}}
@if(!$customer)
<div class="ts-modal-backdrop" id="tsLoginModal">
  <div class="ts-login-modal" style="position:relative;">

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

      <div class="ts-lm-unlock">
        🔒 &nbsp; Login to unlock the best price
      </div>

      <div class="ts-lm-steps">
        <div class="ts-lm-step-dot active" id="tsDot1"></div>
        <div class="ts-lm-step-dot" id="tsDot2"></div>
      </div>

      <div class="ts-lm-msg" id="tsLmMsg"></div>

      {{-- Step 1: Name + Phone --}}
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

      {{-- Step 2: OTP --}}
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

<!-- LOCATION MODAL -->
<div class="loc-overlay" id="locModal">
  <div class="loc-modal">
    <div class="loc-modal-inner">
      <div class="loc-modal-header">
        <div class="loc-modal-logo">
          <div class="logo-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
              <path d="M12 2L2 7l10 5 10-5-10-5z"/>
              <path d="M2 17l10 5 10-5"/>
              <path d="M2 12l10 5 10-5"/>
            </svg>
          </div>
          <span class="logo-text">Ts <span>Service Center</span></span>
        </div>
        <button class="loc-close" id="locClose">✕</button>
      </div>
      <div class="loc-search-box">
        <input type="text" id="citySearch" placeholder="Search your city or pincode" autocomplete="off">
        <button class="loc-search-btn">
          <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
        </button>
      </div>
      <div class="loc-cities-title">Popular Cities</div>
      <div class="loc-cities-grid">
        <div class="loc-city" data-city="Bangalore">
          <div class="city-wrap">
            <svg viewBox="0 0 56 56" fill="none">
              <rect x="4" y="46" width="48" height="4" rx="1" fill="#00c853" opacity=".18"/>
              <rect x="8" y="43" width="40" height="3" rx="1" fill="#00c853" opacity=".22"/>
              <rect x="10" y="25" width="36" height="18" rx="1" fill="#00c853" opacity=".15" stroke="#00c853" stroke-width="1.4"/>
              <rect x="13" y="28" width="3" height="15" rx="1" fill="#00c853" opacity=".5"/>
              <rect x="19" y="28" width="3" height="15" rx="1" fill="#00c853" opacity=".5"/>
              <rect x="25" y="28" width="3" height="15" rx="1" fill="#00c853" opacity=".5"/>
              <rect x="31" y="28" width="3" height="15" rx="1" fill="#00c853" opacity=".5"/>
              <rect x="37" y="28" width="3" height="15" rx="1" fill="#00c853" opacity=".5"/>
              <rect x="8" y="22" width="40" height="3" rx="1" fill="#00c853" opacity=".6"/>
              <rect x="20" y="14" width="16" height="9" rx="1" fill="#00c853" opacity=".45"/>
              <ellipse cx="28" cy="14" rx="8" ry="5" fill="#00c853" opacity=".6"/>
              <rect x="26" y="7" width="4" height="8" rx="1" fill="#00c853" opacity=".75"/>
              <circle cx="28" cy="6" r="2" fill="#00c853"/>
            </svg>
          </div>
          <span class="city-nm">Bangalore</span>
        </div>
        <div class="loc-city" data-city="Chennai">
          <div class="city-wrap">
            <svg viewBox="0 0 56 56" fill="none">
              <rect x="4" y="46" width="48" height="4" rx="1" fill="#00c853" opacity=".18"/>
              <rect x="12" y="36" width="32" height="10" rx="1" fill="#00c853" opacity=".18" stroke="#00c853" stroke-width="1.3"/>
              <rect x="23" y="39" width="10" height="7" rx="1" fill="#00c853" opacity=".25"/>
              <path d="M23 39 Q28 36 33 39" fill="#00c853" opacity=".35"/>
              <rect x="16" y="28" width="24" height="9" rx="1" fill="#00c853" opacity=".2" stroke="#00c853" stroke-width="1.3"/>
              <rect x="19" y="21" width="18" height="8" rx="1" fill="#00c853" opacity=".28" stroke="#00c853" stroke-width="1.3"/>
              <rect x="22" y="15" width="12" height="7" rx="1" fill="#00c853" opacity=".38" stroke="#00c853" stroke-width="1.3"/>
              <rect x="24" y="10" width="8" height="6" rx="1" fill="#00c853" opacity=".5" stroke="#00c853" stroke-width="1.3"/>
              <ellipse cx="28" cy="5.5" rx="2.5" ry="2" fill="#00c853" opacity=".8"/>
              <rect x="27" y="3" width="2" height="3" rx="1" fill="#00c853"/>
            </svg>
          </div>
          <span class="city-nm">Chennai</span>
        </div>
        <div class="loc-city" data-city="Delhi">
          <div class="city-wrap">
            <svg viewBox="0 0 56 56" fill="none">
              <rect x="4" y="46" width="48" height="4" rx="1" fill="#00c853" opacity=".18"/>
              <rect x="10" y="26" width="8" height="20" rx="1" fill="#00c853" opacity=".18" stroke="#00c853" stroke-width="1.4"/>
              <rect x="38" y="26" width="8" height="20" rx="1" fill="#00c853" opacity=".18" stroke="#00c853" stroke-width="1.4"/>
              <path d="M10 26 Q28 8 46 26" fill="none" stroke="#00c853" stroke-width="2.5"/>
              <rect x="8" y="22" width="40" height="5" rx="1" fill="#00c853" opacity=".45"/>
              <rect x="18" y="16" width="20" height="7" rx="1" fill="#00c853" opacity=".5"/>
              <rect x="24" y="10" width="8" height="7" rx="1" fill="#00c853" opacity=".65"/>
              <path d="M25 10 Q27 6 28 9 Q29 6 31 10" fill="#00c853" opacity=".8"/>
              <rect x="14" y="34" width="6" height="10" rx="1" fill="#00c853" opacity=".12"/>
              <rect x="36" y="34" width="6" height="10" rx="1" fill="#00c853" opacity=".12"/>
            </svg>
          </div>
          <span class="city-nm">Delhi</span>
        </div>
        <div class="loc-city selected" data-city="Gurgaon">
          <div class="city-wrap">
            <svg viewBox="0 0 56 56" fill="none">
              <rect x="2" y="46" width="52" height="4" rx="1" fill="#00c853" opacity=".25"/>
              <rect x="22" y="12" width="11" height="34" rx="1" fill="#00c853" opacity=".4" stroke="#00c853" stroke-width="1.4"/>
              <rect x="34" y="20" width="9" height="26" rx="1" fill="#00c853" opacity=".35" stroke="#00c853" stroke-width="1.3"/>
            </svg>
          </div>
          <span class="city-nm">Gurgaon</span>
        </div>
        <div class="loc-city" data-city="Hyderabad">
          <div class="city-wrap">
            <svg viewBox="0 0 56 56" fill="none">
              <rect x="4" y="46" width="48" height="4" rx="1" fill="#00c853" opacity=".18"/>
              <rect x="18" y="28" width="20" height="18" rx="1" fill="#00c853" opacity=".2" stroke="#00c853" stroke-width="1.3"/>
              <circle cx="28" cy="22" r="4" fill="none" stroke="#00c853" stroke-width="1.3"/>
            </svg>
          </div>
          <span class="city-nm">Hyderabad</span>
        </div>
        <div class="loc-city" data-city="Mumbai">
          <div class="city-wrap">
            <svg viewBox="0 0 56 56" fill="none">
              <rect x="6" y="44" width="44" height="3" rx="1" fill="#00c853" opacity=".2"/>
              <rect x="24" y="14" width="8" height="15" rx="1" fill="#00c853" opacity=".35" stroke="#00c853" stroke-width="1.2"/>
              <ellipse cx="28" cy="14" rx="4.5" ry="3.5" fill="#00c853" opacity=".55"/>
            </svg>
          </div>
          <span class="city-nm">Mumbai</span>
        </div>
        <div class="loc-city" data-city="Pune">
          <div class="city-wrap">
            <svg viewBox="0 0 56 56" fill="none">
              <rect x="4" y="46" width="48" height="4" rx="1" fill="#00c853" opacity=".18"/>
              <rect x="22" y="14" width="12" height="17" rx="1" fill="#00c853" opacity=".3" stroke="#00c853" stroke-width="1.3"/>
              <path d="M20 14 L28 6 L36 14 Z" fill="#00c853" opacity=".45"/>
            </svg>
          </div>
          <span class="city-nm">Pune</span>
        </div>
      </div>
      <button class="loc-view-all">View All Cities</button>
    </div>
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="sell-wrap">
  <div class="sell-section-hdr">
    <h2 class="sell-section-ttl">Sell Old Mobile Phone</h2>
  </div>

  @if($brands->isEmpty())
    <div style="text-align:center;padding:60px 20px;color:#aaa;">
      <div style="font-size:48px;margin-bottom:12px;">📱</div>
      <p style="font-family:'Nunito Sans',sans-serif;">No brands available yet.</p>
    </div>
  @else
    <div class="sell-brands-grid">
      @foreach($brands as $b)
      <a class="sell-brand-card" href="{{ route('sell.brand.models', $b->slug) }}">
        <div class="sell-brand-logo-wrap">
          @if($b->logo)
            <img src="{{ asset('storage/'.$b->logo) }}" alt="{{ $b->name }}" loading="lazy">
          @else
            <div class="sell-brand-logo-placeholder">
              {{ strtoupper(substr($b->name, 0, 1)) }}
            </div>
          @endif
        </div>
        <div class="sell-brand-name">{{ $b->name }}</div>
        @if(isset($b->models_count) && $b->models_count > 0)
          <div class="sell-brand-count">{{ $b->models_count }} models</div>
        @endif
      </a>
      @endforeach
    </div>
  @endif

  <!-- How It Works -->
  <div class="how-wrap">
    <div class="how-title">How It Works</div>
    <div class="how-steps">
      <div class="how-step">
        <div class="how-step-icon">📱</div>
        <div class="how-step-title">Select Your Phone</div>
        <div class="how-step-desc">Choose brand, model and variant</div>
      </div>
      <div class="how-step">
        <div class="how-step-icon">✅</div>
        <div class="how-step-title">Get Best Price</div>
        <div class="how-step-desc">Instant price based on condition</div>
      </div>
      <div class="how-step">
        <div class="how-step-icon">🚗</div>
        <div class="how-step-title">Free Pickup</div>
        <div class="how-step-desc">Executive picks from your doorstep</div>
      </div>
      <div class="how-step">
        <div class="how-step-icon">💰</div>
        <div class="how-step-title">Instant Payment</div>
        <div class="how-step-desc">Cash or bank transfer immediately</div>
      </div>
    </div>
  </div>
</div>

<script src="{{ asset('js/main.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ── 1. Hamburger ─────────────────────────────────────────
  var hamburger = document.getElementById('hamburger');
  var drawer    = document.getElementById('mobileDrawer');
  var overlay   = document.getElementById('drawerOverlay');
  var closeBtn  = document.getElementById('drawerClose');

  function openDrawer()  { if (drawer) drawer.classList.add('open'); }
  function closeDrawer() { if (drawer) drawer.classList.remove('open'); }

  if (hamburger) hamburger.addEventListener('click', openDrawer);
  if (overlay)   overlay.addEventListener('click',   closeDrawer);
  if (closeBtn)  closeBtn.addEventListener('click',  closeDrawer);

  // ── 2. Desktop Sell Phone mega-menu hover ─────────────────
  var sellMenu = document.getElementById('tsMiSell');
  if (sellMenu) {
    sellMenu.querySelectorAll('.ts-dd-left-item[data-panel]').forEach(function (item) {
      item.addEventListener('mouseenter', function () {
        sellMenu.querySelectorAll('.ts-dd-left-item').forEach(function (i) { i.classList.remove('ts-active'); });
        this.classList.add('ts-active');
        sellMenu.querySelectorAll('.ts-dd-right').forEach(function (p) { p.classList.remove('ts-active'); });
        var panel = document.getElementById(this.dataset.panel);
        if (panel) panel.classList.add('ts-active');
      });
    });
  }

  // ── 3. Desktop Sell Laptop mega-menu hover ────────────────
  var laptopMenu = document.getElementById('mi-laptop');
  if (laptopMenu) {
    laptopMenu.querySelectorAll('.ts-dd-left-item[data-panel]').forEach(function (item) {
      item.addEventListener('mouseenter', function () {
        laptopMenu.querySelectorAll('.ts-dd-left-item').forEach(function (i) { i.classList.remove('ts-active'); });
        this.classList.add('ts-active');
        laptopMenu.querySelectorAll('.ts-dd-right').forEach(function (p) { p.classList.remove('ts-active'); });
        var panel = document.getElementById(this.dataset.panel);
        if (panel) panel.classList.add('ts-active');
      });
    });
  }

  // ── 4. Mobile drawer accordion ───────────────────────────
  document.querySelectorAll('.drawer-item.has-sub').forEach(function (item) {
    item.addEventListener('click', function () {
      var subId = this.dataset.sub;
      var sub   = subId ? document.getElementById(subId) : null;
      if (!sub) return;
      var isOpen = sub.classList.contains('open');
      document.querySelectorAll('.drawer-sub').forEach(function (s) { s.classList.remove('open'); });
      document.querySelectorAll('.drawer-item.has-sub').forEach(function (s) { s.classList.remove('open'); });
      if (!isOpen) { sub.classList.add('open'); this.classList.add('open'); }
    });
  });

  // ── 5. User dropdown (logged-in state) ───────────────────
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

  // ── 6. Login modal open / close ──────────────────────────
  var loginBtn   = document.getElementById('tsLoginBtn');
  var modal      = document.getElementById('tsLoginModal');
  var modalClose = document.getElementById('tsModalClose');

  function openModal() {
    if (modal) { modal.classList.add('open'); resetModal(); }
  }
  function closeModal() {
    if (modal) modal.classList.remove('open');
  }

  if (loginBtn)   loginBtn.addEventListener('click', openModal);
  if (modalClose) modalClose.addEventListener('click', closeModal);
  if (modal) {
    modal.addEventListener('click', function (e) {
      if (e.target === modal) closeModal();
    });
  }

  // ── 7. Login form logic ───────────────────────────────────
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
  if (agreeChk) agreeChk.addEventListener('change', updateSendBtn);

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

  function startCountdown(seconds) {
    if (!resendBtn) return;
    resendBtn.disabled = true;
    var remaining = seconds;
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

  function goToStep2() {
    if (step1) step1.style.display = 'none';
    if (step2) step2.style.display = 'block';
    if (dot1)  dot1.classList.remove('active');
    if (dot2)  dot2.classList.add('active');
    if (otpTarget && phoneInput) otpTarget.textContent = phoneInput.value.trim();
    otpBoxes.forEach(function (b) { if (b) b.value = ''; });
    updateVerifyBtn();
    if (otpBoxes[0]) otpBoxes[0].focus();
    startCountdown(30);
  }

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

  // ── Send OTP ──────────────────────────────────────────────
  function doSendOtp() {
    if (!sendOtpBtn || sendOtpBtn.disabled) return;
    hideMsg();
    sendOtpBtn.disabled = true;
    sendOtpBtn.textContent = 'Sending…';

    fetch('{{ route("sell.send-otp") }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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

  if (phoneInput) {
    phoneInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && !sendOtpBtn.disabled) doSendOtp();
    });
  }

  // ── Resend OTP ────────────────────────────────────────────
  if (resendBtn) {
    resendBtn.addEventListener('click', function () {
      hideMsg();
      fetch('{{ route("sell.send-otp") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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

  // ── Verify OTP ────────────────────────────────────────────
  if (verifyOtpBtn) {
    verifyOtpBtn.addEventListener('click', function () {
      hideMsg();
      verifyOtpBtn.disabled = true;
      verifyOtpBtn.textContent = 'Verifying…';

      var otp = otpBoxes.map(function (b) { return b ? b.value : ''; }).join('');

      fetch('{{ route("sell.verify-otp") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ otp: otp })
      })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          showMsg('Login successful! Welcome ' + (data.name || '') + ' 🎉', 'success');
          clearInterval(countdownTimer);
          setTimeout(function () { window.location.reload(); }, 900);
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

});
</script>
</body>
</html>