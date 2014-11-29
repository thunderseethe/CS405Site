<?php

class Bids extends \BaseController{
    public function add(){
        $store = Input::get('store');
        //$store = Store::find($store_id);
        $item = Input::get('item');
        //$item = Item::find($item_id);
        $amount = Input::get('amount');
        $auction = Auction::where('item_id', $item)->where('store_id', $store)->first();
        $user = Auth::user();
        $date = date("Y-m-d H:i:s", time());
        $bid = Bid::create(array("amount"=>$amount, "date"=>$date, "status"=>"Auction"));
        $bid->user()->associate($user);
        $bid->auction()->associate($auction);
        $bid->save();
        return Response::json(array("store"=>$store, "item"=>$item, "amount"=>money_format("%i", $amount)), 200);
    }
}