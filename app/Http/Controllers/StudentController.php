<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function getStudents(){
        $students = Student::with('course', 'yearLevel', 'section')->get();

        return response()->json(['students' => $students]);
    }  

    public function addStudent(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'id_number' => ['nullable', 'string', 'max:255', 'unique:students'],
            'course_id' => ['required', 'exists:courses,id'],
            'year_level_id' => ['required', 'exists:year_levels,id'],
            'section_id' => ['required', 'exists:sections,id'],
        ]);

        $student = Student::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'id_number' => $request->id_number,
            'course_id' => $request->course_id,
            'year_level_id' => $request->year_level_id,
            'section_id' => $request->section_id,
        ]);

        return response()->json(['message' => 'Student added successfully', 'student' => $student]);
    }

    public function editStudent(Request $request, $id){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'id_number' => ['nullable', 'string', 'max:255', 'unique:students,id_number,' . $id],
            'course_id' => ['required', 'exists:courses,id'],
            'year_level_id' => ['required', 'exists:year_levels,id'],
            'section_id' => ['required', 'exists:sections,id'],
        ]);

        $student = Student::find($id);

        if(!$student){
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'id_number' => $request->id_number,
            'course_id' => $request->course_id,
            'year_level_id' => $request->year_level_id,
            'section_id' => $request->section_id,
        ]);

        return response()->json(['message' => 'Student updated successfully', 'student' => $student ]);
    }   

    public function deleteStudent($id){
        $student = Student::find($id);

        if(!$student){
            return response()->json(['message' => 'Student not found'], 404);
        }

        $student->delete();

        return response()->json(['message' => 'Student deleted successfully']);
    }
}
