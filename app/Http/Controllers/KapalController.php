<?php

namespace App\Http\Controllers;

use App\Models\Kapal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KapalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kapal = Kapal::get();
        if(count($kapal)) {
            return response()->json([
                'status' => 'success',
                'data' => $kapal
            ]);
        }

        return response()->json(['message' => 'tidak ada data kapal']);

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
        $validator = Validator::make($request->all(), [
            'kode_kapal'   => 'required',
            'nama_kapal' => 'required',
            'nama_pemilik' => 'required',
            'alamat_pemilik' => 'required',
            'ukuran_kapal' => 'required',
            'kapten' => 'required',
            'jumlah_anggota' => 'required',
            'foto_kapal' => 'required|mimes:png,jpg,jpeg|max:2048',
            'nomor_izin' => 'required',
            'dokumen_perizinan' => 'required'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $image = $request->file("foto_kapal");

        $imageName = time(). "_". $image->getClientOriginalName();
        $image->move('image', $imageName);


        $kapal = Kapal::create([
            'kode_kapal' => $request->kode_kapal,
            'nama_kapal' => $request->nama_kapal,
            'nama_pemilik' => $request->nama_pemilik,
            'alamat_pemilik' =>$request->alamat_pemilik,
            'ukuran_kapal' => $request->ukuran_kapal,
            'kapten' => $request->kapten,
            'jumlah_anggota' => $request->jumlah_anggota,
            'foto_kapal' => asset('image/' . $imageName),
            'nomor_izin' => $request->nomor_izin,
            'dokumen_perizinan' => $request->dokumen_perizinan
        ]);


        if($kapal) {
            return response()->json([
                'status' => 200,
                'message' => 'Data kapal berhasil ditambahkan',
                'data' => $kapal
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Kapal gagal disimpan',
            'data' => $kapal
        ], 409);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kapal = Kapal::findOrFail($id);


        if($request->file('foto_kapal')) {
            $image = $request->file('foto_kapal');
            $imageName = time(). "_". $image->getClientOriginalName();
            $image->move('image', $imageName);

            $kapal->update([
                'foto_kapal' => asset('image/' . $imageName),
            ]);
        }


        $kapal = $kapal->update([
            'kode_kapal' => $request->kode_kapal,
            'nama_kapal' => $request->nama_kapal,
            'nama_pemilik' => $request->nama_pemilik,
            'alamat_pemilik' =>$request->alamat_pemilik,
            'ukuran_kapal' => $request->ukuran_kapal,
            'kapten' => $request->kapten,
            'jumlah_anggota' => $request->jumlah_anggota,
            'nomor_izin' => $request->nomor_izin,
            'dokumen_perizinan' => $request->dokumen_perizinan
        ]);


        if($kapal) {
            return response()->json([
                'status' => 200,
                'message' => 'Data kapal berhasil diupdate',
                'data' => $kapal
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Produk gagal di update',
            'data' => $kapal
        ], 409);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kapal = Kapal::findOrFail($id);
        $kapal->delete();

        return response()->json([
            'status' => 200,
            'message' => 'berhasil hapus data kapal'
        ]);
    }
}
