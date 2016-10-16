<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Traits;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TraitController extends Controller
{
    public function showList()
    {
        $traits = Traits::all();
        return view('admin.trait.show-list', compact('traits'));
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
        $inputs = $request->all();
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'category' => 'required|exists:categories,id'
        ]);

        if($id) {
            $trait = Traits::findOrFail($id);
            $actionType = 'updated';
        } else {
            $trait = New Traits;
            $actionType = 'created';
        }

        $trait->name = $inputs['name'];
        $trait->description = $inputs['description'];
        $trait->category_id = $inputs['category'];
        $trait->save();

        return redirect()->route('admin-traits-list')->with(['message' => 'Trait ' . $actionType . ' successfully']);
    }

    public function delete($id) {
        $trait = Traits::findOrFail($id);
        $trait->delete();
        return redirect()->route('admin-traits-list')->with(['message' => 'Trait Deleted Successfully']);
    }
}
