<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianBuku extends Model
{
    protected $table = 'pengembalian_buku';
    protected $primarykey = 'id_pengembalian_buku';
    public $timestamps = false;
    protected $fillable = ['id_peminjaman_buku','tanggal_pengembalian','denda'];

    use HasFactory;
}

