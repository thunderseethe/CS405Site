<?php

class Cart extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /cart
	 *
	 * @return Response
	 */
	public function index()
	{
        $cart = Session::get('cart');
        $data = array();
        $sum = 0;
        foreach($cart as $store_id=>$s_items){
            $store = Store::where('id', '=', $store_id)->first();
            $items = $store->items->filter(function($item) use ($s_items){
                return in_array($item->id, $s_items); 
            });
            foreach($items as $item){
                $sum += $item['pivot']['price'];
            }
            $data[$store_id] = $items;
        }
        $data['cart'] = $data;
        $data['sum'] = money_format("%i", $sum);
        $data['active_cart'] = true;
		return View::make('cart.index')->with('data', $data);
	}
    
    public function create()
    {
        $cart = Session::get('cart');
        $quant = Input::get('quantity');
        foreach($cart as $store=>$s_items){
            $order = Order::create(array("user_id"=>Auth::user()->id, "store_id"=>$store, "date"=>date("Y-m-d H:i:s", time()), "status"=>"Pending"));
            $items = Store::where('id', '=', $store)->first()->items->filter(function ($item) use ($s_items){
                return in_array($item->id, $s_items); 
            });
            foreach($items as $item){
                $price = $item->pivot->price * $item->pivot->promotion_rate;
                $order->items()->attach($item->id, array("price"=>$price, "quantity"=>$quant[$store][$item->id])); 
            }
        }
        Session::flash('alert', 'Successfully placed your order');
        Session::put('cart', array());
        return Redirect::to('/');
    }
    
    public function delete($store, $item){
        $cart = Session::get('cart');
        unset($cart[$store][$item]);
        Session::put('cart', $cart);
        return Response::json($cart, 200);
    }
    
    public function add($store, $item)
    {
        $cart = Session::get('cart');
        if(!isset($cart[$store])){
            $cart[$store][] = $item;
        }
        else if(!empty($store) and !empty($item) and !in_array($item, $cart[$store])){
            $cart[$store][$item] = $item;
        }
        Session::put('cart', $cart);
        return Response::json($cart, 200);
    }
}