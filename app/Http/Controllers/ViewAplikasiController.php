<?php

namespace App\Http\Controllers;

use App\Models\ListAplikasi;
use Illuminate\Http\Request;

class ViewAplikasiController extends Controller
{
    public function index()
    {
        $dataList = ListAplikasi::all();
        return response()->json([
            'message' => 'Data List Aplikasi',
            'data' => $dataList
        ]);
    }

    public function store(Request $request)
    {
        $listaplikasi = new ListAplikasi();

        $request->validate([
            'nama'=>'required',
            'url'=>'required',
            'foto'=>'required|max:2048',
            'status'=>'required',
        ]);

        $filename="";
        if($request->hasFile('foto')){
            $filename=$request->file('foto')->store('posts', 'public');
        }else{
            $filename=null;
        }

        $listaplikasi->nama=$request->nama;
        $listaplikasi->url=$request->url;
        $listaplikasi->foto=$filename;
        $listaplikasi->status=$request->status;
        $listaplikasi->save();

        return response()->json([
            'message' => 'Data berhasil ditambahkan',
            'data' => $listaplikasi,
        ]);

        // $request->validate([
        //     'nama' => 'required',
        //     'url' => 'required',
        //     'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'status' => 'required',
        // ]);

        // $input = $request->all();
        // if ($image = $request->file('foto')) {
        //     $destionationPath = 'image/foto/';
        //     $aplikasiImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
        //     $image->move($destionationPath, $aplikasiImg);
        //     $input['foto'] = $aplikasiImg;
        // }

        // ListAplikasi::create($input);

        // return response()->json([
        //     'message' => 'Aplikasi telah ditambahkan',
        //     'nama' => $request->nama,
        //     'url' => $request->url,
        //     'foto' => asset('image/foto/' . $aplikasiImg),
        //     'status' => $request->status,
        // ]);
    }

    public function show($id)
    {
        $listaplikasi = ListAplikasi::where('id', $id)->first();

        return response()->json([
            'message' => 'Detail Data List Aaplikasi',
            'data' => $listaplikasi
        ]);
    }

    public function update(Request $request, ListAplikasi $listAplikasi)
   {
        $request->validate([
            'nama' => 'required',
            'url' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        $input = $request->all();
        if ($image = $request->file('foto')) {
            $destionationPath = 'image/foto/';
            $aplikasiImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destionationPath, $aplikasiImg);
            $input['foto'] = $aplikasiImg;
        } else {
            unset($input['foto']);
        }

        $listAplikasi->update($input);

        return response()->json([
            'message' => 'Aplikasi telah diupdate',
            'data' => $input
        ]);

   }
   
   public function destroy($id)
   {
        $listaplikasi = ListAplikasi::where('id', $id)->delete();
        
        if ($listaplikasi != null) {
            return response()->json([
                'message' => 'Data list aplikasi dihapus',
                'data' => $listaplikasi
            ]);
        } else {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
   }
}
