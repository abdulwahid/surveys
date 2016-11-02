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
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required|exists:categories,id'
        ]);

        if($id) {
            $trait = Traits::findOrFail($id);
            $actionType = 'updated';
        } else {
            $trait = New Traits;
            $actionType = 'created';
        }

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
