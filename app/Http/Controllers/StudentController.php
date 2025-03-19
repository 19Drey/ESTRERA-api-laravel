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
}
