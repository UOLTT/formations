<?php

namespace App\Http\Controllers\API\v4;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class UsersController extends Controller
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
            'email' => 'string',
            'organization_id' => 'integer',
            'squad_id' => 'integer'
        ];
        $this->validate($request,$parameters);
        $User = new User();
        foreach ($parameters as $name => $rule) {
            if ($request->has($name)) {
                $User = $User->where($name,$request->get($name));
            }
        }
        return $User->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parameters = [
            'name' => 'string|required',
            'email' => 'email|required|unique',
            'password' => 'string|required',
            'organization_id' => 'integer',
            'squad_id' => 'integer'
        ];
        $this->validate($request,$parameters);
        $User = new User();
        foreach ($parameters as $name => $rule) {
            if ($request->has($name) && $name != 'password') {
                $User->$name = $request->get($name);
            }
        }
        $User->password = \Hash::make($request->get('password'));
        $User->save();
        return $User;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::with('organization','ships')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TODO make sure the user has the correct permissions to edit self
        $parameters = [
            'name' => 'string',
            'email' => 'email|unique',
            'password' => 'string',
            'organization_id' => 'integer',
            'squad_id' => 'integer'
        ];
        $this->validate($request,$parameters);
        $User = User::findOrFail($id);
        foreach ($parameters as $name => $rule) {
            if ($request->has($name)) {
                $User->$name = $request->get($name);
            }
        }
        $User->save();
        return $this->show($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO ensure correct permissions
        $User = User::findOrFail($id);
        $User->delete();
        return $User;
    }
}
