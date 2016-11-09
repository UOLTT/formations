<?php

namespace App\Http\Controllers\API\v4;

use App\Squad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

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
            'fleet_id' => 'integer',
            'status_id' => 'integer|required',
            'name' => 'string|required',
        ];
        $this->validate($request,$parameters);
        $Squad = new Squad();
        foreach ($parameters as $name => $type) {
            if ($request->has($name)) {
                $Squad->$name = $request->get('name');
            }
        }
        $Squad->save();
        return $Squad;
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
        // TODO if changing admin user, make sure user owns the org
        $parameters = [
            'name' => 'string',
            'domain' => 'string',
            'admin_user_id' => 'integer',
            'status_id' => 'integer',
            'manifesto' => 'string'
        ];
        $Squad = Organization::findOrFail($id);
        $this->validate($request,$parameters);
        foreach ($parameters as $name => $type) {
            if ($request->has($name)) {
                $Squad->$name = $request->get('name');
            }
        }
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
        // TODO make sure user can delete org
        Organization::findOrFail($id)->delete();
    }
}
