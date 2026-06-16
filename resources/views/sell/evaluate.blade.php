{{-- resources/views/sell/evaluate.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sell {{ $model->name }} – Device Evaluation – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #f7f8fa; font-family: 'Nunito Sans', sans-serif; }

/* ══ PAGE WRAP ══ */
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

/* ══ MAIN LAYOUT ══ */
.eval-layout {
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 24px;
  align-items: start;
}

/* ══ LEFT: QUESTIONS ══ */
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

.eval-questions-body {
  padding: 24px 28px;
}

/* ══ SINGLE QUESTION ══ */
.eval-question-block {
  margin-bottom: 28px;
  padding-bottom: 28px;
  border-bottom: 1px solid #f5f5f5;
}
.eval-question-block:last-child {
  border-bottom: none;
  margin-bottom: 0;
  padding-bottom: 0;
}
.eval-q-number {
  font-size: 13px;
  font-weight: 700;
  color: #00c853;
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: .4px;
}
.eval-q-title {
  font-family: 'Nunito', sans-serif;
  font-size: 16px;
  font-weight: 800;
  color: #1a1a1a;
  margin-bottom: 4px;
}
.eval-q-desc {
  font-size: 12.5px;
  color: #999;
  margin-bottom: 14px;
  line-height: 1.5;
}

/* ══ YES / NO BUTTONS ══ */
.eval-options-row {
  display: flex;
  gap: 12px;
}
.eval-option-label {
  display: flex;
  align-items: center;
  gap: 10px;
  border: 1.5px solid #e0e0e0;
  border-radius: 10px;
  padding: 12px 22px;
  cursor: pointer;
  transition: all .18s ease;
  font-family: 'Nunito Sans', sans-serif;
  font-size: 14px;
  font-weight: 600;
  color: #333;
  user-select: none;
  min-width: 120px;
}
.eval-option-label input[type="radio"] {
  width: 18px;
  height: 18px;
  accent-color: #00c853;
  cursor: pointer;
  flex-shrink: 0;
}
.eval-option-label:hover {
  border-color: #00c853;
  background: #f0fff5;
}
.eval-option-label.selected-yes {
  border-color: #00c853;
  background: #f0fff5;
  color: #00a846;
}
.eval-option-label.selected-no {
  border-color: #f44336;
  background: #fff5f5;
  color: #d32f2f;
}

/* ══ CONTINUE BUTTON ══ */
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

/* ══ RIGHT: DEVICE EVALUATION SIDEBAR ══ */
.eval-sidebar {
  position: sticky;
  top: 80px;
}

.eval-device-card {
  background: #fff;
  border-radius: 16px;
  border: 1.5px solid #ebebeb;
  padding: 20px;
  margin-bottom: 16px;
}
.eval-device-row {
  display: flex;
  align-items: center;
  gap: 14px;
}
.eval-device-img-wrap {
  width: 70px;
  height: 80px;
  background: #f5f5f5;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  overflow: hidden;
}
.eval-device-img-wrap img {
  max-height: 72px;
  max-width: 64px;
  object-fit: contain;
}
.eval-device-info h3 {
  font-family: 'Nunito', sans-serif;
  font-size: 16px;
  font-weight: 800;
  color: #1a1a1a;
  margin-bottom: 4px;
}
.eval-device-variant {
  font-size: 12px;
  color: #00c853;
  font-weight: 700;
  background: #f0fff5;
  border: 1px solid #c8f5d9;
  border-radius: 6px;
  display: inline-block;
  padding: 2px 8px;
  margin-bottom: 6px;
}
.eval-device-base-price {
  font-size: 12px;
  color: #888;
}
.eval-device-base-price strong {
  color: #1a1a1a;
  font-weight: 700;
}

/* ══ EVALUATION SUMMARY ══ */
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
  font-size: 14px;
  font-weight: 800;
  color: #1a1a1a;
}
.eval-summary-body {
  padding: 16px 20px;
}

.eval-summary-section-lbl {
  font-size: 11px;
  font-weight: 700;
  color: #bbb;
  text-transform: uppercase;
  letter-spacing: .5px;
  margin-bottom: 8px;
  margin-top: 12px;
}
.eval-summary-section-lbl:first-child { margin-top: 0; }

.eval-summary-item {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: #555;
  margin-bottom: 6px;
  font-weight: 500;
}
.eval-summary-item svg { flex-shrink: 0; }
.eval-summary-empty {
  font-size: 12px;
  color: #bbb;
  font-style: italic;
}

/* ══ PROGRESS BAR ══ */
.eval-progress-wrap {
  background: #fff;
  border-radius: 16px;
  border: 1.5px solid #ebebeb;
  padding: 16px 20px;
  margin-bottom: 16px;
}
.eval-progress-label {
  display: flex;
  justify-content: space-between;
  font-size: 12px;
  font-weight: 700;
  color: #888;
  margin-bottom: 8px;
}
.eval-progress-bar {
  height: 6px;
  background: #f0f0f0;
  border-radius: 50px;
  overflow: hidden;
}
.eval-progress-fill {
  height: 100%;
  background: linear-gradient(90deg, #00c853, #00a846);
  border-radius: 50px;
  transition: width .3s ease;
  width: 0%;
}

/* ══ MOBILE ══ */
@media (max-width: 900px) {
  .eval-layout {
    grid-template-columns: 1fr;
  }
  .eval-sidebar {
    position: static;
    order: -1;
  }
  .eval-device-card, .eval-summary-card, .eval-progress-wrap {
    margin-bottom: 12px;
  }
  .eval-questions-header { padding: 18px 20px 14px; }
  .eval-questions-body { padding: 18px 20px; }
  .eval-continue-wrap { padding: 0 20px 20px; }
}
@media (max-width: 500px) {
  .eval-option-label { min-width: 100px; padding: 10px 16px; }
  .eval-options-row { gap: 8px; }
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
    <span class="active">Device Evaluation</span>
  </div>

  <div class="eval-layout">

    {{-- ══ LEFT: QUESTIONS PANEL ══ --}}
    <div>

      {{-- Progress --}}
      <div class="eval-progress-wrap">
        <div class="eval-progress-label">
          <span>Questions Progress</span>
          <span id="progressText">0 / {{ $questions->count() }} answered</span>
        </div>
        <div class="eval-progress-bar">
          <div class="eval-progress-fill" id="progressFill"></div>
        </div>
      </div>

      <div class="eval-questions-panel">
        <div class="eval-questions-header">
          <h2>Tell us more about your device</h2>
          <p>Please answer all questions about your device to get an accurate price.</p>
        </div>

        <form method="POST" action="{{ route('sell.evaluate.submit', [$brand->slug, $model->slug, $variant->id]) }}"
              id="evalForm">
          @csrf

          <input type="hidden" name="variant_id" value="{{ $variant->id }}">

          <div class="eval-questions-body">

            @forelse($questions as $index => $question)
            <div class="eval-question-block" id="qblock-{{ $question->id }}">

              <div class="eval-q-number">{{ $index + 1 }}. Question</div>
              <div class="eval-q-title">{{ $question->question }}</div>

              @if($question->small_description)
                <div class="eval-q-desc">{{ $question->small_description }}</div>
              @endif

              <div class="eval-options-row">
                {{-- YES --}}
                <label class="eval-option-label" id="lbl-yes-{{ $question->id }}"
                       onclick="selectAnswer({{ $question->id }}, 'yes', this)">
                  <input type="radio"
                         name="answers[{{ $question->id }}]"
                         value="yes"
                         data-qid="{{ $question->id }}"
                         data-answer="yes"
                         data-answer-text="{{ $question->yes_answer }}"
                         data-question="{{ $question->question }}"
                         required>
                  {{ $question->yes_answer }}
                </label>

                {{-- NO --}}
                <label class="eval-option-label" id="lbl-no-{{ $question->id }}"
                       onclick="selectAnswer({{ $question->id }}, 'no', this)">
                  <input type="radio"
                         name="answers[{{ $question->id }}]"
                         value="no"
                         data-qid="{{ $question->id }}"
                         data-answer="no"
                         data-answer-text="{{ $question->no_answer }}"
                         data-question="{{ $question->question }}"
                         required>
                  {{ $question->no_answer }}
                </label>
              </div>
            </div>
            @empty
              <div style="text-align:center;padding:40px 20px;color:#aaa;">
                <div style="font-size:40px;margin-bottom:10px;">📋</div>
                <p>No evaluation questions added for this variant yet.</p>
              </div>
            @endforelse

          </div>

          @if($questions->isNotEmpty())
          <div class="eval-continue-wrap">
            <button type="submit" class="eval-continue-btn" id="continueBtn" disabled>
              Continue
              <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="5" y1="12" x2="19" y2="12"/>
                <polyline points="12 5 19 12 12 19"/>
              </svg>
            </button>
          </div>
          @endif

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

      {{-- Evaluation Summary --}}
      <div class="eval-summary-card">
        <div class="eval-summary-header">Device Evaluation</div>
        <div class="eval-summary-body" id="summaryBody">

          <div class="eval-summary-section-lbl">Device Details</div>
          <div id="summary-device-details">
            <div class="eval-summary-empty">Answer questions to see summary</div>
          </div>

        </div>
      </div>

    </div>

  </div>
</div>

<script>
(function () {
  const totalQuestions = {{ $questions->count() }};
  const answeredMap    = {}; // qid -> { answer, answerText, question }

  // Group labels by question for summary rendering
  const sectionMap = {};

  @foreach($questions as $q)
  sectionMap[{{ $q->id }}] = {
    question: @json($q->question),
    section: @json($q->small_description ?? '')
  };
  @endforeach

  window.selectAnswer = function (qid, answer, clickedLabel) {
    // Remove selected classes from both labels of this question
    const yesLbl = document.getElementById('lbl-yes-' + qid);
    const noLbl  = document.getElementById('lbl-no-'  + qid);
    yesLbl.classList.remove('selected-yes', 'selected-no');
    noLbl.classList.remove('selected-yes', 'selected-no');

    // Add correct class
    if (answer === 'yes') {
      yesLbl.classList.add('selected-yes');
    } else {
      noLbl.classList.add('selected-no');
    }

    // Get answer text from the radio inside clicked label
    const radio = clickedLabel.querySelector('input[type=radio]');
    const answerText = radio.getAttribute('data-answer-text');
    const questionText = radio.getAttribute('data-question');

    // Store
    answeredMap[qid] = { answer, answerText, questionText };

    // Update progress
    updateProgress();

    // Update sidebar summary
    updateSummary();

    // Enable continue if all answered
    checkAllAnswered();
  };

  function updateProgress() {
    const answered = Object.keys(answeredMap).length;
    const pct = totalQuestions > 0 ? (answered / totalQuestions * 100) : 0;
    document.getElementById('progressFill').style.width = pct + '%';
    document.getElementById('progressText').textContent =
      answered + ' / ' + totalQuestions + ' answered';
  }

  function updateSummary() {
    const container = document.getElementById('summary-device-details');
    const keys = Object.keys(answeredMap);

    if (keys.length === 0) {
      container.innerHTML = '<div class="eval-summary-empty">Answer questions to see summary</div>';
      return;
    }

    let html = '';
    keys.forEach(function (qid) {
      const item = answeredMap[qid];
      const isYes = item.answer === 'yes';
      const color = isYes ? '#00c853' : '#f44336';
      const icon = isYes
        ? '<svg width="14" height="14" fill="none" stroke="#00c853" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>'
        : '<svg width="14" height="14" fill="none" stroke="#f44336" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>';

      html += '<div class="eval-summary-item">' + icon +
              '<span style="color:' + color + ';font-weight:600;">' + escapeHtml(item.answerText) + '</span></div>';
    });

    container.innerHTML = html;
  }

  function checkAllAnswered() {
    const answered = Object.keys(answeredMap).length;
    const btn = document.getElementById('continueBtn');
    if (btn) {
      btn.disabled = (answered < totalQuestions);
    }
  }

  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

})();
</script>

<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>