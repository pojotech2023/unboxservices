{{-- resources/views/sell/laptop/accessories.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accessories – {{ $model->name }}</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing:border-box; }
body { background:#f4f6f8; }
.ac-wrap { max-width:1100px;margin:0 auto;padding:28px 20px 60px; }
.ac-breadcrumb { display:flex;align-items:center;gap:5px;font-size:13px;color:#888;margin-bottom:24px;flex-wrap:wrap; }
.ac-breadcrumb a { color:#888;text-decoration:none; }
.ac-breadcrumb a:hover { color:#00bfa5; }
.ac-breadcrumb .sep { color:#ccc; }
.ac-breadcrumb .active { color:#222;font-weight:600; }
.ac-layout { display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start; }
.ac-panel { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.ac-panel-header { padding:30px 36px 20px;text-align:center; }
.ac-panel-title { font-family:'Nunito',sans-serif;font-size:22px;font-weight:900;color:#1a1a1a;margin-bottom:6px; }
.ac-panel-sub { font-size:14px;color:#888; }
.ac-q-block { padding:0 36px 28px;border-bottom:1.5px solid #f5f5f5; }
.ac-q-block:last-of-type { border-bottom:none; }
.ac-q-label { font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#1a1a1a;margin-bottom:4px; }
.ac-q-hint { font-size:13px;color:#aaa;margin-bottom:16px; }

/* Accessory cards */
.ac-cards { display:flex;flex-wrap:wrap;gap:14px; }
.ac-card {
    border:2px solid #e8e8e8;border-radius:14px;
    padding:24px 20px 18px;
    cursor:pointer;text-align:center;background:#fff;
    transition:all .18s;user-select:none;
    min-width:150px;flex:1;max-width:200px;
    position:relative;
}
.ac-card:hover { border-color:#00bfa5;background:#f0fffe; }
.ac-card.selected { border-color:#00bfa5;background:#e0f2f1; }
.ac-card.selected::after {
    content:'✓';position:absolute;top:10px;right:12px;
    font-size:13px;color:#00bfa5;font-weight:900;
}
.ac-card-img {
    width:72px;height:60px;object-fit:contain;
    margin:0 auto 14px;display:block;pointer-events:none;
}
.ac-card-emoji { font-size:40px;margin-bottom:14px;display:block;pointer-events:none; }
.ac-card-label { font-size:13px;font-weight:600;color:#555;line-height:1.4;pointer-events:none; }
.ac-card.selected .ac-card-label { color:#00695c;font-weight:700; }

/* Nav */
.ac-nav { display:flex;align-items:center;justify-content:space-between;padding:24px 36px;border-top:1.5px solid #f0f0f0;background:#fafafa; }
.ac-btn-back { background:none;border:1.5px solid #e0e0e0;border-radius:8px;padding:10px 22px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:#666;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:all .15s; }
.ac-btn-back:hover { border-color:#aaa;color:#333; }
.ac-btn-next { background:#00bfa5;border:none;border-radius:8px;padding:12px 32px;font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#fff;cursor:pointer;transition:all .18s;display:flex;align-items:center;gap:8px; }
.ac-btn-next:hover { background:#00897b;box-shadow:0 4px 16px rgba(0,191,165,.3); }

/* Sidebar */
.ac-sidebar { position:sticky;top:20px; }
.ac-device-card { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.ac-device-top { display:flex;align-items:center;gap:14px;padding:18px 20px;border-bottom:1px solid #f0f0f0; }
.ac-device-img { width:60px;height:50px;object-fit:contain;background:#f7f9fc;border-radius:8px;padding:4px; }
.ac-device-img-ph { width:60px;height:50px;background:#f7f9fc;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:26px; }
.ac-device-name { font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#1a1a1a;line-height:1.2; }
.ac-device-spec { font-size:12px;color:#888;margin-top:3px; }
.ac-price-block { padding:14px 20px;border-bottom:1px solid #f0f0f0; }
.ac-price-label { font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.4px; }
.ac-price-val { font-family:'Nunito',sans-serif;font-size:28px;font-weight:900;color:#e53935;line-height:1.1; }
.ac-price-val span { font-size:16px;vertical-align:super;font-weight:800; }
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

@media(max-width:820px) {
    .ac-layout { grid-template-columns:1fr; }
    .ac-sidebar { position:static; }
    .ac-panel-header,.ac-q-block,.ac-nav { padding-left:20px;padding-right:20px; }
}
</style>
</head>
<body>
@include('sell.partials.navbar')

<div class="ac-wrap">
    <div class="ac-breadcrumb">
        <a href="{{ route('sell.index') }}">Home</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.index') }}">Sell Old Laptop</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.brand.models', $brand->slug) }}">{{ $brand->name }}</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a><span class="sep">›</span>
        <span class="active">Accessories</span>
    </div>

    <div class="ac-layout">
        <div class="ac-panel">
            <div class="ac-panel-header">
                <div class="ac-panel-title">Do you have the following?</div>
                <div class="ac-panel-sub">Please select accessories which are available</div>
            </div>

            @if($questions->isEmpty())
                <div style="text-align:center;padding:40px;color:#bbb;font-size:14px;">
                    No accessories questions configured yet.
                </div>
            @else
                @foreach($questions as $q)
                <div class="ac-q-block">
                    <div class="ac-q-label">{{ $q->question }}</div>
                    @if($q->small_description)
                    <div class="ac-q-hint">{{ $q->small_description }}</div>
                    @endif
                    <div class="ac-cards">
                        @foreach($q->options as $opt)
                        <div class="ac-card"
                             id="accard-{{ $q->id }}-{{ $opt->id }}"
                             onclick="toggleAcCard({{ $q->id }}, {{ $opt->id }}, {{ json_encode($opt->label) }})">
                            @if($opt->option_image)
                                <img class="ac-card-img"
                                     src="{{ asset('storage/'.$opt->option_image) }}"
                                     alt="{{ $opt->label }}">
                            @elseif($opt->icon_emoji)
                                <span class="ac-card-emoji">{{ $opt->icon_emoji }}</span>
                            @else
                                <span class="ac-card-emoji">📦</span>
                            @endif
                            <div class="ac-card-label">{{ $opt->label }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif

            <div class="ac-nav">
                <a href="{{ route('sell.laptop.screen-condition', [$brand->slug, $model->slug]) }}?{{ http_build_query(request()->except(['acc'])) }}"
                   class="ac-btn-back">← Back</a>
                {{-- ✅ Changed: Now goes to device-age page instead of showing login popup --}}
                <button class="ac-btn-next" onclick="continueNext()">
                    Continue →
                </button>
            </div>
        </div>

        <div class="ac-sidebar">
            <div class="ac-device-card">
                <div class="ac-device-top">
                    @if($model->image)
                        <img class="ac-device-img" src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
                    @else
                        <div class="ac-device-img-ph">💻</div>
                    @endif
                    <div>
                        <div class="ac-device-name">{{ $model->name }}</div>
                        <div class="ac-device-spec">{{ $brand->name }}@if($variant) · {{ $variant->storage }} · {{ $variant->ram }}@endif</div>
                    </div>
                </div>
                <div class="ac-price-block">
                    <div class="ac-price-label">Estimated Price</div>
                    <div class="ac-price-val"><span>₹</span>{{ number_format($variant ? $variant->price : $model->price, 0) }}</div>
                    <div class="ac-price-note">Final price after evaluation</div>
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
                <div class="ac-sb-section" id="acSectionTitle" style="display:none;">Accessories</div>
                <div class="ac-sb-list" id="acSidebarList"></div>
            </div>
        </div>
    </div>
</div>

<script>
const acAnswers  = {};
const BASE_PARAMS = {!! json_encode(request()->all()) !!};
// ✅ Next page is device-age
const NEXT_URL    = "{{ route('sell.laptop.device-age', [$brand->slug, $model->slug]) }}";

function toggleAcCard(qId, optId, label) {
    const el = document.getElementById('accard-' + qId + '-' + optId);
    el.classList.toggle('selected');
    const key = qId + '-' + optId;
    if (el.classList.contains('selected')) {
        acAnswers[key] = label;
    } else {
        delete acAnswers[key];
    }
    const all   = Object.values(acAnswers);
    const title = document.getElementById('acSectionTitle');
    const list  = document.getElementById('acSidebarList');
    if (!all.length) { list.innerHTML = ''; title.style.display = 'none'; return; }
    title.style.display = 'block';
    list.innerHTML = all.map(l => `
        <div class="ac-sb-row">
            <span class="ac-sb-dot info"></span>
            <div><div class="ac-sb-a info">${l}</div></div>
        </div>`).join('');
}

function continueNext() {
    // ✅ Build params and navigate to device-age page
    const allLabels = Object.values(acAnswers).join(',');
    const params = new URLSearchParams(BASE_PARAMS);
    if (allLabels) params.set('acc', allLabels);
    window.location.href = NEXT_URL + '?' + params.toString();
}
</script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>