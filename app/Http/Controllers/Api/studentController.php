<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentLaravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; //nos permite hacer validaciones
class studentController extends Controller
{
    //
    public function index()
    {
        // /Student::all() retorna toos los estudiantes :O
        $students = StudentLaravel::all();

        // if($students ->isEmpty()){
        //     $data = [
        //         'message' => `Students don't found`,
        //         'status' => 200
        //     ];
        //     return response() -> json($data, 404);
        // }

        $data = [
            'students' => $students,
            'status' => 200
        ];
        return response() -> json($data, 200);
    }

    public function store(Request $request){

        $validator  = Validator::make($request -> all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|email|unique:student_laravel',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error during data validations',
                'errors' => $validator->errors(),
                'status'=> 400
            ];
            return response()-> json($data, 400);
        }


        $student = StudentLaravel::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'phone' => $request -> phone,
            'language' => $request -> language
        ]);


        if(!$student){
            $data = [
                'message' => 'Error during the creation of an student',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'student' => $student,
            'status' => 201
        ];
        return response()->json($data, 201);

    }

    public function show($id){

        $student = StudentLaravel::find($id);

        if(!$student){
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()-> json($data, 404);
        }

        $data = [
            'student' => $student,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $student = StudentLaravel::find($id);

        if(!$student){
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()-> json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|email|unique:student_laravel',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error during data validations',
                'errors' => $validator->errors(),
                'status'=> 400
            ];
            return response()-> json($data, 400);
        }


        $student -> name = $request -> name;
        $student -> email = $request -> email;
        $student -> phone = $request -> phone;
        $student -> language = $request -> language;

        $data = [
            'message' => 'Student updated',
            'student' => $student,
            'status'=>200
        ];
        return response()->json($data, 200);

    }

    public function delete($id){

        $student = StudentLaravel::find($id);

        if(!$student){
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()-> json($data, 404);
        }

        $student -> delete();


        $data = [
            'message' => 'Student deleted',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function patch(Request $request, $id){
        $student  = StudentLaravel::find($id);
        if(!$student){
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()-> json($data, 404);
        }


        $validator = Validator::make($request->all(),[
            'name' => 'max:255',
            'email' => 'email|unique:student_laravel',
            'phone' => 'digits:10',
            'language' => 'in:English,Spanish,French'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error during data validations',
                'errors' => $validator->errors(),
                'status'=> 400
            ];
            return response()-> json($data, 400);
        }

        if($request->has('name')){
            $student -> name = $request -> name;
        }
        if($request->has('email')){
            $student -> email = $request -> email;
        }
        if($request->has('phone')){
            $student -> phone = $request -> phone;
        }
        if($request->has('language')){
            $student -> language = $request -> language;
        }


        $student-> save();



        $data = [
            'message' => 'Student partially updated',
            'student' => $student,
            'status'=>200
        ];
        return response()->json($data, 200);


    }

}
