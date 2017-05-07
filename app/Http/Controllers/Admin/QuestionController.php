<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Question;
use App\Survey;
use App\Traits;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function showList(Request $request)
    {
        $surveyId = $request->get('survey_id', false);
        if($surveyId) {
            $surveyQuestions = Survey::with('questions')->where('id', $surveyId)->first();
            $questions = !empty($surveyQuestions->questions) ? $surveyQuestions->questions : [];
        } else {
            $questions = Question::all();
        }

        $surveys = Survey::get(['id', 'title']);
        return view('admin.question.show-list', compact('questions', 'surveys','surveyId'));
    }

    public function create()
    {
        $categories = Category::all();
        $surveys = Survey::all();
        $maxQuestionOrder = Question::orderBy('sort_order', 'desc')->first(['sort_order']);
        $maxQuestionOrder = $maxQuestionOrder ? $maxQuestionOrder->sort_order : 0;
        return view('admin.question.create', compact('categories', 'maxQuestionOrder', 'surveys'));
    }

    public function update($id)
    {
        $question = Question::findOrFail($id);
        $categories = Category::all();
        $surveys = Survey::all();
        $questionIds = DB::table('question_survey')->where('question_id', $id)->pluck('survey_id');
        $traits = Traits::where('category_id', $question->category_id)->get();
        return view('admin.question.update', compact('question', 'categories', 'traits', 'surveys', 'questionIds'));
    }

    public function postUpdate(Request $request, $id=null)
    {
        $inputs = $request->all();
        $this->validate($request, [
            'surveys' => 'array',
            'text' => 'required',
            'sort_order' => 'required',
            'category' => 'required|exists:categories,id'
        ]);

        if($id) {
            $question = Question::findOrFail($id);
            $actionType = 'updated';
        } else {
            $question = New Question;
            $actionType = 'created';
        }

        $question->text = $inputs['text'];
        $question->sort_order = $inputs['sort_order'];
        $question->category_id = $inputs['category'];
        $question->save();

        $question->surveys()->detach();
        $question->surveys()->attach($request->get('surveys'));

        return redirect()->route('admin-questions-list')->with(['message' => 'Question ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect()->route('admin-questions-list')->with(['message' => 'Question Deleted Successfully']);
    }
}
