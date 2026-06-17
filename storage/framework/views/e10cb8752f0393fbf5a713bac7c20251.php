<?php $__env->startSection('title', 'Indikator Kinerja'); ?>
<?php $__env->startSection('page-title', 'Kelola Indikator Kinerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Daftar Indikator Kinerja</h5>
        <p class="text-muted mb-0" style="font-size:12px"><?php echo e($indikator->total()); ?> indikator ditemukan</p>
    </div>
    <?php if(auth()->user()->canInput()): ?>
    <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i>Tambah Indikator
        </button>
        <a href="<?php echo e(route('indikator.export.excel')); ?>" class="btn btn-outline-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i>Excel
        </a>
        <a href="<?php echo e(route('indikator.export.pdf')); ?>" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-file-earmark-pdf me-1"></i>PDF
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form class="d-flex gap-2 flex-wrap align-items-center">
            <input type="text" name="search" class="form-control form-control-sm" style="width:220px"
                   placeholder="Cari kode / nama..." value="<?php echo e(request('search')); ?>">
            <select name="kategori_id" class="form-select form-select-sm" style="width:180px">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($kat->id); ?>" <?php echo e(request('kategori_id')==$kat->id?'selected':''); ?>><?php echo e($kat->nama_kategori); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="status" class="form-select form-select-sm" style="width:140px">
                <option value="">Semua Status</option>
                <option value="aktif" <?php echo e(request('status')=='aktif'?'selected':''); ?>>Aktif</option>
                <option value="nonaktif" <?php echo e(request('status')=='nonaktif'?'selected':''); ?>>Nonaktif</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            <a href="<?php echo e(route('indikator.index')); ?>" class="btn btn-outline-secondary btn-sm">Reset</a>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Kode</th>
                        <th>Nama Indikator</th>
                        <th>Kategori</th>
                        <th>Target</th>
                        <th>Satuan</th>
                        <th>Bobot</th>
                        <th>Status</th>
                        <?php if(auth()->user()->canInput()): ?>
                        <th class="text-center">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $indikator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3">
                            <span class="badge" style="background:#EFF6FF;color:#1D4ED8;font-size:11px"><?php echo e($item->kode_indikator); ?></span>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:500"><?php echo e($item->nama_indikator); ?></div>
                            <?php if($item->formula_penilaian): ?>
                            <small class="text-muted"><?php echo e(Str::limit($item->formula_penilaian, 50)); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><span style="font-size:12px"><?php echo e($item->kategori->nama_kategori); ?></span></td>
                        <td style="font-size:13px"><?php echo e(number_format($item->target, 2)); ?></td>
                        <td style="font-size:12px"><?php echo e($item->satuan); ?></td>
                        <td style="font-size:13px;font-weight:600"><?php echo e($item->bobot); ?></td>
                        <td>
                            <?php if($item->status === 'aktif'): ?>
                                <span class="badge bg-success" style="font-size:10px">Aktif</span>
                            <?php else: ?>
                                <span class="badge bg-secondary" style="font-size:10px">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <?php if(auth()->user()->canInput()): ?>
                        <td class="text-center">
                            <a href="<?php echo e(route('indikator.edit', $item)); ?>" class="btn btn-sm btn-outline-primary py-0 px-2">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="<?php echo e(route('indikator.destroy', $item)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada data indikator.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($indikator->hasPages()): ?>
    <div class="card-footer bg-transparent border-0">
        <?php echo e($indikator->links()); ?>

    </div>
    <?php endif; ?>
</div>

<!-- Modal Tambah -->
<?php if(auth()->user()->canInput()): ?>
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?php echo e(route('indikator.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h6 class="modal-title fw-semibold">Tambah Indikator Kinerja</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold" style="font-size:12px">Kode Indikator *</label>
                            <input type="text" name="kode_indikator" class="form-control form-control-sm" placeholder="IK-AK-01" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold" style="font-size:12px">Nama Indikator *</label>
                            <input type="text" name="nama_indikator" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:12px">Kategori *</label>
                            <select name="kategori_id" class="form-select form-select-sm" required>
                                <option value="">-- Pilih --</option>
                                <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($kat->id); ?>"><?php echo e($kat->nama_kategori); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="font-size:12px">Target *</label>
                            <input type="number" name="target" step="0.01" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="font-size:12px">Satuan *</label>
                            <input type="text" name="satuan" class="form-control form-control-sm" placeholder="%, Orang, ..." required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="font-size:12px">Bobot *</label>
                            <input type="number" name="bobot" step="0.01" class="form-control form-control-sm" value="1.00" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold" style="font-size:12px">Status *</label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold" style="font-size:12px">Formula Penilaian</label>
                            <textarea name="formula_penilaian" class="form-control form-control-sm" rows="2"
                                      placeholder="Contoh: (Realisasi / Target) x 100"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maria\bpm-full\resources\views/indikator/index.blade.php ENDPATH**/ ?>