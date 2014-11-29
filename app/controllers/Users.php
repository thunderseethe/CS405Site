<?php

class Users extends \BaseController {

    
    public function login(){
        return View::make('users.login');   
    }
    public function handleLogin(){
        $data = Input::only(['username', 'password']);
        $validator = Validator::make(
            $data,
            [
                'username'=>'required',
                'password'=>'required'
            ]
        );
        if($validator->fails()){
            return Redirect::route('login')->withErrors($validator)->withInput();
        }
        if(Auth::attempt(['username'=>$data['username'], 'password'=>$data['password']])){
            Session::put('cart', array());
            return Redirect::to('/');
        }
        return Redirect::route('login')->withInput();
    }
    public function logout(){
        if(Auth::check()){
            Session::flush();
            Auth::logout();
        }
        return Redirect::to('login');
    }
    
    public function orders(){
        $order = Order::where('user_id', '=', Auth::user()->id)->with(array('user', 'items', 'store'))->get();
        $data['orders'] = $order;
        $data['active_order'] = true;
        return View::make('users.orders')->with('data', $data);
    }
    
    public function bids(){
        $bid = Bid::where('user_id', '=', Auth::user()->id)->with(array('auction', 'user'))->get();
        $data['bids'] = $bid;
        $data['active_bid'] = true;
        return View::make('users.bids')->with('data', $data);
    }
    
    public function profile(){
        return View::make('users.profile');
    }
	/**
	 * Display a listing of the resource.
	 * GET /users
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /users/create
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('users.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /users
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::only(['first_name', 'last_name', 'username', 'password', 'password_confirmation']);
        $validator = Validator::make(
            $data,
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]
        );
        if($validator->fails()){
            return Redirect::route('user.create')->withErrors($validator)->withInput();
        }
        $data['password'] = Hash::make($data['password']);
        $newUser = User::create($data);
        if($newUser){
            Auth::login($newUser);
            return Redirect::route('profile');
        }
        return Redirect::route('user.create')->withInput();
	}

	/**
	 * Display the specified resource.
	 * GET /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /users/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /users/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}