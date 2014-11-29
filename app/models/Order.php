<?php

class Order extends \Eloquent {
    protected $table = 'orders';
	protected $fillable = ['user_id', 'store_id','date', 'status'];
    
    public function user(){
        return $this->belongsTo('User');
    }
    
    public function store()
    {
        return $this->belongsTo('Store');
    }
    
    public function items(){
        return $this->belongsToMany('Item', 'ordereditems', 'order_id', 'item_id')->withPivot('quantity', 'price');
    }
    
    public function total(){
        $sum = 0;
        foreach($this->items as $item){
            $sum += $item->pivot->price * $item->pivot->quantity;
        }
        return $sum;
    }
}