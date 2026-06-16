{{-- resources/views/sell/laptop/additional-features.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Additional Features – {{ $model->name }}</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
/* ── Reset pointer-events so cards are ALWAYS clickable ── */
* { box-sizing: border-box; }
body { background:#f4f6f8; }
.af-wrap { max-width:1100px;margin:0 auto;padding:28px 20px 60px; }
.af-breadcrumb { display:flex;align-items:center;gap:5px;font-size:13px;color:#888;margin-bottom:24px;flex-wrap:wrap; }
.af-breadcrumb a { color:#888;text-decoration:none; }
.af-breadcrumb a:hover { color:#00bfa5; }
.af-breadcrumb .sep { color:#ccc; }
.af-breadcrumb .active { color:#222;font-weight:600; }
.af-layout { display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start; }

/* Main Panel */
.af-panel { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.af-panel-header { padding:30px 36px 20px; }
.af-panel-title { font-family:'Nunito',sans-serif;font-size:22px;font-weight:900;color:#1a1a1a;margin-bottom:6px; }
.af-panel-sub { font-size:14px;color:#888;line-height:1.5; }

/* Question Block */
.af-question { padding:0 36px 28px;border-bottom:1.5px solid #f5f5f5; }
.af-question:last-of-type { border-bottom:none; }
.af-q-label { font-family:'Nunito',sans-serif;font-size:16px;font-weight:800;color:#1a1a1a;margin-bottom:4px; }
.af-q-hint { font-size:13px;color:#aaa;margin-bottom:16px; }
.af-options-row { display:flex;flex-wrap:wrap;gap:10px; }

/* Option pill — pointer-events MUST be auto */
.af-opt {
    display:flex;align-items:center;gap:10px;
    padding:12px 18px;
    border:2px solid #e0e0e0;border-radius:10px;
    cursor:pointer;background:#fff;
    font-family:'Nunito Sans',sans-serif;font-size:14px;font-weight:600;color:#333;
    transition:border-color .15s, background .15s, color .15s;
    user-select:none;min-width:140px;
    pointer-events:auto; /* explicit */
    position:relative;
}
.af-opt:hover { border-color:#00bfa5;background:#f0fffe;color:#00697b; }
.af-opt.selected { border-color:#00bfa5;background:#e0f2f1;color:#00695c; }

/* Hide native input */
.af-opt input[type="radio"],
.af-opt input[type="checkbox"] { display:none; }

/* Custom radio indicator */
.af-opt-radio {
    width:18px;height:18px;border:2px solid #ccc;border-radius:50%;
    flex-shrink:0;display:flex;align-items:center;justify-content:center;
    transition:background .15s,border-color .15s;
    pointer-events:none; /* so clicks pass through to label */
}
.af-opt.selected .af-opt-radio { background:#00bfa5;border-color:#00bfa5; }
.af-opt.selected .af-opt-radio::after {
    content:'';width:7px;height:7px;background:#fff;border-radius:50%;display:block;
}
/* Checkbox indicator */
.af-opt-check {
    width:18px;height:18px;border:2px solid #ccc;border-radius:4px;
    flex-shrink:0;display:flex;align-items:center;justify-content:center;
    transition:background .15s,border-color .15s;
    pointer-events:none;
}
.af-opt.selected .af-opt-check { background:#00bfa5;border-color:#00bfa5; }
.af-opt.selected .af-opt-check::after {
    content:'✓';color:#fff;font-size:12px;font-weight:900;
}

/* Option image */
.af-opt-img {
    width:36px;height:30px;object-fit:contain;flex-shrink:0;
    pointer-events:none; /* pass through to label */
}
.af-opt-emoji { font-size:18px;flex-shrink:0;pointer-events:none; }
.af-opt-text { pointer-events:none; }

/* Nav */
.af-nav { display:flex;align-items:center;justify-content:space-between;padding:24px 36px;border-top:1.5px solid #f0f0f0;background:#fafafa; }
.af-btn-back { background:none;border:1.5px solid #e0e0e0;border-radius:8px;padding:10px 22px;font-family:'Nunito',sans-serif;font-size:14px;font-weight:700;color:#666;cursor:pointer;transition:all .15s;text-decoration:none;display:inline-flex;align-items:center; }
.af-btn-back:hover { border-color:#aaa;color:#333; }
.af-btn-next { background:#00bfa5;border:none;border-radius:8px;padding:12px 32px;font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#fff;cursor:pointer;transition:all .18s;display:flex;align-items:center;gap:8px; }
.af-btn-next:hover { background:#00897b;box-shadow:0 4px 16px rgba(0,191,165,.3); }

/* Sidebar */
.af-sidebar { position:sticky;top:20px; }
.af-device-card { background:#fff;border:1.5px solid #e8e8e8;border-radius:16px;overflow:hidden; }
.af-device-top { display:flex;align-items:center;gap:14px;padding:18px 20px;border-bottom:1px solid #f0f0f0; }
.af-device-img { width:60px;height:50px;object-fit:contain;background:#f7f9fc;border-radius:8px;padding:4px; }
.af-device-img-ph { width:60px;height:50px;background:#f7f9fc;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:26px; }
.af-device-name { font-family:'Nunito',sans-serif;font-size:15px;font-weight:800;color:#1a1a1a;line-height:1.2; }
.af-device-spec { font-size:12px;color:#888;margin-top:3px; }
.af-price-block { padding:14px 20px;border-bottom:1px solid #f0f0f0; }
.af-price-label { font-size:11px;color:#aaa;font-weight:600;text-transform:uppercase;letter-spacing:.4px; }
.af-price-val { font-family:'Nunito',sans-serif;font-size:28px;font-weight:900;color:#e53935;line-height:1.1; }
.af-price-val span { font-size:16px;vertical-align:super;font-weight:800; }
.af-price-note { font-size:11px;color:#aaa;margin-top:3px; }
.af-summary-section { padding:12px 20px 4px;font-size:11px;font-weight:800;color:#aaa;text-transform:uppercase;letter-spacing:.5px;border-top:1px solid #f0f0f0; }
.af-summary-list { padding:0 20px 10px; }
.af-summary-row { display:flex;align-items:flex-start;gap:8px;padding:5px 0;font-size:13px;color:#555; }
.af-summary-dot { width:8px;height:8px;border-radius:50%;margin-top:4px;flex-shrink:0; }
.af-summary-dot.good { background:#4caf50; }
.af-summary-dot.bad  { background:#ef5350; }
.af-summary-dot.info { background:#00bfa5; }
.af-summary-q { color:#888;font-size:12px; }
.af-summary-a { font-weight:700; }
.af-summary-a.good { color:#2e7d32; }
.af-summary-a.bad  { color:#c62828; }
.af-summary-a.info { color:#00695c; }

/* Toast */
.af-toast { position:fixed;bottom:30px;left:50%;transform:translateX(-50%) translateY(20px);background:#1a1a1a;color:#fff;padding:12px 24px;border-radius:10px;font-size:14px;font-weight:600;opacity:0;transition:all .3s;z-index:9999;pointer-events:none; }
.af-toast.show { opacity:1;transform:translateX(-50%) translateY(0); }

@media(max-width:820px) {
    .af-layout { grid-template-columns:1fr; }
    .af-sidebar { position:static; }
    .af-panel-header,.af-question { padding-left:20px;padding-right:20px; }
    .af-nav { padding:20px; }
    .af-options-row { flex-direction:column; }
    .af-opt { width:100%; }
}
</style>
</head>
<body>
@include('sell.partials.navbar')

<div class="af-wrap">
    <div class="af-breadcrumb">
        <a href="{{ route('sell.index') }}">Home</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.index') }}">Sell Old Laptop</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.brand.models', $brand->slug) }}">{{ $brand->name }}</a><span class="sep">›</span>
        <a href="{{ route('sell.laptop.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a><span class="sep">›</span>
        <span class="active">Additional Features</span>
    </div>

    <div class="af-layout">
        {{-- LEFT --}}
        <div class="af-panel">
            <div class="af-panel-header">
                <div class="af-panel-title">Select the additional features of your device?</div>
                <div class="af-panel-sub">Please select your device additional features</div>
            </div>

            @if($questions->isEmpty())
                <div style="text-align:center;padding:60px 30px;color:#bbb;">
                    <div style="font-size:48px;margin-bottom:12px;">⚙️</div>
                    <p style="font-size:14px;">No additional feature questions configured yet.</p>
                </div>
            @else
                @foreach($questions as $q)
                <div class="af-question" data-qid="{{ $q->id }}" data-input="{{ $q->input_type }}">
                    <div class="af-q-label">{{ $q->question }}</div>
                    @if($q->small_description)
                    <div class="af-q-hint">{{ $q->small_description }}</div>
                    @endif
                    <div class="af-options-row">
                        @foreach($q->options as $opt)
                        {{--
                          IMPORTANT: Use a <div> not <label> to avoid any native browser
                          form-element click stealing. All click handling is via JS.
                        --}}
                        <div class="af-opt" id="opt-{{ $q->id }}-{{ $opt->id }}"
                             onclick="selectOpt({{ $q->id }}, {{ $opt->id }}, {{ json_encode($opt->label) }}, '{{ $q->input_type }}')">
                            @if($q->input_type === 'radio')
                                <span class="af-opt-radio"></span>
                            @else
                                <span class="af-opt-check"></span>
                            @endif

                            @if($opt->option_image)
                                <img class="af-opt-img"
                                     src="{{ asset('storage/'.$opt->option_image) }}"
                                     alt="{{ $opt->label }}">
                            @elseif($opt->icon_emoji)
                                <span class="af-opt-emoji">{{ $opt->icon_emoji }}</span>
                            @endif

                            <span class="af-opt-text">{{ $opt->label }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif

            <div class="af-nav">
                <a href="{{ route('sell.laptop.system-config', [$brand->slug, $model->slug]) }}?{{ http_build_query(request()->all()) }}"
                   class="af-btn-back">← Back</a>
                <button class="af-btn-next" id="btnContinue" onclick="continueNext()">
                    Continue <span>→</span>
                </button>
            </div>
        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="af-sidebar">
            <div class="af-device-card">
                <div class="af-device-top">
                    @if($model->image)
                        <img class="af-device-img" src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
                    @else
                        <div class="af-device-img-ph">💻</div>
                    @endif
                    <div>
                        <div class="af-device-name">{{ $model->name }}</div>
                        <div class="af-device-spec">{{ $brand->name }}@if($variant) · {{ $variant->storage }} · {{ $variant->ram }}@endif</div>
                    </div>
                </div>
                <div class="af-price-block">
                    <div class="af-price-label">Estimated Price</div>
                    <div class="af-price-val"><span>₹</span>{{ number_format($variant ? $variant->price : $model->price, 0) }}</div>
                    <div class="af-price-note">Price updates based on your answers</div>
                </div>

                @foreach($summary as $sec)
                <div class="af-summary-section">{{ $sec['section'] }}</div>
                <div class="af-summary-list">
                    @foreach($sec['items'] as $item)
                    <div class="af-summary-row">
                        <span class="af-summary-dot {{ $item['type'] }}"></span>
                        <div>
                            <div class="af-summary-q">{{ $item['q'] }}</div>
                            <div class="af-summary-a {{ $item['type'] }}">{{ $item['a'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach

                <div class="af-summary-section" id="afSectionTitle" style="display:none;">Additional Features</div>
                <div class="af-summary-list" id="afSummaryList"></div>
            </div>
        </div>
    </div>
</div>

<div class="af-toast" id="afToast">Please select an option for all questions</div>

<script>
const answers = {};
const NEXT_URL   = "{{ route('sell.laptop.device-condition', [$brand->slug, $model->slug]) }}";
const BASE_PARAMS = {!! json_encode(request()->all()) !!};

function selectOpt(qId, optId, label, inputType) {
    if (inputType === 'radio') {
        // deselect all options of this question
        document.querySelectorAll('[id^="opt-' + qId + '-"]').forEach(el => el.classList.remove('selected'));
        document.getElementById('opt-' + qId + '-' + optId).classList.add('selected');
        answers[qId] = [{ id: optId, label: label }];
    } else {
        const el = document.getElementById('opt-' + qId + '-' + optId);
        if (el.classList.contains('selected')) {
            el.classList.remove('selected');
            answers[qId] = (answers[qId] || []).filter(a => a.id !== optId);
            if (!answers[qId].length) delete answers[qId];
        } else {
            el.classList.add('selected');
            answers[qId] = [...(answers[qId] || []), { id: optId, label: label }];
        }
    }
    updateAfSidebar();
}

function updateAfSidebar() {
    const list  = document.getElementById('afSummaryList');
    const title = document.getElementById('afSectionTitle');
    const allLabels = Object.values(answers).flat().map(a => a.label);
    if (!allLabels.length) { list.innerHTML = ''; title.style.display = 'none'; return; }
    title.style.display = 'block';
    list.innerHTML = allLabels.map(l => `
        <div class="af-summary-row">
            <span class="af-summary-dot info"></span>
            <div><div class="af-summary-a info">${l}</div></div>
        </div>`).join('');
}

function showToast(msg) {
    const t = document.getElementById('afToast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}

function continueNext() {
    let missing = false;
    document.querySelectorAll('.af-question[data-input="radio"]').forEach(block => {
        const qId = block.dataset.qid;
        if (!answers[qId]) missing = true;
    });
    if (missing) { showToast('Please select an option for all questions'); return; }

    const afArr = Object.entries(answers).map(([qId, opts]) => ({
        q: document.querySelector('.af-question[data-qid="' + qId + '"] .af-q-label')?.textContent || '',
        a: opts.map(o => o.label).join(', ')
    }));
    const params = new URLSearchParams(BASE_PARAMS);
    params.set('af', btoa(JSON.stringify(afArr)));
    window.location.href = NEXT_URL + '?' + params.toString();
}
</script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>