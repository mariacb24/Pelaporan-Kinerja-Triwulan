<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Akreditasi extends Model
{
    protected $table = 'akreditasi';
    protected $fillable = [
        'program_studi', 'jenjang', 'status_akreditasi', 'lembaga_akreditasi',
        'nomor_sk', 'tanggal_sk', 'masa_berlaku', 'link_bukti', 'file_sertifikat',
    ];
    protected $casts = ['tanggal_sk' => 'date', 'masa_berlaku' => 'date'];

    public function getMasaBerlakuStatusAttribute(): string
    {
        if (!$this->masa_berlaku) return 'unknown';
        return $this->masa_berlaku->isFuture() ? 'aktif' : 'expired';
    }
}
