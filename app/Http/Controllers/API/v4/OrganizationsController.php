<?php

namespace App\Http\Controllers\API\v4;

use App\Organization;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(),$parameters);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Form validation failed, see the documentation');
        }

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
        $validator = Validator::make($request->all(),$parameters);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Form validation failed, see the documentation');
        }

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
        $Organization = Organization::findOrFail($id);
        if (!\Auth::user() || \Auth::user()->id != $Organization->admin_user_id) {
            throw new UnauthorizedException("You do not have permission to edit this Organization");
        }
        $parameters = [
            'name' => 'string',
            'domain' => 'string',
            'admin_user_id' => 'integer',
            'status_id' => 'integer',
            'manifesto' => 'string'
        ];
        $validator = Validator::make($request->all(),$parameters);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Form validation failed, see the documentation');
        }

        foreach ($parameters as $name => $type) {
            if ($request->has($name)) {
                $Organization->$name = $request->get($name);
            }
        }
        $Organization->save();
        return $this->show($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Organization = Organization::findOrFail($id);
        if (!\Auth::user() || \Auth::user()->id != $Organization->admin_user_id) {
            throw new UnauthorizedException("You do not have permission to delete this Organization");
        }
        $Organization->delete();
        return $Organization;
    }
}
