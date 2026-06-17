<?php $__env->startSection('title', 'Realisasi Kinerja'); ?>
<?php $__env->startSection('page-title', 'Data Realisasi Kinerja'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Data Realisasi Kinerja</h5>
        <p class="text-muted mb-0" style="font-size:12px">Triwulan <?php echo e($triwulan); ?> &middot; Tahun <?php echo e($tahun); ?></p>
    </div>
    <?php if(auth()->user()->canInput()): ?>
    <a href="<?php echo e(route('realisasi.create', ['triwulan'=>$triwulan,'tahun'=>$tahun])); ?>" class="btn btn-primary btn-sm">
        <i class="bi bi-pencil-square me-1"></i>Input Realisasi
    </a>
    <?php endif; ?>
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 align-items-center flex-wrap">
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
            <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Kode</th>
                        <th>Nama Indikator</th>
                        <th>Target</th>
                        <th>Realisasi</th>
                        <th>Persentase</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Input Oleh</th>
                        <?php if(auth()->user()->canInput()): ?>
                        <th class="text-center">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $realisasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-3">
                            <span class="badge" style="background:#EFF6FF;color:#1D4ED8;font-size:10px">
                                <?php echo e($item->indikator->kode_indikator); ?>

                            </span>
                        </td>
                        <td>
                            <div style="font-size:13px"><?php echo e($item->indikator->nama_indikator); ?></div>
                            <small class="text-muted"><?php echo e($item->indikator->kategori->nama_kategori); ?></small>
                        </td>
                        <td style="font-size:13px"><?php echo e(number_format($item->target,2)); ?> <?php echo e($item->indikator->satuan); ?></td>
                        <td style="font-size:13px;font-weight:600"><?php echo e(number_format($item->realisasi,2)); ?></td>
                        <td>
                            <?php $pct = $item->persentase; ?>
                            <span class="<?php echo e($pct>=100?'pct-high':($pct>=75?'pct-mid':'pct-low')); ?>" style="font-size:13px"><?php echo e($pct); ?>%</span>
                            <div class="progress mt-1" style="height:4px;width:70px;border-radius:2px">
                                <div class="progress-bar" style="width:<?php echo e(min($pct,100)); ?>%;background:<?php echo e($pct>=100?'#10B981':($pct>=75?'#F59E0B':'#EF4444')); ?>"></div>
                            </div>
                        </td>
                        <td style="font-size:13px"><?php echo e(number_format($item->nilai,2)); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($item->status_verifikasi); ?>" style="font-size:10px">
                                <?php echo e(ucfirst(str_replace('_',' ',$item->status_verifikasi))); ?>

                            </span>
                        </td>
                        <td style="font-size:12px;color:#64748B"><?php echo e($item->createdBy?->name ?? '-'); ?></td>
                        <?php if(auth()->user()->canInput()): ?>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="<?php echo e(route('realisasi.edit', $item)); ?>" class="btn btn-sm btn-outline-primary py-0 px-2"><i class="bi bi-pencil"></i></a>
                                <?php if(auth()->user()->isAdmin()): ?>
                                <button class="btn btn-sm btn-outline-success py-0 px-2 btn-verif"
                                        data-id="<?php echo e($item->id); ?>" data-status="terverifikasi" title="Verifikasi">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger py-0 px-2 btn-verif"
                                        data-id="<?php echo e($item->id); ?>" data-status="ditolak" title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                <?php endif; ?>
                                <form action="<?php echo e(route('realisasi.destroy', $item)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada data realisasi periode ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($realisasi->hasPages()): ?>
    <div class="card-footer bg-transparent border-0"><?php echo e($realisasi->links()); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.querySelectorAll('.btn-verif').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id, status = this.dataset.status;
        Swal.fire({
            title: status === 'terverifikasi' ? 'Verifikasi data ini?' : 'Tolak data ini?',
            icon: status === 'terverifikasi' ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonColor: status === 'terverifikasi' ? '#10B981' : '#EF4444',
            confirmButtonText: 'Ya', cancelButtonText: 'Batal',
        }).then(r => {
            if (r.isConfirmed) $.post(`/realisasi/${id}/verifikasi`, {status}, () => location.reload());
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maria\bpm-full\resources\views/realisasi/index.blade.php ENDPATH**/ ?>