<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; font-size: 11px; color: #000; padding: 30px; }
    .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 14px; }
    .header h2 { font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
    .header h3 { font-size: 12px; font-weight: normal; }
    .meta { margin-bottom: 12px; }
    .meta table { width: 100%; font-size: 11px; }
    .meta td { padding: 2px 0; }
    .meta td:first-child { width: 150px; font-weight: bold; }
    
    table.main { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 10px; }
    table.main th { background: #1E293B; color: #fff; padding: 5px 6px; text-align: left; border: 1px solid #1E293B; }
    table.main td { border: 1px solid #ddd; padding: 4px 6px; }
    table.main tr:nth-child(even) td { background: #f9f9f9; }
    
    .pct-high { color: #065F46; font-weight: bold; }
    .pct-mid  { color: #92400E; font-weight: bold; }
    .pct-low  { color: #991B1B; font-weight: bold; }
    
    /* PERBAIKAN STRUKTUR STRUKTUR TANDA TANGAN UNTUK DOMPDF DOMAIN */
    .table-sign { width: 100%; border: none; margin-top: 30px; table-layout: fixed; }
    .table-sign td { border: none; text-align: center; vertical-align: top; width: 33.3%; font-size: 11px; }
    .sign-line { height: 60px; } /* Memberi ruang kosong horizontal yang konsisten untuk ttd */
    .sign-name { font-weight: bold; text-decoration: underline; margin-bottom: 2px; }
    
    .footer { margin-top: 30px; border-top: 1px solid #999; padding-top: 6px; font-size: 9px; color: #666; text-align: center; }
</style>
</head>
<body>

<div class="header">
    <h2>Universitas Katolik Darma Cendika</h2>
    <h3>Badan Penjaminan Mutu (BPM)</h3>
    <div style="font-size:12px;font-weight:bold;margin-top:6px">LAPORAN KINERJA TRIWULAN {{ $triwulan }} TAHUN {{ $tahun }}</div>
</div>

<div class="meta">
    <table>
        <tr><td>Periode</td><td>: Triwulan {{ $triwulan }} Tahun {{ $tahun }}</td></tr>
        <tr><td>Total Indikator</td><td>: {{ $laporan['totalIndikator'] }} indikator</td></tr>
        <tr><td>Indikator Tercapai</td><td>: {{ $laporan['tercapai'] }} indikator</td></tr>
        <tr><td>Rata-rata Capaian</td><td>: {{ $laporan['rataCapaian'] }}%</td></tr>
        <tr><td>Tanggal Cetak</td><td>: {{ now()->isoFormat('D MMMM Y') }}</td></tr>
    </table>
</div>

<table class="main">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Indikator</th>
            <th>Kategori</th>
            <th>Target</th>
            <th>Realisasi</th>
            <th>%</th>
            <th>Bobot</th>
            <th>Nilai</th>
            <th>Ket</th>
        </tr>
    </thead>
    <tbody>
    @forelse($laporan['realisasi'] as $i => $r)
    <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $r->indikator->kode_indikator }}</td>
        <td>{{ $r->indikator->nama_indikator }}</td>
        <td>{{ $r->indikator->kategori->nama_kategori }}</td>
        <td>{{ number_format($r->target,2) }}</td>
        <td><strong>{{ number_format($r->realisasi,2) }}</strong></td>
        <td class="{{ $r->persentase>=100 ? 'pct-high' : ($r->persentase>=75 ? 'pct-mid' : 'pct-low') }}">{{ $r->persentase }}%</td>
        <td>{{ $r->bobot_snapshot }}</td>
        <td>{{ number_format($r->nilai,2) }}</td>
        <td>{{ $r->keterangan ? substr($r->keterangan,0,30) : '-' }}</td>
    </tr>
    @empty
    <tr><td colspan="10" style="text-align:center;padding:10px;color:#666">Belum ada data terverifikasi.</td></tr>
    @endforelse
    <tr style="background:#f0f4ff;font-weight:bold">
        <td colspan="6">TOTAL / RATA-RATA</td>
        <td>{{ $laporan['rataCapaian'] }}%</td>
        <td>-</td>
        <td>{{ $laporan['totalNilai'] }}</td>
        <td>-</td>
    </tr>
    </tbody>
</table>

<table class="table-sign">
    <tr>
        <td>
            <p style="color: #555;">Mengetahui,</p>
            <div class="sign-line"></div>
            <p class="sign-name">Rektor</p>
            <p style="font-size:10px;color:#666">Universitas Katolik Darma Cendika</p>
        </td>
        <td>
            <p style="color: #555;">Diketahui,</p>
            <div class="sign-line"></div>
            <p class="sign-name">Wakil Rektor I</p>
            <p style="font-size:10px;color:#666">Bidang Akademik</p>
        </td>
        <td>
            <p style="color: #555;">Kepala BPM,</p>
            <div class="sign-line"></div>
            <p class="sign-name">Ketua BPM</p>
            <p style="font-size:10px;color:#666">Badan Penjaminan Mutu</p>
        </td>
    </tr>
</table>

<div class="footer">Dicetak oleh Sistem Informasi Kinerja BPM &bull; {{ now()->format('d/m/Y H:i') }}</div>
</body>
</html>