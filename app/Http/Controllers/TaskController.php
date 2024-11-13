<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Task;
use App\Objects\Task\TaskFilterObject;
use App\Objects\Task\TaskObject;
use App\Services\Task\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Görevler');
        return view('pages.task.index');
    }

    public function listWithDatatable(DataTables $dataTables, Request $request)
    {
        $filter = (new TaskFilterObject())->initFromRequest($request);
        return $dataTables->eloquent($this->taskService->list($filter))->toJson();
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
            $object = new TaskObject();
            $object->initFromRequest($request)->setCreatedBy(Auth::id());
            $this->taskService->store($object);
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
                return response()->json(['status' => 201, 'data' => $this->taskService->list(new TaskFilterObject($id))->first()], 201);
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
    public function update(UpdateRequest $request, Task $task)
    {
        try {
            $object = new TaskObject();
            $object->initFromRequest($request)->setTask($task)->setUpdatedBy(Auth::id());
            $this->taskService->update($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $this->taskService->destroy((new TaskObject())->setTask($task)->setDeletedBy(Auth::id()));
            return response()->json(['status' => 200, 'message' => 'Görev silindi!'], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
