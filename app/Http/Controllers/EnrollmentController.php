<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function index(): View
    {
        $enrollments = Enrollment::with(['student', 'subject'])
            ->latest('enrollment_date')
            ->latest('id')
            ->paginate(10);

        return view('enrollments.index', compact('enrollments'));
    }

    public function create(): View
    {
        return view('enrollments.create', $this->formOptions());
    }

    public function show(Enrollment $enrollment): View
    {
        $enrollment->load(['student', 'subject']);

        return view('enrollments.show', compact('enrollment'));
    }

    public function store(Request $request): RedirectResponse
    {
        Enrollment::create($this->validatedData($request));

        return redirect()->route('enrollments.index')->with('status', 'Enrollment added successfully.');
    }

    public function edit(Enrollment $enrollment): View
    {
        return view('enrollments.edit', array_merge(
            $this->formOptions(),
            ['enrollment' => $enrollment->load(['student', 'subject'])],
        ));
    }

    public function update(Request $request, Enrollment $enrollment): RedirectResponse
    {
        $enrollment->update($this->validatedData($request, $enrollment));

        return redirect()->route('enrollments.index')->with('status', 'Enrollment updated successfully.');
    }

    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('status', 'Enrollment deleted successfully.');
    }

    private function formOptions(): array
    {
        return [
            'students' => Student::orderBy('last_name')->orderBy('first_name')->get(),
            'subjects' => Subject::orderBy('subject_code')->get(),
        ];
    }

    private function validatedData(Request $request, ?Enrollment $enrollment = null): array
    {
        return $request->validate([
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'subject_id' => [
                'required',
                'integer',
                'exists:subjects,id',
                Rule::unique('enrollments', 'subject_id')
                    ->where('student_id', $request->input('student_id'))
                    ->ignore($enrollment),
            ],
            'enrollment_date' => ['required', 'date'],
            'status' => ['required', 'string', 'max:255'],
            'year_level' => ['required', 'integer', 'between:1,4'],
        ], [
            'subject_id.unique' => 'This student is already enrolled in that subject.',
        ]);
    }
}
