<?php

namespace App\Http\Controllers;

use App\City;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Session\TokenMismatchException;
Use DB;
use DataTables;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

           return view('user.user_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // $city = City::pluck('name','id')->toArray();
         return view('user.user_create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
         
         $this->validate($request, array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'street' => 'required',
            'profile_pic' => 'required',
            'zip_code' => 'required|numeric|min:6',
            'city' => 'required'
        ));

       
        $imageName = time().'.'.request()->profile_pic->getClientOriginalExtension();
        request()->profile_pic->move(public_path('user_image'), $imageName);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->street = $request->street;
        $user->profile_pic = $imageName;   
        $user->zip_code = $request->zip_code;
        $user->city = $request->city;
        $user->save();

         return redirect('/user')->with('message', 'User Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        User::find($id)->delete();
        return redirect('/user')->with('message', 'Successfully User Delete!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::where('id', $id)->first();
        $city = City::where('name',$user->city)->pluck('name','id')->toArray();
        return view('user.user_edit', compact('user','city'));
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


         $this->validate($request, array(
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'street' => 'required',
            'zip_code' => 'required|numeric|min:6',
            'city' => 'required'
        ));


         $data = $request->all();

        if(!empty($data['profile_pic'])){
            $imageName = time().'.'.request()->profile_pic->getClientOriginalExtension();
        request()->profile_pic->move(public_path('user_image'), $imageName);
        }else{
            $imageName = $data['old_image'];
        }


        $user = User::where('id',$id)->first();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->street = $request->street;
        $user->profile_pic = $imageName;   
        $user->zip_code = $request->zip_code;
        $user->city = $request->city;
        $user->save();

        return redirect('/user')->with('message', 'Successfully User Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {    

    }

      /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userDatatable(Request $request)
    {
    
         
    if ($request->ajax()) {
      
        $data = User::select(['id','first_name','last_name','profile_pic','email','street','zip_code','city'])->newQuery();
    
         return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('profile_pic', function($row){
                    $profile_pic = "<img class='form-control' src=" .asset('/user_image/'.$row->profile_pic.'') .">";
                    return $profile_pic;
                })
                ->addColumn('action', function($row){
                     $btn = '<a href="' . route('user.edit', $row->id) .'" class="btn btn-primary btn-flat">EDIT</a>
                     <a href="' . route('user.destroy',$row->id) .'" class="btn btn-danger btn-flat">DELETE</a>';
                    return $btn;
                })
                ->rawColumns(['profile_pic','action'])
                ->make(true);
          }
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cityList(Request $request)
    {
    
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("cities")
                    ->select("id","name")
                    ->where('name','LIKE',"%$search%")
                    ->get();

        }

        return response()->json($data);
    }

   
}