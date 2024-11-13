<?php

namespace App\Http\Controllers;

use App\Http\Requests\Interview\StoreRequest;
use App\Models\Interview;
use App\Objects\Interview\InterviewFilterObject;
use App\Objects\Interview\InterviewObject;
use App\Objects\Product\ProductFilterObject;
use App\Services\Interview\InterviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class InterviewController extends Controller
{
    protected InterviewService $interviewService;

    public function __construct(InterviewService $interviewService)
    {
        $this->interviewService = $interviewService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Görüşmeler');
        return view('pages.interview.index');
    }

    public function listWithDatatable(DataTables $dataTables, Request $request)
    {
        $filter = (new InterviewFilterObject())->initFromRequest($request);
        return $dataTables->eloquent($this->interviewService->list($filter))->toJson();
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
            $object = new InterviewObject();
            $object->initFromRequest($request)->setCreatedBy(Auth::id());
            $this->interviewService->store($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        if ($request->ajax()) {
            try {
                return response()->json(['status' => 201, 'data' => $this->interviewService->list(new InterviewFilterObject($id))->first()], 201);
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
    public function update(Request $request, Interview $interview)
    {
        try {
            $object = new InterviewObject();
            $object->initFromRequest($request)->setInterview($interview)->setUpdatedBy(Auth::id());
            $this->interviewService->update($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interview $interview)
    {
        try {
            $this->interviewService->destroy((new InterviewObject())->setInterview($interview)->setDeletedBy(Auth::id()));
            return response()->json(['status' => 200, 'message' => 'Görüşme silindi!'], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
