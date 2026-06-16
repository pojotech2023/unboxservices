{{-- resources/views/sell/models.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sell {{ $brand->name }} Phone – Ts Service Center</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
/* ══ SELL MODELS PAGE ══ */
.sell-page-wrap {
  max-width: 1300px;
  margin: 0 auto;
  padding: 28px 20px 60px;
}

/* Breadcrumb */
.sell-breadcrumb {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #888;
  margin-bottom: 18px;
  flex-wrap: wrap;
}
.sell-breadcrumb a { color: #888; text-decoration: none; }
.sell-breadcrumb a:hover { color: #00c853; }
.sell-breadcrumb .sep { color: #ccc; }
.sell-breadcrumb .active { color: #333; font-weight: 600; }

/* Page title row */
.sell-title-row {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 16px;
  margin-bottom: 24px;
  flex-wrap: wrap;
}
.sell-page-title {
  font-family: 'Nunito', sans-serif;
  font-size: 26px;
  font-weight: 800;
  color: #1a1a1a;
  margin: 0;
}

/* Search box */
.sell-model-search {
  position: relative;
  min-width: 260px;
}
.sell-model-search input {
  width: 100%;
  padding: 10px 16px 10px 40px;
  border: 1.5px solid #e0e0e0;
  border-radius: 50px;
  font-size: 14px;
  font-family: 'Nunito Sans', sans-serif;
  outline: none;
  transition: border-color .2s;
  background: #fafafa;
}
.sell-model-search input:focus { border-color: #00c853; background:#fff; }
.sell-model-search svg {
  position: absolute;
  left: 13px;
  top: 50%;
  transform: translateY(-50%);
  color: #aaa;
}

/* Section label */
.sell-section-label {
  font-family: 'Nunito', sans-serif;
  font-size: 17px;
  font-weight: 800;
  color: #1a1a1a;
  margin-bottom: 16px;
}

/* Models Grid */
.sell-models-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
  gap: 16px;
}

.sell-model-card {
  background: #fff;
  border: 1.5px solid #ececec;
  border-radius: 14px;
  padding: 20px 14px 16px;
  text-align: center;
  cursor: pointer;
  transition: all .2s ease;
  text-decoration: none;
  display: block;
}
.sell-model-card:hover {
  border-color: #00c853;
  box-shadow: 0 6px 24px rgba(0,200,83,.13);
  transform: translateY(-3px);
}

.sell-model-img-wrap {
  height: 110px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 12px;
}
.sell-model-img-wrap img {
  max-height: 105px;
  max-width: 100%;
  object-fit: contain;
}
.sell-model-img-placeholder {
  width: 60px;
  height: 100px;
  background: linear-gradient(135deg, #f5f5f5, #ebebeb);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ccc;
  font-size: 26px;
}
.sell-model-name {
  font-family: 'Nunito Sans', sans-serif;
  font-size: 13px;
  font-weight: 700;
  color: #1a1a1a;
  line-height: 1.35;
}

/* Empty state */
.sell-empty {
  text-align: center;
  padding: 60px 20px;
  color: #aaa;
  font-size: 15px;
}

/* Mobile search bar below nav */
.ts-mobile-search { display: none; }
@media (max-width: 768px) {
  .ts-mobile-search {
    display: block;
    padding: 10px 16px;
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
  }
  .ts-mobile-search input {
    width: 100%;
    padding: 9px 14px 9px 36px;
    border: 1.5px solid #e8e8e8;
    border-radius: 50px;
    font-size: 14px;
    background: #f8f8f8;
    outline: none;
  }
  .ts-mobile-search-inner { position: relative; }
  .ts-mobile-search-inner svg { position:absolute; left:11px; top:50%; transform:translateY(-50%); }

  .sell-page-title { font-size: 20px; }
  .sell-model-search { display: none; }
  .sell-models-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; }
  .sell-model-card { padding: 14px 8px 12px; }
  .sell-model-img-wrap { height: 80px; }
  .sell-model-img-wrap img { max-height: 75px; }
  .sell-model-name { font-size: 11px; }
}
@media (max-width: 400px) {
  .sell-models-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
</head>
<body>

@include('sell.partials.navbar')

<div class="ts-mobile-search">
  <div class="ts-mobile-search-inner">
    <svg width="14" height="14" fill="none" stroke="#999" stroke-width="2" viewBox="0 0 24 24">
      <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
    </svg>
    <input type="text" id="mobileSearchInput" placeholder="Search {{ $brand->name }} models...">
  </div>
</div>

<div class="sell-page-wrap">

  {{-- Breadcrumb --}}
  <div class="sell-breadcrumb">
    <a href="{{ route('sell.index') }}">Home</a>
    <span class="sep">›</span>
    <a href="{{ route('sell.phone') }}">Sell Old Mobile Phone</a>
    <span class="sep">›</span>
    <span class="active">Sell Old {{ $brand->name }}</span>
  </div>

  {{-- Title + Search --}}
  <div class="sell-title-row">
    <h1 class="sell-page-title">Sell Old {{ $brand->name }} Mobile Phone</h1>
    <div class="sell-model-search">
      <svg width="15" height="15" fill="none" stroke="#aaa" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      <input type="text" id="desktopSearchInput" placeholder="Select Model">
    </div>
  </div>

  {{-- Models --}}
  <div class="sell-section-label">Select Model</div>

  @if($models->isEmpty())
    <div class="sell-empty">
      <div style="font-size:40px; margin-bottom:10px;">📱</div>
      No models found for {{ $brand->name }}.
    </div>
  @else
    <div class="sell-models-grid" id="modelsGrid">
      @foreach($models as $model)
      <a class="sell-model-card model-item"
         href="{{ route('sell.model.variants', [$brand->slug, $model->slug]) }}">
        <div class="sell-model-img-wrap">
          @if($model->image)
            <img src="{{ asset('storage/'.$model->image) }}" alt="{{ $model->name }}" loading="lazy">
          @else
            <div class="sell-model-img-placeholder">📱</div>
          @endif
        </div>
        <div class="sell-model-name">{{ $model->name }}</div>
      </a>
      @endforeach
    </div>
  @endif

</div>

<script src="{{ asset('js/main.js') }}"></script>
<script>
// Search filter — works on both desktop & mobile inputs
function filterModels(q) {
  q = q.toLowerCase();
  document.querySelectorAll('.model-item').forEach(card => {
    const name = card.querySelector('.sell-model-name').textContent.toLowerCase();
    card.style.display = name.includes(q) ? '' : 'none';
  });
}

const di = document.getElementById('desktopSearchInput');
const mi = document.getElementById('mobileSearchInput');
if (di) di.addEventListener('input', e => filterModels(e.target.value));
if (mi) mi.addEventListener('input', e => {
  filterModels(e.target.value);
  if (di) di.value = e.target.value;
});
</script>
</body>
</html>
