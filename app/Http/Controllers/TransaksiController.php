<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\PeminjamanBuku;
use App\Models\DetailPeminjamanBuku;
use App\Models\PengembalianBuku;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function PeminjamanBuku(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_siswa'=>'required',
            'tanggal_pinjam'=>'required',
            'tanggal_kembali'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = PeminjamanBuku::create([
            'id_siswa'       =>$request->id_siswa,
            'tanggal_pinjam' =>$request->tanggal_pinjam,
            'tanggal_kembali'=>$request->tanggal_kembali
        ]);
        if($save){
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    
    }

    public function tambahItem(Request $req, $id)
    {
        $validator = Validator::make($req->all(),[
            'id_buku'=>'required',
            'qty'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save = DetailPeminjamanBuku::create([
            'id_peminjaman_buku'    =>$id,
            'id_buku'               =>$req->id_buku,
            'qty'                   =>$req->qty,
        ]);
        if($save){
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }

    

    public function PengembalianBuku(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'id_peminjaman_buku'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $cek_kembali=PengembalianBuku::where('id_peminjaman_buku',$req->id_peminjaman_buku);
        if($cek_kembali->count() == 0){
            $dt_kembali = PeminjamanBuku::where('id',$req->id_peminjaman_buku)->first();
            $tanggal_sekarang = Carbon::now()->format('Y-m-d');
            $tanggal_kembali = new Carbon($dt_kembali->tanggal_kembali);
            $dendaperhari = 1500;
            if(strtotime($tanggal_sekarang) > strtotime($tanggal_kembali)){
                $jumlah_hari = $tanggal_kembali->diff($tanggal_sekarang)->days;
                $denda = $jumlah_hari*$dendaperhari;
            }else {
                $denda = 0;
            }
            $save = PengembalianBuku::create([
                'id_peminjaman_buku'    => $req->id_peminjaman_buku,
                'tanggal_pengembalian'  => $tanggal_sekarang,
                'denda'                 => $denda,
            ]);
            if($save){
                $data['status'] = 1;
                $data['message'] = 'Berhasil dikembalikan';
            } else {
                $data['status'] = 0;
                $data['message'] = 'Pengembalian gagal';
            }
        } else {
            $data = ['status'=>0,'message'=>'Sudah pernah dikembalikan'];
        }
        return response()->json($data);
    }


    }


