{{-- resources/views/sell/laptop/screen-condition.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Screen Condition – {{ $model->name }}</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing:border-box; }
body { background:#f4f6f8; }
.sc2-wrap { max-width:1100px;margin:0 auto;padding:28px 20px 60px; }
.sc2-breadcrumb { display:flex;align-items:center;gap:5px;font-size:13px;color:#888;margin-bottom:24px;flex-wrap:wrap; }
.sc2-breadcrumb a { color:#888;text-decoration:none; }
.sc2-breadcrumb a:hover { color:#00bfa5; }
.sc2-breadcrumb .sep { color:#ccc; }
.sc2-breadcrumb .active { color:#222;font-weight:600; }
.sc2-layout { display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start; }
.sc2-panel { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.sc2-panel-header { padding:30px 36px 20px;text-align:center; }
.sc2-panel-title { font-family:'Nunito',sans-serif;font-size:22px;font-weight:900;color:#1a1a1a;margin-bottom:6px; }
.sc2-panel-sub { font-size:14px;color:#888; }
.sc2-q-block { padding:0 36px 28px;border-bottom:1.5px solid #f5f5f5; }
.sc2-q-block:last-of-type { border-bottom:none; }
.sc2-q-label { font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#1a1a1a;margin-bottom:4px; }
.sc2-q-hint { font-size:13px;color:#aaa;margin-bottom:16px; }
.sc2-cards { display:grid;grid-template-columns:repeat(4,1fr);gap:12px; }

.sc2-card {
    border:2px solid #e8e8e8;border-radius:12px;
    padding:20px 12px 14px;
    cursor:pointer;text-align:center;background:#fff;
    transition:all .18s;user-select:none;position:relative;
}
.sc2-card:hover { border-color:#00bfa5;background:#f0fffe; }
.sc2-card.selected { border-color:#00bfa5;background:#00bfa5; }
.sc2-card.selected .sc2-card-label { color:#fff;font-weight:700; }

.sc2-card-img {
    width:64px;height:54px;object-fit:contain;margin:0 auto 12px;display:block;
    pointer-events:none;transition:filter .18s;
}
.sc2-card.selected .sc2-card-img { filter: none; }

.sc2-card-emoji { font-size:36px;margin-bottom:12px;display:block;pointer-events:none; }
.sc2-card-label { font-size:12px;font-weight:600;color:#555;line-height:1.4;pointer-events:none; }

/* Nav */
.sc2-nav { display:flex;align-items:center;justify-content:space-between;padding:24px 36px;border-top:1.5px solid #f0f0f0;background:#fafafa; }
.sc2-btn-back { background:none;border:1.5px solid #e0e0e0;border-radius:8px;padding:10px 22px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:#666;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:all .15s; }
.sc2-btn-back:hover { border-color:#aaa;color:#333; }
.sc2-btn-next { background:#00bfa5;border:none;border-radius:8px;padding:12px 32px;font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#fff;cursor:pointer;transition:all .18s;display:flex;align-items:center;gap:8px; }
.sc2-btn-next:hover { background:#00897b;box-shadow:0 4px 16px rgba(0,191,165,.3); }

/* Sidebar */
.sc2-sidebar { position:sticky;top:20px; }
.sc2-device-card { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.sc2-device-top { display:flex;align-items:center;gap:14px;padding:18px 20px;border-bottom:1px solid #f0f0f0; }
.sc2-device-img { width:60px;height:50px;object-fit:contain;background:#f7f9fc;border-radius:8px;padding:4px; }
.sc2-device-img-ph { width:60px;height:50px;background:#f7f9fc;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:26px; }
.sc2-device-name { font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#1a1a1a;line-height:1.2; }
.sc2-device-spec { font-size:12px;color:#888;margin-top:3px; }
.sc2-price-block { padding:14px 20px;border-bottom:1px solid #f0f0f0; }
.sc2-price-label { font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.4px; }
.sc2-price-val { font-family:'Nunito',sans-serif;font-size:28px;font-weight:900;color:#e53935;line-height:1.1; }
.sc2-price-val span { font-size:16px;vertical-align:super;font-weight:800; }
.sc2-price-note { font-size:11px;color:#aaa;margin-top:3px; }
.sc2-sb-section { padding:12px 20px 4px;font-size:11px;font-weight:800;color:#aaa;text-transform:uppercase;letter-spacing:.5px;border-top:1px solid #f0f0f0; }
.sc2-sb-list { padding:0 20px 10px; }
.sc2-sb-row { display:flex;align-items:flex-start;gap:8px;padding:5px 0;font-size:13px;color:#555; }
.sc2-sb-dot { width:8px;height:8px;border-radius:50%;margin-top:4px;flex-shrink:0; }
.sc2-sb-dot.good { background:#4caf50; }
.sc2-sb-dot.bad  { background:#ef5350; }
.sc2-sb-dot.info { background:#00bfa5; }
.sc2-sb-q { color:#888;font-size:12px; }
.sc2-sb-a { font-weight:700; }
.sc2-sb-a.good { color:#2e7d32; }
.sc2-sb-a.bad  { color:#c62828; }
.sc2-sb-a.info { color:#00695c; }

.sc2-toast { position:fixed;bottom:30px;left:50%;transform:translateX(-50%) translateY(20px);background:#1a1a1a;color:#fff;padding:12px 24px;border-radius:10px;font-size:14px;font-weight:600;opacity:0;transition:all .3s;z-index:9999;pointer-events:none; }
.sc2-toast.show { opacity:1;transform:translateX(-50%) translateY(0); }

@media(max-width:820px) {
    .sc2-layout { grid-template-columns:1fr; }
    .sc2-sidebar { position:static; }
    .sc2-cards { grid-template-columns:repeat(2,1fr); }
    .sc2-panel-header,.sc2-q-block,.sc2-nav { padding-left:20px;padding-right:20px; }
}
</style>
</head>
<body>
@include('sell.partials.navbar')

<div class="sc2-wrap">
    <div class="sc2-breadcrumb">
        <a href="{{ route('sell.index') }}">Home</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.index') }}">Sell Old Laptop</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.brand.models', $brand->slug) }}">{{ $brand->name }}</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a><span class="sep">›</span>
        <span class="active">Screen Condition</span>
    </div>

    <div class="sc2-layout">
        <div class="sc2-panel">
            <div class="sc2-panel-header">
                <div class="sc2-panel-title">Select the screen condition of your device?</div>
                <div class="sc2-panel-sub">The better condition your device is in, we will pay you more</div>
            </div>

            @if($questions->isEmpty())
                <div style="text-align:center;padding:40px;color:#bbb;font-size:14px;">
                    No screen condition questions configured yet.
                </div>
            @else
                @foreach($questions as $q)
                <div class="sc2-q-block" data-qid="{{ $q->id }}">
                    <div class="sc2-q-label">{{ $q->question }}</div>
                    @if($q->small_description)
                    <div class="sc2-q-hint">{{ $q->small_description }}</div>
                    @endif
                    <div class="sc2-cards">
                        @foreach($q->options as $opt)
                        <div class="sc2-card"
                             id="sc2card-{{ $q->id }}-{{ $opt->id }}"
                             onclick="selectSc2({{ $q->id }}, {{ $opt->id }}, {{ json_encode($opt->label) }}, '{{ $q->input_type }}')">
                            @if($opt->option_image)
                                <img class="sc2-card-img"
                                     src="{{ asset('storage/'.$opt->option_image) }}"
                                     alt="{{ $opt->label }}">
                            @elseif($opt->icon_emoji)
                                <span class="sc2-card-emoji">{{ $opt->icon_emoji }}</span>
                            @else
                                <span class="sc2-card-emoji">🖥️</span>
                            @endif
                            <div class="sc2-card-label">{{ $opt->label }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif

            <div class="sc2-nav">
                <a href="{{ route('sell.laptop.device-condition', [$brand->slug, $model->slug]) }}?{{ http_build_query(request()->except(['sc'])) }}"
                   class="sc2-btn-back">← Back</a>
                <button class="sc2-btn-next" onclick="continueNext()">Continue <span>→</span></button>
            </div>
        </div>

        <div class="sc2-sidebar">
            <div class="sc2-device-card">
                <div class="sc2-device-top">
                    @if($model->image)
                        <img class="sc2-device-img" src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
                    @else
                        <div class="sc2-device-img-ph">💻</div>
                    @endif
                    <div>
                        <div class="sc2-device-name">{{ $model->name }}</div>
                        <div class="sc2-device-spec">{{ $brand->name }}@if($variant) · {{ $variant->storage }} · {{ $variant->ram }}@endif</div>
                    </div>
                </div>
                <div class="sc2-price-block">
                    <div class="sc2-price-label">Estimated Price</div>
                    <div class="sc2-price-val"><span>₹</span>{{ number_format($variant ? $variant->price : $model->price, 0) }}</div>
                    <div class="sc2-price-note">Price updates based on your answers</div>
                </div>
                @foreach($summary as $sec)
                <div class="sc2-sb-section">{{ $sec['section'] }}</div>
                <div class="sc2-sb-list">
                    @foreach($sec['items'] as $item)
                    <div class="sc2-sb-row">
                        <span class="sc2-sb-dot {{ $item['type'] }}"></span>
                        <div>
                            <div class="sc2-sb-q">{{ $item['q'] }}</div>
                            <div class="sc2-sb-a {{ $item['type'] }}">{{ $item['a'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
                <div class="sc2-sb-section" id="sc2SectionTitle" style="display:none;">Screen Condition</div>
                <div class="sc2-sb-list" id="sc2SidebarList"></div>
            </div>
        </div>
    </div>
</div>

<div class="sc2-toast" id="sc2Toast">Please select screen condition</div>

<script>
const sc2Answers  = {};
const BASE_PARAMS = {!! json_encode(request()->all()) !!};
const NEXT_URL    = "{{ route('sell.laptop.accessories', [$brand->slug, $model->slug]) }}";

function selectSc2(qId, optId, label, inputType) {
    const el = document.getElementById('sc2card-' + qId + '-' + optId);
    if (inputType === 'radio') {
        document.querySelectorAll('[id^="sc2card-' + qId + '-"]').forEach(e => e.classList.remove('selected'));
        el.classList.add('selected');
        sc2Answers[qId] = [{ id: optId, label: label }];
    } else {
        el.classList.toggle('selected');
        sc2Answers[qId] = el.classList.contains('selected')
            ? [...(sc2Answers[qId] || []), { id: optId, label: label }]
            : (sc2Answers[qId] || []).filter(a => a.id !== optId);
    }
    const all   = Object.values(sc2Answers).flat().map(a => a.label);
    const title = document.getElementById('sc2SectionTitle');
    const list  = document.getElementById('sc2SidebarList');
    if (!all.length) { list.innerHTML = ''; title.style.display = 'none'; return; }
    title.style.display = 'block';
    list.innerHTML = all.map(l => `
        <div class="sc2-sb-row">
            <span class="sc2-sb-dot info"></span>
            <div><div class="sc2-sb-a info">${l}</div></div>
        </div>`).join('');
}

function showToast(m) {
    const t = document.getElementById('sc2Toast');
    t.textContent = m;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}

function continueNext() {
    // Validate radio questions
    let missing = false;
    document.querySelectorAll('.sc2-q-block').forEach(block => {
        const qId = block.dataset.qid;
        const inputType = block.querySelector('.sc2-card')?.closest('.sc2-q-block')?.dataset?.inputType;
        // Check if this question has no answer and has radio type
        const cards = block.querySelectorAll('.sc2-card');
        if (cards.length > 0 && !sc2Answers[qId]) {
            // Check if radio: look at first card's data
            const firstCardId = cards[0].id; // sc2card-{qId}-{optId}
            if (firstCardId && !sc2Answers[qId]) missing = true;
        }
    });

    if (missing) { showToast('Please select an option for all questions'); return; }

    const allLabels = Object.values(sc2Answers).flat().map(a => a.label).join(',');
    const params = new URLSearchParams(BASE_PARAMS);
    if (allLabels) params.set('sc', allLabels);
    window.location.href = NEXT_URL + '?' + params.toString();
}
</script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>