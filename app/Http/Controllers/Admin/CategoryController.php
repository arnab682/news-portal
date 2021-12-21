<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = DB::table('categories')->orderBy('id', 'desc')->paginate(3);
        return view('admin.category.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.category.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_en' => 'required|unique:categories|max:255',
            'category_bg' => 'required|unique:categories|max:255',
           ]);

             $data = array();
             $data['category_en'] = $request->category_en;
             $data['category_bg'] = $request->category_bg;
             DB::table('categories')->insert($data);

             $notification = array(
                 'message' => 'Category Inserted Successfully',
                 'alert-type' => 'success'
             );

        return Redirect()->route('admin.category.index')->with($notification);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $category = DB::table('categories')->where('id',$id)->first();
    	return view('admin.category.edit',compact('category'));
    }


    public function update(Request $request, $id)
    {
        $data = array();
    	 $data['category_en'] = $request->category_en;
    	 $data['category_bg'] = $request->category_bg;
    	 DB::table('categories')->where('id',$id)->update($data);

    	 $notification = array(
    	 	'message' => 'Category Updated Successfully',
    	 	'alert-type' => 'success'
    	 );

    	return Redirect()->route('admin.category.index')->with($notification);
    }


    public function destroy($id)
    {
        DB::table('categories')->where('id',$id)->delete();

    	$notification = array(
    	 	'message' => 'Category Deleted Successfully',
    	 	'alert-type' => 'success'
    	 );

    	 return Redirect()->route('admin.category.index')->with($notification);
    }
}
