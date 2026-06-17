<?php $__env->startSection('title', 'Edit Realisasi'); ?>
<?php $__env->startSection('page-title', 'Edit Realisasi Kinerja'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Edit Realisasi</h5>
    <a href="<?php echo e(route('realisasi.index')); ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card" style="max-width:600px">
    <div class="card-body">
        <div class="mb-3 p-3 rounded" style="background:#F8FAFC">
            <div class="row g-2" style="font-size:13px">
                <div class="col-6"><span class="text-muted">Kode:</span> <strong><?php echo e($realisasi->indikator->kode_indikator); ?></strong></div>
                <div class="col-6"><span class="text-muted">Periode:</span> <strong>TW<?php echo e($realisasi->triwulan); ?> / <?php echo e($realisasi->tahun); ?></strong></div>
                <div class="col-12"><span class="text-muted">Indikator:</span> <strong><?php echo e($realisasi->indikator->nama_indikator); ?></strong></div>
                <div class="col-6"><span class="text-muted">Target:</span> <strong><?php echo e(number_format($realisasi->target,2)); ?> <?php echo e($realisasi->indikator->satuan); ?></strong></div>
            </div>
        </div>
        <form action="<?php echo e(route('realisasi.update', $realisasi)); ?>" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px">Realisasi *</label>
                <div class="input-group">
                    <input type="number" name="realisasi" step="0.01" min="0"
                           class="form-control" id="realisasiInput"
                           value="<?php echo e(old('realisasi', $realisasi->realisasi)); ?>" required>
                    <span class="input-group-text"><?php echo e($realisasi->indikator->satuan); ?></span>
                </div>
            </div>
            <div class="mb-3 p-2 rounded" style="background:#EFF6FF">
                <span style="font-size:12px;color:#64748B">Persentase: </span>
                <span id="pctPreview" class="fw-bold" style="color:#2563EB"><?php echo e($realisasi->persentase); ?>%</span>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:13px">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"><?php echo e(old('keterangan', $realisasi->keterangan)); ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo e(route('realisasi.index')); ?>" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
const target = <?php echo e($realisasi->target); ?>;
document.getElementById('realisasiInput').addEventListener('input', function() {
    const pct = target > 0 ? ((parseFloat(this.value)||0)/target*100).toFixed(2) : 0;
    const el = document.getElementById('pctPreview');
    el.textContent = pct + '%';
    el.style.color = pct>=100?'#10B981':pct>=75?'#F59E0B':'#EF4444';
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maria\bpm-full\resources\views/realisasi/edit.blade.php ENDPATH**/ ?>