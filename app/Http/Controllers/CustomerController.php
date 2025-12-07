<?php

namespace App\Http\Controllers;


use App\Domain\Customer\UseCases\CetCustomer;
use App\Domain\Customer\UseCases\CreateCustomer;
use App\Domain\Customer\UseCases\DeleteCustomer;
use App\Domain\Customer\UseCases\UpdateCustomer;
use App\Helper\ApiResource;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @docs  this prefict used  this dpandancy inection (CreateCustomer $useCase)
     * CreateCustomer  use in constructor CustomerRepository this providor registerd -> (adapter) EloquentCustomerRepository
     * her Isolited UseCase and Isolated Entite Domain is Isolied this arch Nice :)
     */
    public function store(CustomerRequest $request, CreateCustomer $useCase)
    {
        $useCase->execute($request->name, $request->email);
        return ApiResource::setSchema(new CustomerResource([]), "Successfully Created Customer", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id, CetCustomer $useCase)
    {
        $customer = $useCase->execut($id);
        if($customer)
            return ApiResource::setSchema(new CustomerResource($customer), "Retreved Data Successfully!.",200);
        return ApiResource::setSchema(new CustomerResource([]), "Retreved Data Faulid!.",200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, int $id, UpdateCustomer $useCase)
    {
        $useCase->execut($id, $request->name, $request->email);
        return ApiResource::setSchema(new CustomerResource([]), "Customer Updated Successfully", 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id,  DeleteCustomer $useCase)
    {
        $useCase->execut($id);
        return ApiResource::setSchema(new CustomerResource([]), "Customer Deleted Successfully", 200);
    }
}
