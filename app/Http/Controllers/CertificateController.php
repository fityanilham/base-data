<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $sertifikat = Certificate::get();
    return $sertifikat;
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
    $certificate = Validator::make(
      $request->all(), [
        'name' => 'required',
        'pelajaran' => 'required',
      ],
      [
        'name.required' => 'Masukkan tingkat kesulitan!',
        'pelajaran.required' => 'Masukkan pelajaran!',
      ]
    );

    if($certificate->fails()) {
      return response()->json([
        'success' => false,
        'message' => 'Silahkan isi bagian yang kosong',
        'data'    => $certificate->errors()
      ],401);
    }else {
      $post = Certificate::create([
        'name' => $request->input('name'),
        'pelajaran' => $request->input('pelajaran'),
      ]);
      if ($post) {
        return response()->json([
          'success' => true,
          'message' => 'Data berhasil disimpan!',
        ], 200);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Data gagal disimpan!',
        ], 401);
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Certificate  $certificate
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $certificate = Certificate::where('id', $id)->first();
      if ($certificate) {
        return $certificate;
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Tidak ada detail data!',
          'data' => 'Kosong!'
        ], 401);
      }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Certificate  $certificate
   * @return \Illuminate\Http\Response
   */
  public function edit(Certificate $certificate)
  {
      //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Certificate  $certificate
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    Quotes::where('id', $request->id)->update([
      'name' => $request->name,
      'pelajaran' => $request->pelajaran,
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Data berhasil disimpan!',
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Certificate  $certificate
   * @return \Illuminate\Http\Response
   */
  public function destroy(Certificate $certificate)
  {
    $certificate = Certificate::findOrFail($id);
      if($certificate) {
        $certificate->delete();
        return response()->json([
          'success' => true,
          'message' => 'Data berhasil dihapus!',
        ], 200);
      } else {
        return response()->json([
          'success' => false,
          'message' => 'Data gagal dihapus!',
        ], 401);
      }
  }
}
