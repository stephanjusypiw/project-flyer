<?php

namespace App\Http\Controllers;

use App\Flyer;
// use App\Http\Controllers\MyTraits\AuthorizesUsers;
use App\Http\Requests\ChangeFlyerRequest;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\FlyerRequest;
use App\Http\Controllers\Controller;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FlyersController extends Controller
{


  //  use AuthorizesUsers;
    /**
     * FlyersController constructor.
     */
    public function __construct()
    {
        // everybody must be authenticated to access the methods
        // except for the show method
        $this->middleware('auth', ['except' => ['show']]);

        parent::__construct();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('flyers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FlyerRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlyerRequest $request)
    {

        Flyer::create($request->all());

        flash()->success('Success!' , 'Your Flyer has been created');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param $zip
     * @param $street
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show($zip, $street)
    {
        $flyer = Flyer::locatedAt($zip, $street);



        return view('flyers.show', compact('flyer'));
    }


    /**
     * @param $zip
     * @param $street
     * @param ChangeFlyerRequest $request
     */
    public function addPhoto($zip, $street, ChangeFlyerRequest $request)
    {

//        $this->validate($request, [
//            'photo' =>  'required|mimes:jpg,jpeg,png,bmp'
//        ]);
//
//
//        if(! $this->userCreatedFlyer($request))
//        {
//             return $this->unauthorized($request);
//        }

        $photo = $this->makePhoto($request->file('photo'));

        // fix this.....
       Flyer::locatedAt($zip, $street)->addPhoto($photo);

    }



    /**
     *
     *
     * @param UploadedFile $file
     * @return mixed
     */
    protected function makePhoto(UploadedFile $file){

        //get new photo object with current name
        return Photo::named($file->getClientOriginalName())
                ->move($file);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
