<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $companies = Company::latest()->paginate(10);
        
        return Inertia::render('Company/Index', [
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return Inertia::render('Company/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request, CompanyService $companyService)
    {
        //
        $data = $request->validated();

        return $companyService->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
        return Inertia::render('Company/Edit', [
            'company' => $company
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company, CompanyService $companyService)
    {
        //
        $data = $request->validated();

        return $companyService->update($company, $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company, CompanyService $companyService)
    {
        //
        return $companyService->delete($company);
    }
}
