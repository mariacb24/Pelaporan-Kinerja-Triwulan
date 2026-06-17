<?php $__env->startSection('title', 'Laporan Final'); ?>
<?php $__env->startSection('page-title', 'Laporan Final Kinerja BPM'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Laporan Final Kinerja BPM</h5>
        <p class="text-muted mb-0" style="font-size:12px">Triwulan <?php echo e($triwulan); ?> &middot; Tahun <?php echo e($tahun); ?></p>
    </div>
    <div class="d-flex gap-2 flex-wrap w-100 w-md-auto justify-content-md-end">
        <form method="GET" action="<?php echo e(route('laporan.final')); ?>" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="triwulan" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <?php for($i=1;$i<=4;$i++): ?>
                    <option value="<?php echo e($i); ?>" <?php echo e($i==$triwulan?"selected":""); ?>>TW<?php echo e($i); ?></option>
                <?php endfor; ?>
            </select>

            <select name="tahun" class="form-select form-select-sm" style="width:auto" onchange="this.form.submit()">
                <?php for($y=2023;$y<=now()->year+1;$y++): ?>
                    <option value="<?php echo e($y); ?>" <?php echo e($y==$tahun?"selected":""); ?>><?php echo e($y); ?></option>
                <?php endfor; ?>
            </select>

            <button type="submit" class="btn btn-sm btn-primary d-md-none">Terapkan</button>
        </form>

        <a href="<?php echo e(route('laporan.pdf', ['triwulan'=>$triwulan, 'tahun'=>$tahun])); ?>" class="btn btn-danger btn-sm">
            <i class="bi bi-file-earmark-pdf me-1"></i>Download PDF Resmi
        </a>
        <a href="<?php echo e(route('laporan.excel', ['triwulan'=>$triwulan, 'tahun'=>$tahun])); ?>" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel me-1"></i>Download Excel
        </a>
    </div>
</div>

<div class="card" style="border-top:4px solid #2563EB">
    <div class="card-body text-center py-4">
        <h6 class="fw-bold text-uppercase mb-1" style="letter-spacing:.05em">UNIVERSITAS KATOLIK DARMA CENDIKA</h6>
        <p class="text-muted mb-1" style="font-size:12px">BADAN PENJAMINAN MUTU (BPM)</p>
        <hr class="my-2" style="width:200px;margin:0 auto">

        <h6 class="fw-bold text-primary mt-2 mb-1">
            LAPORAN KINERJA TRIWULAN <?php echo e($triwulan); ?> - KONSOLIDASI UNIVERSITAS
        </h6>
        <p class="text-muted" style="font-size:12px">Periode Tahun <?php echo e($tahun); ?></p>
    </div>
</div>

<div class="row g-3 my-3">
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #2563EB"><div class="card-body py-2"><div class="fs-3 fw-bold text-primary"><?php echo e($laporan['totalIndikator']); ?></div><small class="text-muted">Indikator</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #10B981"><div class="card-body py-2"><div class="fs-3 fw-bold" style="color:#10B981"><?php echo e($laporan['tercapai']); ?></div><small class="text-muted">Tercapai</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #EF4444"><div class="card-body py-2"><div class="fs-3 fw-bold" style="color:#EF4444"><?php echo e($laporan['belumTercapai']); ?></div><small class="text-muted">Belum Tercapai</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #F59E0B"><div class="card-body py-2"><div class="fs-3 fw-bold" style="color:#F59E0B"><?php echo e($laporan['rataCapaian']); ?>%</div><small class="text-muted">Rata-rata Capaian</small></div></div></div>
</div>

<div class="card mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table mb-0" style="font-size:13px">
            <thead><tr><th class="ps-3">No</th><th>Kode</th><th>Nama Indikator</th><th>Kategori</th><th>Target</th><th>Realisasi</th><th>%</th><th>Nilai</th></tr></thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $laporan['realisasi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="ps-3"><?php echo e($i+1); ?></td>
                <td><span class="badge" style="background:#EFF6FF;color:#1D4ED8;font-size:10px"><?php echo e($r->indikator->kode_indikator); ?></span></td>
                <td><?php echo e($r->indikator->nama_indikator); ?></td>
                <td style="font-size:12px"><?php echo e($r->indikator->kategori->nama_kategori); ?></td>
                <td><?php echo e(number_format($r->target,2)); ?></td>
                <td class="fw-semibold"><?php echo e(number_format($r->realisasi,2)); ?></td>
                <td><?php $p=$r->persentase; ?><span class="<?php echo e($p>=100 ? 'pct-high' : ($p>=75 ? 'pct-mid' : 'pct-low')); ?>"><?php echo e($p); ?>%</span></td>
                <td><?php echo e(number_format($r->nilai,2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data terverifikasi untuk periode ini.</td></tr>
            <?php endif; ?>
            </tbody>
            <tfoot style="background:#F8FAFC;font-weight:600">
                <tr><td colspan="6" class="ps-3">Total Nilai Kinerja</td><td class="text-primary"><?php echo e($laporan['rataCapaian']); ?>%</td><td class="text-primary"><?php echo e($laporan['totalNilai']); ?></td></tr>
            </tfoot>
        </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row" style="font-size:13px">
            <div class="col-md-4 text-center">
                <p class="mb-0 text-muted">Mengetahui,</p>
                <div style="height:60px;border-bottom:1px solid #374151;width:160px;margin:8px auto 6px"></div>
                <p class="fw-semibold mb-0">Rektor</p>
                <p style="font-size:11px;color:#94A3B8">Universitas Katolik Darma Cendika</p>
            </div>
            <div class="col-md-4 text-center">
                <p class="mb-0 text-muted">Diketahui,</p>
                <div style="height:60px;border-bottom:1px solid #374151;width:160px;margin:8px auto 6px"></div>
                <p class="fw-semibold mb-0">Wakil Rektor I</p>
                <p style="font-size:11px;color:#94A3B8">Bidang Academic</p>
            </div>
            <div class="col-md-4 text-center">
                <p class="mb-0 text-muted">Kepala BPM,</p>
                <div style="height:60px;border-bottom:1px solid #374151;width:160px;margin:8px auto 6px"></div>
                <p class="fw-semibold mb-0">Ketua BPM</p>
                <p style="font-size:11px;color:#94A3B8">Badan Penjaminan Mutu</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maria\bpm-full\resources\views/laporan/final.blade.php ENDPATH**/ ?>