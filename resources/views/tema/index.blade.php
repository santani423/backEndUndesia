<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Tema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f5f6fa; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .table th { font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; color: #6c757d; }
        .badge-color { display: inline-block; width: 18px; height: 18px; border-radius: 4px; border: 1px solid #dee2e6; vertical-align: middle; }
        .asset-row { background: #f8f9fa; border-radius: 8px; padding: 12px; margin-bottom: 10px; }
        .size-row { background: #fff; border-radius: 6px; padding: 5px 8px; margin-bottom: 3px; }
        .size-header { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: #adb5bd; }
        #size-list-0, [id^="size-list-"] { max-height: 320px; overflow-y: auto; border: 1px solid #e9ecef; border-radius: 8px; padding: 6px; background: #f8f9fa; }
        .color-row { background: #f8f9fa; border-radius: 8px; padding: 10px; margin-bottom: 8px; }
        .section-title { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #6c757d; margin-bottom: 8px; }
        .btn-remove { padding: 2px 7px; font-size: .75rem; }
        #toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .asset-preview { max-height: 100px; max-width: 180px; border-radius: 6px; border: 1px solid #dee2e6; object-fit: contain; background: #f8f9fa; }
        .asset-preview-placeholder { width: 80px; height: 80px; border: 2px dashed #dee2e6; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #adb5bd; font-size: 1.5rem; background: #f8f9fa; }
    </style>
</head>
<body>

<div id="toast-container"></div>

<div class="container-fluid py-4 px-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-0 fw-bold">Manajemen Tema</h4>
            <small class="text-muted">Kelola tema, aset, ukuran, dan warna</small>
        </div>
        <button class="btn btn-primary" onclick="openCreateModal()">
            <i class="bi bi-plus-lg me-1"></i> Tambah Tema
        </button>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="temaTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Aset</th>
                            <th>Warna</th>
                            <th class="pe-4 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="temaBody">
                        <tr><td colspan="6" class="text-center py-4 text-muted">Memuat data…</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL FORM ===== --}}
<div class="modal fade" id="temaModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title mb-0" id="modalTitle">Tambah Tema</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="temaForm" novalidate>
                    <input type="hidden" id="editCode">

                    {{-- Info dasar --}}
                    <div class="card mb-4">
                        <div class="card-header fw-semibold py-2 bg-light">Informasi Tema</div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Kode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fCode" placeholder="Contoh: TEMA1" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fName" placeholder="Nama tema" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Aset --}}
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between py-2 bg-light">
                            <span class="fw-semibold">Aset</span>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addAsset()">
                                <i class="bi bi-plus"></i> Tambah Aset
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="assetList">
                                <p class="text-muted small mb-0">Belum ada aset. Klik "Tambah Aset".</p>
                            </div>
                        </div>
                    </div>

                    {{-- Warna --}}
                    <div class="card mb-2">
                        <div class="card-header d-flex align-items-center justify-content-between py-2 bg-light">
                            <span class="fw-semibold">Warna Tema</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addColor()">
                                <i class="bi bi-plus"></i> Tambah Warna
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="colorList">
                                <p class="text-muted small mb-0">Belum ada warna. Klik "Tambah Warna".</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary px-4" onclick="submitForm()" id="btnSubmit">
                    <span id="btnText">Simpan</span>
                    <span id="btnSpinner" class="spinner-border spinner-border-sm ms-1 d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL DUPLIKAT TEMA ===== --}}
<div class="modal fade" id="duplicateModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-copy me-2"></i>Duplikat Tema</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">
                    Salin semua data dari tema <strong id="dupSourceName"></strong> ke tema baru.
                    Isi kode dan nama untuk tema baru.
                </p>
                <div class="mb-3">
                    <label class="form-label" for="dupCode">Kode Tema Baru <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="dupCode" placeholder="Contoh: TEMA2">
                </div>
                <div class="mb-1">
                    <label class="form-label" for="dupName">Nama Tema Baru <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="dupName" placeholder="Nama tema baru">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success px-4" onclick="confirmDuplicate()" id="btnDuplicate">
                    <span id="btnDupText">Duplikat</span>
                    <span id="btnDupSpinner" class="spinner-border spinner-border-sm ms-1 d-none"></span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus Tema</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus tema <strong id="deleteTemaNama"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()" id="btnDelete">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const API = '/api';
let breakpoints  = [];
let sizeTemas    = [];
let deleteCode   = null;
let assetIdx     = 0;
let colorIdx     = 0;
let sizeCounters = {};

// ── Init ───────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
    await Promise.all([loadBreakpoints(), loadSizeTemas()]);
    loadTemas();
});

async function loadBreakpoints() {
    try {
        const r = await fetch(`${API}/brackPoin`);
        if (!r.ok) return;
        const d = await r.json();
        const raw = d.data ?? d;
        breakpoints = Array.isArray(raw) ? raw : [];
    } catch (e) {
        console.error('Gagal load breakpoints:', e);
    }
}

async function loadSizeTemas() {
    try {
        const r = await fetch(`${API}/size`);
        const d = await r.json();
        const raw = d.data ?? d;
        sizeTemas = Array.isArray(raw) ? raw : [];
    } catch (e) {
        console.error('Gagal load size temas:', e);
    }
}


async function loadTemas() {
    const tbody = document.getElementById('temaBody');
    tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">Memuat…</td></tr>';
    try {
        const r = await fetch(`${API}/tema`);
        const d = await r.json();
        const list = d.data ?? [];
        if (!list.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-muted">Belum ada tema.</td></tr>';
            return;
        }
        tbody.innerHTML = list.map((t, i) => `
            <tr>
                <td class="ps-4 text-muted">${i + 1}</td>
                <td><span class="badge bg-secondary">${t.code}</span></td>
                <td class="fw-medium">${t.name ?? '-'}</td>
                <td><span class="badge bg-light text-dark border">${(t.assets ?? []).length} aset</span></td>
                <td>
                    ${(t.theme_colors ?? []).slice(0,4).map(c =>
                        `<span class="badge-color me-1" style="background:${c.value}" title="${c.key}: ${c.value}"></span>`
                    ).join('')}
                    ${(t.theme_colors ?? []).length > 4 ? `<small class="text-muted">+${t.theme_colors.length - 4}</small>` : ''}
                </td>
                <td class="pe-4 text-end">
                    <button class="btn btn-sm btn-outline-success me-1" title="Duplikat Tema" onclick="openDuplicateModal('${t.code}','${t.name}')">
                        <i class="bi bi-copy"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary me-1" onclick='openEditModal(${JSON.stringify(t)})'>
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="openDeleteModal('${t.code}','${t.name}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    } catch (e) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4 text-danger">Gagal memuat data.</td></tr>';
    }
}

// ── Modal Buat / Edit ──────────────────────────────────────────────────────────
async function openCreateModal() {
    // Preload master data agar dropdown siap saat user klik "Tambah Ukuran"
    if (!breakpoints.length) await loadBreakpoints();
    if (!sizeTemas.length)   await loadSizeTemas();

    document.getElementById('modalTitle').textContent = 'Tambah Tema';
    document.getElementById('btnText').textContent    = 'Simpan';
    document.getElementById('editCode').value  = '';
    document.getElementById('fCode').value     = '';
    document.getElementById('fCode').disabled  = false;
    document.getElementById('fName').value     = '';
    document.getElementById('assetList').innerHTML = '<p class="text-muted small mb-0">Belum ada aset. Klik "Tambah Aset".</p>';
    document.getElementById('colorList').innerHTML = '<p class="text-muted small mb-0">Belum ada warna. Klik "Tambah Warna".</p>';
    assetIdx = 0; colorIdx = 0; sizeCounters = {};
    new bootstrap.Modal(document.getElementById('temaModal')).show();
}

async function openEditModal(tema) {
    document.getElementById('modalTitle').textContent = 'Edit Tema';
    document.getElementById('btnText').textContent    = 'Update';
    document.getElementById('editCode').value  = tema.code;
    document.getElementById('fCode').value     = tema.code;
    document.getElementById('fCode').disabled  = true;
    document.getElementById('fName').value     = tema.name ?? '';

    assetIdx = 0; colorIdx = 0; sizeCounters = {};
    const assetList = document.getElementById('assetList');
    const colorList = document.getElementById('colorList');
    assetList.innerHTML = '<p class="text-muted small">Memuat aset…</p>';
    colorList.innerHTML = '';

    // Pastikan master data tersedia sebelum render
    if (!breakpoints.length) await loadBreakpoints();
    if (!sizeTemas.length)   await loadSizeTemas();

    assetList.innerHTML = '';
    for (const asset of (tema.assets ?? [])) {
        await addAsset(asset);
    }
    (tema.theme_colors ?? []).forEach(color => addColor(color));

    if (!assetList.querySelector('.asset-row'))
        assetList.innerHTML = '<p class="text-muted small mb-0">Belum ada aset. Klik "Tambah Aset".</p>';
    if (!colorList.querySelector('.color-row'))
        colorList.innerHTML = '<p class="text-muted small mb-0">Belum ada warna. Klik "Tambah Warna".</p>';

    new bootstrap.Modal(document.getElementById('temaModal')).show();
}

// ── Asset ──────────────────────────────────────────────────────────────────────
async function addAsset(data = null) {
    if (!breakpoints.length) await loadBreakpoints();
    if (!sizeTemas.length)   await loadSizeTemas();

    const idx = assetIdx++;
    sizeCounters[idx] = 0;
    const list = document.getElementById('assetList');
    list.querySelector('p.text-muted')?.remove();

    const div = document.createElement('div');
    div.className = 'asset-row';
    div.id = `asset-${idx}`;
    div.innerHTML = `
        <input type="hidden" class="asset-id" value="${data?.id ?? ''}">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="section-title">Aset #${idx + 1}</span>
            <button type="button" class="btn btn-outline-danger btn-remove" onclick="removeAsset(${idx})">
                <i class="bi bi-x"></i>
            </button>
        </div>
        <div class="row g-2 mb-2">
            <div class="col-md-4">
                <label class="form-label small">Nama</label>
                <input type="text" class="form-control form-control-sm asset-name" value="${data?.name ?? ''}" placeholder="background">
            </div>
            <div class="col-md-5">
                <label class="form-label small">Path / URL</label>
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control form-control-sm asset-path" value="${data?.src ?? data?.path ?? ''}"
                        placeholder="/images/bg.jpg" oninput="previewFromUrl(${idx}, this.value)">
                    <label class="btn btn-outline-secondary btn-sm mb-0" for="file-asset-${idx}" title="Upload Gambar" style="cursor:pointer">
                        <i class="bi bi-upload"></i>
                    </label>
                </div>
                <input type="file" id="file-asset-${idx}" accept="image/*" class="d-none" onchange="handleAssetUpload(${idx}, this)">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Tipe</label>
                <input type="text" class="form-control form-control-sm asset-type" value="${data?.type ?? ''}" placeholder="image">
            </div>
        </div>
        <div class="mb-2" id="preview-wrap-${idx}">
            <label class="form-label small d-block">Preview</label>
            ${(data?.src ?? data?.path) ? `<img src="${data?.src ?? data?.path}" class="asset-preview" id="asset-preview-${idx}" alt="preview">` : `<div class="asset-preview-placeholder" id="asset-preview-${idx}"><i class="bi bi-image"></i></div>`}
        </div>
        <div id="size-list-${idx}"></div>
    `;
    list.appendChild(div);

    // Normalise ke format { device, size_tema_id } yang dimengerti buildSizeGrid
    let xMedia = [];
    if (data?.xMedia?.length) {
        // Format dari endpoint show: { device, size, py }
        xMedia = data.xMedia;
    } else if (data?.asset_sizes?.length) {
        // Format relasi langsung: { breack_poin_id, size_tema_id, breakpoint:{code}, size_tema:{...} }
        xMedia = data.asset_sizes.map(s => ({
            device:      s.breakpoint?.code ?? '',
            size_tema_id: s.size_tema_id,
        }));
    } else if (data?.assetSizes?.length) {
        // Format dari endpoint index dengan eager load
        xMedia = data.assetSizes.map(s => ({
            device:      s.breakpoint?.code ?? '',
            size_tema_id: s.size_tema_id,
        }));
    }
    await buildSizeGrid(idx, xMedia);
}

function setPreviewEl(idx, src) {
    const wrap = document.getElementById(`preview-wrap-${idx}`);
    if (!wrap) return;
    let el = document.getElementById(`asset-preview-${idx}`);
    if (src) {
        if (!el || el.tagName !== 'IMG') {
            const img = document.createElement('img');
            img.className = 'asset-preview';
            img.id = `asset-preview-${idx}`;
            img.alt = 'preview';
            if (el) el.replaceWith(img);
            el = img;
        }
        el.src = src;
        el.onerror = () => { el.src = ''; el.alt = 'Gambar tidak dapat dimuat'; };
    } else {
        if (!el || el.tagName === 'IMG') {
            const ph = document.createElement('div');
            ph.className = 'asset-preview-placeholder';
            ph.id = `asset-preview-${idx}`;
            ph.innerHTML = '<i class="bi bi-image"></i>';
            if (el) el.replaceWith(ph);
        }
    }
}

function previewFromUrl(idx, url) {
    setPreviewEl(idx, url.trim() || null);
}

async function handleAssetUpload(idx, input) {
    const file = input.files[0];
    if (!file) return;
    input.value = '';

    // Preview lokal segera
    const reader = new FileReader();
    reader.onload = e => setPreviewEl(idx, e.target.result);
    reader.readAsDataURL(file);

    // Tampilkan loading pada tombol upload
    const label = document.querySelector(`label[for="file-asset-${idx}"]`);
    if (label) { label.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'; label.style.pointerEvents = 'none'; }

    const temaNama = document.getElementById('fCode')?.value.trim()
                   || document.getElementById('fName')?.value.trim()
                   || 'default';

    const formData = new FormData();
    formData.append('file', file);
    formData.append('tema_name', temaNama);

    try {
        const r = await fetch(`${API}/upload-asset`, { method: 'POST', body: formData });
        const d = await r.json().catch(() => ({}));

        if (!r.ok) {
            const msg = d.message ?? (d.errors ? Object.values(d.errors).flat().join(' ') : `Error ${r.status}`);
            showToast('Upload gagal: ' + msg, 'danger');
            return;
        }

        const url = d.url ?? d.path ?? d.data?.url ?? d.data?.path ?? '';
        if (url) {
            const pathInput = document.getElementById(`asset-${idx}`)?.querySelector('.asset-path');
            if (pathInput) { pathInput.value = d.path; setPreviewEl(idx, url); }
            showToast('Gambar berhasil diupload.', 'success');
        } else {
            showToast('Upload sukses tapi URL tidak ditemukan dalam response.', 'warning');
        }
    } catch (e) {
        showToast('Upload gagal: ' + (e.message ?? 'kesalahan jaringan'), 'danger');
    } finally {
        if (label) { label.innerHTML = '<i class="bi bi-upload"></i>'; label.style.pointerEvents = ''; }
    }
}

function removeAsset(idx) {
    const el = document.getElementById(`asset-${idx}`);
    if (el) el.remove();
    checkEmptyAssets();
}

function checkEmptyAssets() {
    const list = document.getElementById('assetList');
    if (!list.querySelector('.asset-row')) {
        list.innerHTML = '<p class="text-muted small mb-0">Belum ada aset. Klik "Tambah Aset".</p>';
    }
}

// ── Sizes ─────────────────────────────────────────────────────────────────────
const SIZE_TYPES = ['top', 'bottom', 'right', 'left', 'w'];

// Render grid ukuran: satu baris per kombinasi Breakpoint × Type
// existing: array xMedia [ { device, size, size_tema_id } ]
async function buildSizeGrid(aIdx, existing = []) {
    if (!breakpoints.length) await loadBreakpoints();
    if (!sizeTemas.length)   await loadSizeTemas();

    const listEl = document.getElementById(`size-list-${aIdx}`);
    if (!listEl) return;
    listEl.innerHTML = '';
    sizeCounters[aIdx] = 0;

    // Header kolom
    const hdr = document.createElement('div');
    hdr.className = 'd-flex align-items-center gap-2 size-header px-1 mb-1';
    hdr.innerHTML = `
        <span style="min-width:80px">Breakpoint</span>
        <span style="min-width:70px">Tipe</span>
        <span style="flex:1">Ukuran</span>
    `;
    listEl.appendChild(hdr);

    for (const bp of breakpoints) {
        for (const type of SIZE_TYPES) {
            const sIdx = sizeCounters[aIdx];
            sizeCounters[aIdx] = sIdx + 1;

            // Cari data existing untuk kombinasi breakpoint + type ini
            let selectedId = '';
            for (const e of existing) {
                if (e.device !== bp.code) continue;
                // Cek via size_tema_id
                if (e.size_tema_id) {
                    const st = sizeTemas.find(s => s.id == e.size_tema_id);
                    if (st?.type === type) { selectedId = e.size_tema_id; break; }
                }
                // Cek via value string (dari xMedia show API)
                if (e.size) {
                    const st = sizeTemas.find(s => s.type === type && s.value === e.size);
                    if (st) { selectedId = st.id; break; }
                }
            }

            // Options hanya untuk type ini, urutkan by no
            const opts = sizeTemas
                .filter(s => s.type === type)
                .sort((a, b) => (a.no ?? 0) - (b.no ?? 0))
                .map(s => `<option value="${s.id}" ${selectedId == s.id ? 'selected' : ''}>${s.value}</option>`)
                .join('');

            const div = document.createElement('div');
            div.className = 'size-row d-flex gap-2 align-items-center';
            div.id = `size-${aIdx}-${sIdx}`;
            div.setAttribute('data-bp', bp.code);
            div.setAttribute('data-type', type);
            div.innerHTML = `
                <input type="hidden" class="size-bp" value="${bp.code}">
                <input type="hidden" class="size-type" value="${type}">
                <span class="badge bg-secondary" style="min-width:80px;font-size:.72rem">${bp.code}${bp.sekala ? '<br><small class=\'fw-normal\'>' + bp.sekala + '</small>' : ''}</span>
                <span class="badge bg-light text-dark border" style="min-width:70px;font-size:.72rem">${type}</span>
                <div style="flex:1">
                    <select class="form-select form-select-sm size-st">
                        <option value="">— pilih —</option>
                        ${opts}
                    </select>
                </div>
            `;
            listEl.appendChild(div);
        }
    }
}

function removeSize(id) {
    const el = document.getElementById(`size-${id}`);
    if (el) el.remove();
}

// ── Colors ────────────────────────────────────────────────────────────────────
function addColor(data = null) {
    const idx  = colorIdx++;
    const list = document.getElementById('colorList');
    const ph   = list.querySelector('p.text-muted');
    if (ph) ph.remove();

    const div = document.createElement('div');
    div.className = 'color-row';
    div.id = `color-${idx}`;
    div.innerHTML = `
        <input type="hidden" class="color-id" value="${data?.id ?? ''}">
        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label small">Key</label>
                <input type="text" class="form-control form-control-sm color-key" value="${data?.key ?? ''}" placeholder="primary">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Value</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text p-1">
                        <input type="color" class="color-picker border-0" style="width:22px;height:22px;cursor:pointer;background:none"
                            value="${data?.value ?? '#000000'}" oninput="syncColor(${idx}, this.value)">
                    </span>
                    <input type="text" class="form-control form-control-sm color-value" value="${data?.value ?? ''}"
                        placeholder="#FFFFFF" oninput="syncPicker(${idx}, this.value)">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Label</label>
                <input type="text" class="form-control form-control-sm color-label" value="${data?.label ?? ''}" placeholder="Warna Utama">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Group</label>
                <input type="text" class="form-control form-control-sm color-group" value="${data?.group ?? ''}" placeholder="base">
            </div>
            <div class="col-md-2 text-end">
                <button type="button" class="btn btn-outline-danger btn-remove" onclick="removeColor(${idx})">
                    <i class="bi bi-x"></i> Hapus
                </button>
            </div>
        </div>
    `;
    list.appendChild(div);
}

function removeColor(idx) {
    const el = document.getElementById(`color-${idx}`);
    if (el) el.remove();
    const list = document.getElementById('colorList');
    if (!list.querySelector('.color-row')) {
        list.innerHTML = '<p class="text-muted small mb-0">Belum ada warna. Klik "Tambah Warna".</p>';
    }
}

function syncColor(idx, val) {
    const row = document.getElementById(`color-${idx}`);
    if (row) row.querySelector('.color-value').value = val;
}

function syncPicker(idx, val) {
    const row = document.getElementById(`color-${idx}`);
    if (row && /^#[0-9a-fA-F]{6}$/.test(val)) row.querySelector('.color-picker').value = val;
}

// ── Collect Form Data ─────────────────────────────────────────────────────────
function collectPayload() {
    const assets = [];
    document.querySelectorAll('.asset-row').forEach(row => {
        const assetIdxAttr = row.id.replace('asset-', '');
        const sizes = [];
        row.querySelectorAll(`#size-list-${assetIdxAttr} .size-row`).forEach(sRow => {
            const bp = sRow.querySelector('.size-bp').value;
            const st = sRow.querySelector('.size-st').value;
            if (bp && st) sizes.push({ breakpoint_code: bp, size_tema_id: parseInt(st) });
            // baris tanpa size dipilih diabaikan
        });
        const asset = {
            name:  row.querySelector('.asset-name').value,
            path:  row.querySelector('.asset-path').value,
            type:  row.querySelector('.asset-type').value,
            sizes,
        };
        const id = row.querySelector('.asset-id').value;
        if (id) asset.id = parseInt(id);
        assets.push(asset);
    });

    const theme_colors = [];
    document.querySelectorAll('.color-row').forEach(row => {
        const color = {
            key:   row.querySelector('.color-key').value,
            value: row.querySelector('.color-value').value,
            label: row.querySelector('.color-label').value,
            group: row.querySelector('.color-group').value,
        };
        const id = row.querySelector('.color-id').value;
        if (id) color.id = parseInt(id);
        theme_colors.push(color);
    });

    return {
        code:   document.getElementById('fCode').value.trim(),
        name:   document.getElementById('fName').value.trim(),
        assets,
        theme_colors,
    };
}

