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


    public function EditStudent($id)
    {
        $data = HomeModel::find($id);
        if($data){
            return response()->json([
                'status'=>200,
                'massage'=>$data,
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'massage'=>'User Not Found',
            ]);
        }
    }


    public function UpdateStudent(request $request,$id)
    {
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
             $data = HomeModel::find($id);
                if($data){
                    $data->name = $request->name;
                    $data->email = $request->email;
                    $data->update();
                    return response()->json([
                        'status'=>200,
                        'massage'=>'Update Sussess',
                    ]);
                }else{
                    return response()->json([
                        'status'=>404,
                        'massage'=>'User Not Found',
                    ]);
                }
            
        }
    }


    public function DeleteStudent($id)
    {
        $stu = HomeModel::find($id);
        $stu->delete();
        return response()->json([
            'status'=>200,
            'massage'=>'Delete Sussess',
        ]);
    }
}
