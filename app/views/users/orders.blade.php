@extends("layout")

@section("css")
<style type="text/css">
span.status{
    color:#666;
    font-weight:bold;
}
</style>
@stop

@section("content")
<div class="row" id>
    <div class="col-lg-12">
        <div class="widget">
            <div class="header">
                <span>Orders</span>    
            </div>
            <div class="content">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($data['orders'] as $index=>$order)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading{{$index}}">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$index}}" aria-expanded="false" aria-controls="collapse{{$index}}">
                                    Order #{{$order->id}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$index}}">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12 error_alert">

                                    </div>
                                    <div class="col-lg-6">
                                        <p>Store: {{$order->store->name}}</p>
                                        <p>Status: <span class="status">{{$order->status}}</span></p>
                                        <p>Order Placed: {{$order->date}} </p>
                                    </div>
                                    <div class="col-lg-6">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Item Name</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->items as $item)
                                                <tr>
                                                    <td style="text-transform:capitalize">
                                                        {{$item->name}}
                                                    </td>
                                                    <td>
                                                        $ {{money_format("%i", $item->pivot->price)}}
                                                    </td>
                                                    <td>
                                                        x {{$item->pivot->quantity}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop
