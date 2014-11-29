<?php

class Store extends Eloquent {
    protected $table = "stores";
	protected $fillable = ["name", "description"];
    
    public function auctions(){
        return $this->hasMany('auctions');
    }
    
    public function orders(){
        return $this->hasMany('Order');
    }
    
    public function user(){
        return $this->belongsTo('User');
    }
    
    public function items(){
        return $this->belongsToMany('Item', 'stocks', 'store_id', 'item_id')->withPivot('quantity', 'price', 'type', 'promotion_rate');   
    }
}