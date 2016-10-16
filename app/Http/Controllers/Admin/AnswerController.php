<?php

namespace App\Http\Controllers\Admin;

use App\Answer;
use App\Traits;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{
    public function showList(Request $request, $traitId=false)
    {
        $answers = [];
        $trait = false;
        if($traitId) {

            $trait = Traits::where('id', $traitId)->first();
            if($trait) {
                $answers = Answer::where('trait_id', $traitId)->get();
            } else {
                $request->session()->flash('message', 'Trait not found. Showing Answers for all Traits.');
            }
        }

        if(!$answers) {
            $answers = Answer::all();
        }

        return view('admin.answer.show-list', compact('answers', 'trait'));
    }
}
