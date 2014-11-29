<?php

use \NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer;
use \NlpTools\Similarity\Simhash;

class Home extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function showWelcome()
	{
		return View::make('hello');
	}
    
    public function store(){
        $stores = Store::with('items', 'items.auctions')->get();
        $data['rec'] = array();
        if(Auth::check()){
            $orders = Order::where('user_id', '=', Auth::user()->id)->with('items')->orderBy('date', 'DESC')->limit(10)->get();
            $all_items = Item::all();
            $toknz = new WhitespaceAndPunctuationTokenizer();
            $simhash = new Simhash(16);
            $rec = array();
            foreach($orders as $order){
                foreach($order->items as $item){
                    $check = $toknz->tokenize($item->keywords);
                    foreach($all_items as $a_item){
                        if($item->id == $a_item->id) continue; //Skip cases where both items are the exact same
                        $key = $toknz->tokenize($a_item->keywords);
                        $val = $simhash->similarity($key, $check);
                        if(!isset($rec[$a_item->id])){
                            $rec[$a_item->id] = 0;   
                        }
                        $rec[$a_item->id] += $val;
                    }
                }
            }
            arsort($rec);
            $i = 0;
            foreach($rec as $id=>$fill){
                if($i >= 5) break;
                $item = Item::find($id);
                $data['rec'][] = $item;
                $i++;

            }
        }
        $data['stores'] = $stores;
        $data['active_home'] = true;
        return View::make('store')->with('data', $data);
    }
}
