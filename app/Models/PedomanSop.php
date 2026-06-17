<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PedomanSop extends Model
{
    protected $table = 'pedoman_sop';
    protected $fillable = ['nama_pedoman', 'jenis', 'url', 'file_path', 'tahun', 'status', 'keterangan'];
}
