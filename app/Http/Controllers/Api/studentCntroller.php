<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentCntroller extends Controller
{
    public function index()
    {
        $students = Student::all();
        if ($students->isEmpty()) {
            $data = [
                'Message' => 'No students found',
                'status' => 200
            ];
            return response()->json($data, 200);
        }
        $data = [
            'students' => $students,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Data validation error',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data, 400);
        }
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language,
        ]);

        if (!$student) {
            $data = [
                'message' => 'Error creating student',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'Student' => $student,
            'status' => 201,
        ];
        return response()->json($data, 201);
    }

    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $data = [
            'message' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
        $student->delete();
        $data = [
            'message' => 'Student successfully removed',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update($request, $id)
    {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:student',
            'phone' => 'required|digits:10',
            'language' => 'required|in:English,Spanish,French',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Data validation error',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data, 400);
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;
        $student->save();
        $data = [
            'message' => 'Student successfully updated',
            'student' => $student,
            'status' => 200,
        ];
        return response() -> json($data, 200);
    }

    public function updatePartial($request, $id) {
        $student = Student::find($id);
        if (!$student) {
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:student',
            'phone' => 'digits:10',
            'language' => 'in:English,Spanish,French',
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Data validation error',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data, 400);
        }

        if ($request -> has('name')) {
            $student->name = $request->name;
        }
        if ($request -> has('email')) {
            $student->email = $request->email;
        }
        if ($request -> has('phone')) {
            $student->phone = $request->phone;
        }
        if ($request -> has('languaje')) {
            $student->language = $request->language;
        }
        
        $student->save();
        $data = [
            'message' => 'Student successfully updated',
            'student' => $student,
            'status' => 200,
        ];
        return response() -> json($data, 200);
        
    }
}
