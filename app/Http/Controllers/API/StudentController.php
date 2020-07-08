<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Student;
use Validator;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $list_student = Student::paginate(10);
            return response()->json([
                'liststudent'  => $list_student->items(),
                'status'       =>  true,
                'code'         => 200,
                'meta'         =>[
                    'total'         => $list_student->total(),
                    'perPage'       => $list_student->perPage(),
                    'currentPage'   => $list_student->currentPage(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    =>false,
                'code'      => 500,
                'message'   =>$th->getMessage(),
            ]);
        } 
    }

    public function studentbyID($id)
    {
        try {
            $studentbyID = Student::find($id);
            if(is_null($studentbyID)){
                return response()->json([
                    'status' => true,
                    'code'  => 404,
                    'message'=> 'Record not found!'
                ]);
            }
            return response()->json([
                'student'   => $studentbyID,
                'status' => true,
                'code'  => 200,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    =>false,
                'code'      => 500,
                'message'   =>$th->getMessage(),
            ]);
        }
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), 
            [
                'name'=> 'required|min:2|max:255',
                'email'=> 'required',
                'address'=> 'required|max:255',
                'phone'=> 'required|max:255',
                'university'=> 'required|max:255',
            ],
            // [
            //     'required'=> 'Tên danh mục không được để trống',
            //     'min'=> 'Tên danh mục phải đủ từ 2 đến 255 ký tự',
            //     'max'=>'Tên danh mục phải đủ từ 2 đến 255 ký tự',
            // ]
                );
                if($validator->fails()){
                    return response()->json($validator->errors(), 400);
                }
            $student = Student::create($request->all());
            return Response()->json([
                'studentNew' => $student,
                'status'     => true,
                'code'       => 201,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    =>false,
                'code'      => 500,
                'message'   =>$th->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        try {
            $student = Student::find($id);
            if(is_null($student)){
                return response()->json([
                    'status'   => true,
                    'code'     => 404,
                    'message'  => 'Record not found!'
                ]);
            }
            $student->update($request->all());
            return response()->json([
                'student'       => $student,
                'status'        => true,
                'code'          => 200,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    =>false,
                'code'      => 500,
                'message'   =>$th->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $student = Student::find($id);
            if(is_null($student)){
                return response()->json([
                    'status'   => true,
                    'code'     => 404,
                    'message'  => 'Record not found!'
                ]);
            }
            $student->delete();
            return response()->json([
                'status'     => true,
                'code'       => 204,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'    =>false,
                'code'      => 500,
                'message'   =>$th->getMessage(),
            ]);
        }
    }
}
