<?php

namespace App\Http\Controllers;

use App\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    public function storeAndAttach($request,$model,$details,$fieldname='images',$location='/uploads/pictures/assets/'){

      $this->validate($request, [
            //  'images' => 'required',
              'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048'
      ]);

        if($request->hasfile($fieldname))
         {
            foreach($request->file($fieldname) as $image)
            {
                $location = $location;
                $name=$image->getClientOriginalName();
                $image->move(public_path().$location, $name);
                $data[] = $name;

                $pic = new Picture();
                $pic->picture = $location.$name;
                $pic->details = $details;
                $pic->uploader_id = Auth::user()->id;

                $model->pictures()->save($pic);
            }
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Picture $picture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        //
    }

    public function upload($file, $directory, $filename){
    		$input = Input::all();
    		$rules = array(
    		    'file' => 'image|max:4000',
    		);

    		$validation = Validator::make($input, $rules);

    		if ($validation->fails())
    		{
    			return Response::make($validation->errors->first(), 400);
    		}

    		$file = Input::file('file');

            $extension = File::extension($file['name']);
            $directory = asset('public/uploads/pictures/');
            $filename = sha1(time().time()).".{$extension}";

            $upload_success = Input::upload('file', $directory, $filename);

            if( $upload_success ) {
            	return Response::json('success', 200);
            } else {
            	return Response::json('error', 400);
            }
    	}

    public function uploadImage($file,$loc,$rename='false',$repeat='true'){
        // $location = "../../../../".$loc;
         $files = array();
         $xfile = " ";
         $new_path = " ";

        for($i=0; $i<count($file["name"]); $i++){
            $target_dir = $loc;
            $target_file = $target_dir . basename($file["name"][$i]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image

          if($rename){
            if($i==0){
                $xfile = $target_dir.$rename.".".$imageFileType;
                $new_path =$loc.$rename.".".$imageFileType;
            }else {
              $xfile = $target_dir.$rename.$i.".".$imageFileType;
              $new_path =$loc.$rename.$i.".".$imageFileType;
            }
          }else{
             $xfile = $target_file.".".$imageFileType;
             $new_path =$loc.basename($file["name"][$i]).".".$imageFileType;
          }

          if(!$repeat){
              if (file_exists($xfile)) {
                      unlink($xfile);
              } else {
                  // File not found.
              }
          }

            if(move_uploaded_file($file["tmp_name"][$i],$xfile)) {
                 array_push($files,$new_path);
            }
         }

          return $files;
      }
}
