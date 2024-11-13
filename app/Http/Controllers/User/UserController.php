<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Objects\Role\RoleFilterObject;
use App\Objects\User\UserFilterObject;
use App\Objects\User\UserObject;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Exceptions\Exception;

class UserController extends Controller
{
    protected UserService $userService;
    protected RoleService $roleService;

    public function __construct(UserService $userService,RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * @throws Exception
     */
    public function listWithDatatable(DataTables $dataTables, Request $request)
    {
        $filter = (new UserFilterObject())->initFromRequest($request);
        return $dataTables->eloquent($this->userService->list($filter))->toJson();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle("Kullanıcılar");
        return view('pages.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        View::share(["_pageData" => [
            "roleList" => $this->roleService->listWithSelect(new RoleFilterObject())->get(),
        ]]);
        setPageTitle("Kullanıcı Ekle");
        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $userObject = new UserObject();
            $userObject->initFromRequest($request);
            $this->userService->store($userObject);
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
    public function edit(User $user)
    {
        setPageTitle("Kullanıcı Düzenle - " . $user->nameSurname());
        View::share(['_pageData' => [
            "user" => $user,
            "roleList" => $this->roleService->listWithSelect(new RoleFilterObject())->get(),
        ]]);
        return view('pages.user.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        try {
            $userObject = new UserObject();
            $userObject->initFromRequest($request)->setUser($user);
            $this->userService->update($userObject);
            return response()->json(['status' => 201, 'message' => 'Başarılı şekilde oluşturuldu!'], 201);
        }
        catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $this->userService->destroy($user);
            return response()->json(['status' => 200, 'message' => 'Rol silindi!'], 200);
        }
        catch (\Throwable $th){
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
