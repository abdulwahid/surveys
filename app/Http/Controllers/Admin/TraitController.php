<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Survey;
use App\Traits;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TraitController extends Controller
{
    public function showList(Request $request)
    {
        $surveyId = $request->get('survey_id', false);
        if($surveyId) {
            $questionIds = DB::table('question_survey')->where('survey_id', $surveyId)->pluck('question_id');
            $traits = Traits::join('answers', 'answers.trait_id', '=', 'traits.id')
                ->whereIn('answers.question_id', $questionIds)
                ->select('traits.*')
                ->groupBy('traits.id')
                ->get();
        } else {
            $traits = Traits::all();
        }

        $surveys = Survey::get(['id', 'title']);
        return view('admin.trait.show-list', compact('traits', 'surveys','surveyId'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.trait.create', compact('categories'));
    }

    public function update($id)
    {
        $trait = Traits::findOrFail($id);
        $categories = Category::all();
        return view('admin.trait.update', compact('trait', 'categories'));
    }

    public function postUpdate(Request $request, $id=null)
    {
        $validations = ['category' => 'required|exists:categories,id'];

        if($id) {
            $trait = Traits::findOrFail($id);
            $actionType = 'updated';
            $validations['name'] = 'required';
        } else {
            $trait = New Traits;
            $actionType = 'created';
            $validations['name'] = 'required|unique:traits';
        }

        $this->validate($request, $validations);

        $trait->name = $request->get('name');
        $trait->description = $request->get('description', '');
        $trait->category_id = $request->get('category');
        $trait->save();

        return redirect()->back()->with(['message' => 'Trait ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $trait = Traits::findOrFail($id);
        $trait->delete();
        return redirect()->back()->with(['message' => 'Trait Deleted Successfully']);
    }
}
