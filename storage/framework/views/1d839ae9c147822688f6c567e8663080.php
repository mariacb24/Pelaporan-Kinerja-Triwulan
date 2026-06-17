<?php $__env->startSection('title', 'Survei Kepuasan'); ?>
<?php $__env->startSection('page-title', 'Survei & Kepuasan'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Survei Kepuasan</h5>
    <?php if(auth()->user()->canInput()): ?>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg me-1"></i>Tambah Survei</button>
    <?php endif; ?>
</div>
<div class="card"><div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-hover mb-0" style="font-size:13px">
        <thead><tr><th class="ps-3">Nama Survei</th><th>Tahun</th><th>Triwulan</th><th>Responden</th><th>Hasil</th><th>Keterangan</th><?php if(auth()->user()->canInput()): ?><th>Aksi</th><?php endif; ?></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $survei; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td class="ps-3 fw-semibold"><?php echo e($s->nama_survei); ?></td>
            <td><?php echo e($s->tahun); ?></td>
            <td><?php echo e($s->triwulan ? 'TW'.$s->triwulan : '-'); ?></td>
            <td><?php echo e(number_format($s->jumlah_responden)); ?></td>
            <td><?php if($s->url_hasil): ?><a href="<?php echo e($s->url_hasil); ?>" target="_blank" class="text-primary" style="font-size:12px">Lihat Hasil</a><?php else: ?> <span class="text-muted">-</span><?php endif; ?></td>
            <td style="font-size:12px;color:#64748B"><?php echo e($s->keterangan ?? '-'); ?></td>
            <?php if(auth()->user()->canInput()): ?>
            <td>
                <button class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo e($s->id); ?>"><i class="bi bi-pencil"></i></button>
                <form action="<?php echo e(route('survei.destroy', $s)); ?>" method="POST" class="d-inline"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button></form>
            </td>
            <?php endif; ?>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data survei.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
    </div>
</div></div>
<?php if(auth()->user()->canInput()): ?>
<div class="modal fade" id="modalTambah" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form action="<?php echo e(route('survei.store')); ?>" method="POST"><?php echo csrf_field(); ?>
        <div class="modal-header"><h6 class="modal-title fw-semibold">Tambah Survei</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Nama Survei *</label><input type="text" name="nama_survei" class="form-control form-control-sm" required></div>
            <div class="row g-2 mb-3">
                <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Tahun *</label><input type="number" name="tahun" class="form-control form-control-sm" value="<?php echo e(now()->year); ?>" required></div>
                <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Triwulan</label><select name="triwulan" class="form-select form-select-sm"><option value="">-</option><option>1</option><option>2</option><option>3</option><option>4</option></select></div>
                <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Responden</label><input type="number" name="jumlah_responden" class="form-control form-control-sm" value="0"></div>
            </div>
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">URL Hasil</label><input type="url" name="url_hasil" class="form-control form-control-sm" placeholder="https://..."></div>
            <div><label class="form-label fw-semibold" style="font-size:12px">Keterangan</label><textarea name="keterangan" class="form-control form-control-sm" rows="2"></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
    </form>
</div></div></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maria\bpm-full\resources\views/survei/index.blade.php ENDPATH**/ ?>