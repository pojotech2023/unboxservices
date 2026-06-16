{{-- resources/views/sell/laptop/device-condition.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Device Condition – {{ $model->name }}</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing:border-box; }
body { background:#f4f6f8; }
.dc-wrap { max-width:1100px;margin:0 auto;padding:28px 20px 60px; }
.dc-breadcrumb { display:flex;align-items:center;gap:5px;font-size:13px;color:#888;margin-bottom:24px;flex-wrap:wrap; }
.dc-breadcrumb a { color:#888;text-decoration:none; }
.dc-breadcrumb a:hover { color:#00bfa5; }
.dc-breadcrumb .sep { color:#ccc; }
.dc-breadcrumb .active { color:#222;font-weight:600; }
.dc-layout { display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start; }

.dc-panel { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.dc-panel-header { padding:30px 36px 20px;text-align:center; }
.dc-panel-title { font-family:'Nunito',sans-serif;font-size:22px;font-weight:900;color:#1a1a1a;margin-bottom:6px; }
.dc-panel-sub { font-size:14px;color:#888;line-height:1.5; }

/* Section label (question text) */
.dc-section-lbl { padding:8px 36px 0;font-family:'Nunito',sans-serif;font-size:14px;font-weight:800;color:#444; }
.dc-section-hint { padding:4px 36px 14px;font-size:12px;color:#aaa; }

/* Cards grid — 4 per row like Cashify */
.dc-cards-grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:12px;
    padding:0 36px 28px;
}

/* Card */
.dc-card {
    border:2px solid #e8e8e8;
    border-radius:12px;
    padding:18px 12px 14px;
    cursor:pointer;
    transition:border-color .18s, background .18s, box-shadow .18s;
    text-align:center;
    background:#fff;
    user-select:none;
    position:relative;
    /* IMPORTANT: no pointer-events override — keep default auto */
}
.dc-card:hover {
    border-color:#00bfa5;
    background:#f0fffe;
    box-shadow:0 2px 12px rgba(0,191,165,.12);
}
.dc-card.selected {
    border-color:#e53935;
    background:#fff5f5;
    box-shadow:0 2px 12px rgba(229,57,53,.15);
}
.dc-card.selected::after {
    content:'✓';
    position:absolute;top:8px;right:10px;
    font-size:11px;font-weight:900;
    color:#fff;
    background:#e53935;
    border-radius:50%;
    width:18px;height:18px;
    display:flex;align-items:center;justify-content:center;
    line-height:18px;
}

/* Image inside card */
.dc-card-img {
    width:64px;height:54px;
    object-fit:contain;
    margin:0 auto 10px;
    display:block;
    pointer-events:none; /* pass through to card div */
}
.dc-card-emoji {
    font-size:36px;
    margin-bottom:10px;
    display:block;
    pointer-events:none;
}
.dc-card-label {
    font-size:12px;font-weight:600;
    color:#555;line-height:1.4;
    pointer-events:none;
}
.dc-card.selected .dc-card-label { color:#c62828;font-weight:700; }

/* Nav */
.dc-nav { display:flex;align-items:center;justify-content:space-between;padding:24px 36px;border-top:1.5px solid #f0f0f0;background:#fafafa; }
.dc-btn-back { background:none;border:1.5px solid #e0e0e0;border-radius:8px;padding:10px 22px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:#666;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:all .15s; }
.dc-btn-back:hover { border-color:#aaa;color:#333; }
.dc-btn-next { background:#00bfa5;border:none;border-radius:8px;padding:12px 32px;font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#fff;cursor:pointer;transition:all .18s;display:flex;align-items:center;gap:8px; }
.dc-btn-next:hover { background:#00897b;box-shadow:0 4px 16px rgba(0,191,165,.3); }

/* Sidebar */
.dc-sidebar { position:sticky;top:20px; }
.dc-device-card { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.dc-device-top { display:flex;align-items:center;gap:14px;padding:18px 20px;border-bottom:1px solid #f0f0f0; }
.dc-device-img { width:60px;height:50px;object-fit:contain;background:#f7f9fc;border-radius:8px;padding:4px; }
.dc-device-img-ph { width:60px;height:50px;background:#f7f9fc;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:26px; }
.dc-device-name { font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#1a1a1a;line-height:1.2; }
.dc-device-spec { font-size:12px;color:#888;margin-top:3px; }
.dc-price-block { padding:14px 20px;border-bottom:1px solid #f0f0f0; }
.dc-price-label { font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.4px; }
.dc-price-val { font-family:'Nunito',sans-serif;font-size:28px;font-weight:900;color:#e53935;line-height:1.1; }
.dc-price-val span { font-size:16px;vertical-align:super;font-weight:800; }
.dc-price-note { font-size:11px;color:#aaa;margin-top:3px; }
.dc-sb-section { padding:12px 20px 4px;font-size:11px;font-weight:800;color:#aaa;text-transform:uppercase;letter-spacing:.5px;border-top:1px solid #f0f0f0; }
.dc-sb-list { padding:0 20px 10px; }
.dc-sb-row { display:flex;align-items:flex-start;gap:8px;padding:5px 0;font-size:13px;color:#555; }
.dc-sb-dot { width:8px;height:8px;border-radius:50%;margin-top:4px;flex-shrink:0; }
.dc-sb-dot.good { background:#4caf50; }
.dc-sb-dot.bad  { background:#ef5350; }
.dc-sb-dot.info { background:#00bfa5; }
.dc-sb-q { color:#888;font-size:12px; }
.dc-sb-a { font-weight:700; }
.dc-sb-a.good { color:#2e7d32; }
.dc-sb-a.bad  { color:#c62828; }
.dc-sb-a.info { color:#00695c; }

.dc-toast { position:fixed;bottom:30px;left:50%;transform:translateX(-50%) translateY(20px);background:#1a1a1a;color:#fff;padding:12px 24px;border-radius:10px;font-size:14px;font-weight:600;opacity:0;transition:all .3s;z-index:9999;pointer-events:none; }
.dc-toast.show { opacity:1;transform:translateX(-50%) translateY(0); }

@media(max-width:820px) {
    .dc-layout { grid-template-columns:1fr; }
    .dc-sidebar { position:static; }
    .dc-cards-grid { grid-template-columns:repeat(2,1fr); }
    .dc-panel-header,.dc-section-lbl,.dc-section-hint,.dc-nav { padding-left:20px;padding-right:20px; }
    .dc-cards-grid { padding-left:20px;padding-right:20px; }
}
</style>
</head>
<body>
@include('sell.partials.navbar')

<div class="dc-wrap">
    <div class="dc-breadcrumb">
        <a href="{{ route('sell.index') }}">Home</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.index') }}">Sell Old Laptop</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.brand.models', $brand->slug) }}">{{ $brand->name }}</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a><span class="sep">›</span>
        <span class="active">Device Condition</span>
    </div>

    <div class="dc-layout">
        <div class="dc-panel">
            <div class="dc-panel-header">
                <div class="dc-panel-title">Does your device function properly?</div>
                <div class="dc-panel-sub">Please choose appropriate condition to get accurate quote</div>
            </div>

            @if($questions->isEmpty())
                <div style="text-align:center;padding:40px;color:#bbb;font-size:14px;">
                    No device condition questions configured yet.
                </div>
            @else
                @foreach($questions as $q)
                <div class="dc-section-lbl">{{ $q->question }}</div>
                @if($q->small_description)
                <div class="dc-section-hint">{{ $q->small_description }}</div>
                @endif
                <div class="dc-cards-grid">
                    @foreach($q->options as $opt)
                    {{-- Use div + onclick for reliable clicks --}}
                    <div class="dc-card"
                         id="dcard-{{ $q->id }}-{{ $opt->id }}"
                         onclick="toggleDCard({{ $q->id }}, {{ $opt->id }}, {{ json_encode($opt->label) }}, '{{ $q->input_type }}')">
                        @if($opt->option_image)
                            <img class="dc-card-img"
                                 src="{{ asset('storage/'.$opt->option_image) }}"
                                 alt="{{ $opt->label }}">
                        @elseif($opt->icon_emoji)
                            <span class="dc-card-emoji">{{ $opt->icon_emoji }}</span>
                        @else
                            <span class="dc-card-emoji">💻</span>
                        @endif
                        <div class="dc-card-label">{{ $opt->label }}</div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            @endif

            <div class="dc-nav">
                <a href="{{ route('sell.laptop.additional-features', [$brand->slug, $model->slug]) }}?{{ http_build_query(request()->except(['dc'])) }}"
                   class="dc-btn-back">← Back</a>
                <button class="dc-btn-next" onclick="continueNext()">Continue <span>→</span></button>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="dc-sidebar">
            <div class="dc-device-card">
                <div class="dc-device-top">
                    @if($model->image)
                        <img class="dc-device-img" src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
                    @else
                        <div class="dc-device-img-ph">💻</div>
                    @endif
                    <div>
                        <div class="dc-device-name">{{ $model->name }}</div>
                        <div class="dc-device-spec">{{ $brand->name }}@if($variant) · {{ $variant->storage }} · {{ $variant->ram }}@endif</div>
                    </div>
                </div>
                <div class="dc-price-block">
                    <div class="dc-price-label">Estimated Price</div>
                    <div class="dc-price-val"><span>₹</span>{{ number_format($variant ? $variant->price : $model->price, 0) }}</div>
                    <div class="dc-price-note">Price updates based on your answers</div>
                </div>
                @foreach($summary as $sec)
                <div class="dc-sb-section">{{ $sec['section'] }}</div>
                <div class="dc-sb-list">
                    @foreach($sec['items'] as $item)
                    <div class="dc-sb-row">
                        <span class="dc-sb-dot {{ $item['type'] }}"></span>
                        <div>
                            <div class="dc-sb-q">{{ $item['q'] }}</div>
                            <div class="dc-sb-a {{ $item['type'] }}">{{ $item['a'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
                <div class="dc-sb-section" id="dcSectionTitle" style="display:none;">Device Condition</div>
                <div class="dc-sb-list" id="dcSidebarList"></div>
            </div>
        </div>
    </div>
</div>

<div class="dc-toast" id="dcToast">Please select at least one option</div>

<script>
const dcAnswers = {};
const BASE_PARAMS = {!! json_encode(request()->all()) !!};
const NEXT_URL    = "{{ route('sell.laptop.screen-condition', [$brand->slug, $model->slug]) }}";

function toggleDCard(qId, optId, label, inputType) {
    const el = document.getElementById('dcard-' + qId + '-' + optId);
    if (inputType === 'radio') {
        document.querySelectorAll('[id^="dcard-' + qId + '-"]').forEach(e => e.classList.remove('selected'));
        el.classList.add('selected');
        dcAnswers[qId] = [{ id: optId, label: label }];
    } else {
        if (el.classList.contains('selected')) {
            el.classList.remove('selected');
            dcAnswers[qId] = (dcAnswers[qId] || []).filter(a => a.id !== optId);
            if (!dcAnswers[qId]?.length) delete dcAnswers[qId];
        } else {
            el.classList.add('selected');
            dcAnswers[qId] = [...(dcAnswers[qId] || []), { id: optId, label: label }];
        }
    }
    updateDcSidebar();
}

function updateDcSidebar() {
    const list  = document.getElementById('dcSidebarList');
    const title = document.getElementById('dcSectionTitle');
    const all   = Object.values(dcAnswers).flat().map(a => a.label);
    if (!all.length) { list.innerHTML = ''; title.style.display = 'none'; return; }
    title.style.display = 'block';
    list.innerHTML = all.map(l => `
        <div class="dc-sb-row">
            <span class="dc-sb-dot bad"></span>
            <div><div class="dc-sb-a bad">${l}</div></div>
        </div>`).join('');
}

function showToast(m) {
    const t = document.getElementById('dcToast');
    t.textContent = m;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}

function continueNext() {
    const allAnswers = Object.values(dcAnswers).flat().map(a => a.label);
    const params = new URLSearchParams(BASE_PARAMS);
    if (allAnswers.length) params.set('dc', allAnswers.join(','));
    window.location.href = NEXT_URL + '?' + params.toString();
}
</script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>