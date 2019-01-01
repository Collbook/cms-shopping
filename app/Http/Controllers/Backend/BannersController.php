<?php

namespace App\Http\Controllers\Backend;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'link' => 'required',
            'image' => 'required'
        ]);

        $data = $request->all();

        //echo "<pre>";print_r($data);die();
        $banner = new Banner;
        $banner->title = $data['title'];
        $banner->link = $data['link'];
        $banner->text1 = $data['text1'];
        $banner->text2 = $data['text2'];
        $banner->text3 = $data['text3'];

        if(empty($data['status'])){
            $status='0';
        }else{
            $status='1';
        }

        if($request->hasFile('image')){
            $image_tmp = Input::file('image');
            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = rand(111,99999).'.'.$extension;
                $path_banner = 'backend/assets/images/banner'.'/'.$fileName;

                Image::make($image_tmp)->resize(484,441)->save($path_banner);
                $banner->image = $fileName;
            }
        }

        $banner->status = $status;

        $banner->save();
        Toastr::success('Banner has been added successfully','Sucess');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);
        return view('admin.banners.edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required',
            'link' => 'required',
            //'image' => 'required'
        ]);

        $data = $request->all();

        if($request->hasFile('image')){
            $image_tmp = Input::file('image');
            if ($image_tmp->isValid()) {
                // Upload Images after Resize
                $extension = $image_tmp->getClientOriginalExtension();
                $fileName = rand(111,99999).'.'.$extension;
                $path_banner = 'backend/assets/images/banner'.'/'.$fileName;

                Image::make($image_tmp)->resize(484,441)->save($path_banner);
                //$banner->image = $fileName;
            }
        }else if(!empty($data['current_image'])){
            $fileName = $data['current_image'];
        }else{
            $fileName = '';
        }

        if(empty($data['status'])){
            $status='0';
        }else{
            $status='1';
        }

        if(empty($data['title'])){
            $data['title'] = "";
        }

        if(empty($data['link'])){
            $data['link'] = "";
        }

        if(empty($data['text1'])){
            $data['text1'] = "";
        }

        if(empty($data['text2'])){
            $data['text2'] = "";
        }

        if(empty($data['text3'])){
            $data['text3'] = "";
        }

        //$banner->status = $status;




        Banner::where(['id'=>$id])->update(['status'=>$status,'title'=>$data['title'],'link'=>$data['link'],'text1'=>$data['text1'],'text2'=>$data['text2'],'text3'=>$data['text3'],'image'=>$fileName]);


        Toastr::success('Banner has been added successfully','Sucess');
        return redirect()->route('admin.banner.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        // Get Product Image
		$banner = Banner::where('id',$id)->first();
        // Get Product Image Paths
        //dd($productImage);

        $path_banner = 'backend/assets/images/banner/';

		// Delete Large Image if not exists in Folder
        if(file_exists($path_banner.$banner->image)){
            unlink($path_banner.$banner->image);
        }

        // Delete Image from Products table
        //Banner::where(['id'=>$id])->update(['image'=>'']);

        $banner = Banner::find($id);
        $banner->delete();
        Toastr::success('Banner has been deleted successfully','Sucess');
        return redirect()->back();

    }
}
