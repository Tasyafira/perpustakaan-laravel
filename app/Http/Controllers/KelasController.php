<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_kelas'=>'required',
            'kelompok'=>'required'
        ]);
        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $save =Kelas::create([
            'nama_kelas'=>$request->nama_kelas,
            'kelompok'=>$request->kelompok
        ]);
        if($save){
            return Response()->json(['status'=>1]);
        } else {
            return Response()->json(['status'=>0]);
        }
    }

    public function show()
    {
        return Kelas::all();
    }

    public function detail($id)
    {
        if(Kelas::where('id_kelas', $id)->exists()){
            $data_kelas= Kelas::select('kelas.id_kelas', 'nama_kelas', 'kelompok')->where('id_kelas', '=', $id)->get();
            return Response()->json($data_kelas);
        }
        else{
            return Response()->json(['message' => 'Tidak ditemukan']);
        }
    }

    public function update($id, Request $request) {         
        $validator=Validator::make($request->all(),         
        [   
            'nama_kelas'=>'required',
            'kelompok'=>'required'        
        ]); 

        if($validator->fails()) {             
            return Response()->json($validator->errors());         
        } 

        $ubah = Kelas::where('id_kelas', $id)->update([             
            'nama_kelas' =>$request->nama_kelas,
            'kelompok' =>$request->kelompok  
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
        $hapus = Kelas::where('id_kelas', $id)->delete();

        if($hapus) {
            return Response()->json(['status' => 1]);
        }

        else {
            return Response()->json(['status' => 0]);
        }
    }
}