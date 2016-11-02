<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\SurveyType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function showList() {

        $categories = Category::all();
        return view('admin.category.show-list', compact('categories'));
    }

    public function create() {
        $surveyTypes = SurveyType::all();
        return view('admin.category.create', compact('surveyTypes'));
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

}
