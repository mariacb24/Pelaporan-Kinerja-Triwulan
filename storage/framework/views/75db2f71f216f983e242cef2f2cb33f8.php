<?php $__env->startSection('title', 'Draft Laporan'); ?>
<?php $__env->startSection('page-title', 'Draft Laporan Kinerja'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Draft Laporan Kinerja BPM</h5>
        <p class="text-muted mb-0" style="font-size:12px">Triwulan <?php echo e($triwulan); ?> &middot; Tahun <?php echo e($tahun); ?></p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <form method="GET" class="d-flex gap-2">
            <select name="triwulan" class="form-select form-select-sm" style="width:auto">
                <?php for($i=1;$i<=4;$i++): ?><option value="<?php echo e($i); ?>" <?php echo e($i==$triwulan?"selected":""); ?>>TW<?php echo e($i); ?></option><?php endfor; ?>
            </select>
            <select name="tahun" class="form-select form-select-sm" style="width:auto">
                <?php for($y=2023;$y<=now()->year+1;$y++): ?><option value="<?php echo e($y); ?>" <?php echo e($y==$tahun?"selected":""); ?>><?php echo e($y); ?></option><?php endfor; ?>
            </select>
            <button class="btn btn-sm btn-primary">Terapkan</button>
        </form>
        <a href="<?php echo e(route('laporan.pdf', ['triwulan'=>$triwulan,'tahun'=>$tahun])); ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
        <a href="<?php echo e(route('laporan.excel', ['triwulan'=>$triwulan,'tahun'=>$tahun])); ?>" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel me-1"></i>Excel</a>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #2563EB"><div class="card-body py-2"><div class="fs-3 fw-bold text-primary"><?php echo e($laporan['totalIndikator']); ?></div><div style="font-size:11px;color:#94A3B8">Total Indikator</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #10B981"><div class="card-body py-2"><div class="fs-3 fw-bold" style="color:#10B981"><?php echo e($laporan['tercapai']); ?></div><div style="font-size:11px;color:#94A3B8">Tercapai</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #EF4444"><div class="card-body py-2"><div class="fs-3 fw-bold" style="color:#EF4444"><?php echo e($laporan['belumTercapai']); ?></div><div style="font-size:11px;color:#94A3B8">Belum Tercapai</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #F59E0B"><div class="card-body py-2"><div class="fs-3 fw-bold" style="color:#F59E0B"><?php echo e($laporan['rataCapaian']); ?>%</div><div style="font-size:11px;color:#94A3B8">Rata-rata</div></div></div></div>
</div>
<?php $__currentLoopData = $laporan['byKategori']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card mb-3">
    <div class="card-header" style="background:#F8FAFC"><span class="fw-semibold" style="font-size:13px"><?php echo e($kategori); ?></span></div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-sm mb-0" style="font-size:13px">
            <thead><tr><th class="ps-3">Kode</th><th>Nama Indikator</th><th>Target</th><th>Realisasi</th><th>%</th><th>Nilai</th><th>Status</th></tr></thead>
            <tbody>
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="ps-3"><span class="badge" style="background:#EFF6FF;color:#1D4ED8;font-size:10px"><?php echo e($r->indikator->kode_indikator); ?></span></td>
                <td><?php echo e($r->indikator->nama_indikator); ?></td>
                <td><?php echo e(number_format($r->target,2)); ?> <?php echo e($r->indikator->satuan); ?></td>
                <td class="fw-semibold"><?php echo e(number_format($r->realisasi,2)); ?></td>
                <td><?php $p=$r->persentase; ?><span class="<?php echo e($p>=100 ? 'pct-high' : ($p>=75 ? 'pct-mid' : 'pct-low')); ?>"><?php echo e($p); ?>%</span></td>
                <td><?php echo e(number_format($r->nilai,2)); ?></td>
                <td><span class="badge badge-<?php echo e($r->status_verifikasi); ?>" style="font-size:10px"><?php echo e(ucfirst(str_replace('_',' ',$r->status_verifikasi))); ?></span></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if($laporan['realisasi']->isEmpty()): ?>
<div class="card"><div class="card-body text-center py-5"><i class="bi bi-inbox" style="font-size:3rem;color:#CBD5E1"></i><p class="text-muted mt-3">Belum ada data realisasi untuk periode ini.</p></div></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maria\bpm-full\resources\views/laporan/draft.blade.php ENDPATH**/ ?>