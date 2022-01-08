<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Image;

class PostController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index()
    {
        $post = DB::table('posts')
			->join('categories','posts.category_id','categories.id')
			->join('subcategories','posts.subcategory_id','subcategories.id')
			->join('districts','posts.district_id','districts.id')
			->join('subdistricts','posts.subdistrict_id','subdistricts.id')
			->select('posts.*','categories.category_en','subcategories.subcategory_en','districts.district_en','subdistricts.subdistrict_en')
			->orderBy('id','desc')->paginate(5);//dd($post);die();
		return view('admin.post.index',compact('post'));
    }


    public function create()
    {
        $category = DB::table('categories')->get();
    	$district = DB::table('districts')->get();
    	return view('admin.post.create',compact('category','district'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'district_id' => 'required',
           ]);


           $data = array();
           $data['title_en'] = $request->title_en;
           $data['title_bg'] = $request->title_bg;
           $data['user_id'] = Auth::id();
           $data['category_id'] = $request->category_id;
           $data['subcategory_id'] = $request->subcategory_id;
           $data['district_id'] = $request->district_id;
           $data['subdistrict_id'] = $request->subdistrict_id;
           $data['tags_en'] = $request->tags_en;
           $data['tags_bg'] = $request->tags_bg;
           $data['details_en'] = $request->details_en;
           $data['details_bg'] = $request->details_bg;
           $data['headline'] = $request->headline;
           $data['first_section'] = $request->first_section;
           $data['first_section_thumbnail'] = $request->first_section_thumbnail;
           $data['bigthumbnail'] = $request->bigthumbnail;
           $data['post_date'] = date('d-m-Y');
           $data['post_month'] = date("F");


           $image = $request->image;

            if ($image) {
                $image_one = uniqid().'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(500,300)->save('image/postimg/'.$image_one);
                $data['image'] = 'image/postimg/'.$image_one;
                // image/postimg/343434.png
                DB::table('posts')->insert($data);

                $notification = array(
                        'message' => 'Post Inserted Successfully',
                        'alert-type' => 'success'
                    );

                return Redirect()->route('admin.all.post')->with($notification);

            }else{
                return Redirect()->back();
            }

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $post = DB::table('posts')->where('id',$id)->first();
        $category = DB::table('categories')->get();
        $district = DB::table('districts')->get();
        return view('admin.post.edit',compact('post','category','district'));
    }


    public function update(Request $request, $id)
    {
        $data = array();
        $data['title_en'] = $request->title_en;
        $data['title_bg'] = $request->title_bg;
        $data['user_id'] = Auth::id();
        $data['category_id'] = $request->category_id;
        $data['subcategory_id'] = $request->subcategory_id;
        $data['district_id'] = $request->district_id;
        $data['subdistrict_id'] = $request->subdistrict_id;
        $data['tags_en'] = $request->tags_en;
        $data['tags_bg'] = $request->tags_bg;
        $data['details_en'] = $request->details_en;
        $data['details_bg'] = $request->details_bg;
        $data['headline'] = $request->headline;
        $data['first_section'] = $request->first_section;
        $data['first_section_thumbnail'] = $request->first_section_thumbnail;
        $data['bigthumbnail'] = $request->bigthumbnail;


        $oldimage = $request->oldimage;
        $image = $request->image;

  	 	if ($image) {
  	 		$image_one = uniqid().'.'.$image->getClientOriginalExtension();
  	 		Image::make($image)->resize(500,300)->save('image/postimg/'.$image_one);
  	 		$data['image'] = 'image/postimg/'.$image_one;
  	 		// image/postimg/343434.png
  	 		DB::table('posts')->where('id',$id)->update($data);
  	 		unlink($oldimage);

  	 		$notification = array(
                'message' => 'Post Updated Successfully',
                'alert-type' => 'success'
            );

    	    return Redirect()->route('admin.all.post')->with($notification);

  	 	}else{
  	 		$data['image'] = $oldimage;
  	 		DB::table('posts')->where('id',$id)->update($data);

  	 		$notification = array(
                'message' => 'Post Updated Successfully',
                'alert-type' => 'success'
            );
            return Redirect()->route('admin.all.post')->with($notification);
  	 	}
    }


    public function destroy($id)
    {
        $post = DB::table('posts')->where('id',$id)->first();
        unlink($post->image);

        DB::table('posts')->where('id',$id)->delete();

        $notification = array(
                'message' => 'Post Deleted Successfully',
                'alert-type' => 'error'
            );

    	return Redirect()->route('admin.all.post')->with($notification);
    }

    public function GetSubCategory($category_id){

        $sub = DB::table('subcategories')->where('category_id',$category_id)->get();
        return response()->json($sub);

    }


    public function GetSubDistrict($district_id){

        $sub = DB::table('subdistricts')->where('district_id',$district_id)->get();
        return response()->json($sub);

    }
}
