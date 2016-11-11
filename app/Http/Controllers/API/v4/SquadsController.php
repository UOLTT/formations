<?php

namespace App\Http\Controllers\API\v4;

use App\Fleet;
use App\Squad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Validation\UnauthorizedException;

class SquadsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parameters = [
            'fleet_id' => 'integer',
            'formation_id' => 'integer',
            'name' => 'string',
            'status_id' => 'integer'
        ];
        $this->validate($request,$parameters);
        $Squad = new Squad();
        foreach ($parameters as $name => $type) {
            if ($request->has($name)) {
                $Squad = $Squad->where($name,$request->get($name));
            }
        }
        return $Squad->get();
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
            'fleet_id' => 'integer|required',
            'formation_id' => 'integer',
            'name' => 'string|required',
            'status_id' => 'integer|required',
        ];
        $this->validate($request,$parameters);
        $Fleet = Fleet::with('organization','admiral')->findOrFail($request->get('fleet_id'));

        if (
            \Auth::user() ||
            ($Fleet->admiral->id != \Auth::user()->id) ||
            ($Fleet->organization->admin_user_id != \Auth::user()->id)
        ) {
            throw new UnauthorizedException("You do not have permission to create squadrons");
        }

        $Squad = new Squad();
        foreach ($parameters as $name => $type) {
            if ($request->has($name)) {
                $Squad->$name = $request->get('name');
            }
        }
        $Squad->save();
        return $this->show($Squad->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Squad::with([
            'fleet' => function($query) {
                $query->with('status');
            },
            'status',
            'users',
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
        $parameters = [
            'formation_id' => 'integer',
            'name' => 'string',
            'status_id' => 'integer'
        ];
        $this->validate($request,$parameters);
        $Squad = Squad::with('fleet')->findOrFail($id);

        if (
            \Auth::user() ||
            ($Squad->squad_leader_id != \Auth::user()->id) ||
            ($Squad->fleet->admiral->id != \Auth::user()->id) ||
            ($Squad->fleet->organization->admin_user_id != \Auth::user()->id)
        ) {
            throw new UnauthorizedException("You do not have permission to create squadrons");
        }

        foreach ($parameters as $item => $rule) {
            if ($request->has($item)) {
                $Squad->$item = $request->get($item);
            }
        }
        $Squad->save();
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
        $Squad = Squad::with(['fleet'=>function($query) {
            $query->with('organization');
        }])->findOrFail($id);
        if (
            \Auth::user() ||
            ($Squad->squad_leader_id != \Auth::user()->id) ||
            ($Squad->fleet->admiral->id != \Auth::user()->id) ||
            ($Squad->fleet->organization->admin_user_id != \Auth::user()->id)
        ) {
            throw new UnauthorizedException("You do not have permission to create squadrons");
        }
        $Squad->delete();
    }
}
