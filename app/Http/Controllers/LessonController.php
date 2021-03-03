<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $lesson = Lesson::with('Chapter', 'Quiz')->get();
      return $lesson;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
      $Lesson = Validator::make(
        $request->all(), [
          'user_id' => 'required',
          'pelajaran' => 'required',
          'guru' => 'required',
          'tingkatan' => 'required',
          'deskripsi' => 'required',
        ],
        [
          'user_id.required' => 'Masukkan user id!',
          'pelajaran.required' => 'Masukkan nama pelajaran Post!',
          'guru.required' => 'Masukkan nama guru!',
          'tingkatan.required' => 'Masukkan tingkat kesulitan!',
          'deskripsi.required' => 'Masukkan deskripsi pelajaran!',
        ]
      );

      if($Lesson->fails()) {
        return response()->json([
          'success' => false,
          'message' => 'Silahkan isi bagian yang kosong',
          'data'    => $Lesson->errors()
        ],401);
      }else {
        $post = Lesson::create([
          'user_id' => $request->input('user_id'),
          'pelajaran' => $request->input('pelajaran'),
          'guru' => $request->input('guru'),
          'tingkatan' => $request->input('tingkatan'),
          'deskripsi' => $request->input('deskripsi'),
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
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson, $id)
    {
      $lesson = Lesson::with('Chapter', 'Quiz')->where('id', $id)->first();
      if ($lesson) {
        return $lesson;
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
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if (Lesson::where('id', $id)->exists()) {
        $lesson = Lesson::find($id);

        $lesson->pelajaran = is_null($request->pelajaran) ? $lesson->pelajaran : $lesson->pelajaran;
        $lesson->guru = is_null($request->guru) ? $lesson->guru : $lesson->guru;
        $lesson->tingkatan = is_null($request->tingkatan) ? $lesson->tingkatan : $lesson->tingkatan;
        $lesson->deskripsi = is_null($request->deskripsi) ? $lesson->deskripsi : $lesson->deskripsi;
        $lesson->save();

        return response()->json([
          'success' => true,
          'message' => 'Data berhasil diupdate!',
        ], 200);
      } else {
        return response()->json([
          "message" => "buku"
        ], 404);
      }
      // $lesson = Validator::make(
      //   $request->all(), [
      //     'pelajaran' => '',
      //     'guru' => '',
      //     'tingkatan' => '',
      //     'deskripsi' => '',
      //   ],
      //   [
      //     'pelajaran.' => 'Masukkan nama pelajaran!',
      //     'guru.' => 'Masukkan nama guru!',
      //     'tingkatan.' => 'Masukkan tingkat kesulitan!',
      //     'deskripsi.' => 'Masukkan deskripsi pelajaran!',
      //   ]
      // );

      // if($lesson->fails()) {
      //   return response()->json([
      //     'success' => false,
      //     'message' => 'Silahkan isi bagian yang kosong',
      //     'data' => $lesson->errors()
      //   ],401);
      // } else {
      //   $post = Lesson::where('id', $request->id)->update([
      //     'pelajaran' => $request->input('pelajaran'),
      //     'guru' => $request->input('guru'),
      //     'tingkatan' => $request->input('tingkatan'),
      //     'deskripsi' => $request->input('deskripsi'),
      //   ]);
      //   if ($post) {
      //     return response()->json([
      //       'success' => true,
      //       'message' => 'Data berhasil diupdate!',
      //     ], 200);
      //   } else {
      //     return response()->json([
      //       'success' => false,
      //       'message' => 'Data gagal diupdate!',
      //     ], 401);
      //   }
      // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson, $id)
    {
      $lesson = Lesson::findOrFail($id);
      if($lesson) {
        $lesson->delete();
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