// ── Submit ────────────────────────────────────────────────────────────────────
async function submitForm() {
    const code    = document.getElementById('fCode').value.trim();
    const name    = document.getElementById('fName').value.trim();
    const editCode = document.getElementById('editCode').value;

    if (!name || (!editCode && !code)) {
        showToast('Kode dan Nama wajib diisi.', 'danger');
        return;
    }

    const payload = collectPayload();
    const isEdit  = !!editCode;
    const url     = isEdit ? `${API}/tema/${editCode}/full` : `${API}/tema`;
    const method  = isEdit ? 'PUT' : 'POST';

    setBtnLoading(true);
    try {
        const r = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(payload),
        });
        const d = await r.json();
        if (!r.ok) {
            const errMsg = d.message ?? JSON.stringify(d.errors ?? d);
            showToast(errMsg, 'danger');
            return;
        }
        bootstrap.Modal.getInstance(document.getElementById('temaModal')).hide();
        showToast(d.message ?? 'Berhasil!', 'success');
        loadTemas();
    } catch {
        showToast('Terjadi kesalahan jaringan.', 'danger');
    } finally {
        setBtnLoading(false);
    }
}

function setBtnLoading(state) {
    document.getElementById('btnSubmit').disabled   = state;
    document.getElementById('btnSpinner').classList.toggle('d-none', !state);
}

