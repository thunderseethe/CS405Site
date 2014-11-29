<?php

class Sales extends \BaseController{
    public function stats(){
        $date = date("Y-m-d H:i:s", strtotime("-1 week"));
        $week = Order::where('date', '>=', $date)->with(array('user', 'items'))->get();
        $week_total = 0;
        foreach($week as $order){
            $week_total += $order->total();   
        }
        
        $date = date("Y-m-d H:i:s", strtotime("-1 month"));
        $month = Order::where('date', '>=', $date)->with(array('user', 'items'))->get();
        $month_total = 0;
        foreach($month as $order){
            $month_total += $order->total();
        }
        
        $date = date("Y-m-d H:i:s", strtotime("-1 year"));
        $year = Order::where('date', '>=', $date)->with(array('user', 'items'))->get();
        $year_total = 0;
        foreach($year as $order){
            $year_total += $order->total();   
        }
        
        $data['week'] = $week;
        $data['week_total'] = $week_total;
        $data['month'] = $month;
        $data['month_total'] = $month_total;
        $data['year'] = $year;
        $data['year_total'] = $year_total;
        $data['active_sales'] = true;
        return View::make('sales.stats')->with('data', $data);
    }
    
    public function promo(){
        $user = User::where('type', '=', 4)->first();
        $data['items'] = Store::where('user_id', '=', $user->id)->first()->items;
        $data['active_sales'] = true;
        return View::make('sales.promo')->with('data', $data);   
    }
    
    public function edit(){
        $num = Input::get('num');
        if($num > 100) $num = 100;
        if($num < 0) $num = 0;
        $id = Input::get('id');
        $user = User::where('type', '=', 4)->first();
        Store::where('user_id', '=', $user->id)->first()->items()->updateExistingPivot($id, ["promotion_rate"=>1-($num/100.0)]);
        return Response::json(["num"=>$num], 200);
    }
}