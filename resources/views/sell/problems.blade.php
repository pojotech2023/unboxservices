{{-- resources/views/sell/problems.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Functional & Physical Problems – {{ $model->name }} – Ts Service Center</title>
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
.sell-breadcrumb {
  display: flex; align-items: center; gap: 6px;
  font-size: 13px; color: #888; margin-bottom: 28px; flex-wrap: wrap;
}
.sell-breadcrumb a { color: #888; text-decoration: none; }
.sell-breadcrumb a:hover { color: #00c853; }
.sell-breadcrumb .sep { color: #ccc; }
.sell-breadcrumb .active { color: #333; font-weight: 600; }

.eval-layout {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 24px;
  align-items: start;
}

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
  font-size: 20px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px;
}
.eval-questions-header p { font-size: 13px; color: #888; }

.problems-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  padding: 24px 28px;
}

/* ── Problem Card ── */
.problem-card {
  border: 2px solid #e0e0e0;
  border-radius: 14px;
  overflow: hidden;
  cursor: pointer;
  transition: all .2s ease;
  position: relative;
  background: #fff;
  user-select: none;
}
.problem-card:hover {
  border-color: #f44336;
  box-shadow: 0 4px 16px rgba(244,67,54,.12);
  transform: translateY(-2px);
}
.problem-card.selected {
  border-color: #f44336;
  background: #fff5f5;
  box-shadow: 0 4px 16px rgba(244,67,54,.18);
}

/* ── Tick Badge ── */
.problem-check {
  position: absolute; top: 8px; right: 8px;
  width: 22px; height: 22px;
  background: #e0e0e0; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  transition: all .2s;
}
.problem-card.selected .problem-check { background: #f44336; }
.problem-check svg { display: none; }
.problem-card.selected .problem-check svg { display: block; }

/* ── Image Area ── */
.problem-img-wrap {
  width: 100%; aspect-ratio: 1;
  background: #f8f8f8;
  display: flex; align-items: center; justify-content: center;
  overflow: hidden;
}
.problem-img-wrap img {
  width: 100%; height: 100%; object-fit: cover;
}

/* ── Label at Bottom ── */
.problem-desc {
  padding: 10px 12px;
  font-size: 13px; font-weight: 600; color: #333;
  text-align: center; line-height: 1.4;
  transition: all .2s;
}
.problem-card.selected .problem-desc {
  background: #f44336;
  color: #fff;
}

/* ── No Problems Option ── */
.no-problems-option { margin: 0 28px 24px; }
.no-problems-label {
  display: flex; align-items: center; gap: 10px;
  border: 2px solid #e0e0e0; border-radius: 12px;
  padding: 14px 20px; cursor: pointer; transition: all .18s;
  font-size: 14px; font-weight: 600; color: #555;
}
.no-problems-label:hover { border-color: #00c853; background: #f0fff5; }
.no-problems-label.selected { border-color: #00c853; background: #f0fff5; color: #00a846; }
.no-problems-label input { accent-color: #00c853; width: 18px; height: 18px; }

/* ── Continue Button ── */
.eval-continue-wrap { padding: 0 28px 28px; }
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
.eval-continue-btn:disabled {
  background: #e0e0e0; color: #aaa;
  cursor: not-allowed; box-shadow: none; transform: none;
}

/* ── Sidebar ── */
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
.eval-device-info h3 { font-family: 'Nunito', sans-serif; font-size: 16px; font-weight: 800; color: #1a1a1a; margin-bottom: 4px; }
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
  display: flex; align-items: flex-start; gap: 8px;
  font-size: 13px; color: #555; margin-bottom: 6px; font-weight: 500;
}
.eval-summary-sub-item {
  display: flex; align-items: flex-start; gap: 8px;
  font-size: 12px; color: #555; margin-bottom: 4px; font-weight: 500;
  padding-left: 20px;
}

@media (max-width: 900px) {
  .eval-layout { grid-template-columns: 1fr; }
  .eval-sidebar { position: static; order: -1; }
  .problems-grid { grid-template-columns: repeat(2, 1fr); padding: 18px 20px; }
  .eval-questions-header { padding: 18px 20px 14px; }
  .eval-continue-wrap { padding: 0 20px 20px; }
  .no-problems-option { margin: 0 20px 20px; }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

<div class="eval-page-wrap">

  <div class="sell-breadcrumb">
    <a href="{{ route('sell.index') }}">Home</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.phone') }}">Sell Old Mobile Phone</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.brand.models', $brand->slug) }}">{{ $brand->name }}</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.model.variants', [$brand->slug, $model->slug]) }}">{{ $model->name }}</a>
    <span class="sep">›</span>
    <span class="active">Functional & Physical Problems</span>
  </div>

  <div class="eval-layout">

    <div>
      <div class="eval-questions-panel">
        <div class="eval-questions-header">
          <h2>Functional or Physical Problems</h2>
          <p>Select all problems that apply to your device. You can select multiple.</p>
        </div>

        <form method="POST" action="{{ route('sell.problems.submit', [$brand->slug, $model->slug, $variant->id]) }}"
              id="problemsForm">
          @csrf

          @if($problems->isNotEmpty())
          <div class="problems-grid" id="problemsGrid">
            @foreach($problems as $problem)
            <div class="problem-card" id="prob-card-{{ $problem->id }}"
                 onclick="toggleProblem({{ $problem->id }}, '{{ addslashes($problem->description) }}')">
              <div class="problem-check">
                <svg width="12" height="12" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
              </div>
              <div class="problem-img-wrap">
                <img src="{{ asset('storage/' . $problem->image) }}" alt="{{ $problem->description }}">
              </div>
              <div class="problem-desc">{{ $problem->description }}</div>
              <input type="checkbox"
                     name="problem_ids[]"
                     value="{{ $problem->id }}"
                     id="prob-chk-{{ $problem->id }}"
                     style="display:none;"
                     data-description="{{ $problem->description }}">
            </div>
            @endforeach
          </div>
          @else
          <div style="text-align:center;padding:40px 20px;color:#aaa;">
            <div style="font-size:40px;margin-bottom:10px;">✅</div>
            <p>No problems configured for this device.</p>
          </div>
          @endif

          <div class="no-problems-option">
            <label class="no-problems-label" id="noProblemsLabel">
              <input type="radio" name="no_problems" id="noProblemsRadio" value="1"
                     onchange="selectNoProblems(this)">
              No problems – my device is fully functional
            </label>
          </div>

          <div class="eval-continue-wrap">
            <button type="submit" class="eval-continue-btn" id="problemContinueBtn" disabled>
              Continue to Accessories
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- ═══ SIDEBAR ═══ --}}
    <div class="eval-sidebar">
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
            <div class="eval-device-base-price">Base Price: <strong>₹{{ number_format($variant->price, 2) }}</strong></div>
          </div>
        </div>
      </div>

      <div class="eval-summary-card">
        <div class="eval-summary-header">Device Evaluation</div>
        <div class="eval-summary-body">

          {{-- ── DEVICE DETAILS ── --}}
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

          {{-- ── SELECTED DEFECTS + SECTION ANSWERS ── --}}
          @if(isset($selectedDefects) && $selectedDefects->isNotEmpty())
          <div class="eval-summary-section-lbl">Selected Defects</div>
          @foreach($selectedDefects as $def)
            <div class="eval-summary-item">
              <svg width="14" height="14" fill="none" stroke="#f44336" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
              </svg>
              <span style="color:#f44336;font-weight:600;">{{ $def->description }}</span>
            </div>

            {{-- Section image answers for this defect --}}
            @if(isset($sectionAnswers[$def->id]) && !empty($sectionAnswers[$def->id]))
              @foreach($sectionAnswers[$def->id] as $sectionId => $imageId)
                @php
                  $img = \App\Models\DefectSectionImage::find($imageId);
                @endphp
                @if($img)
                  <div class="eval-summary-sub-item">
                    <svg width="12" height="12" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                      <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    <span style="color:#00c853;font-weight:600;">{{ $img->description }}</span>
                  </div>
                @endif
              @endforeach
            @endif
          @endforeach
          @endif

          {{-- ── PROBLEMS (live JS) ── --}}
          <div class="eval-summary-section-lbl">Problems</div>
          <div id="problemsSummary">
            <div style="font-size:12px;color:#bbb;font-style:italic;">No problems selected yet</div>
          </div>

        </div>
      </div>
    </div>
    {{-- end sidebar --}}

  </div>
</div>

<script>
(function () {
  const selectedProblems = {};

  window.toggleProblem = function (id, description) {
    const card = document.getElementById('prob-card-' + id);
    const chk  = document.getElementById('prob-chk-' + id);
    const noRadio = document.getElementById('noProblemsRadio');
    noRadio.checked = false;
    document.getElementById('noProblemsLabel').classList.remove('selected');

    if (selectedProblems[id]) {
      delete selectedProblems[id];
      card.classList.remove('selected');
      chk.checked = false;
    } else {
      selectedProblems[id] = description;
      card.classList.add('selected');
      chk.checked = true;
    }
    updateProblemsSummary();
    checkCanContinue();
  };

  window.selectNoProblems = function (radio) {
    if (radio.checked) {
      Object.keys(selectedProblems).forEach(function (id) {
        delete selectedProblems[id];
        const card = document.getElementById('prob-card-' + id);
        if (card) card.classList.remove('selected');
        const chk = document.getElementById('prob-chk-' + id);
        if (chk) chk.checked = false;
      });
      document.getElementById('noProblemsLabel').classList.add('selected');
      updateProblemsSummary();
      checkCanContinue();
    }
  };

  function updateProblemsSummary() {
    const container  = document.getElementById('problemsSummary');
    const noProblems = document.getElementById('noProblemsRadio').checked;
    const keys       = Object.keys(selectedProblems);

    if (noProblems) {
      container.innerHTML =
        '<div class="eval-summary-item">' +
        '<svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>' +
        '<span style="color:#00c853;font-weight:600;">No problems</span></div>';
      return;
    }
    if (keys.length === 0) {
      container.innerHTML = '<div style="font-size:12px;color:#bbb;font-style:italic;">No problems selected yet</div>';
      return;
    }
    let html = '';
    keys.forEach(function (id) {
      html +=
        '<div class="eval-summary-item">' +
        '<svg width="14" height="14" fill="none" stroke="#f44336" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>' +
        '<span style="color:#f44336;font-weight:600;">' + escapeHtml(selectedProblems[id]) + '</span></div>';
    });
    container.innerHTML = html;
  }

  function checkCanContinue() {
    const hasProblems = Object.keys(selectedProblems).length > 0;
    const noChecked   = document.getElementById('noProblemsRadio').checked;
    document.getElementById('problemContinueBtn').disabled = !(hasProblems || noChecked);
  }

  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }
})();
</script>

<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>