@extends('layouts.app')
@section('title', 'Laptop Questions')
@section('content')
<div class="container-fluid py-4">
  <div class="page-inner">

    <div class="page-header" style="margin-top:40px">
      <h3 class="fw-bold mb-3">Laptop Questions</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item"><a href="#">Laptop Questions</a></li>
      </ul>
    </div>

    <div class="card mb-4 shadow-sm border-0" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
      <div class="card-body d-flex align-items-center gap-3 text-white">
        <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:16px;">
          <i class="fas fa-laptop fa-2x"></i>
        </div>
        <div>
          <h5 class="mb-1 fw-bold">Laptop Evaluation Questions</h5>
          <small class="opacity-75">Manage questions for each evaluation step. Each question has options with image and deduction amount.</small>
          <div class="mt-1">
            <span class="badge bg-info">{{ $questions->count() }} Questions</span>
            <span class="badge bg-success ms-1">{{ $questions->sum(fn($q)=>$q->options->count()) }} Options</span>
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

    {{-- GROUP TABS --}}
    <ul class="nav nav-tabs mb-3" id="groupTabs">
      @foreach($groups as $key => $label)
      <li class="nav-item">
        <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                data-group="{{ $key }}" onclick="filterGroup('{{ $key }}', this)">
          {{ $label }}
          <span class="badge bg-secondary ms-1">{{ $questions->where('question_group',$key)->count() }}</span>
        </button>
      </li>
      @endforeach
    </ul>

    {{-- ADD QUESTION BUTTON --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
      <span class="text-muted small" id="groupLabel">Showing: {{ array_values($groups)[0] }}</span>
      <button class="btn btn-primary btn-sm" onclick="showAddForm()">
        <i class="fas fa-plus me-1"></i> Add Question
      </button>
    </div>

    {{-- ADD FORM --}}
    <div id="addQuestionForm" class="card mb-4 border-primary" style="display:none;">
      <div class="card-header bg-primary text-white fw-bold">Add New Question</div>
      <div class="card-body">
        <form action="{{ route('admin.laptop.questions.store') }}" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-5">
              <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
              <input type="text" name="question" class="form-control" placeholder="e.g. What is the screen size?" required>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-semibold">Small Description</label>
              <input type="text" name="small_description" class="form-control" placeholder="Optional hint text">
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Question Group <span class="text-danger">*</span></label>
              <select name="question_group" class="form-select" required id="addGroupSelect">
                @foreach($groups as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Input Type <span class="text-danger">*</span></label>
              <select name="input_type" class="form-select" required>
                <option value="radio">Radio (Single Select)</option>
                <option value="multi_select">Multi Select</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label fw-semibold">Sort Order</label>
              <input type="number" name="sort_order" class="form-control" value="0" min="0">
            </div>
          </div>
          <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save me-1"></i>Save Question</button>
            <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('addQuestionForm').style.display='none'">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    {{-- QUESTIONS LIST --}}
    @foreach($groups as $groupKey => $groupLabel)
    <div class="group-block" data-group="{{ $groupKey }}" style="{{ $loop->first ? '' : 'display:none;' }}">

      @php $groupQuestions = $questions->where('question_group', $groupKey); @endphp

      @if($groupQuestions->isEmpty())
      <div class="text-center py-5 text-muted">
        <i class="fas fa-question-circle fa-3x mb-3 opacity-25"></i>
        <p>No questions for "{{ $groupLabel }}" yet.</p>
      </div>
      @else
      @foreach($groupQuestions as $q)
      <div class="card mb-3 shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center"
             style="background:#f8f9fa">
          <div>
            <span class="badge {{ $q->is_active ? 'bg-success' : 'bg-secondary' }} me-2">
              {{ $q->is_active ? 'Active' : 'Inactive' }}
            </span>
            <span class="badge bg-info me-2">{{ $q->input_type === 'radio' ? 'Single' : 'Multi' }}</span>
            <strong>{{ $q->question }}</strong>
            @if($q->small_description)
            <small class="text-muted ms-2">— {{ $q->small_description }}</small>
            @endif
          </div>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-success btn-sm" onclick="showAddOption({{ $q->id }})">
              <i class="fas fa-plus"></i> Add Option
            </button>
            <button class="btn btn-warning btn-sm" onclick="openEditQuestion({{ $q->id }}, '{{ addslashes($q->question) }}', '{{ addslashes($q->small_description ?? '') }}', '{{ $q->question_group }}', '{{ $q->input_type }}', {{ $q->sort_order }}, {{ $q->is_active ? 'true' : 'false' }})">
              <i class="fas fa-edit"></i>
            </button>
            <form action="{{ route('admin.laptop.questions.destroy', $q->id) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this question and all its options?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
            </form>
          </div>
        </div>

        {{-- Options --}}
        <div class="card-body p-0">
          @if($q->options->isEmpty())
          <div class="text-center py-3 text-muted small">No options yet. Click "Add Option" to add.</div>
          @else
          <div class="table-responsive">
            <table class="table table-sm table-hover mb-0 align-middle">
              <thead class="table-light">
                <tr>
                  <th width="80">Image</th>
                  <th>Label</th>
                  <th width="120" class="text-center">Deduction (₹)</th>
                  <th width="80" class="text-center">Order</th>
                  <th width="120">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($q->options as $opt)
                <tr>
                  <td class="text-center">
                    @if($opt->option_image)
                      <img src="{{ asset('storage/'.$opt->option_image) }}"
                           alt="{{ $opt->label }}"
                           style="width:50px;height:40px;object-fit:contain;border-radius:6px;border:1px solid #eee;background:#f8f9fa;padding:3px;">
                    @elseif($opt->icon_emoji)
                      <span style="font-size:24px;">{{ $opt->icon_emoji }}</span>
                    @else
                      <span class="text-muted small">No image</span>
                    @endif
                  </td>
                  <td class="fw-semibold">{{ $opt->label }}</td>
                  <td class="text-center">
                    @if($opt->deduction > 0)
                    <span class="badge bg-danger">-₹{{ number_format($opt->deduction) }}</span>
                    @else
                    <span class="badge bg-success">No deduction</span>
                    @endif
                  </td>
                  <td class="text-center text-muted">{{ $opt->sort_order }}</td>
                  <td>
                    <button class="btn btn-warning btn-sm"
                            onclick="openEditOption({{ $opt->id }}, '{{ addslashes($opt->label) }}', '{{ $opt->icon_emoji }}', {{ $opt->deduction }}, {{ $opt->sort_order }}, '{{ $opt->option_image ? asset('storage/'.$opt->option_image) : '' }}')">
                      <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.laptop.questions.options.destroy', $opt->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this option?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif

          {{-- Add option inline form — NOW WITH IMAGE UPLOAD --}}
          <div id="addOptForm-{{ $q->id }}" style="display:none;" class="p-3 bg-light border-top">
            <form action="{{ route('admin.laptop.questions.options.store', $q->id) }}"
                  method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row g-2 align-items-end">
                <div class="col-md-4">
                  <label class="form-label fw-semibold small">Label <span class="text-danger">*</span></label>
                  <input type="text" name="label" class="form-control form-control-sm"
                         placeholder="e.g. Keyboard not working" required>
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold small">
                    Option Image
                    <span class="text-muted">(PNG/JPG, max 2MB)</span>
                  </label>
                  <input type="file" name="option_image" class="form-control form-control-sm"
                         accept="image/*" onchange="previewAddImage(this, {{ $q->id }})">
                  <div id="addPreview-{{ $q->id }}" class="mt-1" style="display:none;">
                    <img id="addPreviewImg-{{ $q->id }}" src="" alt="preview"
                         style="height:50px;border-radius:6px;border:1px solid #ddd;object-fit:contain;background:#fff;padding:2px;">
                  </div>
                </div>
                <div class="col-md-2">
                  <label class="form-label fw-semibold small">Deduction ₹</label>
                  <input type="number" name="deduction" class="form-control form-control-sm" value="0" min="0">
                </div>
                <div class="col-md-1">
                  <label class="form-label fw-semibold small">Order</label>
                  <input type="number" name="sort_order" class="form-control form-control-sm"
                         value="{{ $q->options->count() }}">
                </div>
                <div class="col-md-2">
                  <button type="submit" class="btn btn-success btn-sm w-100">
                    <i class="fas fa-save me-1"></i>Save
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach
      @endif
    </div>
    @endforeach

  </div>
</div>

{{-- EDIT QUESTION MODAL --}}
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
            <input type="text" name="question" id="eq_question" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Small Description</label>
            <input type="text" name="small_description" id="eq_desc" class="form-control">
          </div>
          <div class="row g-3">
            <div class="col-6">
              <label class="form-label fw-semibold">Question Group</label>
              <select name="question_group" id="eq_group" class="form-select">
                @foreach($groups as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Input Type</label>
              <select name="input_type" id="eq_input" class="form-select">
                <option value="radio">Radio (Single)</option>
                <option value="multi_select">Multi Select</option>
              </select>
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Sort Order</label>
              <input type="number" name="sort_order" id="eq_order" class="form-control" min="0">
            </div>
            <div class="col-6">
              <label class="form-label fw-semibold">Status</label>
              <select name="is_active" id="eq_active" class="form-select">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning fw-bold"><i class="fas fa-save me-1"></i>Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- EDIT OPTION MODAL — WITH IMAGE UPLOAD --}}
<div class="modal fade" id="editOptionModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editOptionForm" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title"><i class="fas fa-image me-2"></i>Edit Option</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Label <span class="text-danger">*</span></label>
            <input type="text" name="label" id="eo_label" class="form-control" required>
          </div>

          {{-- Current image display --}}
          <div class="mb-3" id="eo_current_img_wrap">
            <label class="form-label fw-semibold">Current Image</label>
            <div class="d-flex align-items-center gap-3">
              <img id="eo_current_img" src="" alt="current"
                   style="height:60px;max-width:100px;object-fit:contain;border-radius:8px;border:1px solid #dee2e6;padding:4px;background:#f8f9fa;">
              <div class="form-check">
                <input type="checkbox" name="remove_image" value="1" class="form-check-input" id="eo_remove_img">
                <label class="form-check-label text-danger small fw-semibold" for="eo_remove_img">Remove image</label>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Upload New Image
              <span class="text-muted fw-normal">(PNG/JPG, max 2MB — replaces existing)</span>
            </label>
            <input type="file" name="option_image" id="eo_image_file" class="form-control"
                   accept="image/*" onchange="previewEditImage(this)">
            <div id="eo_new_preview" class="mt-2" style="display:none;">
              <img id="eo_new_preview_img" src="" alt="new preview"
                   style="height:60px;border-radius:8px;border:1px solid #dee2e6;object-fit:contain;padding:4px;background:#f8f9fa;">
              <span class="text-success small ms-2 fw-semibold">New image selected</span>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-4">
              <label class="form-label fw-semibold">Deduction ₹</label>
              <input type="number" name="deduction" id="eo_deduction" class="form-control" min="0">
            </div>
            <div class="col-4">
              <label class="form-label fw-semibold">Sort Order</label>
              <input type="number" name="sort_order" id="eo_order" class="form-control" min="0">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-warning fw-bold"><i class="fas fa-save me-1"></i>Update Option</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
const QB = "{{ url('admin/laptop/questions') }}";
const OB = "{{ url('admin/laptop/questions/options') }}";
const GROUPS = @json($groups);

// Group filter tabs
function filterGroup(key, btn) {
    document.querySelectorAll('.group-block').forEach(b => b.style.display = 'none');
    document.querySelector('.group-block[data-group="' + key + '"]').style.display = 'block';
    document.querySelectorAll('#groupTabs .nav-link').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('groupLabel').textContent = 'Showing: ' + GROUPS[key];
    document.getElementById('addGroupSelect').value = key;
}

// Show add form
function showAddForm() {
    const form = document.getElementById('addQuestionForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Show add option inline form
function showAddOption(qId) {
    const form = document.getElementById('addOptForm-' + qId);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Preview image in add form
function previewAddImage(input, qId) {
    const wrap = document.getElementById('addPreview-' + qId);
    const img  = document.getElementById('addPreviewImg-' + qId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; wrap.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    } else {
        wrap.style.display = 'none';
    }
}

// Preview image in edit modal
function previewEditImage(input) {
    const wrap = document.getElementById('eo_new_preview');
    const img  = document.getElementById('eo_new_preview_img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; wrap.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    } else {
        wrap.style.display = 'none';
    }
}

// Edit question modal
function openEditQuestion(id, question, desc, group, inputType, sortOrder, isActive) {
    document.getElementById('editQuestionForm').action = QB + '/' + id;
    document.getElementById('eq_question').value = question;
    document.getElementById('eq_desc').value = desc;
    document.getElementById('eq_group').value = group;
    document.getElementById('eq_input').value = inputType;
    document.getElementById('eq_order').value = sortOrder;
    document.getElementById('eq_active').value = isActive ? '1' : '0';
    new bootstrap.Modal(document.getElementById('editQuestionModal')).show();
}

// Edit option modal
function openEditOption(id, label, icon, deduction, sortOrder, imageUrl) {
    document.getElementById('editOptionForm').action = OB + '/' + id;
    document.getElementById('eo_label').value = label;
    document.getElementById('eo_deduction').value = deduction;
    document.getElementById('eo_order').value = sortOrder;

    // Reset file input & previews
    document.getElementById('eo_image_file').value = '';
    document.getElementById('eo_new_preview').style.display = 'none';
    document.getElementById('eo_remove_img').checked = false;

    // Show current image if exists
    const wrap = document.getElementById('eo_current_img_wrap');
    const img  = document.getElementById('eo_current_img');
    if (imageUrl) {
        img.src = imageUrl;
        wrap.style.display = 'block';
    } else {
        wrap.style.display = 'none';
    }

    new bootstrap.Modal(document.getElementById('editOptionModal')).show();
}
</script>
@endsection