// ── Delete ─────────────────────────────────────────────────────────────────────
function openDeleteModal(code, name) {
    deleteCode = code;
    document.getElementById('deleteTemaNama').textContent = name ?? code;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

async function confirmDelete() {
    if (!deleteCode) return;
    document.getElementById('btnDelete').disabled = true;
    try {
        const r = await fetch(`${API}/tema/${deleteCode}`, { method: 'DELETE', headers: { 'Accept': 'application/json' } });
        if (r.ok || r.status === 204) {
            bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
            showToast('Tema berhasil dihapus.', 'success');
            loadTemas();
        } else {
            const d = await r.json();
            showToast(d.message ?? 'Gagal menghapus.', 'danger');
        }
    } catch {
        showToast('Terjadi kesalahan jaringan.', 'danger');
    } finally {
        document.getElementById('btnDelete').disabled = false;
        deleteCode = null;
    }
}

// ── Duplicate ─────────────────────────────────────────────────────────────────
let duplicateSourceCode = null;

function openDuplicateModal(code, name) {
    duplicateSourceCode = code;
    document.getElementById('dupSourceName').textContent = name ?? code;
    document.getElementById('dupCode').value = '';
    document.getElementById('dupName').value = '';
    new bootstrap.Modal(document.getElementById('duplicateModal')).show();
}

async function confirmDuplicate() {
    const code = document.getElementById('dupCode').value.trim();
    const name = document.getElementById('dupName').value.trim();
    if (!code || !name) {
        showToast('Kode dan Nama wajib diisi.', 'danger');
        return;
    }

    const btn = document.getElementById('btnDuplicate');
    const spinner = document.getElementById('btnDupSpinner');
    const btnText = document.getElementById('btnDupText');
    btn.disabled = true;
    spinner.classList.remove('d-none');
    btnText.textContent = 'Menduplikat…';

    try {
        const r = await fetch(`${API}/tema/${duplicateSourceCode}/duplicate`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ code, name }),
        });
        const d = await r.json();
        if (!r.ok) {
            showToast(d.message ?? JSON.stringify(d.errors ?? d), 'danger');
            return;
        }
        bootstrap.Modal.getInstance(document.getElementById('duplicateModal')).hide();
        showToast(d.message ?? 'Tema berhasil diduplikat!', 'success');
        loadTemas();
    } catch {
        showToast('Terjadi kesalahan jaringan.', 'danger');
    } finally {
        btn.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'Duplikat';
        duplicateSourceCode = null;
    }
}

// ── Toast ─────────────────────────────────────────────────────────────────────
function showToast(msg, type = 'success') {
    const el = document.createElement('div');
    el.className = `toast align-items-center text-bg-${type} border-0 show mb-2`;
    el.role = 'alert';
    el.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${msg}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>`;
    document.getElementById('toast-container').appendChild(el);
    setTimeout(() => el.remove(), 4000);
}
</script>
</body>
</html>
