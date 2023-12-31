<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::select('employees.id', 'employees.name', 'employees.email', 'employees.phone', 'employees.department_id', 'departments.name as department')
        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->paginate(10);

        $departments = Department::all();        
        return Inertia::render('Employees/Index', ['employees' => $employees, 'departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|max:150',
            'phone' => 'required|max:150',
            'department_id' => 'required|max:150'
        ]);
        $employee = new Employee($request->input());
        $employee->save();
        return redirect('employees');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|max:150',
            'phone' => 'required|max:150',
            'department_id' => 'required|max:150'
        ]);
        $employee->update($request->input());
        return redirect('employees');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('employees');
    }

    public function EmployeeByDepartment()
    {
        $data = Employee::select(DB::raw('count(employees.id) as count, departments.name'))
        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->groupBY('departments.name')
        ->get();
        return Inertia::render('Employees/Graphic', ['data' => $data]);
    }

    public function reports()
    {
        $employees = Employee::select('employees.id', 'employees.name', 'employees.email', 'employees.phone', 'employees.department_id', 'departments.name as department')
        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->get();
        $departments = Department::all();
        return Inertia::render('Employees/Reports', ['employees' => $employees, 'departments' => $departments]);
    }
}
