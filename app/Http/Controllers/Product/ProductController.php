<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Models\Product\Product;
use App\Objects\Product\ProductFilterObject;
use App\Objects\Product\ProductObject;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Ürünler');
        return view('pages.product.index');
    }


    public function listWithDatatable(DataTables $dataTables, Request $request)
    {
        $filter = (new ProductFilterObject())->initFromRequest($request);
        return $dataTables->eloquent($this->productService->list($filter))->toJson();
    }

    public function select(Request $request)
    {
        try {
            $filter = new ProductFilterObject();
            $filter->initFromRequest($request);
            return response()->json(['status' => 200, 'data' => $this->productService->select($filter)->get()], 200);
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
            $object = new ProductObject();
            $object->initFromRequest($request)->setCreatedBy(Auth::id());
            $this->productService->store($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        if ($request->ajax()) {
            try {
                return response()->json(['status' => 201, 'data' => $this->productService->list(new ProductFilterObject($id))->first()], 201);
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
    public function update(Request $request, Product $product)
    {
        try {
            $object = new ProductObject();
            $object->initFromRequest($request)->setProduct($product)->setDeletedBy(Auth::id());
            $this->productService->update($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $this->productService->destroy((new ProductObject())->setProduct($product)->setDeletedBy(Auth::id()));
            return response()->json(['status' => 200, 'message' => 'Rol silindi!'], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
