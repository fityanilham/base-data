<?php

namespace App\Http\Controllers;

use App\Models\AnswerOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnswerOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AO = AnswerOption::get();
        return $AO;
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
        $AO = Validator::make(
            $request->all(), [
                'quiz_id' => 'required',
                'is_correct' => 'required',
                'answer_text' => 'required',
            ],
            [
                'quiz_id.required' => 'Masukkan quiz id!',
                'is_correct.required' => 'Masukkan is correct!',
                'answer_text.required' => 'Masukkan answer text!',
            ]
            );

            if($AO->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi bagian yang kosong',
                'data'    => $AO->errors()
            ],401);
            }else {
            $post = AnswerOption::create([
                'quiz_id' => $request->input('quiz_id'),
                'is_correct' => $request->input('is_correct'),
                'answer_text' => $request->input('answer_text'),
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
     * @param  \App\Models\AnswerOption  $answerOption
     * @return \Illuminate\Http\Response
     */
    public function show(AnswerOption $answerOption, $id)
    {
        $AO = AnswerOption::where('id', $id)->first();
      if ($AO) {
        return $AO;
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
     * @param  \App\Models\AnswerOption  $answerOption
     * @return \Illuminate\Http\Response
     */
    public function edit(AnswerOption $answerOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnswerOption  $answerOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnswerOption $answerOption, $id)
    {
        // $AO = Validator::make(
        //     $request->all(), [
        //         'quiz_id' => 'required',
        //         'is_correct' => 'required',
        //         'answer_text' => 'required',
        //     ],
        //     [
        //         'quiz_id.required' => 'Masukkan quiz id!',
        //         'is_correct.required' => 'Masukkan is Correct!',
        //         'answer_text.required' => 'Masukkan answer text!',
        //     ]
        //     );

        //     if($AO->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Silahkan isi bagian yang kosong',
        //         'data'    => $AO->errors()
        //     ],401);
        //     }else {
        //     $post = AnswerOption::where('id', $request->$id)->update([
        //         'quiz_id' => $request->input('quiz_id'),
        //         'is_correct' => $request->input('is_correct'),
        //         'answer_text' => $request->input('answer_text'),
        //     ]);
        //     if ($post) {
        //         return response()->json([
        //         'success' => true,
        //         'message' => 'Data berhasil disimpan!',
        //         ], 200);
        //     } else {
        //         return response()->json([
        //         'success' => false,
        //         'message' => 'Data gagal disimpan!',
        //         ], 401);
        //     }
        // }
        $OA = AnswerOption::where('id', $id)->first();
        $OA -> quiz_id = $request -> quiz_id;
        $OA -> is_correct = $request -> is_correct;
        $OA -> answer_tex = $request -> answer_tex;
        if($OA->update()) {
            return response()->json([
            'success' => false,
            'message' => 'Berhasil Update data',
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnswerOption  $answerOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnswerOption $answerOption, $id)
    {
        $AO = AnswerOption::findOrFail($id);
      if($AO) {
        $AO->delete();
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
