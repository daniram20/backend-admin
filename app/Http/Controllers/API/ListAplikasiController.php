<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListAplikasiResource;
use App\Models\ListAplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
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

    public function update(Request $request, ListAplikasi $listAplikasi)
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

            Storage::delete('public/images/' . $listAplikasi->foto);

            $listAplikasi->update([
                'nama' => $request->nama,
                'url' => $request->url,
                'foto' => $filename,
                'status' => $request->status,
            ]);
        } else {
            $listAplikasi->update([
                'nama' => $request->nama,
                'url' => $request->url,
                'status' => $request->status,
            ]);
        }

        return response()->json(['Aplikasi updated successfully.', new ListAplikasiResource($listAplikasi)]);

   }
   
   public function destroy(ListAplikasi $listAplikasi)
   {
        $listAplikasi->delete();
        Storage::delete('public/images/' . $listAplikasi->foto);
        
        return response()->json(['Aplikasi deleted successfully.']);
   }
}
