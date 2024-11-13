<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreRequest;
use App\Http\Requests\Customer\UpdateRequest;
use App\Models\Customer\Customer;
use App\Objects\Customer\CustomerFilterObject;
use App\Objects\Customer\CustomerObject;
use App\Services\Customer\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    protected CustomerService $customerService;


    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Müşteriler');
        return view('pages.customer.index');
    }

    public function listWithDatatable(DataTables $dataTables, Request $request)
    {
        $filter = (new CustomerFilterObject())->initFromRequest($request);
        return $dataTables->eloquent($this->customerService->list($filter))->toJson();
    }

    public function select(Request $request)
    {
        try {
            $filter = new CustomerFilterObject();
            $filter->initFromRequest($request);
            return response()->json(['status' => 200, 'data' => $this->customerService->select($filter)->get()], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $object = new CustomerObject();
            $object->initFromRequest($request)->setCreatedBy(Auth::id());
            $this->customerService->store($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,int $id)
    {
        if ($request->ajax()) {
            try {
                return response()->json(['status' => 201, 'data' => $this->customerService->list(new CustomerFilterObject($id))->first()], 201);
            }
            catch (\Throwable $th){
                return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Customer $customer)
    {
        try {
            $object = new CustomerObject();
            $object->initFromRequest($request)->setCustomer($customer)->setUpdatedBy(Auth::id());
            $this->customerService->update($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $this->customerService->destroy((new CustomerObject())->setCustomer($customer)->setDeletedBy(Auth::id()));
            return response()->json(['status' => 200, 'message' => 'Müşteri silindi!'], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
