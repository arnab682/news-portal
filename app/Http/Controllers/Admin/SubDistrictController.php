<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SubDistrictController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $subdistrict = DB::table('subdistricts')
    		->join('districts','subdistricts.district_id','districts.id')
    		->select('subdistricts.*','districts.district_en')
    		->orderBy('id','desc')->paginate(4);
    	return view('admin.subdistrict.index',compact('subdistrict'));
    }


    public function create()
    {
        $district = DB::table('districts')->get();
    	return view('admin.subdistrict.create',compact('district'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'subdistrict_en' => 'required|unique:subdistricts|max:255',
            'subdistrict_bg' => 'required|unique:subdistricts|max:255',
           ]);

            $data = array();
            $data['subdistrict_en'] = $request->subdistrict_en;
            $data['subdistrict_bg'] = $request->subdistrict_bg;
            $data['district_id'] = $request->district_id;
            DB::table('subdistricts')->insert($data);

            $notification = array(
                'message' => 'SubDistrict Inserted Successfully',
                'alert-type' => 'success'
             );

        return Redirect()->route('admin.subdistrict.index')->with($notification);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $subdistrict = DB::table('subdistricts')->where('id',$id)->first();
    	$district = DB::table('districts')->get();
    	return view('admin.subdistrict.edit',compact('subdistrict','district'));
    }


    public function update(Request $request, $id)
    {
         $data = array();
    	 $data['subdistrict_en'] = $request->subdistrict_en;
    	 $data['subdistrict_bg'] = $request->subdistrict_bg;
    	 $data['district_id'] = $request->district_id;
    	 DB::table('subdistricts')->where('id',$id)->update($data);

    	 $notification = array(
    	 	'message' => 'SubDistrict Updated Successfully',
    	 	'alert-type' => 'success'
    	 );

    	return Redirect()->route('admin.subdistrict.index')->with($notification);
    }


    public function destroy($id)
    {
        DB::table('subdistricts')->where('id',$id)->delete();

    	$notification = array(
    	 	'message' => 'SubDistrict Deleted Successfully',
    	 	'alert-type' => 'error'
    	 );

    	return Redirect()->route('admin.subdistrict.index')->with($notification);
    }
}
