<?php

class Bid extends \Eloquent {
    protected $table = 'bids';
	protected $fillable = ["amount", "date"];
    
    public function user(){
        return $this->belongsTo('User');
    }
    
    public function Auction(){
        return $this->belongsTo('Auction');
    }
}