<?php

class Auction extends \Eloquent{
    protected $table = 'auctions';
    protected $fillable = ["end", "status"];
    
    public function item(){
        return $this->belongsTo('Item');   
    }
    
    public function store(){
        return $this->belongsTo('Store');   
    }
    
    public function bids(){
        return $this->hasMany('Bid');   
    }
    
    public function highest_bid(){
        $max = $this->bids->max('amount');
        if(!$max){
            $max = 0;   
        }
        return $max;   
    }
}