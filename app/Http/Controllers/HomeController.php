<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\HomeModel;

class HomeController extends Controller
{

    public function FetchData(){
        $data = HomeModel::all();
        return response()->json([
            'users'=>$data,
        ]);
    }

    public function UserPost(request $request){
        $validated = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
        ]);
        if($validated->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validated->messages(),
            ]);
        }else{
             $data = new HomeModel();
             $data->name = $request->name;
             $data->email = $request->email;
             $data->save();
             return response()->json([
                 'status'=>200,
                 'massage'=>'Added Sussess',
             ]);
        }
    }
}
