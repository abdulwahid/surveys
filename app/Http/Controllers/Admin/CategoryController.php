<?php

namespace App\Http\Controllers\Admin;

use App\Category;
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
        return view('admin.category.create');
    }

    public function update($id) {
        $category = Category::findOrFail($id);
        return view('admin.category.update', compact('category'));
    }

    public function postUpdate(Request $request, $id=null) {


        $inputs = $request->all();

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'sort_order' => 'required|numeric'

        ]);

        if($id) {
            $category = Category::findOrFail($id);
            $actionType = 'updated';
        } else {
            $category = New Category;
            $actionType = 'created';
        }

        $category->name = $inputs['name'];
        $category->description = $inputs['description'];
        $category->sort_order = $inputs['sort_order'];
        $category->save();

        return redirect()->route('admin-categories-list')->with(['message' => 'Category ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin-categories-list')->with(['message' => 'Category Deleted Successfully']);
    }

}
