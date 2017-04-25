<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Survey;
use App\SurveyType;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function showList(Request $request) {

        $surveyId = $request->get('survey_id', false);
        if($surveyId) {
            $questionIds = DB::table('question_survey')->where('survey_id', $surveyId)->pluck('question_id');
            $categories = Category::join('questions', 'questions.category_id', '=', 'categories.id')
                ->whereIn('questions.id', $questionIds)
                ->select('categories.*')
                ->groupBy('categories.id')
                ->get();
        } else {
            $categories = Category::all();
        }

        $surveys = Survey::get(['id', 'title']);
        return view('admin.category.show-list', compact('categories', 'surveys','surveyId'));
    }

    public function create() {
        $surveyTypes = SurveyType::all();
        $maxCategoryOrder = Category::orderBy('sort_order', 'desc')->first(['sort_order']);
        $maxCategoryOrder = $maxCategoryOrder ? $maxCategoryOrder->sort_order : 0;
        return view('admin.category.create', compact('surveyTypes','maxCategoryOrder'));
    }

    public function update($id) {
        $category = Category::findOrFail($id);
        $surveyTypes = SurveyType::all();
        return view('admin.category.update', compact('category', 'surveyTypes'));
    }

    public function postUpdate(Request $request, $id=null) {

        $this->validate($request, [
            'survey_type' => 'required|exists:survey_types,id',
            'name' => 'required',
            'sort_order' => 'required|numeric'
        ]);

        if($id) {
            $category = Category::findOrFail($id);
            $actionType = 'updated';
        } else {
            $category = New Category;
            $actionType = 'created';
        }

        $category->survey_type_id = $request->get('survey_type');
        $category->name = $request->get('name');
        $category->description = $request->get('description', '');
        $category->sort_order = $request->get('sort_order');
        $category->save();

        return redirect()->route('admin-categories-list')->with(['message' => 'Category ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin-categories-list')->with(['message' => 'Category Deleted Successfully']);
    }

    public function updateSortOrder(Request $request, $id=null) {

        $this->validate($request, [
            'category_id' => 'required|exists:categories,id',
            'sort_order' => 'required|numeric'
        ]);

        Category::where('id', $request->get('category_id'))
            ->update(['sort_order' => $request->get('sort_order')]);

        return response()->json(['status' => 'success']);
    }

}
