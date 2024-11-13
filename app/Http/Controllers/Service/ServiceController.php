<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreRequest;
use App\Http\Requests\Service\UpdateRequest;
use App\Models\Service\Service;
use App\Objects\Service\ServiceFilterObject;
use App\Objects\Service\ServiceObject;
use App\Services\Service\ServiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
    protected ServiceService $serviceService;

    public function __construct(ServiceService $serviceService){
        $this->serviceService = $serviceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Servisler');
        return view('pages.service.index');
    }

    public function listWithDatatable(DataTables $dataTables, Request $request)
    {
        $filter = (new ServiceFilterObject())->initFromRequest($request);
        return $dataTables->eloquent($this->serviceService->list($filter))->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        setPageTitle("Servis Ekle");
        return view('pages.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $object = new ServiceObject();
            $object->initFromRequest($request)->setCreatedBy(Auth::id());
            $this->serviceService->store($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        setPageTitle("Servis Düzenle - " . $service->getAttribute('code'));
        View::share(['_pageData' => [
            "service" => $service,
            "items" => $service->items()->with('product')->get(),
        ]]);
        return view('pages.service.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Service $service)
    {
        try {
            $object = new ServiceObject();
            $object->initFromRequest($request)->setService($service)->setUpdatedBy(Auth::id());
            $this->serviceService->update($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        try {
            $this->serviceService->destroy((new ServiceObject())->setService($service)->setDeletedBy(Auth::id()));
            return response()->json(['status' => 200, 'message' => 'Servis silindi!'], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
