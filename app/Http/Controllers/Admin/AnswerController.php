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

    public function postUpdate(Request $request, $id=null)
    {
//        dd($request->all());
        $this->validate($request, [
            'answer_text' => 'required',
            'answer_trait' => 'exists:traits,id',
            'answer_question' => 'required|exists:questions,id'
        ]);

        if($id) {
            $answer = Answer::findOrFail($id);
            $actionType = 'updated';
        } else {
            $answer = New Answer;
            $actionType = 'created';
        }

        $answer->text = $request->get('answer_text');
        $answer->sort_order = $request->has('answer_sort_order') ? $request->get('answer_sort_order') : '1';
        $answer->trait_id = $request->has('answer_trait') ? $request->get('answer_trait') : NULL;
        $answer->question_id = $request->get('answer_question');
        $answer->save();

        return redirect()->back()->with(['message' => 'Answer ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return redirect()->back()->with(['message' => 'Answer deleted successfully']);
    }
}
