<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class EmployeeService
{
    public function store($data)
    {
        try {
            Employee::create($data);

            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }
    public function update($employee, $data)
    {
        try {
            $employee->update($data);

            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }
    public function delete($employee)
    {
        try {
            $employee->delete();
            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }
}
