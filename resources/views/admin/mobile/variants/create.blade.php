@extends('layouts.app')

@section('title', 'Add Variants')

@section('content')
<div class="container-fluid py-4">
 <div class="page-inner">
        <div class="page-header" style="margin-top:40px">
            <h3 class="fw-bold mb-3">{{ $model->name }} Variants</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('brands.index') }}">Mobile Brand</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="{{ route('brands.models', $brand->id) }}">{{ $brand->name }} Models</a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item">
                    <a href="#">{{ $model->name }} Variants</a>
                </li>
            </ul>
        </div>

    {{-- Model Info Card --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex align-items-center gap-3">
            @if($model->image)
                <img src="{{ asset('storage/'.$model->image) }}" width="80" height="80"
                     style="object-fit:cover; border-radius:8px;">
            @endif
            <div>
                <h5 class="mb-0 fw-bold">{{ $model->name }}</h5>
                <small class="text-muted">Brand: {{ $brand->name }}</small>
            </div>
        </div>
    </div>

    {{-- Add Variant Card --}}
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <span class="fw-bold">Add Memory Variants</span>
        </div>
        <div class="card-body">

            <form action="{{ route('brands.models.variants.store', [$brand->id, $model->id]) }}"
                  method="POST" id="variantForm">
                @csrf

                {{-- Memory Input Section --}}
                <div class="mb-4 p-3 border rounded">
                    <h6 class="fw-bold mb-3">🧩 Memory Attribute</h6>
                   <label class="form-label text-muted small">
    Type memory value and press <strong>Enter</strong> or <strong>,</strong> to add
</label>

                    {{-- Tag Container --}}
                    <div class="border rounded p-2 d-flex flex-wrap gap-2 align-items-center"
                         id="tagContainer"
                         style="min-height:48px; cursor:text; background:#fff;"
                         onclick="document.getElementById('memoryInput').focus()">

                        <input type="text"
                               id="memoryInput"
                              placeholder="e.g. 8GB, 16GB, 32GB... (press Enter to add)"
                               style="border:none; outline:none; min-width:220px; flex-grow:1;"
                               autocomplete="off">
                    </div>
                    <small class="text-muted mt-1 d-block">Example: 8GB, 16GB, 32GB, 64GB</small>
                </div>

                {{-- Auto Generated Variants Table --}}
                <div id="variantsTableWrapper" style="display:none;">
                    <h6 class="fw-bold mb-3">Variant Price & Stock</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th width="200">Memory</th>
                                    <th>Price (₹)</th>
                                    <th width="80">Remove</th>
                                </tr>
                            </thead>
                            <tbody id="variantsTableBody"></tbody>
                        </table>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save"></i> Submit
                    </button>
                    <a href="{{ route('brands.models.variants', [$brand->id, $model->id]) }}"
                       class="btn btn-secondary px-4 ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ✅ INLINE SCRIPT - @push பயன்படுத்தல -- jQuery conflict இல்லாம் --}}
<script>
(function() {
    // DOM ready
    document.addEventListener('DOMContentLoaded', function() {

        var input        = document.getElementById('memoryInput');
        var container    = document.getElementById('tagContainer');
        var tableBody    = document.getElementById('variantsTableBody');
        var tableWrapper = document.getElementById('variantsTableWrapper');
        var form         = document.getElementById('variantForm');
        var tags         = [];

        // ✅ KEY FIX: Enter key - form submit தடுக்கிறோம்
        input.addEventListener('keydown', function(e) {

            if (e.key === 'Enter') {
                e.preventDefault();  // ← FORM SUBMIT ஆகாம தடுக்கிறோம்
                e.stopPropagation();
                processInput();
                return false;
            }

            if (e.key === ',') {
                e.preventDefault();
                processInput();
                return false;
            }

            // Backspace - last tag delete
            if (e.key === 'Backspace' && input.value === '' && tags.length > 0) {
                removeTag(tags[tags.length - 1]);
            }
        });

        function processInput() {
            var value = input.value.trim().replace(/,/g, '').toUpperCase();
            // GB இல்லன்னா auto add பண்ணு (optional)
            if (value !== '') {
                if (!tags.includes(value)) {
                    addTag(value);
                } else {
                    // Already exists - shake effect
                    input.style.color = 'red';
                    setTimeout(function() { input.style.color = ''; }, 500);
                }
                input.value = '';
            }
        }

        function addTag(value) {
            tags.push(value);

            // ── Badge உருவாக்கு ──
            var span = document.createElement('span');
            span.className = 'badge bg-success d-inline-flex align-items-center gap-1 px-3 py-2';
            span.style.fontSize = '13px';
            span.setAttribute('data-value', value);
            span.innerHTML = value +
                '<button type="button" onclick="window._removeTag(\'' + value + '\')" ' +
                'style="background:none;border:none;color:#fff;font-size:18px;line-height:1;' +
                'padding:0 0 0 6px;cursor:pointer;">&times;</button>';

            container.insertBefore(span, input);

            // ── Table Row உருவாக்கு ──
            addTableRow(value);
            reIndexRows();
            showTable();
        }

        window._removeTag = function(value) {
            // Badge remove
            var badge = container.querySelector('[data-value="' + value + '"]');
            if (badge) badge.remove();

            // Row remove
            var row = tableBody.querySelector('[data-memory="' + value + '"]');
            if (row) row.remove();

            // Tags array update
            tags = tags.filter(function(t) { return t !== value; });

            reIndexRows();
            showTable();
        };

        function addTableRow(memory) {
            var tr = document.createElement('tr');
            tr.setAttribute('data-memory', memory);
            tr.innerHTML =
                '<td>' +
                    '<span class="badge bg-dark px-3 py-2" style="font-size:14px;">' + memory + '</span>' +
                    '<input type="hidden" name="variants[0][memory]" value="' + memory + '">' +
                '</td>' +
                '<td>' +
                    '<div class="input-group">' +
                        '<span class="input-group-text">₹</span>' +
                        '<input type="number" name="variants[0][price]" ' +
                               'class="form-control" placeholder="0.00" ' +
                               'min="0" step="0.01" required>' +
                    '</div>' +
                '</td>' +
                //'<td>' +
                //     '<input type="number" name="variants[0][stock]" ' +
                //            'class="form-control" placeholder="0" ' +
                //            'min="0" value="0" required>' +
                // '</td>' +
                '<td class="text-center">' +
                    '<button type="button" class="btn btn-danger btn-sm" ' +
                            'onclick="window._removeTag(\'' + memory + '\')">' +
                        '<i class="fas fa-trash"></i>' +
                    '</button>' +
                '</td>';
            tableBody.appendChild(tr);
        }

        function reIndexRows() {
            var rows = tableBody.querySelectorAll('tr');
            rows.forEach(function(row, i) {
                var mInput = row.querySelector('input[type="hidden"]');
                var pInput = row.querySelector('input[name*="price"]');
               
                if (mInput) mInput.name = 'variants[' + i + '][memory]';
                if (pInput) pInput.name = 'variants[' + i + '][price]';
               
            });
        }

        function showTable() {
            tableWrapper.style.display = tags.length > 0 ? 'block' : 'none';
        }

        // Form submit validation
        form.addEventListener('submit', function(e) {
            if (tags.length === 0) {
                e.preventDefault();
                alert('Please add at least one memory variant (Example: 8GB)');
                input.focus();
            }
        });

    });
})();
</script>
@endsection