<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListAplikasiResource;
use App\Models\ListAplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ListAplikasiController extends Controller
{
    public function index()
    {
        $data = ListAplikasi::latest()->get();
        return ListAplikasiResource::collection($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'url' => 'required|string',
            'foto' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $file = $request->file('foto');
        $destionationPath = "public\images";
        $filename = 'aplikasi_' . date("Ymd_his") . '.' . $file->extension();
        $aplikasi = ListAplikasi::create([
            'nama' => $request->nama,
            'url' => $request->url,
            'foto' => $filename,
            'status' => $request->status,
        ]);
        Storage::putFileAs($destionationPath, $file, $filename);

        return response()->json(['Aplikasi berhasil ditambahkan.', new ListAplikasiResource($aplikasi)]);
    }

    public function show($id)
    {
         $aplikasi = ListAplikasi::find($id);
        if (is_null($aplikasi)) {
            return response()->json(['error' => 'Aplikasi not found.'], 404);
        }
        return response()->json(['Aplikasi fetched successfully.', new ListAplikasiResource($aplikasi)]);
    }

    public function update(Request $request, ListAplikasi $aplikasi)
   {
         $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'url' => 'required|string',
            'foto' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if($request->hasFile('foto')) {

            $file = $request->file('foto');
            $destinationPath = "public\images";
            $filename = 'aplikasi_' . date("Ymd_his") . '.' . $file->extension();
            Storage::putFileAs($destinationPath, $file, $filename);

            Storage::delete('public/images/' . $aplikasi->foto);

            $aplikasi->update([
                'nama' => $request->nama,
                'url' => $request->url,
                'foto' => $filename,
                'status' => $request->status,
            ]);
        } else {
            $aplikasi->update([
                'nama' => $request->nama,
                'url' => $request->url,
                'status' => $request->status,
            ]);
        }

        return response()->json(['Aplikasi updated successfully.', new ListAplikasiResource($aplikasi)]);

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
