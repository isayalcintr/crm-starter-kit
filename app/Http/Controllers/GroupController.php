<?php

namespace App\Http\Controllers;

use App\Enums\Group\SectionEnum;
use App\Enums\Group\TypeEnum;
use App\Http\Requests\Group\StoreRequest;
use App\Http\Requests\Group\UpdateRequest;
use App\Models\Group;
use App\Objects\Group\GroupFilterObject;
use App\Objects\Group\GroupObject;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GroupController extends Controller
{
    protected GroupService $groupService;

    public function __construct(GroupService $groupService){
        $this->groupService = $groupService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle("Group Yönetimi");
        return view('pages.group.index');
    }

    public function listWithDatatable(DataTables $dataTables , Request $request)
    {
        $filter = new GroupFilterObject();
        $filter->initFromRequest($request);
        return $dataTables->eloquent($this->groupService->list($filter))->toJson();
    }

    public function select(Request $request)
    {
        try {
            $filter = new GroupFilterObject();
            $filter->initFromRequest($request);
            return response()->json(['status' => 200, 'data' => $this->groupService->select($filter)->get()], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    public function selectSection(Request $request)
    {
        return response()->json(['status' => 200, 'data' => collect(SectionEnum::cases())->map(function ($section){
            return (object)['id' => $section->value, 'text' => SectionEnum::getLabel($section->value)];
        })], 200);
    }

    public function selectType(int $section)
    {
        try {
            return response()->json(['status' => 200, 'data' => collect(TypeEnum::cases())
                ->filter(function ($type) use ($section){
                    return TypeEnum::getSection($type->value)->value == $section;
                })
                ->map(function ($type){
                    return (object)['id' => $type->value, 'text' => TypeEnum::getLabel($type->value)];
                })->values()], 200);
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
            $object = new GroupObject();
            $object->initFromRequest($request);
            $this->groupService->store($object);
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
                return response()->json(['status' => 201, 'data' => $this->groupService->list(new GroupFilterObject($id))->first()], 201);
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
    public function update(UpdateRequest $request, Group $group)
    {
        try {
            $object = new GroupObject();
            $object->initFromRequest($request)->setGroup($group);
            $this->groupService->update($object);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        try {
            if ($group->is_system)
                return response()->json(['status' => 403, 'message' => 'Sistem grubu silinemez!'], 403);
            $this->groupService->destroy($group);
            return response()->json(['status' => 200, 'message' => 'Rol silindi!'], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
