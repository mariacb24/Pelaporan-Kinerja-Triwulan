<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KepuasanMahasiswa extends Model
{
    protected $table = 'kepuasan_mahasiswa';
    protected $fillable = ['aspek', 'tidak_puas', 'kurang_puas', 'puas', 'sangat_puas', 'skor_rata', 'tahun'];

    public function hitungSkor(): float
    {
        $total = $this->tidak_puas + $this->kurang_puas + $this->puas + $this->sangat_puas;
        if ($total <= 0) return 0;
        return round(
            ($this->tidak_puas * 1 + $this->kurang_puas * 2 + $this->puas * 3 + $this->sangat_puas * 4) / $total, 2
        );
    }
}
