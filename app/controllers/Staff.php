<?php

class Staff extends \BaseController{
    public function inventory(){
        $id = User::where('type', '=', 4)->first()->id;
        if(Auth::user()->type == 2){
            $id = Auth::user()->id;
        }
        $store = Store::where('user_id', '=', $id)->with('items')->first();
        $data['items'] = $store->items;
        $data['active_store'] = true;
        return View::make('staff.inventory')->with('data', $data);
    }
    
    public function edit(){
        $num = Input::get('num');
        $id = Input::get('id');
        $user = User::where('type', '=', 4)->first();
        Store::where('user_id', '=', $user->id)->first()->items()->updateExistingPivot($id, ["quantity"=>$num]);
        return Response::json(["num"=>$num]);
    }
    
    public function orders(){
        $id = User::where('type', '=', 4)->first()->id;
        if(Auth::user()->type == 2){
            $id = Auth::user()->id;   
        }
        $store = Store::where('user_id', '=', $id)->first();
        $order = Order::where('store_id', '=', $store->id)->with(array('user','items'))->get();
        $data['orders'] = $order;
        $data['active_store'] = true;
        return View::make('staff.orders')->with('data', $data);
    }
    
    public function ship(){
        $oID = Input::get('id');
        $order = Order::find($oID);
        $o_items = $order->items;
        $o_ids = $o_items->lists('id');
        $user = User::where('type', '=', 4)->first();
        $s_items = Store::where('user_id', '=', $user->id)->first()->items;
        $error = array();
        $isError = false;
        $quant = array();
        for($i = 0; $i < $o_items->count(); $i++){
            $o_item = $o_items[$i];
            $s_item = $s_items->find($o_item->id);
            if($o_item->pivot->quantity > $s_item->pivot->quantity){
                $isError = true;
                $error = array("error" => true, "name" => $o_item->name, "max" => $s_item->pivot->quantity);
                return Response::json($error, 200);
            }
            $quant[$o_item->id] = $s_item->pivot->quantity - $o_item->pivot->quantity;
        }
        foreach($o_items as $item){
            Store::where('user_id', '=', $user->id)->first()->items()->updateExistingPivot($item->id, ["quantity"=>$quant[$item->id]]);
        }
        $order->status = "Shipped";
        $order->save();
        return Response::json(array("error"=>false));
    }
    
    public function bids(){
        $store = Store::where('user_id', Auth::user()->id)->first();
        $auctions = Auction::where('store_id', $store->id)->with(array('bids', 'bids.user','item', 'store'))->get();
        $data['auctions'] = $auctions;/*Bid::where('store_id', '=', $store->id)->with(array('user', 'store', 'item'))->get();*/
        return View::make('staff.bids')->with('data', $data);
    }
    
    public function auction(){
        $id = Input::get('id');
        $auction = Auction::find($id);
        $auction->status = "Shipped";
        $auction->save();
        return Response::json(array("error"=>false));
    }
    
    public function manage(){
        $store = Store::where('user_id', '=', Auth::user()->id)->first();
        $data = array();
        if(!$store){
            $data['create'] = true;
            $data['name'] = "";
            $data['description'] = "";
            $data['stock'] = false;
        }else{
            $data['create'] = false;
            $data['id'] = $store->id;
            $data['name'] = $store->name;
            $data['description'] = $store->description;
            $data['stock'] = $store->items;
        }
        return View::make('staff.manage')->with('data', $data);
    }
    
    public function store(){
        $create = Input::get('create');
        $name = Input::get('name');
        $desc = Input::get('description');
        $user = Auth::user();
        if($create){
            $store = Store::create(array("name"=>$name, "description"=>$desc));
            $store->user()->associate($user);
        }else{
            $store = Store::where('user_id', '=',  $user->id)->first();
            $store->name = $name;
            $store->description = $desc;
        }
        $store->save();
        return Redirect::to('staff/manage')->with('alert', 'Successfully edited store');
    }
    
    public function item_add(){
        $name = Input::get('name');
        $desc = Input::get('desc');
        $key = Input::get('keyword');
        $price = Input::get('price');
        $quant = Input::get('quantity');
        $end = Input::get('end');
        $type = Input::get('type');
        $user = Auth::user();
        $store = Store::where('user_id', '=', $user->id)->first();
        $item = Item::create(array("name"=>$name, "description"=>$desc, "keywords"=>$key));
        
        $arr = $item->toArray();
        $store->items()->attach($item->id, array("type"=>$type));
        if($type == 0){
            $store->items()->updateExistingPivot($item->id, array("price"=>$price, "quantity"=>$quant));
            
            $arr['first'] = $price;
            $arr['second'] = $quant;
        } else {
            $auction = Auction::create(array("end"=>$end, "status"=>"Pending"));
            $auction->item()->associate($item);
            $auction->store()->associate($store);
            $auction->save();
            $arr['second'] = $end;
            $arr['first'] = money_format("%n", 0);
        }
        $store->save();
        return Response::json($arr, 200);
    }
    
    public function item_del(){
        $id = Input::get('id');
        $store = Store::where('user_id', '=', Auth::user()->id)->first();
        $auction = Auction::where('store_id', $store->id)->where('item_id', $id)->first();
        if($auction){
            $auction->bids()->delete();
            $auction->delete();
        }
        $store->items()->detach($id);
        return Response::json($id, 200);
    }
}