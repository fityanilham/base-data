<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $quiz = Quiz::get();
      return $quiz;
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
      $quiz = Validator::make(
        $request->all(), [
          'user_id' => 'required',
          'lesson_id' => 'required',
          'soal' => 'required',
          'jawaban' => 'required',
          'jawaban' => 'required',
          'jawaban' => 'required',
        ],
        [
          'user_id.required' => 'Masukkan user id!',
          'lesson_id.required' => 'Masukkan lesson id!',
          'soal.required' => 'Masukkan Soal!',
          'jawaban.required' => 'Masukkan jawaban!',
          'jawaban.required' => 'Masukkan jawaban salah 1!',
          'jawaban.required' => 'Masukkan jawaban salah 2!',
        ]
      );

      if($quiz->fails()) {
        return response()->json([
          'success' => false,
          'message' => 'Silahkan isi bagian yang kosong',
          'data'    => $quiz->errors()
        ],401);
      }else {
        $post = Quiz::create([
          'user_id' => $request->input('user_id'),
          'lesson_id' => $request->input('lesson_id'),
          'soal' => $request->input('soal'),
          'jawaban' => $request->input('jawaban'),
          'jawaban' => $request->input('jawaban'),
          'jawaban' => $request->input('jawaban'),
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
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function show(Quiz $quiz, $id)
    {
      $quiz = Lesson::where('id', $id)->first();
      if ($quiz) {
        return $quiz;
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
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz)
    {
      $quiz = Validator::make(
        $request->all(), [
          'user_id' => 'required',
          'lesson_id' => 'required',
          'soal' => 'required',
          'jawaban' => 'required',
          'jawaban' => 'required',
          'jawaban' => 'required',
        ],
        [
          'user_id.required' => 'Masukkan user_id!',
          'lesson_id.required' => 'Masukkan lesson_id!',
          'soal.required' => 'Masukkan Soal!',
          'jawaban.required' => 'Masukkan jawaban!',
          'jawaban.required' => 'Masukkan jawaban salah 1!',
          'jawaban.required' => 'Masukkan jawaban salah 2!',
        ]
      );

      if($quiz->fails()) {
        return response()->json([
          'success' => false,
          'message' => 'Silahkan isi bagian yang kosong',
          'data'    => $quiz->errors()
        ],401);
      }else {
        $post = Quiz::where('id', $request->$id)->update([
          'user_id' => $request->input('user_id'),
          'lesson_id' => $request->input('lesson_id'),
          'soal' => $request->input('soal'),
          'jawaban' => $request->input('jawaban'),
          'jawaban' => $request->input('jawaban'),
          'jawaban' => $request->input('jawaban'),
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
      $quiz = Quiz::findOrFail($id);
      if($quiz) {
        $quiz->delete();
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
