<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IndikatorKinerja;
use App\Models\KategoriIndikator;

class IndikatorKinerjaSeeder extends Seeder
{
    public function run(): void
    {
        $kat = KategoriIndikator::pluck('id', 'nama_kategori');

        $data = [
            ['kode_indikator'=>'IK-AK-01','nama_indikator'=>'Persentase Kelulusan Tepat Waktu','kategori_id'=>$kat['Akademik'],'target'=>75,'satuan'=>'%','bobot'=>2.50,'formula_penilaian'=>'(Jumlah lulus tepat waktu / Total mahasiswa) x 100'],
            ['kode_indikator'=>'IK-AK-02','nama_indikator'=>'IPK Rata-rata Lulusan','kategori_id'=>$kat['Akademik'],'target'=>3.25,'satuan'=>'Nilai','bobot'=>2.00,'formula_penilaian'=>'Rata-rata IPK seluruh lulusan'],
            ['kode_indikator'=>'IK-AK-03','nama_indikator'=>'Persentase Dosen Berkualifikasi S3','kategori_id'=>$kat['Akademik'],'target'=>40,'satuan'=>'%','bobot'=>1.50,'formula_penilaian'=>'(Dosen S3 / Total dosen) x 100'],
            ['kode_indikator'=>'IK-AK-04','nama_indikator'=>'Rasio Dosen terhadap Mahasiswa','kategori_id'=>$kat['Akademik'],'target'=>1/30,'satuan'=>'Rasio','bobot'=>1.50,'formula_penilaian'=>'Total dosen / Total mahasiswa'],
            ['kode_indikator'=>'IK-KM-01','nama_indikator'=>'Jumlah Prestasi Mahasiswa Tingkat Nasional','kategori_id'=>$kat['Kemahasiswaan'],'target'=>10,'satuan'=>'Prestasi','bobot'=>1.50,'formula_penilaian'=>'Jumlah prestasi yang diraih mahasiswa'],
            ['kode_indikator'=>'IK-KM-02','nama_indikator'=>'Persentase Mahasiswa Aktif Organisasi','kategori_id'=>$kat['Kemahasiswaan'],'target'=>60,'satuan'=>'%','bobot'=>1.00,'formula_penilaian'=>'(Mahasiswa aktif / Total mahasiswa) x 100'],
            ['kode_indikator'=>'IK-KM-03','nama_indikator'=>'Tingkat Kepuasan Mahasiswa','kategori_id'=>$kat['Kemahasiswaan'],'target'=>3.50,'satuan'=>'Skor/4','bobot'=>1.50,'formula_penilaian'=>'Skor rata-rata kepuasan dari survei'],
            ['kode_indikator'=>'IK-PN-01','nama_indikator'=>'Jumlah Publikasi Ilmiah Terindeks','kategori_id'=>$kat['Penelitian'],'target'=>50,'satuan'=>'Publikasi','bobot'=>2.00,'formula_penilaian'=>'Total publikasi di jurnal terindeks Scopus/SINTA'],
            ['kode_indikator'=>'IK-PN-02','nama_indikator'=>'Jumlah Penelitian dengan Dana Eksternal','kategori_id'=>$kat['Penelitian'],'target'=>15,'satuan'=>'Penelitian','bobot'=>1.50,'formula_penilaian'=>'Total penelitian dengan pendanaan eksternal'],
            ['kode_indikator'=>'IK-PN-03','nama_indikator'=>'Jumlah Paten/HKI Terdaftar','kategori_id'=>$kat['Penelitian'],'target'=>5,'satuan'=>'HKI','bobot'=>1.00,'formula_penilaian'=>'Jumlah HKI yang terdaftar'],
            ['kode_indikator'=>'IK-PM-01','nama_indikator'=>'Jumlah Kegiatan Pengabdian Masyarakat','kategori_id'=>$kat['Pengabdian Masyarakat'],'target'=>20,'satuan'=>'Kegiatan','bobot'=>1.00,'formula_penilaian'=>'Total kegiatan pengabdian terlaksana'],
            ['kode_indikator'=>'IK-KS-01','nama_indikator'=>'Jumlah Kerjasama Aktif','kategori_id'=>$kat['Kerjasama'],'target'=>25,'satuan'=>'MOU/PKS','bobot'=>1.00,'formula_penilaian'=>'Total kerjasama yang masih aktif'],
            ['kode_indikator'=>'IK-KS-02','nama_indikator'=>'Jumlah Kerjasama Internasional','kategori_id'=>$kat['Kerjasama'],'target'=>5,'satuan'=>'MOU','bobot'=>1.00,'formula_penilaian'=>'Total kerjasama dengan institusi luar negeri'],
            ['kode_indikator'=>'IK-SD-01','nama_indikator'=>'Persentase Dosen Bersertifikat Pendidik','kategori_id'=>$kat['SDM'],'target'=>80,'satuan'=>'%','bobot'=>1.50,'formula_penilaian'=>'(Dosen bersertifikat / Total dosen) x 100'],
            ['kode_indikator'=>'IK-SD-02','nama_indikator'=>'Persentase Tenaga Kependidikan Terlatih','kategori_id'=>$kat['SDM'],'target'=>70,'satuan'=>'%','bobot'=>1.00,'formula_penilaian'=>'(Tendik terlatih / Total tendik) x 100'],
            ['kode_indikator'=>'IK-SP-01','nama_indikator'=>'Indeks Kepuasan Sarana Prasarana','kategori_id'=>$kat['Sarana Prasarana'],'target'=>3.25,'satuan'=>'Skor/4','bobot'=>1.00,'formula_penilaian'=>'Skor kepuasan aspek sarana prasarana'],
        ];

        foreach ($data as $item) {
            IndikatorKinerja::firstOrCreate(['kode_indikator' => $item['kode_indikator']], array_merge($item, ['status' => 'aktif']));
        }
    }
}
