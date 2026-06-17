<?php $__env->startSection('title', 'Input Realisasi'); ?>
<?php $__env->startSection('page-title', 'Input Realisasi Kinerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Input Realisasi Kinerja</h5>
        <p class="text-muted mb-0" style="font-size:12px">Triwulan <?php echo e($triwulan); ?> &middot; Tahun <?php echo e($tahun); ?></p>
    </div>
</div>

<div class="alert alert-info py-2 mb-3" style="font-size:13px">
    <i class="bi bi-info-circle-fill me-2"></i>
    Input realisasi per indikator untuk periode Triwulan <?php echo e($triwulan); ?> Tahun <?php echo e($tahun); ?>.
    Setelah disimpan, data akan dikirim untuk verifikasi.
</div>

<!-- Filter Periode -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 align-items-center flex-wrap">
            <label style="font-size:12px;font-weight:600;margin-bottom:0">Periode:</label>
            <select name="triwulan" class="form-select form-select-sm" style="width:auto">
                <?php for($i=1;$i<=4;$i++): ?>
                    <option value="<?php echo e($i); ?>" <?php echo e($i==$triwulan?'selected':''); ?>>TW<?php echo e($i); ?></option>
                <?php endfor; ?>
            </select>
            <select name="tahun" class="form-select form-select-sm" style="width:auto">
                <?php for($y=2023;$y<=now()->year+1;$y++): ?>
                    <option value="<?php echo e($y); ?>" <?php echo e($y==$tahun?'selected':''); ?>><?php echo e($y); ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
        </form>
    </div>
</div>

<!-- Input Form -->
<div class="card">
    <div class="card-body p-0">
        <form action="<?php echo e(route('realisasi.store')); ?>" method="POST" id="formBulk">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="triwulan" value="<?php echo e($triwulan); ?>">
            <input type="hidden" name="tahun" value="<?php echo e($tahun); ?>">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width:110px">Kode</th>
                            <th>Nama Indikator</th>
                            <th>Kategori</th>
                            <th style="width:100px">Target</th>
                            <th>Satuan</th>
                            <th style="width:130px">Realisasi *</th>
                            <th style="width:80px">%</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $indikator; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-3">
                                <span class="badge" style="background:#EFF6FF;color:#1D4ED8;font-size:10px"><?php echo e($item->kode_indikator); ?></span>
                            </td>
                            <td style="font-size:13px"><?php echo e($item->nama_indikator); ?></td>
                            <td style="font-size:12px;color:#64748B"><?php echo e($item->kategori->nama_kategori); ?></td>
                            <td style="font-size:13px;font-weight:600"><?php echo e(number_format($item->target, 2)); ?></td>
                            <td style="font-size:12px"><?php echo e($item->satuan); ?></td>
                            <td>
                                <input type="number"
                                       name="items[<?php echo e($item->id); ?>][realisasi]"
                                       step="0.01" min="0"
                                       class="form-control form-control-sm realisasi-input"
                                       data-target="<?php echo e($item->target); ?>"
                                       data-row="<?php echo e($item->id); ?>"
                                       value="<?php echo e($existing[$item->id] ?? ''); ?>"
                                       placeholder="0">
                                <input type="hidden" name="items[<?php echo e($item->id); ?>][indikator_id]" value="<?php echo e($item->id); ?>">
                            </td>
                            <td>
                                <span class="pct-display fw-semibold" id="pct-<?php echo e($item->id); ?>" style="font-size:13px">
                                    <?php if(isset($existing[$item->id]) && $item->target > 0): ?>
                                        <?php echo e(number_format(($existing[$item->id] / $item->target) * 100, 1)); ?>%
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </span>
                            </td>
                            <td>
                                <input type="text" name="items[<?php echo e($item->id); ?>][keterangan]"
                                       class="form-control form-control-sm"
                                       placeholder="Opsional..." style="font-size:12px">
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada indikator aktif.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3 d-flex justify-content-between align-items-center border-top">
                <small class="text-muted">* Isi hanya indikator yang memiliki realisasi periode ini</small>
                <div class="d-flex gap-2">
                    <button type="submit" name="action" value="draft" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-floppy me-1"></i>Simpan Draft
                    </button>
                    <button type="submit" name="action" value="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-send me-1"></i>Kirim untuk Verifikasi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Hitung persentase otomatis
document.querySelectorAll('.realisasi-input').forEach(input => {
    input.addEventListener('input', function() {
        const target = parseFloat(this.dataset.target) || 0;
        const realisasi = parseFloat(this.value) || 0;
        const pctEl = document.getElementById('pct-' + this.dataset.row);
        if (target > 0 && realisasi > 0) {
            const pct = (realisasi / target * 100).toFixed(1);
            pctEl.textContent = pct + '%';
            pctEl.className = 'pct-display fw-semibold';
            if (pct >= 100) pctEl.style.color = '#10B981';
            else if (pct >= 75) pctEl.style.color = '#F59E0B';
            else pctEl.style.color = '#EF4444';
        } else {
            pctEl.textContent = '—';
            pctEl.style.color = '';
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maria\bpm-full\resources\views/realisasi/create.blade.php ENDPATH**/ ?>