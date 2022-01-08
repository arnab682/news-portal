<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SubCategoryController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $subcategory = DB::table('subcategories')
                        ->join('categories','subcategories.category_id','categories.id')
                        ->select('subcategories.*','categories.category_en')
                        ->orderBy('id','desc')->paginate(4);
    	return view('admin.subcategory.index',compact('subcategory'));
    }


    public function create()
    {
        $category = DB::table('categories')->get();
    	return view('admin.subcategory.create',compact('category'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subcategory_en' => 'required|unique:subcategories|max:255',
            'subcategory_bg' => 'required|unique:subcategories|max:255',
           ]);

            $data = array();
            $data['subcategory_en'] = $request->subcategory_en;
            $data['subcategory_bg'] = $request->subcategory_bg;
            $data['category_id'] = $request->category_id;
            DB::table('subcategories')->insert($data);

            $notification = array(
                'message' => 'SubCategory Inserted Successfully',
                'alert-type' => 'success'
            );

        return Redirect()->route('admin.subcategory.index')->with($notification);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $subcategory = DB::table('subcategories')->where('id',$id)->first();
    	$category = DB::table('categories')->get();
    	return view('admin.subcategory.edit',compact('subcategory','category'));
    }


    public function update(Request $request, $id)
    {
         $data = array();
    	 $data['subcategory_en'] = $request->subcategory_en;
    	 $data['subcategory_bg'] = $request->subcategory_bg;
    	 $data['category_id'] = $request->category_id;
    	 DB::table('subcategories')->where('id',$id)->update($data);

    	 $notification = array(
    	 	'message' => 'SubCategory Updated Successfully',
    	 	'alert-type' => 'success'
    	 );

    	return Redirect()->route('admin.subcategory.index')->with($notification);
    }


    public function destroy($id)
    {
        DB::table('subcategories')->where('id',$id)->delete();

    	$notification = array(
    	 	'message' => 'SubCategory Deleted Successfully',
    	 	'alert-type' => 'error'
    	 );

    	 return Redirect()->route('admin.subcategory.index')->with($notification);
    }
}
