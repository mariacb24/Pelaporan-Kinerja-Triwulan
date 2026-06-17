<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DokumenSpmi extends Model
{
    protected $table = 'dokumen_spmi';
    protected $fillable = ['nama_dokumen', 'kategori', 'link_drive', 'file_path', 'status', 'tahun', 'keterangan'];
}
