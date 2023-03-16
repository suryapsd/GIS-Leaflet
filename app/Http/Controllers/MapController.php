<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Map::get();
        return view('map',[
            'spaces' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Lakukan validasi data
        $this->validate($request, [
            'image' => 'image|mimes:png,jpg,jpeg',
            'name' => 'required',
            'telepon' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        // melakukan pengecekan ketika ada file gambar yang akan di input
        $data = new Map();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/imgCover/', $uploadFile);
            $data->image = $uploadFile;
        }else{
            $data->image = 'store_profile.jpg';
        }

        // Memasukkan nilai untuk masing-masing field pada tabel space berdasarkan inputan dari
        // form create 
        $data->name = $request->input('name');
        $data->telepon = $request->input('telepon');
        $data->address = $request->input('address');
        $data->latitude = $request->input('latitude');
        $data->longitude = $request->input('longitude');

        //return dd($data);

        // proses simpan data
        $data->save();

        // redirect ke halaman index space
        if ($data) {
            return redirect('/map')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect('/map')->with('error', 'Data gagal disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function show(Map $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function edit(Map $map)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Map $map)
    {
        // Lakukan validasi data
        $this->validate($request, [
            'mimage' => 'image|mimes:png,jpg,jpeg',
            'mname' => 'required',
            'mtelepon' => 'required',
            'maddress' => 'required',
            'mlatitude' => 'required',
            'mlongitude' => 'required'
        ]);

        //dd($request->mimage);
        // Jika data yang akan diganti ada pada tabel space
        // cek terlebih dahulu apakah akan mengganti gambar atau tidak
        // jika gambar diganti hapus terlebuh dahulu gambar lama
        $map = Map::findOrFail($map->id);
        if ($request->hasFile('mimage')) {
            
            if (File::exists("uploads/imgCover/" . $map->image)) {
                File::delete("uploads/imgCover/" . $map->image);
            }
            
            $file = $request->file("mimage");
            //$uploadFile = StoreImage::replace($space->image,$file->getRealPath(),$file->getClientOriginalName());
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('uploads/imgCover/', $uploadFile);
            $map->image = $uploadFile;
        }

        // Lakukan Proses update data ke tabel space
        $map->update([
            'name' => $request->mname,
            'telepon' => $request->mtelepon,
            'address' => $request->maddress,
            'latitude' => $request->mlatitude,
            'longitude' => $request->mlongitude,
        ]);
       
        // redirect ke halaman index space
        if ($map) {
            return redirect('/map')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect('/map')->with('error', 'Data gagal diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function destroy(Map $map)
    {
        //
    }
}
