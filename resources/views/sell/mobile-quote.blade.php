{{-- resources/views/sell/mobile-quote.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Price – {{ $data['model'] }}</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing:border-box; margin:0; padding:0; }
body { background:#f7f8fa; font-family:'Nunito Sans',sans-serif; }
.quote-wrap { max-width:960px; margin:0 auto; padding:40px 20px 80px; }
.quote-title { font-family:'Nunito',sans-serif; font-size:26px; font-weight:900; color:#1a1a1a; margin-bottom:6px; }
.quote-sub { font-size:14px; color:#888; margin-bottom:32px; }

.quote-grid { display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start; }

.quote-main-card {
    background:#fff;
    border:1.5px solid #e8e8e8;
    border-radius:20px;
    overflow:hidden;
}
.quote-device-row {
    display:flex; align-items:center; gap:20px;
    padding:28px 28px 24px;
    border-bottom:1.5px solid #f0f0f0;
}
.quote-device-img {
    width:80px; height:90px;
    background:#f7f9fc; border-radius:12px;
    border:1px solid #eee;
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; overflow:hidden;
}
.quote-device-img img { max-height:80px; max-width:72px; object-fit:contain; }
.quote-device-name { font-family:'Nunito',sans-serif; font-size:18px; font-weight:800; color:#1a1a1a; margin-bottom:4px; }
.quote-device-spec { font-size:13px; color:#888; margin-bottom:6px; }
.quote-selling-label { font-size:12px; color:#aaa; font-weight:600; }
.quote-price-big {
    font-family:'Nunito',sans-serif; font-size:38px; font-weight:900;
    color:#e53935; line-height:1;
}
.quote-price-big span { font-size:22px; }

.quote-benefits {
    display:flex; gap:0; border-bottom:1.5px solid #f0f0f0;
}
.quote-benefit {
    flex:1; display:flex; align-items:center; gap:10px;
    padding:14px 20px; border-right:1px solid #f0f0f0; font-size:13px; font-weight:700; color:#333;
}
.quote-benefit:last-child { border-right:none; }
.quote-benefit-icon { font-size:20px; }

.quote-breakdown { padding:24px 28px; }
.quote-breakdown-title { font-family:'Nunito',sans-serif; font-size:15px; font-weight:800; color:#1a1a1a; margin-bottom:16px; }
.quote-row { display:flex; justify-content:space-between; align-items:center; padding:8px 0; font-size:14px; color:#555; }
.quote-row.total { border-top:1.5px solid #f0f0f0; margin-top:8px; padding-top:16px; font-weight:800; color:#1a1a1a; font-size:16px; }
.quote-row .label { color:#888; }
.quote-row .val { font-weight:700; }
.quote-row.total .val { color:#e53935; font-family:'Nunito',sans-serif; font-size:22px; font-weight:900; }
.quote-row .deduction { color:#2e7d32; }

.quote-actions { padding:0 28px 28px; display:flex; flex-direction:column; gap:12px; }
.btn-sell-now {
    width:100%; padding:16px;
    background:#00bfa5; color:#fff;
    border:none; border-radius:12px;
    font-family:'Nunito',sans-serif; font-size:16px; font-weight:800;
    cursor:pointer; transition:all .2s; text-align:center; text-decoration:none;
    display:flex; align-items:center; justify-content:center; gap:8px;
}
.btn-sell-now:hover { background:#00897b; box-shadow:0 8px 24px rgba(0,191,165,.3); transform:translateY(-1px); }
.btn-recalculate {
    width:100%; padding:12px;
    background:transparent; color:#888;
    border:1.5px solid #e0e0e0; border-radius:12px;
    font-family:'Nunito',sans-serif; font-size:14px; font-weight:700;
    cursor:pointer; text-align:center; text-decoration:none;
    display:block; transition:all .2s;
}
.btn-recalculate:hover { border-color:#00bfa5; color:#00bfa5; }

.quote-sidebar { position:sticky; top:20px; }
.quote-trust-card { background:#fff; border:1.5px solid #e8e8e8; border-radius:16px; padding:24px; margin-bottom:16px; }
.quote-trust-title { font-family:'Nunito',sans-serif; font-size:15px; font-weight:800; color:#1a1a1a; margin-bottom:16px; }
.trust-item { display:flex; align-items:flex-start; gap:12px; padding:10px 0; border-bottom:1px solid #f5f5f5; }
.trust-item:last-child { border-bottom:none; }
.trust-icon { width:36px; height:36px; border-radius:10px; background:#f0fff5; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.trust-text-title { font-size:13px; font-weight:700; color:#1a1a1a; margin-bottom:2px; }
.trust-text-sub { font-size:12px; color:#aaa; line-height:1.4; }

.quote-verified-card { background:#e8f5e9; border:1px solid #c8f5d9; border-radius:12px; padding:14px 16px; display:flex; align-items:center; gap:10px; font-size:13px; font-weight:700; color:#2e7d32; }

@media(max-width:800px) {
    .quote-grid { grid-template-columns:1fr; }
    .quote-sidebar { position:static; }
    .quote-benefits { flex-wrap:wrap; }
    .quote-benefit { flex:0 0 50%; border-bottom:1px solid #f0f0f0; }
}
@media(max-width:500px) {
    .quote-benefit { flex:0 0 100%; }
    .quote-device-row { flex-direction:column; align-items:flex-start; }
    .quote-price-big { font-size:30px; }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

<div class="quote-wrap">
    <h1 class="quote-title">You're almost done</h1>
    <p class="quote-sub">Here's the best price for your {{ $data['model'] }}</p>

    <div class="quote-grid">

        <div>
            <div class="quote-main-card">
                <div class="quote-device-row">
                    <div class="quote-device-img">
                        @if(!empty($data['model_image']))
                            <img src="{{ asset('storage/'.$data['model_image']) }}" alt="{{ $data['model'] }}">
                        @else
                            <span style="font-size:32px;opacity:.3;">📱</span>
                        @endif
                    </div>
                    <div>
                        <div class="quote-device-name">{{ $data['model'] }}</div>
                        <div class="quote-device-spec">
                            {{ $data['brand'] }}
                            @if(!empty($data['variant'])) · {{ $data['variant'] }} @endif
                        </div>
                        <div class="quote-selling-label">Selling price :</div>
                        <div class="quote-price-big">
                            <span>₹</span>{{ number_format($data['price']) }}
                        </div>
                    </div>
                </div>

                <div class="quote-benefits">
                    <div class="quote-benefit">
                        <span class="quote-benefit-icon">⚡</span> Fast Payments
                    </div>
                    <div class="quote-benefit">
                        <span class="quote-benefit-icon">🚗</span> Free Pickup
                    </div>
                    <div class="quote-benefit">
                        <span class="quote-benefit-icon">🛡️</span> 100% Safe
                    </div>
                </div>

                <div class="quote-breakdown">
                    <div class="quote-breakdown-title">Price Summary</div>
                    <div class="quote-row">
                        <span class="label">Base Price</span>
                        <span class="val">₹{{ number_format($data['base_price']) }}</span>
                    </div>
                    @if(!empty($data['deduction']) && $data['deduction'] > 0)
                    <div class="quote-row">
                        <span class="label">Condition Deduction</span>
                        <span class="val" style="color:#e53935;">−₹{{ number_format($data['deduction']) }}</span>
                    </div>
                    @endif
                    <div class="quote-row total">
                        <span>Total Amount</span>
                        <span class="val">₹{{ number_format($data['price']) }}</span>
                    </div>
                </div>

                <div class="quote-actions">
                    <a href="{{ route('sell.phone.checkout', $data['evaluation_id']) }}" class="btn-sell-now">
                        Sell Now
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                    <a href="{{ route('sell.model.variants', [$data['brand_slug'], $data['model_slug']]) }}" class="btn-recalculate">
                        Recalculate
                    </a>
                </div>
            </div>
        </div>

        <div class="quote-sidebar">
            @if(session('customer'))
            <div class="quote-verified-card" style="margin-bottom:16px;">
                <svg width="18" height="18" fill="none" stroke="#2e7d32" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M20 6L9 17l-5-5"/>
                </svg>
                Logged in as {{ session('customer.name') }}
            </div>
            @endif

            <div class="quote-trust-card">
                <div class="quote-trust-title">Why sell with us?</div>
                <div class="trust-item">
                    <div class="trust-icon">💰</div>
                    <div>
                        <div class="trust-text-title">Best Price Guaranteed</div>
                        <div class="trust-text-sub">We offer the highest resale value in the market</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">🚗</div>
                    <div>
                        <div class="trust-text-title">Free Doorstep Pickup</div>
                        <div class="trust-text-sub">Our team comes to your location</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">⚡</div>
                    <div>
                        <div class="trust-text-title">Instant Payment</div>
                        <div class="trust-text-sub">Cash or bank transfer on the spot</div>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">🛡️</div>
                    <div>
                        <div class="trust-text-title">Safe & Secure</div>
                        <div class="trust-text-sub">Data wiped before handover</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
