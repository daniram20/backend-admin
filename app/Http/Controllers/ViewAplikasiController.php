<?php

namespace App\Http\Controllers;

use App\Models\ListAplikasi;
use Illuminate\Http\Request;

class ViewAplikasiController extends Controller
{
    public function index()
    {
        $listAplikasi = ListAplikasi::all();
        return view('listaplikasi.listaplikasi', compact('listAplikasi'));
    }

    public function create() 
    {
        return view('listaplikasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'url'=>'required',
            'foto'=>'required|max:2048',
            'status'=>'required',
        ]);

        $input = $request->all();
        if ($image = $request->file('foto')){
            $destionationPath = 'image/foto';
            $icon = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destionationPath, $icon);
            $input['foto'] = $icon;
        }

        ListAplikasi::create($input);

        return redirect()->route('list.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $listaplikasi = ListAplikasi::where('id', $id)->first();

        return response()->json([
            'message' => 'Detail Data List Aaplikasi',
            'data' => $listaplikasi
        ]);
    }

    public function edit(ListAplikasi $listAplikasi)
    {
        return view('listaplikasi.edit', compact('listAplikasi'));
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
        if ($image = $request->file('foto')){
            $destionationPath = 'image/foto';
            $icon = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destionationPath, $icon);
            $input['foto'] = $icon;
        }

        $listAplikasi->update($input);

        return redirect()->route('list.index')->with('success', 'Data berhasil diubah');

   }
   
   public function destroy($id)
   {
    $data =  ListAplikasi::find($id);
    unlink("image/foto/" . $data->foto);
    $data::where("id", $id)->delete();

    return redirect()->route('list.index')->with('success', 'Data berhasil dihapus');
   }
}
