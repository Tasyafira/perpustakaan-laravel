<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanBuku;
use App\Models\DetailPeminjamanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PeminjamanBukuController extends Controller
{
    public function store(Request $request)
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


    public function show()
    {
        $data_peminjaman_buku = PeminjamanBuku::join('siswa', 'siswa.id_siswa', 'peminjaman_buku.id_siswa')->get();
        return Response()->json($data_peminjaman_buku);
    }
    
    public function detail($id)
    {
        if(PeminjamanBuku::where('id_peminjaman_buku', $id)->exists()){
            $data_peminjaman_buku = PeminjamanBuku::join('siswa',  'siswa.id_siswa', 'peminjaman_buku.id_siswa') ->where('peminjaman_buku.id_peminjaman_buku', '=', $id)->get();
            return Response()->json($data_peminjaman_buku);
        }
        else{
            return Response()->json(['message' => 'Tidak ditemukan']);
        }
    }

    public function update($id, Request $request) {         
        $validator=Validator::make($request->all(),         
        [   
            'id_siswa'=>'required',
            'tanggal_pinjam'=>'required',
            'tanggal_kembali'=>'required'       
        ]); 

        if($validator->fails()) {             
            return Response()->json($validator->errors());         
        } 

        $ubah = PeminjamanBuku::where('id_peminjaman_buku', $id)->update([             
            'id_siswa'            =>$request->id_siswa,
            'tanggal_pinjam'      =>$request->tanggal_pinjam,
            'tanggal_kembali'     =>$request->tanggal_kembali
        ]); 

        if($ubah) {             
            return Response()->json(['status' => 1]);         
        }         
        else {             
            return Response()->json(['status' => 0]);         
        }     
    }
    
    public function destroy($id)
    {
        $hapus = PeminjamanBuku::where('id_peminjaman_buku', $id)->delete();

        if($hapus) {
            return Response()->json(['status' => 1]);
        }

        else {
            return Response()->json(['status' => 0]);
        }
    }
    
}

