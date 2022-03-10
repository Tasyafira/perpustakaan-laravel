<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primarykey = 'id_siswa';
    public $timestamps = false;
    protected $fillable = ['nama_siswa','tanggal_lahir','gender','alamat','id_kelas'];

    use HasFactory;
}
