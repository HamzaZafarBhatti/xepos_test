<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employees = Employee::with('company:id,name')->latest()->paginate(10);

        return Inertia::render('Employee/Index', [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $companies = Company::all()->pluck('name', 'id')->toArray();

        return Inertia::render('Employee/Create', [
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request, EmployeeService $employeeService)
    {
        //
        $data = $request->validated();

        return $employeeService->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
        $companies = Company::all()->pluck('name', 'id')->toArray();

        return Inertia::render('Employee/Edit', [
            'companies' => $companies,
            'employee' => $employee,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee, EmployeeService $employeeService)
    {
        //
        $data = $request->validated();

        return $employeeService->update($employee, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee, EmployeeService $employeeService)
    {
        //
        return $employeeService->delete($employee);
    }
}
