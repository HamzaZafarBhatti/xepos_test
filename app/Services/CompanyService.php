<?php

namespace App\Services;

use App\Events\CompanyCreated;
use App\Models\Company;
use Illuminate\Support\Facades\Log;

class CompanyService
{
    public function store($data)
    {
        try {
            //code...
            if ($image = $data['logo']) {
                $company = new Company();
                $filename = 'logo_' . time() . '.' . $image->getClientOriginalExtension();
                $location =  storage_path($company->getUploadPath() . $filename);
                move_uploaded_file($data['logo'], $location);
                $data['logo'] = $filename;
            }
            $company = Company::create($data);

            event(new CompanyCreated($company));

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
    public function update($company, $data)
    {
        try {
            if ($image = $data['logo']) {
                $filename = 'logo_' . time() . '.' . $image->getClientOriginalExtension();
                $location =  storage_path($company->getUploadPath() . $filename);
                move_uploaded_file($data['logo'], $location);
                $data['logo'] = $filename;
                if ($company->logo && file_exists(storage_path($company->getUploadPath() . $company->logo))) {
                    unlink(storage_path($company->getUploadPath() . $company->logo));
                }
            }
            $company->update($data);

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
    public function delete($company)
    {
        try {
            if ($company->logo && file_exists(storage_path($company->getUploadPath() . $company->logo))) {
                unlink(storage_path($company->getUploadPath() . $company->logo));
            }
            $company->delete();
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
