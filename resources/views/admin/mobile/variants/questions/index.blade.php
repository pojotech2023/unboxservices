@extends('layouts.app')

@section('title', 'Variant Questions & Defects')

@section('content')
<div class="container-fluid py-4">
    <div class="page-inner">

        {{-- Page Header --}}
        <div class="page-header" style="margin-top:40px">
            <h3 class="fw-bold mb-3">{{ $variant->memory }} — Questions & Defects</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a>
                </li>
            </ul>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- ══════════════════════════════════════════════════════ --}}
        {{-- SECTION 1: QUESTIONS                                  --}}
        {{-- ══════════════════════════════════════════════════════ --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="fas fa-question-circle me-2"></i>Questions</span>
                <button type="button" class="btn btn-primary btn-sm" id="btnShowAddQuestion">
                    <i class="fas fa-plus me-1"></i> Add Questions
                </button>
            </div>

            {{-- ADD QUESTIONS FORM --}}
            <div id="addQuestionsForm" style="display:none;">
                <div class="card-body border-bottom bg-light">
                    <form action="{{ route('brands.models.variants.questions.store') }}"
                          method="POST">
                        @csrf
                        <div id="questionsContainer">
                            <div class="question-row border rounded p-3 mb-3 bg-white position-relative">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-question-row position-absolute"
                                        style="top:8px;right:8px;">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
                                        <input type="text" name="questions[0][question]" class="form-control"
                                               placeholder="e.g. Is the screen cracked?" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Small Description</label>
                                        <input type="text" name="questions[0][small_description]" class="form-control"
                                               placeholder="Optional hint or sub-text">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-success">
                                            <i class="fas fa-check-circle me-1"></i>Yes Answer <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="questions[0][yes_answer]" class="form-control border-success"
                                               value="Yes" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-danger">
                                            <i class="fas fa-times-circle me-1"></i>No Answer <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="questions[0][no_answer]" class="form-control border-danger"
                                               value="No" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddMoreQuestion">
                                <i class="fas fa-plus me-1"></i> Add More Question
                            </button>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-save me-1"></i> Save All Questions
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" id="btnHideAddQuestion">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- QUESTIONS LIST --}}
            <div class="card-body p-0">
                @if($questions->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-question-circle fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">No questions added yet. Click "Add Questions" to start.</p>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="40">#</th>
                                <th>Question</th>
                                <th>Description</th>
                                <th width="130" class="text-center">Yes Answer</th>
                                <th width="130" class="text-center">No Answer</th>
                                <th width="130">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $i => $q)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="fw-semibold">{{ $q->question }}</td>
                                <td class="text-muted small">{{ $q->small_description ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success px-2 py-1">{{ $q->yes_answer }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger px-2 py-1">{{ $q->no_answer }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-sm btn-edit-question"
                                            data-id="{{ $q->id }}"
                                            data-question="{{ addslashes($q->question) }}"
                                            data-desc="{{ addslashes($q->small_description ?? '') }}"
                                            data-yes="{{ addslashes($q->yes_answer) }}"
                                            data-no="{{ addslashes($q->no_answer) }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('brands.models.variants.questions.destroy', $q->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this question?')">
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

        {{-- ══════════════════════════════════════════════════════ --}}
        {{-- SECTION 2: SCREEN / BODY DEFECTS (Clickable Cards)   --}}
        {{-- ══════════════════════════════════════════════════════ --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="fas fa-mobile-alt me-2"></i>Select Screen / Body Defects</span>
                <button type="button" class="btn btn-primary btn-sm" id="btnShowAddDefect">
                    <i class="fas fa-plus me-1"></i> Add Defects
                </button>
            </div>

            {{-- ADD DEFECTS FORM --}}
            <div id="addDefectsForm" style="display:none;">
                <div class="card-body border-bottom bg-light">
                    <form action="{{ route('brands.models.variants.questions.defects.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="defectsContainer">
                            <div class="defect-row border rounded p-3 mb-3 bg-white position-relative">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-defect-row position-absolute"
                                        style="top:8px;right:8px;">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-image me-1"></i>Defect Image <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" name="defects[0][image]" class="form-control defect-image-input"
                                               accept="image/*" required>
                                        <div class="mt-2 defect-preview" style="display:none;">
                                            <img src="" alt="preview"
                                                 style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                        <input type="text" name="defects[0][description]" class="form-control"
                                               placeholder="e.g. Cracked screen, Scratches on back" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddMoreDefect">
                                <i class="fas fa-plus me-1"></i> Add More Defect
                            </button>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-save me-1"></i> Save All Defects
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" id="btnHideAddDefect">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- DEFECTS GRID — each card is clickable --}}
            <div class="card-body">
                @if($defects->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-mobile-alt fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">No defects added yet. Click "Add Defects" to start.</p>
                </div>
                @else
                <div class="row g-3">
                    @foreach($defects as $defect)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card border shadow-sm h-100 text-center defect-card"
                             style="cursor:pointer; transition: transform 0.15s, box-shadow 0.15s;"
                             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 6px 18px rgba(0,0,0,0.12)'"
                             onmouseout="this.style.transform='';this.style.boxShadow=''">

                            {{-- Clickable area → detail page --}}
                            <a href="{{ route('brands.models.variants.defects.show', $defect->id) }}"
                               class="text-decoration-none text-dark">
                                <div class="card-body p-2">
                                    <img src="{{ asset('storage/'.$defect->image) }}"
                                         alt="{{ $defect->description }}"
                                         class="img-fluid rounded mb-2"
                                         style="width:80px;height:80px;object-fit:cover;">
                                    <p class="mb-0 small fw-semibold text-truncate" title="{{ $defect->description }}">
                                        {{ $defect->description }}
                                    </p>
                                    <small class="text-primary">
                                        <i class="fas fa-arrow-right me-1"></i>View Sections
                                    </small>
                                </div>
                            </a>

                            {{-- Edit / Delete buttons (stop propagation) --}}
                            <div class="card-footer p-1 bg-transparent border-top">
                                <button type="button" class="btn btn-warning btn-sm btn-edit-defect"
                                        onclick="event.stopPropagation()"
                                        data-id="{{ $defect->id }}"
                                        data-desc="{{ addslashes($defect->description) }}"
                                        data-img="{{ asset('storage/'.$defect->image) }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('brands.models.variants.questions.defects.destroy', $defect->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this defect?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="event.stopPropagation()">
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

        {{-- ══════════════════════════════════════════════════════ --}}
        {{-- SECTION 3: FUNCTIONAL OR PHYSICAL PROBLEMS           --}}
        {{-- ══════════════════════════════════════════════════════ --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold">
                    <i class="fas fa-tools me-2"></i>Functional or Physical Problems
                </span>
                <button type="button" class="btn btn-primary btn-sm" id="btnShowAddProblem">
                    <i class="fas fa-plus me-1"></i> Add Problems
                </button>
            </div>

            {{-- ADD PROBLEMS FORM --}}
            <div id="addProblemsForm" style="display:none;">
                <div class="card-body border-bottom bg-light">
                    <form action="{{ route('brands.models.variants.problems.store') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="problemsContainer">
                            <div class="problem-row border rounded p-3 mb-3 bg-white position-relative">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-problem-row position-absolute"
                                        style="top:8px;right:8px;">
                                    <i class="fas fa-times"></i>
                                </button>
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-image me-1"></i>Problem Image <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" name="problems[0][image]"
                                               class="form-control problem-image-input"
                                               accept="image/*" required>
                                        <div class="mt-2 problem-preview" style="display:none;">
                                            <img src="" alt="preview"
                                                 style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                        <input type="text" name="problems[0][description]" class="form-control"
                                               placeholder="e.g. Battery draining fast, Speaker not working" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddMoreProblem">
                                <i class="fas fa-plus me-1"></i> Add More Problem
                            </button>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-save me-1"></i> Save All Problems
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm" id="btnHideAddProblem">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- PROBLEMS GRID --}}
            <div class="card-body">
                @if($problems->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-tools fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">No problems added yet. Click "Add Problems" to start.</p>
                </div>
                @else
                <div class="row g-3">
                    @foreach($problems as $problem)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card border shadow-sm h-100 text-center">
                            <div class="card-body p-2">
                                <img src="{{ asset('storage/'.$problem->image) }}"
                                     alt="{{ $problem->description }}"
                                     class="img-fluid rounded mb-2"
                                     style="width:80px;height:80px;object-fit:cover;">
                                <p class="mb-0 small fw-semibold text-truncate"
                                   title="{{ $problem->description }}">
                                    {{ $problem->description }}
                                </p>
                            </div>
                            <div class="card-footer p-1 bg-transparent border-top">
                                <button type="button" class="btn btn-warning btn-sm btn-edit-problem"
                                        data-id="{{ $problem->id }}"
                                        data-desc="{{ addslashes($problem->description) }}"
                                        data-img="{{ asset('storage/'.$problem->image) }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('brands.models.variants.problems.destroy', $problem->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this problem?')">
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

    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- EDIT QUESTION MODAL                                   --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editQuestionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editQuestionForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Question</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
                        <input type="text" name="question" id="editQuestion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Small Description</label>
                        <input type="text" name="small_description" id="editSmallDesc" class="form-control"
                               placeholder="Optional hint or sub-text">
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-success">
                                <i class="fas fa-check-circle me-1"></i>Yes Answer
                            </label>
                            <input type="text" name="yes_answer" id="editYesAnswer"
                                   class="form-control border-success" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-danger">
                                <i class="fas fa-times-circle me-1"></i>No Answer
                            </label>
                            <input type="text" name="no_answer" id="editNoAnswer"
                                   class="form-control border-danger" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold">
                        <i class="fas fa-save me-1"></i> Update Question
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- EDIT DEFECT MODAL                                     --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editDefectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editDefectForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Defect</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <img id="editDefectCurrentImg" src="" alt="current"
                             style="width:110px;height:110px;object-fit:cover;border-radius:10px;border:2px solid #dee2e6;">
                        <p class="text-muted small mt-1 mb-0">Current Image</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Replace Image <span class="text-muted small">(optional)</span></label>
                        <input type="file" name="image" id="editDefectImageInput" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" id="editDefectDesc" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold">
                        <i class="fas fa-save me-1"></i> Update Defect
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════ --}}
{{-- EDIT PROBLEM MODAL                                    --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="editProblemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editProblemForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Problem</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 text-center">
                        <img id="editProblemCurrentImg" src="" alt="current"
                             style="width:110px;height:110px;object-fit:cover;border-radius:10px;border:2px solid #dee2e6;">
                        <p class="text-muted small mt-1 mb-0">Current Image</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Replace Image <span class="text-muted small">(optional)</span></label>
                        <input type="file" name="image" id="editProblemImageInput" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                        <input type="text" name="description" id="editProblemDesc" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold">
                        <i class="fas fa-save me-1"></i> Update Problem
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container-fluid py-4">
  <div class="page-inner">

    

    {{-- Info Card --}}
    <div class="card mb-4 shadow-sm border-0" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
      <div class="card-body d-flex align-items-center gap-3 text-white">
        <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:16px;">
          <i class="fas fa-box-open fa-2x"></i>
        </div>
        <div>
          <h5 class="mb-1 fw-bold">Global Accessories</h5>
          <small class="opacity-75"></small>
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

    var questionUpdateBase = "{{ url('/admin/mobile/questions/QID/update') }}";
    var defectUpdateBase   = "{{ url('/admin/mobile/defects/DID/update') }}";
    var problemUpdateBase  = "{{ url('/admin/mobile/problems/PID/update') }}";

    var questionIndex = 1;
    var defectIndex   = 1;
    var problemIndex  = 1;

    // ══════════════════════════════════════════════════════════════
    //  QUESTIONS — show/hide / add-more / remove
    // ══════════════════════════════════════════════════════════════
    document.getElementById('btnShowAddQuestion').addEventListener('click', function () {
        document.getElementById('addQuestionsForm').style.display = 'block';
        this.style.display = 'none';
    });
    document.getElementById('btnHideAddQuestion').addEventListener('click', function () {
        document.getElementById('addQuestionsForm').style.display = 'none';
        document.getElementById('btnShowAddQuestion').style.display = '';
    });

    document.getElementById('btnAddMoreQuestion').addEventListener('click', function () {
        var container = document.getElementById('questionsContainer');
        var html = '<div class="question-row border rounded p-3 mb-3 bg-white position-relative">' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-question-row position-absolute" style="top:8px;right:8px;"><i class="fas fa-times"></i></button>' +
            '<div class="row g-3">' +
            '<div class="col-md-6"><label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>' +
            '<input type="text" name="questions[' + questionIndex + '][question]" class="form-control" placeholder="e.g. Is the battery draining fast?" required></div>' +
            '<div class="col-md-6"><label class="form-label fw-semibold">Small Description</label>' +
            '<input type="text" name="questions[' + questionIndex + '][small_description]" class="form-control" placeholder="Optional hint or sub-text"></div>' +
            '<div class="col-md-6"><label class="form-label fw-semibold text-success"><i class="fas fa-check-circle me-1"></i>Yes Answer <span class="text-danger">*</span></label>' +
            '<input type="text" name="questions[' + questionIndex + '][yes_answer]" class="form-control border-success" value="Yes" required></div>' +
            '<div class="col-md-6"><label class="form-label fw-semibold text-danger"><i class="fas fa-times-circle me-1"></i>No Answer <span class="text-danger">*</span></label>' +
            '<input type="text" name="questions[' + questionIndex + '][no_answer]" class="form-control border-danger" value="No" required></div>' +
            '</div></div>';
        container.insertAdjacentHTML('beforeend', html);
        questionIndex++;
        bindRemoveQuestionRows();
    });

    function bindRemoveQuestionRows() {
        document.querySelectorAll('.remove-question-row').forEach(function (btn) {
            btn.onclick = function () {
                if (document.querySelectorAll('.question-row').length === 1) {
                    alert('At least one question is required.'); return;
                }
                this.closest('.question-row').remove();
            };
        });
    }
    bindRemoveQuestionRows();

    // ══════════════════════════════════════════════════════════════
    //  DEFECTS — show/hide / add-more / remove / preview
    // ══════════════════════════════════════════════════════════════
    document.getElementById('btnShowAddDefect').addEventListener('click', function () {
        document.getElementById('addDefectsForm').style.display = 'block';
        this.style.display = 'none';
    });
    document.getElementById('btnHideAddDefect').addEventListener('click', function () {
        document.getElementById('addDefectsForm').style.display = 'none';
        document.getElementById('btnShowAddDefect').style.display = '';
    });

    document.getElementById('btnAddMoreDefect').addEventListener('click', function () {
        var container = document.getElementById('defectsContainer');
        var html = '<div class="defect-row border rounded p-3 mb-3 bg-white position-relative">' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-defect-row position-absolute" style="top:8px;right:8px;"><i class="fas fa-times"></i></button>' +
            '<div class="row g-3 align-items-center">' +
            '<div class="col-md-4"><label class="form-label fw-semibold"><i class="fas fa-image me-1"></i>Defect Image <span class="text-danger">*</span></label>' +
            '<input type="file" name="defects[' + defectIndex + '][image]" class="form-control defect-image-input" accept="image/*" required>' +
            '<div class="mt-2 defect-preview" style="display:none;"><img src="" alt="preview" style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;"></div></div>' +
            '<div class="col-md-8"><label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>' +
            '<input type="text" name="defects[' + defectIndex + '][description]" class="form-control" placeholder="e.g. Cracked screen" required></div>' +
            '</div></div>';
        container.insertAdjacentHTML('beforeend', html);
        defectIndex++;
        bindRemoveDefectRows();
        bindDefectImagePreviews();
    });

    function bindRemoveDefectRows() {
        document.querySelectorAll('.remove-defect-row').forEach(function (btn) {
            btn.onclick = function () {
                if (document.querySelectorAll('.defect-row').length === 1) {
                    alert('At least one defect is required.'); return;
                }
                this.closest('.defect-row').remove();
            };
        });
    }
    bindRemoveDefectRows();

    function bindDefectImagePreviews() {
        document.querySelectorAll('.defect-image-input').forEach(function (input) {
            if (input._previewBound) return;
            input._previewBound = true;
            input.addEventListener('change', function () {
                var preview = this.closest('.defect-row').querySelector('.defect-preview');
                var img     = preview.querySelector('img');
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) { img.src = e.target.result; preview.style.display = 'block'; };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    }
    bindDefectImagePreviews();

    // ══════════════════════════════════════════════════════════════
    //  PROBLEMS — show/hide / add-more / remove / preview
    // ══════════════════════════════════════════════════════════════
    document.getElementById('btnShowAddProblem').addEventListener('click', function () {
        document.getElementById('addProblemsForm').style.display = 'block';
        this.style.display = 'none';
    });
    document.getElementById('btnHideAddProblem').addEventListener('click', function () {
        document.getElementById('addProblemsForm').style.display = 'none';
        document.getElementById('btnShowAddProblem').style.display = '';
    });

    document.getElementById('btnAddMoreProblem').addEventListener('click', function () {
        var container = document.getElementById('problemsContainer');
        var html = '<div class="problem-row border rounded p-3 mb-3 bg-white position-relative">' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-problem-row position-absolute" style="top:8px;right:8px;"><i class="fas fa-times"></i></button>' +
            '<div class="row g-3 align-items-center">' +
            '<div class="col-md-4"><label class="form-label fw-semibold"><i class="fas fa-image me-1"></i>Problem Image <span class="text-danger">*</span></label>' +
            '<input type="file" name="problems[' + problemIndex + '][image]" class="form-control problem-image-input" accept="image/*" required>' +
            '<div class="mt-2 problem-preview" style="display:none;"><img src="" alt="preview" style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6;"></div></div>' +
            '<div class="col-md-8"><label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>' +
            '<input type="text" name="problems[' + problemIndex + '][description]" class="form-control" placeholder="e.g. Battery draining fast" required></div>' +
            '</div></div>';
        container.insertAdjacentHTML('beforeend', html);
        problemIndex++;
        bindRemoveProblemRows();
        bindProblemImagePreviews();
    });

    function bindRemoveProblemRows() {
        document.querySelectorAll('.remove-problem-row').forEach(function (btn) {
            btn.onclick = function () {
                if (document.querySelectorAll('.problem-row').length === 1) {
                    alert('At least one problem is required.'); return;
                }
                this.closest('.problem-row').remove();
            };
        });
    }
    bindRemoveProblemRows();

    function bindProblemImagePreviews() {
        document.querySelectorAll('.problem-image-input').forEach(function (input) {
            if (input._previewBound) return;
            input._previewBound = true;
            input.addEventListener('change', function () {
                var preview = this.closest('.problem-row').querySelector('.problem-preview');
                var img     = preview.querySelector('img');
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) { img.src = e.target.result; preview.style.display = 'block'; };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    }
    bindProblemImagePreviews();

    // ══════════════════════════════════════════════════════════════
    //  EDIT QUESTION MODAL
    // ══════════════════════════════════════════════════════════════
    document.querySelectorAll('.btn-edit-question').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('editQuestionForm').action = questionUpdateBase.replace('QID', this.dataset.id);
            document.getElementById('editQuestion').value  = this.dataset.question;
            document.getElementById('editSmallDesc').value = this.dataset.desc;
            document.getElementById('editYesAnswer').value = this.dataset.yes;
            document.getElementById('editNoAnswer').value  = this.dataset.no;
            new bootstrap.Modal(document.getElementById('editQuestionModal')).show();
        });
    });

    // ══════════════════════════════════════════════════════════════
    //  EDIT DEFECT MODAL
    // ══════════════════════════════════════════════════════════════
    document.querySelectorAll('.btn-edit-defect').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('editDefectForm').action          = defectUpdateBase.replace('DID', this.dataset.id);
            document.getElementById('editDefectDesc').value           = this.dataset.desc;
            document.getElementById('editDefectCurrentImg').src       = this.dataset.img;
            document.getElementById('editDefectImageInput').value     = '';
            new bootstrap.Modal(document.getElementById('editDefectModal')).show();
        });
    });

    document.getElementById('editDefectImageInput').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) { document.getElementById('editDefectCurrentImg').src = e.target.result; };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // ══════════════════════════════════════════════════════════════
    //  EDIT PROBLEM MODAL
    // ══════════════════════════════════════════════════════════════
    document.querySelectorAll('.btn-edit-problem').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('editProblemForm').action          = problemUpdateBase.replace('PID', this.dataset.id);
            document.getElementById('editProblemDesc').value           = this.dataset.desc;
            document.getElementById('editProblemCurrentImg').src       = this.dataset.img;
            document.getElementById('editProblemImageInput').value     = '';
            new bootstrap.Modal(document.getElementById('editProblemModal')).show();
        });
    });

    document.getElementById('editProblemImageInput').addEventListener('change', function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) { document.getElementById('editProblemCurrentImg').src = e.target.result; };
            reader.readAsDataURL(this.files[0]);
        }
    });

});

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