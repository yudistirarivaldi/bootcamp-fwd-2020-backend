<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

// use library here
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

// use everything here
use Gate;
use Auth;

// use request
use App\Http\Requests\Doctor\StoreDoctorRequest;
use App\Http\Requests\Doctor\UpdateDoctorRequest;

// Models
use App\Models\MasterData\Specialist;
use App\Models\Operational\Doctor;


class DoctorController extends Controller
{
    // ALWAYS ADDED FOR AUTHENTICATION
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // do not bring access if
        abort_if(Gate::denies('doctor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // for table grid
        $doctor = Doctor::orderBy('created_at', 'desc')->get();

        // for select 2 = ascending A - Z
        $specialist = Specialist::orderBy('name', 'asc')->get();

        return view('pages.backsite.operasional.doctor.index', compact('doctor','specialist'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDoctorRequest $request)
    {

        // get all request from frontsite
        $data = $request->all();

        // store to database
        $doctor = Doctor::create($data);

        alert()->success('Success Message', 'Successfully added new doctor!');
        return redirect()->route('backsite.doctor.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        // do not bring access if
        abort_if(Gate::denies('doctor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('pages.backsite.operasional.doctor.show', compact('doctor'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {

        // do not bring access if
        abort_if(Gate::denies('doctor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // for select 2 = ascending A - Z
        $specialist = Specialist::orderBy('name', 'asc')->get();

        return view('pages.backsite.operasional.doctor.edit', compact('doctor', 'specialist'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDoctorRequest $request, Doctor $doctor)
    {
        // do not bring access if
        abort_if(Gate::denies('doctor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // get all request from frontsite
        $data = $request->all();

        // Update to database
        $doctor->update($data);

        alert()->success('Success Message', 'Successfully updated doctor!');
        return redirect()->route('backsite.doctor.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {

        // do not bring access if
        abort_if(Gate::denies('doctor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $doctor->delete();

        alert()->success('Success Message', 'Successfully deleted doctor!');
        return redirect()->route('backsite.doctor.index');
    }
}
