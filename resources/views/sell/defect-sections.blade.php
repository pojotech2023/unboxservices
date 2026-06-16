{{-- resources/views/sell/defect-sections.blade.php --}}
{{--
  Route: GET /sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/defect-sections
  Controller: SellController@defectSections
  Session keys used:
    sell_answers_{variantId}       — from evaluate step
    sell_defect_ids_{variantId}    — array of selected defect IDs (in order)
    sell_section_answers_{variantId} — accumulated section answers
  Query param: step (0-based index into the defect list)
--}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $currentDefect->description }} – Details – Ts Service Center</title>
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
  display: flex; align-items: center; gap: 6px;
  font-size: 13px; color: #888; margin-bottom: 28px; flex-wrap: wrap;
}
.sell-breadcrumb a { color: #888; text-decoration: none; }
.sell-breadcrumb a:hover { color: #00c853; }
.sell-breadcrumb .sep { color: #ccc; }
.sell-breadcrumb .active { color: #333; font-weight: 600; }

/* ══ PROGRESS STEPPER ══ */
.defect-stepper {
  display: flex;
  align-items: center;
  gap: 0;
  margin-bottom: 28px;
  overflow-x: auto;
  padding-bottom: 4px;
}
.stepper-item {
  display: flex;
  align-items: center;
  gap: 0;
  flex-shrink: 0;
}
.stepper-dot {
  width: 32px; height: 32px;
  border-radius: 50%;
  border: 2px solid #e0e0e0;
  background: #fff;
  display: flex; align-items: center; justify-content: center;
  font-size: 12px; font-weight: 700; color: #aaa;
  transition: all .3s;
  position: relative;
}
.stepper-dot.done { background: #00c853; border-color: #00c853; color: #fff; }
.stepper-dot.active { background: #1a1a1a; border-color: #1a1a1a; color: #fff; }
.stepper-label {
  font-size: 11px; font-weight: 600; color: #aaa;
  max-width: 90px; text-align: center;
  margin: 0 6px;
  line-height: 1.3;
}
.stepper-label.active { color: #1a1a1a; }
.stepper-label.done { color: #00c853; }
.stepper-line {
  flex: 1; min-width: 24px; height: 2px;
  background: #e0e0e0; margin: 0 4px;
}
.stepper-line.done { background: #00c853; }

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
.eval-questions-header .defect-badge {
  display: inline-flex; align-items: center; gap: 6px;
  background: #fff3e0; border: 1px solid #ffe0b2;
  color: #e65100; border-radius: 8px;
  padding: 4px 12px; font-size: 12px; font-weight: 700;
  margin-bottom: 10px;
}
.eval-questions-header h2 {
  font-family: 'Nunito', sans-serif;
  font-size: 20px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px;
}
.eval-questions-header p { font-size: 13px; color: #888; }

/* ══ SECTIONS ══ */
.sections-wrap { padding: 24px 28px; }
.section-block {
  margin-bottom: 28px;
  border: 1.5px solid #ebebeb;
  border-radius: 14px;
  overflow: hidden;
}
.section-block-header {
  padding: 14px 20px;
  background: #f8f9fa;
  border-bottom: 1px solid #ebebeb;
}
.section-block-header h3 {
  font-family: 'Nunito', sans-serif;
  font-size: 15px; font-weight: 800; color: #1a1a1a; margin-bottom: 2px;
}
.section-block-header p { font-size: 12px; color: #888; }
.section-required-badge {
  font-size: 10px; font-weight: 700;
  background: #ffebee; color: #c62828;
  border-radius: 4px; padding: 2px 8px;
  margin-left: 8px; vertical-align: middle;
}

/* ══ IMAGE CARDS in section ══ */
.section-images-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 14px;
  padding: 18px 20px;
}
.section-image-card {
  border: 2px solid #e0e0e0;
  border-radius: 12px;
  overflow: hidden;
  cursor: pointer;
  transition: all .2s ease;
  position: relative;
  background: #fff;
  user-select: none;
}
.section-image-card:hover {
  border-color: #00c853;
  box-shadow: 0 4px 16px rgba(0,200,83,.12);
  transform: translateY(-2px);
}
.section-image-card.selected {
  border-color: #00c853;
  background: #f0fff5;
  box-shadow: 0 4px 16px rgba(0,200,83,.18);
}
.sec-img-check {
  position: absolute; top: 7px; right: 7px;
  width: 20px; height: 20px;
  background: #e0e0e0; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  transition: all .2s;
}
.section-image-card.selected .sec-img-check { background: #00c853; }
.sec-img-check svg { display: none; }
.section-image-card.selected .sec-img-check svg { display: block; }
.sec-img-wrap {
  width: 100%; aspect-ratio: 1;
  background: #f8f8f8;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}
.sec-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
.sec-img-desc {
  padding: 8px 10px;
  font-size: 12px; font-weight: 600; color: #333;
  text-align: center; line-height: 1.3;
}

/* ══ VALIDATION MESSAGE ══ */
.section-validation-msg {
  display: none;
  margin: 0 20px 16px;
  padding: 10px 16px;
  background: #fff3f3;
  border: 1px solid #ffcdd2;
  border-radius: 8px;
  font-size: 13px;
  color: #c62828;
  font-weight: 600;
}

/* ══ CONTINUE ══ */
.eval-continue-wrap {
  padding: 0 28px 28px;
  display: flex; align-items: center; gap: 16px;
}
.eval-continue-btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 8px;
  padding: 15px 40px;
  background: linear-gradient(135deg, #00c853, #00a846);
  color: #fff; border: none; border-radius: 50px;
  font-family: 'Nunito', sans-serif;
  font-size: 16px; font-weight: 800;
  cursor: pointer; transition: all .2s;
}
.eval-continue-btn:hover {
  background: linear-gradient(135deg, #00a846, #008f3a);
  box-shadow: 0 8px 24px rgba(0,200,83,.3);
  transform: translateY(-1px);
}
.step-info {
  font-size: 13px; color: #888;
}
.step-info strong { color: #1a1a1a; }

/* ══ SIDEBAR ══ */
.eval-sidebar { position: sticky; top: 80px; }
.eval-device-card {
  background: #fff; border-radius: 16px;
  border: 1.5px solid #ebebeb; padding: 20px; margin-bottom: 16px;
}
.eval-device-row { display: flex; align-items: center; gap: 14px; }
.eval-device-img-wrap {
  width: 70px; height: 80px; background: #f5f5f5;
  border-radius: 10px; display: flex; align-items: center; justify-content: center;
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
  background: #fff; border-radius: 16px;
  border: 1.5px solid #ebebeb; overflow: hidden;
}
.eval-summary-header {
  padding: 16px 20px; border-bottom: 1px solid #f0f0f0;
  font-family: 'Nunito', sans-serif; font-size: 14px; font-weight: 800; color: #1a1a1a;
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

/* ══ TOAST ══ */
.toast-container {
  position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
  z-index: 9999; display: flex; flex-direction: column; align-items: center; gap: 10px;
}
.toast-msg {
  background: #1a1a1a; color: #fff;
  padding: 12px 24px; border-radius: 50px;
  font-size: 14px; font-weight: 600;
  box-shadow: 0 8px 24px rgba(0,0,0,.25);
  animation: toastIn .3s ease;
  display: flex; align-items: center; gap: 10px;
}
.toast-msg.success { background: #00c853; }
.toast-msg.error   { background: #f44336; }
@keyframes toastIn {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ══ MOBILE ══ */
@media (max-width: 900px) {
  .eval-layout { grid-template-columns: 1fr; }
  .eval-sidebar { position: static; order: -1; }
  .section-images-grid { grid-template-columns: repeat(2, 1fr); padding: 14px 16px; }
  .eval-questions-header { padding: 18px 20px 14px; }
  .sections-wrap { padding: 18px 20px; }
  .eval-continue-wrap { padding: 0 20px 20px; flex-direction: column; align-items: flex-start; }
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
    <a href="{{ route('sell.brand.models', $brand->slug) }}">{{ $brand->name }}</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.defects', [$brand->slug, $model->slug, $variant->id]) }}">Select Defects</a>
    <span class="sep">›</span>
    <span class="active">Defect Details</span>
  </div>

  {{-- Stepper --}}
  <div class="defect-stepper">
    @foreach($selectedDefects as $i => $def)
      @if($i > 0)
        <div class="stepper-line {{ $i <= $step ? 'done' : '' }}"></div>
      @endif
      <div class="stepper-item">
        <div class="stepper-dot {{ $i < $step ? 'done' : ($i == $step ? 'active' : '') }}">
          @if($i < $step)
            <svg width="12" height="12" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
              <polyline points="20 6 9 17 4 12"/>
            </svg>
          @else
            {{ $i + 1 }}
          @endif
        </div>
        <div class="stepper-label {{ $i < $step ? 'done' : ($i == $step ? 'active' : '') }}">
          {{ Str::limit($def->description, 18) }}
        </div>
      </div>
    @endforeach
  </div>

  <div class="eval-layout">

    {{-- ══ LEFT PANEL ══ --}}
    <div>
      <div class="eval-questions-panel">
        <div class="eval-questions-header">
          <div class="defect-badge">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            Defect {{ $step + 1 }} of {{ count($selectedDefects) }}: {{ $currentDefect->description }}
          </div>
          <h2>Tell us more about this defect</h2>
          <p>Select one option from each section below. At least one image must be selected per section.</p>
        </div>

        <form method="POST" action="{{ route('sell.defect.sections.submit', [$brand->slug, $model->slug, $variant->id]) }}"
              id="sectionsForm">
          @csrf
          <input type="hidden" name="step" value="{{ $step }}">
          <input type="hidden" name="defect_id" value="{{ $currentDefect->id }}">

          <div class="sections-wrap">
            @forelse($sections as $si => $section)
            <div class="section-block" id="section-block-{{ $section->id }}">
              <div class="section-block-header">
                <h3>
                  {{ $section->title }}
                  <span class="section-required-badge">Required</span>
                </h3>
                @if($section->description)
                  <p>{{ $section->description }}</p>
                @endif
              </div>

              <div class="section-images-grid" id="grid-{{ $section->id }}">
                @foreach($section->images as $img)
                <div class="section-image-card"
                     id="img-card-{{ $img->id }}"
                     onclick="selectSectionImage({{ $section->id }}, {{ $img->id }}, '{{ addslashes($img->description) }}')">

                  <div class="sec-img-check">
                    <svg width="10" height="10" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
                      <polyline points="20 6 9 17 4 12"/>
                    </svg>
                  </div>

                  <div class="sec-img-wrap">
                    <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->description }}">
                  </div>
                  <div class="sec-img-desc">{{ $img->description }}</div>

                  <input type="radio"
                         name="sections[{{ $section->id }}]"
                         value="{{ $img->id }}"
                         id="radio-{{ $img->id }}"
                         style="display:none;"
                         required>
                </div>
                @endforeach
              </div>

              <div class="section-validation-msg" id="val-{{ $section->id }}">
                ⚠ Please select an option from "{{ $section->title }}" to continue.
              </div>
            </div>
            @empty
            <div style="text-align:center;padding:40px;color:#aaa;">
              <div style="font-size:40px;margin-bottom:10px;">📋</div>
              <p>No sections configured for this defect.</p>
            </div>
            @endforelse
          </div>

          <div class="eval-continue-wrap">
            <button type="submit" class="eval-continue-btn" id="continueBtn" onclick="return validateSections(event)">
              @if($isLast)
                Continue to Problems
              @else
                Next: {{ Str::limit($selectedDefects[$step + 1]->description ?? '', 25) }}
              @endif
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </button>
            <div class="step-info">
              Step <strong>{{ $step + 1 }}</strong> of <strong>{{ count($selectedDefects) }}</strong>
            </div>
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

          @if(!empty($savedAnswers))
          <div class="eval-summary-section-lbl">Device Details</div>
          @foreach($evalQuestions as $q)
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

          <div class="eval-summary-section-lbl">Selected Defects</div>
          @foreach($selectedDefects as $i => $def)
            <div class="eval-summary-item">
              @if($i < $step)
                <svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                <span style="color:#00c853;font-weight:600;">{{ $def->description }}</span>
              @elseif($i == $step)
                <svg width="14" height="14" fill="none" stroke="#ff9800" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                <span style="color:#ff9800;font-weight:600;">{{ $def->description }}</span>
              @else
                <svg width="14" height="14" fill="none" stroke="#ccc" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                <span style="color:#aaa;">{{ $def->description }}</span>
              @endif
            </div>
          @endforeach

          {{-- Current section selections (dynamic) --}}
          <div class="eval-summary-section-lbl">Current Selections</div>
          <div id="sectionSummary">
            <div style="font-size:12px;color:#bbb;font-style:italic;">No selections yet</div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

{{-- Toast Container --}}
<div class="toast-container" id="toastContainer"></div>

<script>
(function () {
  // section_id -> { imageId, description }
  const sectionSelections = {};
  const sectionIds = @json($sections->pluck('id'));

  window.selectSectionImage = function (sectionId, imageId, description) {
    // Remove selected from all cards in this section
    document.querySelectorAll('#grid-' + sectionId + ' .section-image-card')
      .forEach(function (c) { c.classList.remove('selected'); });

    // Select this card
    const card = document.getElementById('img-card-' + imageId);
    if (card) card.classList.add('selected');

    // Check radio
    const radio = document.getElementById('radio-' + imageId);
    if (radio) radio.checked = true;

    // Store
    sectionSelections[sectionId] = { imageId: imageId, description: description };

    // Hide validation msg for this section
    const valMsg = document.getElementById('val-' + sectionId);
    if (valMsg) valMsg.style.display = 'none';

    updateSectionSummary();
    showToast('✓ ' + description + ' selected', 'success');
  };

  window.validateSections = function (e) {
    let allValid = true;
    sectionIds.forEach(function (sid) {
      const valMsg = document.getElementById('val-' + sid);
      if (!sectionSelections[sid]) {
        if (valMsg) valMsg.style.display = 'block';
        allValid = false;
      }
    });
    if (!allValid) {
      e.preventDefault();
      showToast('⚠ Please select one option from each section', 'error');
      // scroll to first invalid section
      const firstInvalid = document.querySelector('.section-validation-msg[style*="block"]');
      if (firstInvalid) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return false;
    }
    return true;
  };

  function updateSectionSummary() {
    const container = document.getElementById('sectionSummary');
    const keys = Object.keys(sectionSelections);
    if (keys.length === 0) {
      container.innerHTML = '<div style="font-size:12px;color:#bbb;font-style:italic;">No selections yet</div>';
      return;
    }
    let html = '';
    keys.forEach(function (sid) {
      const sel = sectionSelections[sid];
      html += '<div class="eval-summary-item">' +
        '<svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>' +
        '<span style="color:#00c853;font-weight:600;">' + escapeHtml(sel.description) + '</span></div>';
    });
    container.innerHTML = html;
  }

  function showToast(msg, type) {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = 'toast-msg ' + (type || '');
    toast.textContent = msg;
    container.appendChild(toast);
    setTimeout(function () {
      toast.style.opacity = '0';
      toast.style.transition = 'opacity .3s';
      setTimeout(function () { toast.remove(); }, 300);
    }, 2000);
  }

  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }
})();
</script>

<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
