<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class DistrictController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $district = DB::table('districts')->orderBy('id','desc')->paginate(3);
    	return view('admin.district.index',compact('district'));
    }


    public function create()
    {
        return view('admin.district.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'district_en' => 'required|unique:districts|max:255',
            'district_bg' => 'required|unique:districts|max:255',
           ]);

            $data = array();
            $data['district_en'] = $request->district_en;
            $data['district_bg'] = $request->district_bg;
            DB::table('districts')->insert($data);

            $notification = array(
                'message' => 'District Inserted Successfully',
                'alert-type' => 'success'
            );

        return Redirect()->route('admin.district.index')->with($notification);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $district = DB::table('districts')->where('id',$id)->first();
    	return view('admin.district.edit',compact('district'));
    }


    public function update(Request $request, $id)
    {
         $data = array();
    	 $data['district_en'] = $request->district_en;
    	 $data['district_bg'] = $request->district_bg;
    	 DB::table('districts')->where('id',$id)->update($data);

    	 $notification = array(
    	 	'message' => 'District Updated Successfully',
    	 	'alert-type' => 'success'
    	 );

    	return Redirect()->route('admin.district.index')->with($notification);
    }


    public function destroy($id)
    {
        DB::table('districts')->where('id',$id)->delete();

    	$notification = array(
    	 	'message' => 'District Deleted Successfully',
    	 	'alert-type' => 'error'
    	 );

    	return Redirect()->route('admin.district.index')->with($notification);
    }
}
