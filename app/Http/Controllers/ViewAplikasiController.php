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
            'nama' => 'required',
            'url' => 'required',
            'foto' => 'required|max:2048',
            'status' => 'required',
        ]);

        $input = $request->all();
        if ($image = $request->file('foto')) {
            $destionationPath = 'image/foto';
            $icon = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destionationPath, $icon);
            $input['foto'] = $icon;
        }

        ListAplikasi::create($input);

        return redirect()->route('list.index')->with('success', 'Data berhasil ditambahkan');
    }


    public function edit($id)
    {
        $listAplikasi = ListAplikasi::find($id);
        return view('listaplikasi.edit', compact('listAplikasi'));
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'nama' => 'required',
        //     'url' => 'required',
        //     'foto' => 'required|max:2048',
        //     'status' => 'required',
        // ]);

        $input = $request->all();
        if ($image = $request->file('foto')) {
            $destionationPath = 'image/foto';
            $icon = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destionationPath, $icon);
            $input['foto'] = $icon;
        }
        $listAplikasi = ListAplikasi::find($id);
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
