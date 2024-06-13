<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $students = Student::all();
            return response()->json($students, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des étudiants'], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        try {
            $student = Student::create($validatedData);
            $user = User::create([
                'name' => $student->name,
                'email' => $student->name . '@gmail.com',
                'password' => Hash::make('passer'),
            ]);
            return response()->json($student, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création de l\'étudiant'], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $student = Student::find($id);
            if ($student) {
                return response()->json($student, 200);
            } else {
                return response()->json(['error' => 'Étudiant non trouvé'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération de l\'étudiant'], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        try {
            $student = Student::find($id);
            if ($student) {
                $student->update($validatedData);
                return response()->json($student, 200);
            } else {
                return response()->json(['error' => 'Étudiant non trouvé'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour de l\'étudiant'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $student = Student::find($id);
            if ($student) {
                $student->delete();
                return response()->json(['message' => 'Étudiant supprimé avec succès'], 200);
            } else {
                return response()->json(['error' => 'Étudiant non trouvé'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de l\'étudiant'], 500);
        }
    }
}
