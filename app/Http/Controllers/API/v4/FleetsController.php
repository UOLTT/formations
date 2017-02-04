<?php

namespace App\Http\Controllers\API\v4;

use App\Fleet;
use App\Http\Controllers\API\ApiController;
use App\Organization;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Support\Facades\Validator;

class FleetsController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parameters = [
            'name' => 'string',
            'organization_id' => 'integer',
            'status_id' => 'integer',
        ];
        // TODO maybe search by user count?

        $this->validate($request,$parameters);

        $Fleets = new Fleet();
        foreach ($parameters as $search => $type) {
            if ($request->has($search)) {
                $Fleets = $Fleets->where($search,$request->get($search));
            }
        }
        return $Fleets->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // makes sure user logged in and owns an org
        if (!\Auth::user() || (Organization::where('admin_user_id',\Auth::user()->id)->count() == 0)) {
            throw new UnauthorizedException("You must own an Organization in order to create a Fleet");
        }

        $variables = [
            'name' => 'required|string',
            'status_id' => 'required|integer',
            'manifesto' => 'string',
            'admiral_id' => 'integer'
        ];

        $this->validate($request,$variables);

        $Fleet = new Fleet();
        if ($request->has('admiral_id')) {
            $Fleet->admiral_id = $request->get('admiral_id');
        }else {
            $Fleet->admiral_id = \Auth::user()->id;
        }
        $Fleet->name = $request->get('name');
        $Fleet->organization()->associate(\Auth::user()->organization->id);
        $Fleet->status()->associate($request->get('status_id'));
        if ($request->has('manifesto')) { $Fleet->manifesto = $request->get('manifesto'); }

        $Fleet->save();
        return $Fleet;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Fleet::with([
            'organization' => function ($query) {
                $query->with('status');
            },
            'status',
            'squads' => function($query) {
                $query->with('status');
            }
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
        $Fleet = Fleet::with('organization','admiral')->findOrfail($id);
        if (!\Auth::user() || ((\Auth::user()->id != $Fleet->admiral->id) && (\Auth::user()->id != $Fleet->organization->admin_user_id))) {
            throw new UnauthorizedException("You do not have permission to edit this fleet");
        }

        $parameters = [
            'name' => 'string',
            'admiral_id' => 'integer',
            'status_id' => 'integer',
            'manifesto' => 'string'
        ];

        $this->validate($request,$parameters);

        foreach ($parameters as $item => $validation) {
            if ($request->has($item)) {
                $Fleet->$item = $request->get($item);
            }
        }
        $Fleet->save();
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
        $Fleet = Fleet::with('organization','admiral')->findOrfail($id);
        if (!\Auth::user() || ((\Auth::user()->id != $Fleet->admiral->id) && (\Auth::user()->id != $Fleet->organization->admin_user_id))) {
            throw new UnauthorizedException("You do not have permission to disband this fleet");
        }
        $Fleet->delete();
        return $Fleet;
    }
}
