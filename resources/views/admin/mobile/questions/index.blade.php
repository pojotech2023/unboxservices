@extends('layouts.app')

@section('title', 'Mobile Questions')

@section('content')
<div class="container-fluid py-4">
    <div class="page-inner">

        {{-- Page Header --}}
        <div class="page-header" style="margin-top:40px">
            <h3 class="fw-bold mb-3">Mobile Questions</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Mobile Questions</a></li>
            </ul>
        </div>

        {{-- Info Card --}}
        <div class="card mb-4 shadow-sm border-0" style="background:linear-gradient(135deg,#1a1a2e,#16213e);">
            <div class="card-body d-flex align-items-center gap-3 text-white">
                <div style="background:rgba(255,255,255,0.1);border-radius:12px;padding:16px;">
                    <i class="fas fa-question-circle fa-2x"></i>
                </div>
                <div>
                    <h5 class="mb-1 fw-bold">Global Mobile Questions</h5>
                    <small class="opacity-75">இந்த questions எல்லா mobile brands, models, variants-க்கும் apply ஆகும்</small>
                    <div class="mt-1">
                        <span class="badge bg-info">{{ $questions->count() }} Questions</span>
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

        {{-- QUESTIONS CARD --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span class="fw-bold"><i class="fas fa-question-circle me-2"></i>Questions</span>
                <button type="button" class="btn btn-primary btn-sm" id="btnShowAddQuestion">
                    <i class="fas fa-plus me-1"></i> Add Questions
                </button>
            </div>

            {{-- ADD FORM --}}
            <div id="addQuestionsForm" style="display:none;">
                <div class="card-body border-bottom bg-light">
                    <form action="{{ route('mobile.questions.store') }}" method="POST">
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
                                    <form action="{{ route('mobile.questions.destroy', $q->id) }}"
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

<script>
document.addEventListener('DOMContentLoaded', function () {

    var questionUpdateBase = "{{ url('admin/mobile/questions') }}/QID/update";
    var questionIndex = 1;

    // Show/hide add form
    document.getElementById('btnShowAddQuestion').addEventListener('click', function () {
        document.getElementById('addQuestionsForm').style.display = 'block';
        this.style.display = 'none';
    });
    document.getElementById('btnHideAddQuestion').addEventListener('click', function () {
        document.getElementById('addQuestionsForm').style.display = 'none';
        document.getElementById('btnShowAddQuestion').style.display = '';
    });

    // Add more question row
    document.getElementById('btnAddMoreQuestion').addEventListener('click', function () {
        var container = document.getElementById('questionsContainer');
        var html = '<div class="question-row border rounded p-3 mb-3 bg-white position-relative">' +
            '<button type="button" class="btn btn-sm btn-outline-danger remove-question-row position-absolute" style="top:8px;right:8px;">' +
            '<i class="fas fa-times"></i></button>' +
            '<div class="row g-3">' +
            '<div class="col-md-6"><label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>' +
            '<input type="text" name="questions[' + questionIndex + '][question]" class="form-control" placeholder="e.g. Is the battery draining?" required></div>' +
            '<div class="col-md-6"><label class="form-label fw-semibold">Small Description</label>' +
            '<input type="text" name="questions[' + questionIndex + '][small_description]" class="form-control" placeholder="Optional hint"></div>' +
            '<div class="col-md-6"><label class="form-label fw-semibold text-success"><i class="fas fa-check-circle me-1"></i>Yes Answer <span class="text-danger">*</span></label>' +
            '<input type="text" name="questions[' + questionIndex + '][yes_answer]" class="form-control border-success" value="Yes" required></div>' +
            '<div class="col-md-6"><label class="form-label fw-semibold text-danger"><i class="fas fa-times-circle me-1"></i>No Answer <span class="text-danger">*</span></label>' +
            '<input type="text" name="questions[' + questionIndex + '][no_answer]" class="form-control border-danger" value="No" required></div>' +
            '</div></div>';
        container.insertAdjacentHTML('beforeend', html);
        questionIndex++;
        bindRemoveRows();
    });

    function bindRemoveRows() {
        document.querySelectorAll('.remove-question-row').forEach(function (btn) {
            btn.onclick = function () {
                var rows = document.querySelectorAll('.question-row');
                if (rows.length === 1) { alert('At least one question is required.'); return; }
                this.closest('.question-row').remove();
            };
        });
    }
    bindRemoveRows();

    // Edit question modal
    document.querySelectorAll('.btn-edit-question').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            document.getElementById('editQuestionForm').action = questionUpdateBase.replace('QID', id);
            document.getElementById('editQuestion').value  = this.getAttribute('data-question');
            document.getElementById('editSmallDesc').value = this.getAttribute('data-desc');
            document.getElementById('editYesAnswer').value = this.getAttribute('data-yes');
            document.getElementById('editNoAnswer').value  = this.getAttribute('data-no');
            new bootstrap.Modal(document.getElementById('editQuestionModal')).show();
        });
    });

});
</script>
@endsection
