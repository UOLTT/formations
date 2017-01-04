<?php

namespace App\Http\Controllers\API\v4;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // TODO make sure this is up to date
        $parameters = [
            'name' => 'string',
            'email' => 'string',
            'organization_id' => 'integer',
            'squad_id' => 'integer'
        ];
        $validator = Validator::make($request->all(),$parameters);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Form validation failed, see the documentation');
        }

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
            'fleet_id' => 'integer',
            'squad_id' => 'integer'
        ];
        $validator = Validator::make($request->all(),$parameters);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Form validation failed, see the documentation');
        }

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
        return User::with('organization','fleet','squad','ships')->findOrFail($id);
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
        if (!\Auth::user() || \Auth::user()->id != $id) {
            throw new UnauthorizedException("You do not have permission to modify this user");
        }
        $parameters = [
            'name' => 'string',
            'email' => 'email|unique',
            'password' => 'string',
            'organization_id' => 'integer',
            'fleet_id' => 'integer',
            'squad_id' => 'integer',
            'ships' => 'array',
            'active_ship.user_id' => 'integer',
            'active_ship.ship_id' => 'integer',
            'station_id' => 'integer'
        ];
        $validator = Validator::make($request->all(),$parameters);
        if ($validator->fails()) {
            throw new \InvalidArgumentException('Form validation failed, see the documentation');
        }

        $User = User::findOrFail($id);
        foreach ($parameters as $name => $rule) {
            if (strpos($name,'.') !== false) {
                continue;
            }elseif ($request->has($name)) {
                if ($name == "ships") {
                    $User->ships()->sync($request->get($name));
                }else {
                    $User->$name = $request->get($name);
                }
            }
        }
        if ($request->has('active_ship')) {
            $User->active_ship = (object)$request->get('active_ship');
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
        if (!\Auth::user() || \Auth::user()->id != $id) {
            throw new UnauthorizedException("You do not have permission to delete that user");
        }
        $User = User::findOrFail($id);
        $User->delete();
        return $User;
    }
}
