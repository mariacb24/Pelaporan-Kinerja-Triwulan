<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DokumenWebsite extends Model
{
    protected $table = 'dokumen_website';
    protected $fillable = ['nama_dokumen', 'kategori', 'url_dokumen', 'tahun', 'status', 'keterangan'];
}
