{{-- resources/views/sell/laptop/checkout.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout – {{ $evaluation->laptopModel->name ?? 'Laptop' }}</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing:border-box; margin:0; padding:0; }
body { background:#f7f8fa; font-family:'Nunito Sans',sans-serif; }
.co-wrap { max-width:1060px; margin:0 auto; padding:32px 20px 80px; }
.co-title { font-family:'Nunito',sans-serif; font-size:24px; font-weight:900; color:#1a1a1a; margin-bottom:28px; }

.co-grid { display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start; }

/* Steps */
.co-steps { display:flex; gap:0; margin-bottom:24px; border:1.5px solid #e8e8e8; border-radius:14px; overflow:hidden; background:#fff; }
.co-step { flex:1; display:flex; align-items:center; gap:10px; padding:14px 20px; font-size:13px; font-weight:700; color:#aaa; border-right:1px solid #f0f0f0; }
.co-step:last-child { border-right:none; }
.co-step.active { color:#00bfa5; }
.co-step.done { color:#4caf50; }
.co-step-num { width:26px; height:26px; border-radius:50%; border:2px solid #e0e0e0; display:flex; align-items:center; justify-content:center; font-family:'Nunito',sans-serif; font-size:12px; font-weight:800; flex-shrink:0; }
.co-step.active .co-step-num { border-color:#00bfa5; color:#00bfa5; }
.co-step.done .co-step-num { border-color:#4caf50; background:#4caf50; color:#fff; }

/* Address Panel */
.co-panel { background:#fff; border:1.5px solid #e8e8e8; border-radius:16px; overflow:hidden; margin-bottom:20px; }
.co-panel-header { padding:20px 24px 16px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; justify-content:space-between; }
.co-panel-title { font-family:'Nunito',sans-serif; font-size:16px; font-weight:800; color:#1a1a1a; display:flex; align-items:center; gap:8px; }
.co-panel-body { padding:24px; }

/* Form */
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
.form-row.single { grid-template-columns:1fr; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-label { font-size:12px; font-weight:700; color:#555; text-transform:uppercase; letter-spacing:.4px; }
.form-input {
    padding:12px 14px; border:1.5px solid #e0e0e0; border-radius:10px;
    font-size:14px; font-weight:600; color:#1a1a1a; outline:none;
    font-family:'Nunito Sans',sans-serif; transition:border-color .2s;
    background:#fff;
}
.form-input:focus { border-color:#00bfa5; }
.form-input::placeholder { color:#bbb; font-weight:400; }
.form-error { font-size:11px; color:#e53935; display:none; }
.form-error.show { display:block; }

/* Address Type Radio */
.addr-type-row { display:flex; gap:12px; margin-top:6px; }
.addr-type-btn {
    flex:1; padding:10px 8px; border:1.5px solid #e0e0e0; border-radius:10px;
    text-align:center; cursor:pointer; transition:all .2s;
    font-size:13px; font-weight:700; color:#555;
}
.addr-type-btn.selected { border-color:#00bfa5; background:#f0fff5; color:#00bfa5; }
.addr-type-radio { display:none; }

/* Pickup Slots */
.slot-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:10px; }
.slot-card {
    border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 16px;
    cursor:pointer; transition:all .2s;
}
.slot-card:hover { border-color:#00bfa5; }
.slot-card.selected { border-color:#00bfa5; background:#f0fff5; }
.slot-day { font-size:11px; color:#888; font-weight:600; text-transform:uppercase; letter-spacing:.4px; margin-bottom:3px; }
.slot-time { font-size:13px; font-weight:800; color:#1a1a1a; }

/* Payment Method */
.pay-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
.pay-card {
    border:1.5px solid #e0e0e0; border-radius:12px; padding:14px;
    text-align:center; cursor:pointer; transition:all .2s;
}
.pay-card:hover { border-color:#00bfa5; }
.pay-card.selected { border-color:#00bfa5; background:#f0fff5; }
.pay-icon { font-size:24px; margin-bottom:6px; }
.pay-label { font-size:12px; font-weight:700; color:#1a1a1a; }

/* Continue btn */
.co-continue-btn {
    width:100%; padding:15px;
    background:#e0e0e0; color:#aaa;
    border:none; border-radius:12px;
    font-family:'Nunito',sans-serif; font-size:16px; font-weight:800;
    cursor:not-allowed; transition:all .25s; text-transform:uppercase;
    letter-spacing:.8px;
}
.co-continue-btn.ready {
    background:#00bfa5; color:#fff; cursor:pointer;
    box-shadow:0 6px 20px rgba(0,191,165,.3);
}
.co-continue-btn.ready:hover { background:#00897b; transform:translateY(-1px); }

/* Sidebar price card */
.co-price-card { background:#fff; border:1.5px solid #e8e8e8; border-radius:16px; overflow:hidden; position:sticky; top:20px; }
.co-price-top { padding:20px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; gap:14px; }
.co-price-img { width:56px; height:60px; background:#f7f9fc; border-radius:10px; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0; }
.co-price-img img { max-height:54px; max-width:50px; object-fit:contain; }
.co-price-name { font-family:'Nunito',sans-serif; font-size:14px; font-weight:800; color:#1a1a1a; margin-bottom:4px; }
.co-price-spec { font-size:12px; color:#888; }
.co-price-body { padding:16px 20px; }
.co-price-section { font-size:11px; font-weight:800; color:#aaa; text-transform:uppercase; letter-spacing:.4px; margin-bottom:10px; }
.co-price-row { display:flex; justify-content:space-between; padding:6px 0; font-size:14px; color:#555; border-bottom:1px solid #f5f5f5; }
.co-price-row:last-child { border-bottom:none; }
.co-price-row .lbl { color:#888; }
.co-price-row .val { font-weight:700; }
.co-price-total { display:flex; justify-content:space-between; padding:14px 20px; background:#f0fff5; border-top:1.5px solid #c8f5d9; }
.co-price-total .lbl { font-weight:800; font-size:14px; color:#1a1a1a; }
.co-price-total .val { font-family:'Nunito',sans-serif; font-size:22px; font-weight:900; color:#e53935; }

@media(max-width:800px) {
    .co-grid { grid-template-columns:1fr; }
    .co-price-card { position:static; }
    .form-row { grid-template-columns:1fr; }
    .pay-grid { grid-template-columns:repeat(3,1fr); }
}
@media(max-width:500px) {
    .co-steps { display:none; }
    .slot-grid { grid-template-columns:1fr; }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

<div class="co-wrap">
    <h1 class="co-title">You're almost done</h1>

    {{-- Steps indicator --}}
    <div class="co-steps">
        <div class="co-step active">
            <div class="co-step-num">1</div>
            Address
        </div>
        <div class="co-step">
            <div class="co-step-num">2</div>
            Pickup Slot
        </div>
        <div class="co-step">
            <div class="co-step-num">3</div>
            Payment
        </div>
    </div>

    <div class="co-grid">
        <div>
            <form method="POST" action="{{ route('sell.laptop.submit-address', $evaluation->id) }}" id="checkoutForm">
                @csrf

                {{-- Address --}}
                <div class="co-panel">
                    <div class="co-panel-header">
                        <div class="co-panel-title">
                            <span>📍</span> Pickup Address
                        </div>
                        @php $lv = session('laptop_otp_verified'); @endphp
                        @if($lv)
                        <span style="font-size:12px;color:#2e7d32;font-weight:700;">
                            ✓ {{ $lv['name'] }} · +91 {{ $lv['mobile'] }}
                        </span>
                        @endif
                    </div>
                    <div class="co-panel-body">
                        {{-- Location hint --}}
                        <div style="display:flex;align-items:center;gap:8px;background:#f0fff5;border:1px solid #c8f5d9;border-radius:10px;padding:10px 14px;margin-bottom:20px;font-size:13px;font-weight:700;color:#2e7d32;cursor:pointer;" onclick="useCurrentLocation()">
                            <svg width="15" height="15" fill="none" stroke="#2e7d32" stroke-width="2.5" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/>
                            </svg>
                            Use my current location
                        </div>

                        <div class="form-row single">
                            <div class="form-group">
                                <label class="form-label">Pincode *</label>
                                <input type="text" name="pincode" id="pincode" class="form-input"
                                       placeholder="600017" maxlength="6"
                                       oninput="this.value=this.value.replace(/\D/,'').slice(0,6); fetchCity(this.value)"
                                       value="{{ old('pincode') }}" required>
                                <span class="form-error" id="pincodeError">Please enter a valid 6-digit pincode</span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Flat No. / H No. / Office *</label>
                                <input type="text" name="flat_no" class="form-input"
                                       placeholder="e.g. 4B, Ground Floor"
                                       value="{{ old('flat_no') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Locality / Area / Street *</label>
                                <input type="text" name="locality" class="form-input"
                                       placeholder="e.g. Anna Nagar"
                                       value="{{ old('locality') }}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Landmark (optional)</label>
                                <input type="text" name="landmark" class="form-input"
                                       placeholder="Near bus stop..."
                                       value="{{ old('landmark') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">City *</label>
                                <input type="text" name="city" id="cityInput" class="form-input"
                                       placeholder="Chennai"
                                       value="{{ old('city') }}" required>
                            </div>
                        </div>

                        <div class="form-row single">
                            <div class="form-group">
                                <label class="form-label">Alternate Number (optional)</label>
                                <input type="tel" name="alternate_number" class="form-input"
                                       placeholder="10-digit mobile" maxlength="10"
                                       value="{{ old('alternate_number') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Save As</label>
                            <div class="addr-type-row">
                                <label class="addr-type-btn selected" onclick="selectAddrType(this, 'home')">
                                    <input type="radio" name="address_type" value="home" class="addr-type-radio" checked>
                                    🏠 Home
                                </label>
                                <label class="addr-type-btn" onclick="selectAddrType(this, 'office')">
                                    <input type="radio" name="address_type" value="office" class="addr-type-radio">
                                    🏢 Office
                                </label>
                                <label class="addr-type-btn" onclick="selectAddrType(this, 'other')">
                                    <input type="radio" name="address_type" value="other" class="addr-type-radio">
                                    📍 Other
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pickup Slot --}}
                <div class="co-panel">
                    <div class="co-panel-header">
                        <div class="co-panel-title"><span>📅</span> Pickup Slot</div>
                    </div>
                    <div class="co-panel-body">
                        <div class="slot-grid" id="slotGrid">
                            @php
                                $slots = [
                                    ['day' => 'Today',     'time' => '10:00 AM – 1:00 PM',  'val' => 'today_morning'],
                                    ['day' => 'Today',     'time' => '2:00 PM – 6:00 PM',   'val' => 'today_afternoon'],
                                    ['day' => 'Tomorrow',  'time' => '10:00 AM – 1:00 PM',  'val' => 'tomorrow_morning'],
                                    ['day' => 'Tomorrow',  'time' => '2:00 PM – 6:00 PM',   'val' => 'tomorrow_afternoon'],
                                ];
                            @endphp
                            @foreach($slots as $slot)
                            <div class="slot-card" data-val="{{ $slot['val'] }}" onclick="selectSlot(this, '{{ $slot['day'] }} {{ $slot['time'] }}')">
                                <div class="slot-day">{{ $slot['day'] }}</div>
                                <div class="slot-time">{{ $slot['time'] }}</div>
                            </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="pickup_slot" id="pickup_slot_input" value="">
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="co-panel">
                    <div class="co-panel-header">
                        <div class="co-panel-title"><span>💳</span> Payment Method</div>
                    </div>
                    <div class="co-panel-body">
                        <div class="pay-grid">
                            <div class="pay-card selected" data-val="cash" onclick="selectPayment(this,'cash')">
                                <div class="pay-icon">💵</div>
                                <div class="pay-label">Cash</div>
                            </div>
                            <div class="pay-card" data-val="upi" onclick="selectPayment(this,'upi')">
                                <div class="pay-icon">📱</div>
                                <div class="pay-label">UPI</div>
                            </div>
                            <div class="pay-card" data-val="bank" onclick="selectPayment(this,'bank')">
                                <div class="pay-icon">🏦</div>
                                <div class="pay-label">Bank Transfer</div>
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" id="payment_method_input" value="cash">
                    </div>
                </div>

              <button type="submit" class="co-continue-btn" id="confirmOrderBtn" disabled>
    CONFIRM ORDER →
</buttofn>

                @if($errors->any())
                <div style="margin-top:12px;padding:12px 16px;background:#fdecea;border-radius:10px;font-size:13px;color:#c62828;">
                    @foreach($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
                @endif
            </form>
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="co-price-card">
                <div class="co-price-top">
                    <div class="co-price-img">
                        @if($evaluation->laptopModel && $evaluation->laptopModel->image)
                            <img src="{{ asset('storage/'.$evaluation->laptopModel->image) }}" alt="">
                        @else
                            <span style="font-size:24px;opacity:.3;">💻</span>
                        @endif
                    </div>
                    <div>
                        <div class="co-price-name">{{ $evaluation->laptopModel->name ?? 'Laptop' }}</div>
                        <div class="co-price-spec">
                            {{ $evaluation->brand->name ?? '' }}
                            @if($evaluation->variant) · {{ $evaluation->variant->storage }} @endif
                        </div>
                    </div>
                </div>
                <div class="co-price-body">
                    <div class="co-price-section">Price Summary</div>
                    <div class="co-price-row">
                        <span class="lbl">Base Price</span>
                        <span class="val">₹{{ number_format($evaluation->base_price) }}</span>
                    </div>
                    @if($evaluation->total_deduction > 0)
                    <div class="co-price-row">
                        <span class="lbl">Deduction</span>
                        <span class="val" style="color:#e53935;">−₹{{ number_format($evaluation->total_deduction) }}</span>
                    </div>
                    @endif
                </div>
                <div class="co-price-total">
                    <span class="lbl">Total Amount</span>
                    <span class="val">₹{{ number_format($evaluation->estimated_price) }}</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    
function selectAddrType(el, val) {
    document.querySelectorAll('.addr-type-btn').forEach(b => b.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input').checked = true;
    checkReady();
}

function selectSlot(el, val) {
    document.querySelectorAll('.slot-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('pickup_slot_input').value = val;
    checkReady();
}

function selectPayment(el, val) {
    document.querySelectorAll('.pay-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('payment_method_input').value = val;
}

function checkReady() {
    const slot    = document.getElementById('pickup_slot_input').value;
    const pincode = document.getElementById('pincode').value;
    const btn     = document.getElementById('confirmOrderBtn');

    const isReady = slot.length > 0 && pincode.length === 6;

    btn.classList.toggle('ready', isReady);
    btn.disabled = !isReady; // 👉 important
}

function fetchCity(pincode) {
    if (pincode.length !== 6) return;
    fetch('https://api.postalpincode.in/pincode/' + pincode)
        .then(r => r.json())
        .then(data => {
            if (data[0]?.Status === 'Success') {
                const city = data[0].PostOffice?.[0]?.District || '';
                if (city) document.getElementById('cityInput').value = city;
            }
        })
        .catch(() => {});
    checkReady();
}

function useCurrentLocation() {
    if (!navigator.geolocation) return alert('Geolocation not supported.');
    navigator.geolocation.getCurrentPosition(pos => {
        const { latitude: lat, longitude: lng } = pos.coords;
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(r => r.json())
            .then(data => {
                const addr = data.address || {};
                if (addr.postcode) document.getElementById('pincode').value = addr.postcode;
                if (addr.city || addr.town || addr.village) {
                    document.getElementById('cityInput').value = addr.city || addr.town || addr.village;
                }
            });
    }, () => alert('Could not get location. Please enter manually.'));
}

// Enable confirm button as user fills in
document.getElementById('checkoutForm').addEventListener('input', checkReady);
window.onload = function() {
    const firstSlot = document.querySelector('.slot-card');
    if (firstSlot) {
        firstSlot.classList.add('selected');
        document.getElementById('pickup_slot_input').value =
            firstSlot.getAttribute('data-val');
    }
    checkReady();
};
</script>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>