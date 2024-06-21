<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        return response()->json(Student::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:students',
        ]);

        $student = Student::create($validatedData);

        return response()->json($student, 201);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if ($student) {
            return response()->json($student);
        } else {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if ($student) {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'age' => 'sometimes|required|integer',
                'email' => 'sometimes|required|string|email|max:255|unique:students,email,' . $id,
            ]);

            $student->update($validatedData);

            return response()->json($student);
        } else {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->delete();

            return response()->json(['message' => 'Student deleted']);
        } else {
            return response()->json(['error' => 'Student not found'], 404);
        }
    }
}

