{{-- resources/views/sell/laptop/device_age.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Device Age – {{ $model->name }}</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing:border-box; }
body { background:#f4f6f8; font-family:'Nunito Sans',sans-serif; }
.ac-wrap { max-width:1100px;margin:0 auto;padding:28px 20px 60px; }
.ac-breadcrumb { display:flex;align-items:center;gap:5px;font-size:13px;color:#888;margin-bottom:24px;flex-wrap:wrap; }
.ac-breadcrumb a { color:#888;text-decoration:none; }
.ac-breadcrumb a:hover { color:#00bfa5; }
.ac-breadcrumb .sep { color:#ccc; }
.ac-breadcrumb .active { color:#222;font-weight:600; }
.ac-layout { display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start; }
.ac-panel { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.ac-panel-header { padding:30px 36px 24px;text-align:center;border-bottom:1.5px solid #f0f0f0; }
.ac-panel-title { font-family:'Nunito',sans-serif;font-size:22px;font-weight:900;color:#1a1a1a;margin-bottom:6px; }
.ac-panel-sub { font-size:14px;color:#888; }

.age-options-wrap { padding:28px 36px 32px; }
.age-options-row { display:flex;flex-direction:column;gap:12px; }

.age-radio-card {
    border:2px solid #e0e0e0;border-radius:12px;
    padding:18px 20px;cursor:pointer;background:#fff;
    transition:all .18s;user-select:none;
    display:flex;align-items:center;gap:14px;
}
.age-radio-card:hover { border-color:#00bfa5;background:#f0fffe; }
.age-radio-card.selected { border-color:#00bfa5;background:#e0f2f1; }

.age-radio-circle {
    width:22px;height:22px;border-radius:50%;
    border:2px solid #ccc;flex-shrink:0;
    display:flex;align-items:center;justify-content:center;
    transition:all .18s;
}
.age-radio-card.selected .age-radio-circle { border-color:#00bfa5; }
.age-radio-circle-inner {
    width:10px;height:10px;border-radius:50%;
    background:#00bfa5;display:none;
}
.age-radio-card.selected .age-radio-circle-inner { display:block; }

.age-radio-icon { font-size:26px;flex-shrink:0;line-height:1; }
.age-radio-img  { width:36px;height:36px;object-fit:contain;flex-shrink:0; }

.age-radio-label {
    font-family:'Nunito',sans-serif;font-size:15px;
    font-weight:800;color:#1a1a1a;flex:1;
}
.age-radio-card.selected .age-radio-label { color:#00695c; }

.age-radio-ded {
    font-size:12px;font-weight:700;
    background:#ffeaea;color:#e53935;
    border-radius:6px;padding:2px 10px;flex-shrink:0;
}
.age-radio-free {
    font-size:12px;font-weight:700;
    background:#f0fff5;color:#00a846;
    border-radius:6px;padding:2px 10px;flex-shrink:0;
}

.ac-nav { display:flex;align-items:center;justify-content:space-between;padding:24px 36px;border-top:1.5px solid #f0f0f0;background:#fafafa; }
.ac-btn-back { background:none;border:1.5px solid #e0e0e0;border-radius:8px;padding:10px 22px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:#666;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:all .15s; }
.ac-btn-back:hover { border-color:#aaa;color:#333; }
.ac-btn-next { background:#00bfa5;border:none;border-radius:8px;padding:12px 32px;font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#fff;cursor:pointer;transition:all .18s;display:flex;align-items:center;gap:8px; }
.ac-btn-next:hover { background:#00897b;box-shadow:0 4px 16px rgba(0,191,165,.3); }
.ac-btn-next:disabled { background:#e0e0e0;color:#aaa;cursor:not-allowed;box-shadow:none; }

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

.age-empty { text-align:center;padding:48px 20px;color:#bbb;font-size:14px; }

@media(max-width:820px){
    .ac-layout { grid-template-columns:1fr; }
    .ac-sidebar { position:static; }
    .ac-panel-header,.age-options-wrap,.ac-nav { padding-left:20px;padding-right:20px; }
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
        <span class="active">Device Age</span>
    </div>

    <div class="ac-layout">

        {{-- MAIN PANEL --}}
        <div class="ac-panel">
            <div class="ac-panel-header">
                @if($question)
                    <div class="ac-panel-title">{{ $question->question }}</div>
                    @if($question->small_description)
                        <div class="ac-panel-sub">{{ $question->small_description }}</div>
                    @endif
                @else
                    <div class="ac-panel-title">Age of your device</div>
                    <div class="ac-panel-sub">Let us know how old is your device. Valid bill is needed for devices less than 3 years.</div>
                @endif
            </div>

            @if($question && $question->options->isNotEmpty())
                <div class="age-options-wrap">
                    <div class="age-options-row">
                        @php $icons = ['🛡️','📅','🕰️','📦','📆']; @endphp
                        @foreach($question->options->sortBy('sort_order') as $i => $opt)
                        <div class="age-radio-card"
                             id="age-opt-{{ $opt->id }}"
                             onclick="selectAge({{ $opt->id }}, {{ json_encode($opt->label) }})">
                            <div class="age-radio-circle">
                                <div class="age-radio-circle-inner"></div>
                            </div>
                            @if($opt->option_image)
                                <img class="age-radio-img"
                                     src="{{ asset('storage/'.$opt->option_image) }}"
                                     alt="{{ $opt->label }}">
                            @elseif($opt->icon_emoji)
                                <span class="age-radio-icon">{{ $opt->icon_emoji }}</span>
                            @else
                                <span class="age-radio-icon">{{ $icons[$i] ?? '📦' }}</span>
                            @endif
                            <div class="age-radio-label">{{ $opt->label }}</div>
                            @if(($opt->deduction ?? 0) > 0)
                                <span class="age-radio-ded">-₹{{ number_format($opt->deduction) }}</span>
                            @else
                                <span class="age-radio-free">No deduction</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="age-empty">
                    <div style="font-size:40px;margin-bottom:10px;">📅</div>
                    <p>No device age options configured yet.</p>
                </div>
            @endif

            <div class="ac-nav">
                <a href="{{ route('sell.laptop.accessories', [$brand->slug, $model->slug]) }}?{{ http_build_query(request()->except(['age','age_id'])) }}"
                   class="ac-btn-back">← Back</a>
                <button class="ac-btn-next" id="ageNextBtn" disabled onclick="goToNextPage()">
                    Continue →
                </button>
            </div>
        </div>

        {{-- SIDEBAR --}}
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
                        <div class="ac-device-spec">
                            {{ $brand->name }}
                            @if($variant) · {{ $variant->storage }} · {{ $variant->ram }} @endif
                        </div>
                    </div>
                </div>
                <div class="ac-price-block">
                    <div class="ac-price-label">Estimated Price</div>
                    <div class="ac-price-val">
                        <span>₹</span>{{ number_format($variant ? $variant->price : $model->price, 0) }}
                    </div>
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

                {{-- Live: selected age --}}
                <div id="ageSidebarSection" style="display:none;">
                    <div class="ac-sb-section">Device Age</div>
                    <div class="ac-sb-list">
                        <div class="ac-sb-row">
                            <span class="ac-sb-dot info"></span>
                            <div>
                                <div class="ac-sb-a info" id="ageSidebarLabel"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
(function(){
    // All existing query params (power_on, processor, ram, storage, etc.)
    const BASE_PARAMS = {!! json_encode(request()->all()) !!};

    // Next page base URL
    const NEXT_URL = '{{ route("sell.laptop.physical-condition", [$brand->slug, $model->slug]) }}';

    let selLabel = null;
    let selId    = null;

    window.selectAge = function(optId, label) {
        document.querySelectorAll('.age-radio-card').forEach(el => el.classList.remove('selected'));
        document.getElementById('age-opt-' + optId).classList.add('selected');
        selId    = optId;
        selLabel = label;
        document.getElementById('ageSidebarSection').style.display = 'block';
        document.getElementById('ageSidebarLabel').textContent = label;
        document.getElementById('ageNextBtn').disabled = false;
    };

    // ✅ No login popup — directly go to physical-condition page with all params
    window.goToNextPage = function() {
        if (!selId || !selLabel) return;

        // Merge existing params + new age params
        let params = Object.assign({}, BASE_PARAMS);
        params['age']    = selLabel;
        params['age_id'] = selId;

        // Remove _token if present (not needed in GET)
        delete params['_token'];

        // Build query string
        let queryString = Object.keys(params)
            .filter(k => params[k] !== null && params[k] !== undefined && params[k] !== '')
            .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(params[k]))
            .join('&');

        window.location.href = NEXT_URL + '?' + queryString;
    };

})();
</script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>