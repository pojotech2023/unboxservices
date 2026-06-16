{{-- resources/views/admin/accessories/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Accessories')

@section('content')
<div class="container-fluid py-4">
  <div class="page-inner">

    {{-- Page Header --}}
    <div class="page-header" style="margin-top:40px">
      <h3 class="fw-bold mb-3">Accessories</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home">
          <a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Accessories</a></li>
      </ul>
    </div>

    {{-- Info Card --}}
    <div class="card mb-4 shadow-sm border-0" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
      <div class="card-body d-flex align-items-center gap-3 text-white">
        <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:16px;">
          <i class="fas fa-box-open fa-2x"></i>
        </div>
        <div>
          <h5 class="mb-1 fw-bold">Global Accessories</h5>
          <small class="opacity-75">இந்த accessories எல்லா mobile sell flow-க்கும் apply ஆகும்</small>
          <div class="mt-1">
            <span class="badge bg-info">{{ $accessories->count() }} Items</span>
          </div>
        </div>
      </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- ACCESSORIES CARD --}}
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <span class="fw-bold"><i class="fas fa-box-open me-2"></i>Accessory Items</span>
        <button type="button" class="btn btn-primary btn-sm" id="btnShowAddAcc">
          <i class="fas fa-plus me-1"></i> Add Accessories
        </button>
      </div>

      {{-- ADD FORM --}}
      <div id="addAccForm" style="display:none;">
        <div class="card-body border-bottom bg-light">
          <form action="{{ route('admin.accessories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="accItemsContainer">
              {{-- Row 0 (template) --}}
              <div class="acc-item-row border rounded p-3 mb-3 bg-white position-relative">
                <button type="button"
                        class="btn btn-sm btn-outline-danger remove-acc-row position-absolute"
                        style="top:8px;right:8px;">
                  <i class="fas fa-times"></i>
                </button>
                <div class="row g-3 align-items-end">
                  <div class="col-md-3">
                    <label class="form-label fw-semibold">Image <span class="text-danger">*</span></label>
                    <input type="file" name="items[0][image]" class="form-control acc-img-input"
                           accept="image/*" required onchange="previewAccImg(this, 'preview-0')">
                    <div class="mt-2" id="preview-0"></div>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                    <input type="text" name="items[0][description]" class="form-control"
                           placeholder="e.g. Original Charger of Device" required>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-semibold">Small Description</label>
                    <input type="text" name="items[0][small_description]" class="form-control"
                           placeholder="Optional sub-text shown below card">
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex gap-2 mt-2">
              <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddMoreAcc">
                <i class="fas fa-plus me-1"></i> Add More
              </button>
              <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-save me-1"></i> Save All
              </button>
              <button type="button" class="btn btn-secondary btn-sm" id="btnHideAddAcc">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- LIST --}}
      <div class="card-body p-0">
        @if($accessories->isEmpty())
        <div class="text-center py-5 text-muted">
          <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
          <p class="mb-0">No accessories added yet. Click "Add Accessories" to start.</p>
        </div>
        @else
        <div class="table-responsive">
          <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
              <tr>
                <th width="50">#</th>
                <th width="90">Image</th>
                <th>Description</th>
                <th>Small Description</th>
                <th width="130">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($accessories as $i => $acc)
              <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                  <img src="{{ asset('storage/' . $acc->image) }}"
                       alt="{{ $acc->description }}"
                       style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid #eee;">
                </td>
                <td class="fw-semibold">{{ $acc->description }}</td>
                <td class="text-muted small">{{ $acc->small_description ?? '—' }}</td>
                <td>
                  <button type="button" class="btn btn-warning btn-sm btn-edit-acc"
                          data-id="{{ $acc->id }}"
                          data-description="{{ addslashes($acc->description) }}"
                          data-small="{{ addslashes($acc->small_description ?? '') }}"
                          data-image="{{ asset('storage/' . $acc->image) }}">
                    <i class="fas fa-edit"></i>
                  </button>
                  <form action="{{ route('admin.accessories.destroy', $acc->id) }}"
                        method="POST" class="d-inline"
                        onsubmit="return confirm('Delete this accessory?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>
    </div>

  </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editAccModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editAccForm" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Accessory</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          {{-- Current image preview --}}
          <div class="mb-3 text-center">
            <img id="editCurrentImg" src="" alt="Current"
                 style="width:100px;height:100px;object-fit:cover;border-radius:10px;border:1px solid #eee;">
            <div class="text-muted small mt-1">Current Image</div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Replace Image</label>
            <input type="file" name="image" id="editAccImage" class="form-control"
                   accept="image/*" onchange="previewEditImg(this)">
            <div class="mt-2" id="editImgPreview"></div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
            <input type="text" name="description" id="editAccDesc" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Small Description</label>
            <input type="text" name="small_description" id="editAccSmall" class="form-control"
                   placeholder="Optional sub-text">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning fw-bold">
            <i class="fas fa-save me-1"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

  var accUpdateBase = "{{ url('admin/accessories') }}/AID";
  var accIndex = 1;

  // Show/hide add form
  document.getElementById('btnShowAddAcc').addEventListener('click', function () {
    document.getElementById('addAccForm').style.display = 'block';
    this.style.display = 'none';
  });
  document.getElementById('btnHideAddAcc').addEventListener('click', function () {
    document.getElementById('addAccForm').style.display = 'none';
    document.getElementById('btnShowAddAcc').style.display = '';
  });

  // Add more row
  document.getElementById('btnAddMoreAcc').addEventListener('click', function () {
    var idx = accIndex;
    var html = '<div class="acc-item-row border rounded p-3 mb-3 bg-white position-relative">' +
      '<button type="button" class="btn btn-sm btn-outline-danger remove-acc-row position-absolute" style="top:8px;right:8px;"><i class="fas fa-times"></i></button>' +
      '<div class="row g-3 align-items-end">' +
      '<div class="col-md-3"><label class="form-label fw-semibold">Image <span class="text-danger">*</span></label>' +
      '<input type="file" name="items[' + idx + '][image]" class="form-control acc-img-input" accept="image/*" required onchange="previewAccImg(this, \'preview-' + idx + '\')">' +
      '<div class="mt-2" id="preview-' + idx + '"></div></div>' +
      '<div class="col-md-4"><label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>' +
      '<input type="text" name="items[' + idx + '][description]" class="form-control" placeholder="e.g. Original Box with same IMEI" required></div>' +
      '<div class="col-md-4"><label class="form-label fw-semibold">Small Description</label>' +
      '<input type="text" name="items[' + idx + '][small_description]" class="form-control" placeholder="Optional sub-text"></div>' +
      '</div></div>';
    document.getElementById('accItemsContainer').insertAdjacentHTML('beforeend', html);
    accIndex++;
    bindRemoveRows();
  });

  function bindRemoveRows() {
    document.querySelectorAll('.remove-acc-row').forEach(function (btn) {
      btn.onclick = function () {
        var rows = document.querySelectorAll('.acc-item-row');
        if (rows.length === 1) { alert('At least one item is required.'); return; }
        this.closest('.acc-item-row').remove();
      };
    });
  }
  bindRemoveRows();

  // Edit modal
  document.querySelectorAll('.btn-edit-acc').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = this.getAttribute('data-id');
      document.getElementById('editAccForm').action = accUpdateBase.replace('AID', id);
      document.getElementById('editAccDesc').value  = this.getAttribute('data-description');
      document.getElementById('editAccSmall').value = this.getAttribute('data-small');
      document.getElementById('editCurrentImg').src = this.getAttribute('data-image');
      document.getElementById('editImgPreview').innerHTML = '';
      new bootstrap.Modal(document.getElementById('editAccModal')).show();
    });
  });

});

// Image preview helpers (global)
function previewAccImg(input, previewId) {
  var file = input.files[0];
  if (!file) return;
  var reader = new FileReader();
  reader.onload = function (e) {
    document.getElementById(previewId).innerHTML =
      '<img src="' + e.target.result + '" style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:1px solid #eee;">';
  };
  reader.readAsDataURL(file);
}

function previewEditImg(input) {
  var file = input.files[0];
  if (!file) return;
  var reader = new FileReader();
  reader.onload = function (e) {
    document.getElementById('editImgPreview').innerHTML =
      '<img src="' + e.target.result + '" style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:1px solid #eee;"><div class="text-muted small mt-1">New Image</div>';
  };
  reader.readAsDataURL(file);
}
</script>
@endsection
