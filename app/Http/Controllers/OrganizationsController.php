<?php

namespace App\Http\Controllers;

use App\Organization;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Database\Eloquent\Collection;
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
        $Organizations = Organization::withCount('users')->with('status');

        if (!empty($request->all())) {
            Debugbar::addMessage($request->all(), 'request');
        }
        if ($request->has('name')) {
            $Organizations = $Organizations->where('name','like','%'.$request->get('name').'%');
        }
        if ($request->has('status')) {
            $Organizations = $Organizations->where('status_id',$request->get('status'));
        }

        $Organizations = $Organizations->orderBy('users_count','desc')->get();

        return view('organizations.index')
            ->with('request', $request)
            ->with('Organizations', $Organizations);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Organization = Organization::withCount('users','fleets','squads')->findOrFail($id);
        return view('organizations.show')->with('Organization',$Organization);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
