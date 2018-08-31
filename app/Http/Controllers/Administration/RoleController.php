<?php namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Authorizable;
use App\Http\Controllers\Controller;
use App\Http\Resources\Auth\RolesResource;
use App\Plugins\Administration\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new RolesResource(Role::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Extensions\Administration\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show( Role $role )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Extensions\Administration\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit( Role $role )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Extensions\Administration\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Role $role )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Extensions\Administration\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy( Role $role )
    {
        //
    }
}
