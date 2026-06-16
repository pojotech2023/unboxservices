@extends('layouts.app')

@section('title', $defect->description . ' — Details')

@section('content')
<div class="container-fluid py-4">
    <div class="page-inner">

        {{-- Page Header --}}
        <div class="page-header" style="margin-top:40px">
            <h3 class="fw-bold mb-1">
                <span class="text-muted fw-normal" style="font-size:1rem;">Defect /</span>
                {{ $defect->description }}
            </h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('brands.models.variants.questions.index', $defect->variant_id) }}">Questions & Defects</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item active">{{ $defect->description }}</li>
            </ul>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- ══════════════════════════════════════════════════════ --}}
        {{--  SECTIONS CARD                                        --}}
        {{-- ══════════════════════════════════════════════════════ --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">
                    <i class="fas fa-layer-group me-2"></i>Sections for "{{ $defect->description }}"
                </span>
                <button type="button" class="btn btn-primary btn-sm" id="btnShowAddSection">
                    <i class="fas fa-plus me-1"></i> Add Section
                </button>
            </div>

            {{-- ── ADD SECTION FORM ─────────────────────────────────── --}}
            <div id="addSectionForm" style="display:none;">
                <div class="card-body border-bottom bg-light">
                    <form action="{{ route('brands.models.variants.defects.sections.store', $defect->id) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Section Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control"
                                       placeholder="e.g. Minor Scratches" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Section Description</label>
                                <input type="text" name="description" class="form-control"
                                       placeholder="e.g. Small surface scratches, barely visible">
                            </div>
                        </div>

                        {{-- Section Images --}}
                        <div class="fw-semibold mb-2"><i class="fas fa-images me-1"></i>Section Images</div>
                        <div id="sectionImagesContainer">
                            <div class="section-image-row border rounded p-3 mb-2 bg-white position-relative">
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger remove-section-image-row position-absolute"
                                        style="top:8px;right:8px;">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold small">
                                            <i class="fas fa-image me-1"></i>Image <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" name="images[0][image]"
                                               class="form-control form-control-sm section-img-input"
                                               accept="image/*" required>
                                        <div class="mt-2 section-img-preview" style="display:none;">
                                            <img src="" alt="preview"
                                                 style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold small">Description <span class="text-danger">*</span></label>
                                        <input type="text" name="images[0][description]" class="form-control form-control-sm"
                                               placeholder="e.g. Light hairline scratch" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnAddMoreSectionImage">
                                <i class="fas fa-plus me-1"></i> Add More Image
                            </button>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-save me-1"></i> Save Section
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" id="btnHideAddSection">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── SECTIONS LIST ────────────────────────────────────── --}}
            <div class="card-body p-3">
                @if($sections->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-layer-group fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">No sections added yet. Click "Add Section" to start.</p>
                </div>
                @else

                @foreach($sections as $section)
                <div class="card border mb-3 shadow-sm">
                    {{-- Section Header --}}
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <div>
                            <span class="fw-bold">{{ $section->title }}</span>
                            @if($section->description)
                            <span class="text-muted small ms-2">— {{ $section->description }}</span>
                            @endif
                        </div>
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-warning btn-sm btn-edit-section"
                                    data-id="{{ $section->id }}"
                                    data-title="{{ addslashes($section->title) }}"
                                    data-desc="{{ addslashes($section->description ?? '') }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <form action="{{ route('brands.models.variants.defects.sections.destroy', $section->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this section and all its images?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                            {{-- Add Image to existing section --}}
                            <button type="button" class="btn btn-outline-primary btn-sm btn-show-add-image"
                                    data-section-id="{{ $section->id }}">
                                <i class="fas fa-plus me-1"></i> Add Image
                            </button>
                        </div>
                    </div>

                    {{-- Inline Add Image Form (hidden per section) --}}
                    <div class="add-image-form bg-light border-bottom p-3" id="addImageForm-{{ $section->id }}" style="display:none;">
                        <form action="{{ route('brands.models.variants.defects.sections.images.store', $section->id) }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small">Image <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control form-control-sm inline-img-input"
                                           accept="image/*" required>
                                    <div class="mt-2 inline-img-preview" style="display:none;">
                                        <img src="" alt="preview"
                                             style="width:60px;height:60px;object-fit:cover;border-radius:6px;border:2px solid #dee2e6;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Description <span class="text-danger">*</span></label>
                                    <input type="text" name="description" class="form-control form-control-sm"
                                           placeholder="e.g. Deep gouge" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                        <i class="fas fa-save me-1"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Section Images Grid --}}
                    <div class="card-body">
                        @if($section->images->isEmpty())
                        <p class="text-muted small mb-0 text-center py-3">
                            <i class="fas fa-images me-1 opacity-50"></i> No images in this section yet.
                        </p>
                        @else
                        <div class="row g-3">
                            @foreach($section->images as $img)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="card border shadow-sm h-100 text-center">
                                    <div class="card-body p-2">
                                        <img src="{{ asset('storage/'.$img->image) }}"
                                             alt="{{ $img->description }}"
                                             class="img-fluid rounded mb-2"
                                             style="width:80px;height:80px;object-fit:cover;">
                                        <p class="mb-0 small fw-semibold text-truncate"
                                           title="{{ $img->description }}">
                                            {{ $img->description }}
                                        </p>
                                    </div>
                                    <div class="card-footer p-1 bg-transparent border-top">
                                        <button type="button" class="btn btn-warning btn-sm btn-edit-section-image"
                                                data-id="{{ $img->id }}"
                                                data-desc="{{ addslashes($img->description) }}"
                                                data-img="{{ asset('storage/'.$img->image) }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('brands.models.variants.defects.sections.images.destroy', $img->id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this image?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach

                @endif
            </div>
        </div>

    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- EDIT SECTION MODAL                                    --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editSectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editSectionForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Section</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="editSectionTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <input type="text" name="description" id="editSectionDesc" class="form-control"
                               placeholder="Optional description">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold">
                        <i class="fas fa-save me-1"></i> Update Section
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- EDIT SECTION IMAGE MODAL                              --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editSectionImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editSectionImageForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Image</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <img id="editSectionImagePreview" src="" alt="current"
                             style="width:110px;height:110px;object-fit:cover;border-radius:10px;border:2px solid #dee2e6;">
                        <p class="text-muted small mt-1 mb-0">Current Image</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Replace Image <span class="text-muted small">(optional)</span></label>
                        <input type="file" name="image" id="editSectionImageInput" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" id="editSectionImageDesc" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold">
                        <i class="fas fa-save me-1"></i> Update Image
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var sectionUpdateBase = "{{ url('/admin/mobile/defects/sections/SID/update') }}";
    var imgUpdateBase     = "{{ url('/admin/mobile/defects/sections/images/IID/update') }}";

    var sectionImgIndex = 1;

    // ── Add Section show/hide ─────────────────────────────────────
    document.getElementById('btnShowAddSection').addEventListener('click', function () {
        document.getElementById('addSectionForm').style.display = 'block';
        this.style.display = 'none';
    });
    document.getElementById('btnHideAddSection').addEventListener('click', function () {
        document.getElementById('addSectionForm').style.display = 'none';
        document.getElementById('btnShowAddSection').style.display = '';
    });

    // ── Add More Image row inside new section form ────────────────
    document.getElementById('btnAddMoreSectionImage').addEventListener('click', function () {
        var container = document.getElementById('sectionImagesContainer');
        var html = '<div class="section-image-row border rounded p-3 mb-2 bg-white position-relative">' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-section-image-row position-absolute" style="top:8px;right:8px;"><i class="fas fa-times"></i></button>' +
            '<div class="row g-3 align-items-center">' +
            '<div class="col-md-4"><label class="form-label fw-semibold small"><i class="fas fa-image me-1"></i>Image <span class="text-danger">*</span></label>' +
            '<input type="file" name="images[' + sectionImgIndex + '][image]" class="form-control form-control-sm section-img-input" accept="image/*" required>' +
            '<div class="mt-2 section-img-preview" style="display:none;"><img src="" alt="preview" style="width:70px;height:70px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;"></div></div>' +
            '<div class="col-md-8"><label class="form-label fw-semibold small">Description <span class="text-danger">*</span></label>' +
            '<input type="text" name="images[' + sectionImgIndex + '][description]" class="form-control form-control-sm" placeholder="e.g. Light hairline scratch" required></div>' +
            '</div></div>';
        container.insertAdjacentHTML('beforeend', html);
        sectionImgIndex++;
        bindRemoveSectionImageRows();
        bindSectionImagePreviews();
    });

    function bindRemoveSectionImageRows() {
        document.querySelectorAll('.remove-section-image-row').forEach(function (btn) {
            btn.onclick = function () {
                var rows = document.querySelectorAll('.section-image-row');
                if (rows.length === 1) { alert('At least one image is required.'); return; }
                this.closest('.section-image-row').remove();
            };
        });
    }
    bindRemoveSectionImageRows();

    function bindSectionImagePreviews() {
        document.querySelectorAll('.section-img-input').forEach(function (input) {
            if (input._bound) return;
            input._bound = true;
            input.addEventListener('change', function () {
                var preview = this.closest('.section-image-row').querySelector('.section-img-preview');
                var img     = preview.querySelector('img');
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) { img.src = e.target.result; preview.style.display = 'block'; };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    }
    bindSectionImagePreviews();

    // ── Inline Add Image toggle per section ───────────────────────
    document.querySelectorAll('.btn-show-add-image').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var sid  = this.getAttribute('data-section-id');
            var form = document.getElementById('addImageForm-' + sid);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    });

    // ── Inline Add Image preview ──────────────────────────────────
    document.querySelectorAll('.inline-img-input').forEach(function (input) {
        input.addEventListener('change', function () {
            var preview = this.closest('.add-image-form').querySelector('.inline-img-preview');
            var img     = preview.querySelector('img');
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) { img.src = e.target.result; preview.style.display = 'block'; };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // ── Edit Section Modal ────────────────────────────────────────
    document.querySelectorAll('.btn-edit-section').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id    = this.getAttribute('data-id');
            var title = this.getAttribute('data-title');
            var desc  = this.getAttribute('data-desc');
            document.getElementById('editSectionForm').action = sectionUpdateBase.replace('SID', id);
            document.getElementById('editSectionTitle').value = title;
            document.getElementById('editSectionDesc').value  = desc;
            new bootstrap.Modal(document.getElementById('editSectionModal')).show();
        });
    });

    // ── Edit Section Image Modal ──────────────────────────────────
    document.querySelectorAll('.btn-edit-section-image').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id   = this.getAttribute('data-id');
            var desc = this.getAttribute('data-desc');
            var img  = this.getAttribute('data-img');
            document.getElementById('editSectionImageForm').action          = imgUpdateBase.replace('IID', id);
            document.getElementById('editSectionImageDesc').value           = desc;
            document.getElementById('editSectionImagePreview').src          = img;
            document.getElementById('editSectionImageInput').value          = '';
            new bootstrap.Modal(document.getElementById('editSectionImageModal')).show();
        });
    });

    // ── Edit image preview in modal ───────────────────────────────
    document.getElementById('editSectionImageInput').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('editSectionImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

});
</script>
@endsection