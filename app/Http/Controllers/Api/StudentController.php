<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(15);

        return StudentResource::collection($students);
    }

    public function show(Student $student): StudentResource
    {
        return new StudentResource($student);
    }

    public function store(Request $request)
    {
        $student = Student::create($this->validatedData($request));

        return (new StudentResource($student))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, Student $student): StudentResource
    {
        $student->update($this->validatedData($request, $student));

        return new StudentResource($student->refresh());
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->noContent();
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Student $student = null): array
    {
        return Validator::make($request->all(), [
            'student_number' => ['required', 'string', 'max:255', Rule::unique('students', 'student_number')->ignore($student)],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student)],
            'course' => ['required', 'string', 'max:255'],
            'year_level' => ['required', 'integer', 'between:1,4'],
        ])->validate();
    }
}
