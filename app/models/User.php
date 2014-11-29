<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface {

	//use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
    protected $fillable = ['first_name','last_name','username','password', 'type'];
    
    //Relationships
    public function orders(){
        return $this->hasMany('Order');
    }
    
    public function bids(){
        return $this->hasMany('Bid');   
    }
    
    public function owns(){
        return $this->hasMany('Store');
    }

    public function getAuthIdentifier(){
    	return $this->id;
    }

    public function getAuthPassword(){
    	return $this->password;
    }

    public function getRememberToken(){
    	return $this->remember_token;
    }

    public function getRememberTokenName(){
    	return "remember_token";
    }

    public function setRememberToken($val){
    	$this->remember_token = $val;
    }
}
