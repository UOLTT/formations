<?php

namespace App\Http\Controllers\API\v4;

use App\Fleet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class FleetsController extends Controller
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
        // TODO ensure correct permissions
        // TODO set org based on users org
        $variables = [
            'name' => 'required|string',
            'organization_id' => 'required|integer',
            'status_id' => 'integer',
            'manifesto' => 'string'
        ];
        $this->validate($request, $variables);
        $Fleet = new Fleet();
        foreach ($variables as $name => $validation) {
            if ($request->has($name)) {
                $Fleet->$name = $request->get($name);
            }
        }
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
        $Fleet = Fleet::findOrFail($id);
        $this->validate($request,[
            'name' => 'string',
            'status_id' => 'integer',
            'manifesto' => 'string'
        ]);
        foreach (['name','status_id','manifesto'] as $item) {
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
        // TODO ensure the user can actually delete the object
        $Fleet = Fleet::findOrFail($id);
        $Fleet->delete();
        return $Fleet;
    }
}
