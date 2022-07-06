<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ListAplikasi;
use Illuminate\Http\Request;

class ListAplikasiController extends Controller
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
        // $listaplikasi = new ListAplikasi();

        // $listaplikasi->nama = $request->nama;
        // $listaplikasi->foto = $request->foto;
        // $listaplikasi->status = $request->status;
        // $listaplikasi->save();

        // return response()->json([
        //     'message' => 'Data berhasil disimpan',
        //     'data' => $listaplikasi
        // ]);

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
        }

        ListAplikasi::create($input);

        return response()->json([
            'message' => 'Aplikasi telah ditambahkan',
            'data' => $input
        ]);
    }

    public function show($id)
    {
        $listaplikasi = ListAplikasi::where('id', $id)->first();

        return response()->json([
            'message' => 'Detail Data List Aaplikasi',
            'data' => $listaplikasi
        ]);
    }

    public function update(Request $request, $id)
   {
        $listaplikasi = ListAplikasi::where('id', $id)->firstOrFail();
        $listaplikasi->nama = $request->nama;
        $listaplikasi->url = $request->url;
        $listaplikasi->foto = $request->foto;
        $listaplikasi->status = $request->status;
        $listaplikasi->save();

        return response()->json([
            'message' => 'Data berhasil diupdate'
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
