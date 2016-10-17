<?php

namespace App\Http\Controllers\API\v4;

use App\Organization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class OrganizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // TODO ensure model is up to date
        $parameters = [
            'name' => 'string',
            'domain' => 'string',
            'admin_user_id' => 'integer',
            'status_id' => 'integer',
        ];
        $this->validate($request,$parameters);
        $Organizations = Organization::withCount('fleets','users','squads');
        foreach ($parameters as $name => $type) {
            if ($request->has($name)) {
                $Organizations = $Organizations->where($name,$request->get($name));
            }
        }
        return $Organizations->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parameters = [
            'name' => 'string|required',
            'domain' => 'string',
            'status_id' => 'integer|required',
            'manifesto' => 'string'
        ];
        $this->validate($request,$parameters);
        $Organization = new Organization();
        foreach ($parameters as $name => $type) {
            if ($request->has($name) && $name != 'domain') {
                $Organization->$name = $request->get('name');
            }
        }
        if ($request->has('domain')) {
            $Organization->domain = strtolower(str_replace(' ','',$request->get('domain')));
        }else {
            $Organization->domain = strtolower(str_replace(' ','',$request->get('name')));
        }
        $Organization->save();
        return $Organization;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // TODO admin user?
        $status = function($query) {
            $query->with('status');
        };
        return Organization::with([
            'users',
            'fleets' => $status,
            'squads' => $status
        ])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TODO if changing admin user, make sure user owns the org
        $parameters = [
            'name' => 'string',
            'domain' => 'string',
            'admin_user_id' => 'integer',
            'status_id' => 'integer',
            'manifesto' => 'string'
        ];
        $Organization = Organization::findOrFail($id);
        $this->validate($request,$parameters);
        foreach ($parameters as $name => $type) {
            if ($request->has($name)) {
                $Organization->$name = $request->get('name');
            }
        }
        return $Organization;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO make sure user can delete org
        Organization::findOrFail($id)->delete();
    }
}
