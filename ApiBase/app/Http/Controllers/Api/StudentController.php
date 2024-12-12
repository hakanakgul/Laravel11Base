<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // Tüm metotlar için kimlik doğrulama
    }

    public function index()
    {
        if (Auth::user()->hasPermissionTo('view student information')) { // Yetki kontrolü
            $students = Student::all();
            return response()->json($students);
        } else if (Auth::user()->hasPermissionTo('view own student information')) {
            $students = Student::where('id', Auth::user()->id)->get();
            return response()->json($students);
        }
        return response()->json(['message' => 'Yetkiniz yok.'], 403);
    }

    // ... diğer metotlar (store, show, update, destroy) için de benzer yetki kontrolleri ekleyin
    public function store(Request $request)
    {
        if (Auth::user()->hasPermissionTo('manage student grades')) {
            $student = Student::create($request->all());
            return response()->json($student, 201);
        }
        return response()->json(['message' => 'Yetkiniz yok.'], 403);
    }

    public function show(Student $student)
    {
        if (Auth::user()->hasPermissionTo('view student information')) {
            return response()->json($student);
        } else if (Auth::user()->hasPermissionTo('view own student information')) {
            return response()->json($student);
        }
        return response()->json(['message' => 'Yetkiniz yok.'], 403);
    }

    public function update(Request $request, Student $student)
    {
        if (Auth::user()->hasPermissionTo('manage student grades')) {
            $student->update($request->all());
            return response()->json($student);
        }
        return response()->json(['message' => 'Yetkiniz yok.'], 403);
    }

    public function destroy(Student $student)
    {
        if (Auth::user()->hasPermissionTo('manage student grades')) {
            $student->delete();
            return response()->json(null, 204);
        }
        return response()->json(['message' => 'Yetkiniz yok.'], 403);
    }
}
