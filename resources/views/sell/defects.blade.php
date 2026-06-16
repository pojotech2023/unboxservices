{{-- resources/views/sell/defects.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sell {{ $model->name }} – Select Defects – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #f7f8fa; font-family: 'Nunito Sans', sans-serif; }

.eval-page-wrap {
  max-width: 1100px;
  margin: 0 auto;
  padding: 28px 20px 80px;
}

/* ══ BREADCRUMB ══ */
.sell-breadcrumb {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #888;
  margin-bottom: 28px;
  flex-wrap: wrap;
}
.sell-breadcrumb a { color: #888; text-decoration: none; }
.sell-breadcrumb a:hover { color: #00c853; }
.sell-breadcrumb .sep { color: #ccc; }
.sell-breadcrumb .active { color: #333; font-weight: 600; }

/* ══ LAYOUT ══ */
.eval-layout {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 24px;
  align-items: start;
}

/* ══ PANEL ══ */
.eval-questions-panel {
  background: #fff;
  border-radius: 16px;
  border: 1.5px solid #ebebeb;
  overflow: hidden;
}
.eval-questions-header {
  padding: 24px 28px 20px;
  border-bottom: 1.5px solid #f0f0f0;
}
.eval-questions-header h2 {
  font-family: 'Nunito', sans-serif;
  font-size: 20px;
  font-weight: 800;
  color: #1a1a1a;
  margin-bottom: 4px;
}
.eval-questions-header p {
  font-size: 13px;
  color: #888;
}

/* ══ DEFECTS GRID ══ */
.defects-grid {
  display: grid;
 grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  padding: 24px 28px;
}

.defect-card {
  border: 2px solid #e0e0e0;
  border-radius: 14px;
  overflow: hidden;
  cursor: pointer;
  transition: all .2s ease;
  position: relative;
  background: #fff;
  user-select: none;
}
.defect-card:hover {
  border-color: #00c853;
  box-shadow: 0 4px 16px rgba(0,200,83,.12);
  transform: translateY(-2px);
}
.defect-card.selected {
  border-color: #00c853;
  background: #f0fff5;
  box-shadow: 0 4px 16px rgba(0,200,83,.18);
}

.defect-check {
  position: absolute;
  top: 8px;
  right: 8px;
  width: 22px;
  height: 22px;
  background: #e0e0e0;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all .2s;
}
.defect-card.selected .defect-check {
  background: #00c853;
}
.defect-check svg { display: none; }
.defect-card.selected .defect-check svg { display: block; }

.defect-img-wrap {
  width: 100%;
  aspect-ratio: 1;
  background: #f8f8f8;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
.defect-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.defect-desc {
  padding: 10px 12px;
  font-size: 13px;
  font-weight: 600;
  color: #333;
  text-align: center;
  line-height: 1.4;
}

/* No defects option */
.no-defects-option {
  margin: 0 28px 24px;
}
.no-defects-label {
  display: flex;
  align-items: center;
  gap: 10px;
  border: 2px solid #e0e0e0;
  border-radius: 12px;
  padding: 14px 20px;
  cursor: pointer;
  transition: all .18s;
  font-size: 14px;
  font-weight: 600;
  color: #555;
}
.no-defects-label:hover {
  border-color: #00c853;
  background: #f0fff5;
}
.no-defects-label.selected {
  border-color: #00c853;
  background: #f0fff5;
  color: #00a846;
}
.no-defects-label input { accent-color: #00c853; width: 18px; height: 18px; }

/* ══ CONTINUE ══ */
.eval-continue-wrap {
  padding: 0 28px 28px;
}
.eval-continue-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 15px 40px;
  background: linear-gradient(135deg, #00c853, #00a846);
  color: #fff;
  border: none;
  border-radius: 50px;
  font-family: 'Nunito', sans-serif;
  font-size: 16px;
  font-weight: 800;
  cursor: pointer;
  transition: all .2s;
}
.eval-continue-btn:hover {
  background: linear-gradient(135deg, #00a846, #008f3a);
  box-shadow: 0 8px 24px rgba(0,200,83,.3);
  transform: translateY(-1px);
}
.eval-continue-btn:disabled {
  background: #e0e0e0;
  color: #aaa;
  cursor: not-allowed;
  box-shadow: none;
  transform: none;
}

/* ══ SIDEBAR ══ */
.eval-sidebar { position: sticky; top: 80px; }

.eval-device-card {
  background: #fff;
  border-radius: 16px;
  border: 1.5px solid #ebebeb;
  padding: 20px;
  margin-bottom: 16px;
}
.eval-device-row { display: flex; align-items: center; gap: 14px; }
.eval-device-img-wrap {
  width: 70px; height: 80px;
  background: #f5f5f5;
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; overflow: hidden;
}
.eval-device-img-wrap img { max-height: 72px; max-width: 64px; object-fit: contain; }
.eval-device-info h3 {
  font-family: 'Nunito', sans-serif;
  font-size: 16px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px;
}
.eval-device-variant {
  font-size: 12px; color: #00c853; font-weight: 700;
  background: #f0fff5; border: 1px solid #c8f5d9;
  border-radius: 6px; display: inline-block; padding: 2px 8px; margin-bottom: 6px;
}
.eval-device-base-price { font-size: 12px; color: #888; }
.eval-device-base-price strong { color: #1a1a1a; font-weight: 700; }

.eval-summary-card {
  background: #fff;
  border-radius: 16px;
  border: 1.5px solid #ebebeb;
  overflow: hidden;
}
.eval-summary-header {
  padding: 16px 20px;
  border-bottom: 1px solid #f0f0f0;
  font-family: 'Nunito', sans-serif;
  font-size: 14px; font-weight: 800; color: #1a1a1a;
}
.eval-summary-body { padding: 16px 20px; }
.eval-summary-section-lbl {
  font-size: 11px; font-weight: 700; color: #bbb;
  text-transform: uppercase; letter-spacing: .5px;
  margin-bottom: 8px; margin-top: 14px;
}
.eval-summary-section-lbl:first-child { margin-top: 0; }
.eval-summary-item {
  display: flex; align-items: center; gap: 8px;
  font-size: 13px; color: #555; margin-bottom: 6px; font-weight: 500;
}
.eval-summary-item svg { flex-shrink: 0; }
.eval-summary-empty { font-size: 12px; color: #bbb; font-style: italic; }

/* ══ MOBILE ══ */
@media (max-width: 900px) {
  .eval-layout { grid-template-columns: 1fr; }
  .eval-sidebar { position: static; order: -1; }
  .defects-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); padding: 18px 20px; }
  .eval-questions-header { padding: 18px 20px 14px; }
  .eval-continue-wrap { padding: 0 20px 20px; }
  .no-defects-option { margin: 0 20px 20px; }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

<div class="eval-page-wrap">

  {{-- Breadcrumb --}}
  <div class="sell-breadcrumb">
    <a href="{{ route('sell.index') }}">Home</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.phone') }}">Sell Old Mobile Phone</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.brand.models', $brand->slug) }}">Sell Old {{ $brand->name }}</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.evaluate', [$brand->slug, $model->slug, $variant->id]) }}">Device Evaluation</a>
    <span class="sep">›</span>
    <span class="active">Select Defects</span>
  </div>

  <div class="eval-layout">

    {{-- ══ LEFT PANEL ══ --}}
    <div>
      <div class="eval-questions-panel">
        <div class="eval-questions-header">
          <h2>Does your device have any defects?</h2>
          <p>Select all defects that apply to your device. Tap an image to select or deselect.</p>
        </div>

        <form method="POST" action="{{ route('sell.defects.submit', [$brand->slug, $model->slug, $variant->id]) }}"
              id="defectsForm">
          @csrf
          <input type="hidden" name="variant_id" value="{{ $variant->id }}">

          @if($defects->isNotEmpty())

            {{-- Defect cards grid --}}
            <div class="defects-grid" id="defectsGrid">
              @foreach($defects as $defect)
              <div class="defect-card" id="card-{{ $defect->id }}"
                   onclick="toggleDefect({{ $defect->id }}, '{{ addslashes($defect->description) }}')">

                <div class="defect-check">
                  <svg width="12" height="12" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                  </svg>
                </div>

                <div class="defect-img-wrap">
                  <img src="{{ asset('storage/' . $defect->image) }}" alt="{{ $defect->description }}">
                </div>
                <div class="defect-desc">{{ $defect->description }}</div>

                {{-- Hidden input, disabled by default --}}
                <input type="checkbox"
                       name="defect_ids[]"
                       value="{{ $defect->id }}"
                       id="chk-{{ $defect->id }}"
                       style="display:none;"
                       data-description="{{ $defect->description }}">
              </div>
              @endforeach
            </div>

          @else
            <div style="text-align:center;padding:40px 20px;color:#aaa;">
              <div style="font-size:40px;margin-bottom:10px;">✅</div>
              <p>No defects have been configured for this variant.</p>
            </div>
          @endif

          {{-- No Defects option --}}
          <div class="no-defects-option">
            <label class="no-defects-label" id="noDefectsLabel">
              <input type="radio" name="no_defects" id="noDefectsRadio" value="1"
                     onchange="selectNoDefects(this)">
              No defects – my device is in perfect condition
            </label>
          </div>

          <div class="eval-continue-wrap">
            <button type="submit" class="eval-continue-btn" id="continueBtn" disabled>
              Continue
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </button>
          </div>

        </form>
      </div>
    </div>

    {{-- ══ RIGHT: SIDEBAR ══ --}}
    <div class="eval-sidebar">

      {{-- Device Card --}}
      <div class="eval-device-card">
        <div class="eval-device-row">
          <div class="eval-device-img-wrap">
            @if($model->image)
              <img src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}">
            @else
              <div style="font-size:32px;opacity:.3;">📱</div>
            @endif
          </div>
          <div class="eval-device-info">
            <h3>{{ $model->name }}</h3>
            <div class="eval-device-variant">{{ $variant->memory }}</div>
            <div class="eval-device-base-price">
              Base Price: <strong>₹{{ number_format($variant->price, 2) }}</strong>
            </div>
          </div>
        </div>
      </div>

      {{-- Summary Card --}}
      <div class="eval-summary-card">
        <div class="eval-summary-header">Device Evaluation</div>
        <div class="eval-summary-body">

          {{-- Previous answers from session --}}
          @if(!empty($savedAnswers))
          <div class="eval-summary-section-lbl">Device Details</div>
          @foreach($questions as $q)
            @if(isset($savedAnswers[$q->id]))
              @php $ans = $savedAnswers[$q->id]; @endphp
              <div class="eval-summary-item">
                @if($ans === 'yes')
                  <svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                  <span style="color:#00c853;font-weight:600;">{{ $q->yes_answer }}</span>
                @else
                  <svg width="14" height="14" fill="none" stroke="#f44336" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                  <span style="color:#f44336;font-weight:600;">{{ $q->no_answer }}</span>
                @endif
              </div>
            @endif
          @endforeach
          @endif

          {{-- Defects selected (dynamic) --}}
          <div class="eval-summary-section-lbl">Defects Selected</div>
          <div id="defectsSummary">
            <div class="eval-summary-empty">No defects selected yet</div>
          </div>

        </div>
      </div>

    </div>

  </div>
</div>

<script>
(function () {
  const selectedDefects = {}; // id -> description

  window.toggleDefect = function (id, description) {
    const card = document.getElementById('card-' + id);
    const chk  = document.getElementById('chk-' + id);

    // Uncheck "no defects" if a defect is selected
    const noDefectsRadio = document.getElementById('noDefectsRadio');
    noDefectsRadio.checked = false;
    document.getElementById('noDefectsLabel').classList.remove('selected');

    if (selectedDefects[id]) {
      delete selectedDefects[id];
      card.classList.remove('selected');
      chk.checked = false;
    } else {
      selectedDefects[id] = description;
      card.classList.add('selected');
      chk.checked = true;
    }

    updateDefectsSummary();
    checkCanContinue();
  };

  window.selectNoDefects = function (radio) {
    if (radio.checked) {
      // Deselect all defects
      Object.keys(selectedDefects).forEach(function (id) {
        delete selectedDefects[id];
        const card = document.getElementById('card-' + id);
        if (card) card.classList.remove('selected');
        const chk = document.getElementById('chk-' + id);
        if (chk) chk.checked = false;
      });
      document.getElementById('noDefectsLabel').classList.add('selected');
      updateDefectsSummary();
      checkCanContinue();
    }
  };

  function updateDefectsSummary() {
    const container = document.getElementById('defectsSummary');
    const keys = Object.keys(selectedDefects);
    const noDefects = document.getElementById('noDefectsRadio').checked;

    if (noDefects) {
      container.innerHTML = '<div class="eval-summary-item">' +
        '<svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>' +
        '<span style="color:#00c853;font-weight:600;">No defects</span></div>';
      return;
    }

    if (keys.length === 0) {
      container.innerHTML = '<div class="eval-summary-empty">No defects selected yet</div>';
      return;
    }

    let html = '';
    keys.forEach(function (id) {
      html += '<div class="eval-summary-item">' +
        '<svg width="14" height="14" fill="none" stroke="#f44336" stroke-width="2.5" viewBox="0 0 24 24">' +
        '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>' +
        '<span style="color:#f44336;font-weight:600;">' + escapeHtml(selectedDefects[id]) + '</span></div>';
    });
    container.innerHTML = html;
  }

  function checkCanContinue() {
    const hasDefects = Object.keys(selectedDefects).length > 0;
    const noDefectsChecked = document.getElementById('noDefectsRadio').checked;
    document.getElementById('continueBtn').disabled = !(hasDefects || noDefectsChecked);
  }

  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }
})();
</script>

<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>