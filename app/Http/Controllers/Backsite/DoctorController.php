<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;

// use library here
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

// use everything here
use Gate;
use Auth;
use File;

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

        // re format before push to table
        $data['fee'] = str_replace(',', '', $data['fee']);
        $data['fee'] = str_replace('IDR ', '', $data['fee']);

        // upload process here
        // cek if file exist
        $path = public_path('app/public/assets/file-doctor');
        if(!File::isDirectory($path)) {
        // if exist then create folder
            $response = Storage::makeDirectory('public/assets/file-doctor');
        }

        // if file exists its time to store photo
        if(isset($data['photo'])){
            $data['photo'] = $request->file('photo')->store(
                'assets/file-doctor', 'public'
            );
        }else{
            $data['photo'] = "";
        }

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
        // get all request from frontsite
        $data = $request->all();

        // re format before push to table
        $data['fee'] = str_replace(',', '', $data['fee']);
        $data['fee'] = str_replace('IDR ', '', $data['fee']);

        // upload process here
        // change format photo
        if(isset($data['photo'])){

             // first checking old photo to delete from storage
            $get_item = $doctor['photo'];

            // change file locations
            $data['photo'] = $request->file('photo')->store(
                'assets/file-doctor', 'public'
            );

            // delete old photo from storage
            $data_old = 'storage/'.$get_item;
            if (File::exists($data_old)) {
                File::delete($data_old);
            }else{
                File::delete('storage/app/public/'.$get_item);
            }

        }

        // update to database
        $doctor->update($data);

        alert()->success('Success Message', 'Successfully updated doctor');
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
