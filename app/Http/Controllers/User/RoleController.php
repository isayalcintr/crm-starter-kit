<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Objects\Role\RoleFilterObject;
use App\Objects\Role\RoleObject;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Exceptions\Exception;

class RoleController extends Controller
{
    protected RoleService $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle("Roller");
        return view('pages.role.index');
    }

    /**
     * @throws Exception
     */
    public function listWithDatatable(DataTables $dataTables, Request $request)
    {
        $search = $request->input('search', '');
        return $dataTables->eloquent($this->roleService->list(
                                            (new RoleFilterObject())
                                                    ->setSearch($search))
                                        )->toJson();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        setPageTitle("Rol Ekle");
        return view('pages.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $roleObject = new RoleObject();
            $roleObject->setName($request->name);
            $roleObject->setPermissions($request->permissions);
            $this->roleService->store($roleObject);
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
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        setPageTitle("Rol Düzenle - " . $role->name);
        View::share(['_pageData' => [
            "role" => $role
        ]]);
        return view('pages.role.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Role $role)
    {
        try {
            $roleObject = new RoleObject();
            $roleObject->setRole($role)->setId($role->id)->setName($request->name)->setPermissions($request->permissions);
            $this->roleService->update($roleObject);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            if ($role->id == 1 || $role->name == "admin")
                return response()->json(['status' => 403, 'message' => 'Admin rolü silinemez!'], 403);
            $this->roleService->destroy($role);
            return response()->json(['status' => 200, 'message' => 'Rol silindi!'], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
