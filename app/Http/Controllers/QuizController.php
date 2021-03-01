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
      $quiz = Quiz::with('AnswerOption')->get();
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
          // 'user_id' => 'required',
          'lesson_id' => 'required',
          'question_text' => 'required',
        ],
        [
          // 'user_id.required' => 'Masukkan user id!',
          'lesson_id.required' => 'Masukkan lesson id!',
          'question_text.required' => 'Masukkan Soal!',
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
          // 'user_id' => $request->input('user_id'),
          'lesson_id' => $request->input('lesson_id'),
          'question_text' => $request->input('question_text'),
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
    public function show($id)
    {
      $quiz = Quiz::with('AnswerOption')->where('id', $id)->first();
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
    public function update(Request $request, Quiz $quiz, $id)
    {
      $quiz = Validator::make(
        $request->all(), [
          // 'user_id' => 'required',
          'lesson_id' => 'required',
          'question_text' => 'required',
        ],
        [
          // 'user_id.required' => 'Masukkan user_id!',
          'lesson_id.required' => 'Masukkan lesson_id!',
          'question_text.required' => 'Masukkan Soal!',
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
          // 'user_id' => $request->input('user_id'),
          'lesson_id' => $request->input('lesson_id'),
          'question_text' => $request->input('question_text'),
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
    public function destroy(Quiz $quiz, $id)
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
