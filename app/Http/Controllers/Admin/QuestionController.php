<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    public function showList()
    {
        $questions = Question::all();
        return view('admin.question.show-list', compact('questions'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.question.create', compact('categories'));
    }

    public function update($id)
    {
        $question = Question::findOrFail($id);
        $categories = Category::all();
        return view('admin.question.update', compact('question', 'categories'));
    }

    public function postUpdate(Request $request, $id=null)
    {
        $inputs = $request->all();
        $this->validate($request, [
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

        return redirect()->route('admin-questions-list')->with(['message' => 'Question ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect()->route('admin-questions-list')->with(['message' => 'Question Deleted Successfully']);
    }
}
