<?php

class Item extends Eloquent {
    protected $table = "items";
	protected $fillable = ["name", "description", "keywords"];
    
    public function auctions(){
        return $this->hasMany('Auction');
    }
    
    public function orders(){
        return $this->belongsToMany('Order', 'ordereditems', 'item_id', 'order_id')->withPivot('quantity', 'price');
    }
    
    public function store(){
        return $this->belongsToMany('Store', 'stocks', 'item_id', 'store_id')->withPivot('quantity', 'price', 'type', 'promotion_rate');
    }
    
    public function auction($store){
        return $this->hasOne('auction')->where('store_id', '=', $store)->first();   
    }
}