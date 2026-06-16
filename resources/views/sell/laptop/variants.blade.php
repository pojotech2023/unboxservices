{{-- resources/views/sell/laptop/variants.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sell {{ $model->name }} – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
.vp-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 28px 20px 60px;
}
.vp-breadcrumb {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: #888;
    margin-bottom: 22px;
    flex-wrap: wrap;
}
.vp-breadcrumb a { color: #888; text-decoration: none; }
.vp-breadcrumb a:hover { color: #1565c0; }
.vp-breadcrumb .sep { color: #ccc; margin: 0 1px; }
.vp-breadcrumb .active { color: #222; font-weight: 600; }

.vp-card {
    background: #fff;
    border: 1.5px solid #e8e8e8;
    border-radius: 16px;
    overflow: hidden;
}
.vp-top {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 0;
}
.vp-img-col {
    background: #f7f9fc;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 30px;
    border-right: 1.5px solid #f0f0f0;
    min-height: 280px;
}
.vp-img-col img {
    max-width: 220px;
    max-height: 200px;
    object-fit: contain;
    filter: drop-shadow(0 8px 24px rgba(0,0,0,.10));
}
.vp-img-placeholder {
    font-size: 90px;
    opacity: .2;
    user-select: none;
}
.vp-info-col {
    padding: 36px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.vp-model-name {
    font-family: 'Nunito', sans-serif;
    font-size: 30px;
    font-weight: 900;
    color: #1a1a1a;
    margin: 0 0 6px;
    line-height: 1.2;
}
.vp-sold-tag {
    font-size: 13px;
    color: #888;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.vp-sold-dot {
    width: 7px; height: 7px;
    background: #4caf50;
    border-radius: 50%;
    display: inline-block;
}
.vp-upto-label {
    font-size: 14px;
    color: #555;
    font-weight: 600;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.vp-upto-price {
    font-family: 'Nunito', sans-serif;
    font-size: 48px;
    font-weight: 900;
    color: #e53935;
    line-height: 1;
    margin-bottom: 28px;
}
.vp-upto-price span {
    font-size: 28px;
    vertical-align: super;
    font-weight: 800;
}
.vp-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 36px;
    background: #00bfa5;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-family: 'Nunito', sans-serif;
    font-size: 17px;
    font-weight: 800;
    cursor: pointer;
    text-decoration: none;
    transition: all .22s ease;
    align-self: flex-start;
    letter-spacing: .2px;
}
.vp-cta-btn:hover {
    background: #00897b;
    box-shadow: 0 6px 20px rgba(0,191,165,.3);
    transform: translateY(-2px);
    color: #fff;
}
.vp-cta-arrow { font-size: 20px; font-weight: 900; }

/* Responsive */
@media(max-width: 768px) {
    .vp-top { grid-template-columns: 1fr; }
    .vp-img-col { border-right: none; border-bottom: 1.5px solid #f0f0f0; min-height: 200px; padding: 28px 20px; }
    .vp-img-col img { max-height: 150px; }
    .vp-info-col { padding: 24px 20px; }
    .vp-model-name { font-size: 24px; }
    .vp-upto-price { font-size: 38px; }
    .vp-cta-btn { width: 100%; justify-content: center; }
}
</style>
</head>
<body>
@include('sell.partials.navbar')

<div class="vp-wrap">

    {{-- Breadcrumb --}}
    <div class="vp-breadcrumb">
        <a href="{{ route('sell.index') }}">Home</a>
        <span class="sep">›</span>
        <a href="{{ route('sell.laptop.index') }}">Sell Old Laptop</a>
        <span class="sep">›</span>
        <a href="{{ route('sell.laptop.brand.models', $brand->slug) }}">Sell Old {{ $brand->name }}</a>
        <span class="sep">›</span>
        <span class="active">Sell Old {{ $model->name }}</span>
    </div>

    {{-- Main Card --}}
    <div class="vp-card">
        <div class="vp-top">

            {{-- Image --}}
            <div class="vp-img-col">
                @if($model->image)
                    <img src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
                @else
                    <div class="vp-img-placeholder">💻</div>
                @endif
            </div>

            {{-- Info + CTA --}}
            <div class="vp-info-col">
                <h1 class="vp-model-name">{{ $model->name }}</h1>

                <div class="vp-sold-tag">
                    <span class="vp-sold-dot"></span>
                    {{ $variants->count() }} variant{{ $variants->count() !== 1 ? 's' : '' }} available
                </div>

                @if($model->price > 0)
                    <div class="vp-upto-label">Get Upto</div>
                    <div class="vp-upto-price">
                        <span>₹</span>{{ number_format($model->price, 0) }}
                    </div>
                @endif

                {{--
                    Always enabled — goes to evaluate page directly.
                    Variants இருந்தால் first variant ID pass ஆகும்,
                    இல்லாவிட்டால் variant param இல்லாமல் போகும்.
                --}}
                @php
                    $firstVariant = $variants->first();
                    $evaluateUrl  = route('sell.laptop.evaluate', [$brand->slug, $model->slug]);
                    if ($firstVariant) {
                        $evaluateUrl .= '?variant=' . $firstVariant->id;
                    }
                @endphp

                <a href="{{ $evaluateUrl }}" class="vp-cta-btn">
                    Get Exact Value
                    <span class="vp-cta-arrow">→</span>
                </a>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>