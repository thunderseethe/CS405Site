@extends("layout")

@section("css")
<style type="text/css">
    td:first-child{
        text-transform:capitalize;   
    }
    .flex-right{
        display:flex;
        flex-direction: row-reverse;
    }
    .widget .header h4{
        margin-left:4px;   
    }
</style>
@stop

@section("content")
    <div class="row">
        <div class="col-lg-12">
            <div class="widget">
                <div class="header">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Statistics</h4>
                        </div>
                        <div class="col-lg-6 flex-right">
                            <ul class="nav nav-pills" role="tablist" align="right">
                                <li role="presentation" class="active"><a href="#week" role="tab" data-toggle="tab">Week</a></li>
                                <li role="presentation" class=""><a href="#month" role="tab" data-toggle="tab">Month</a></li>
                                <li role="presentation" class=""><a href="#year" role="tab" data-toggle="tab">Year</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="week">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['week'] as $order)
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{$item->name}}</td>
                                            <td>${{money_format("%i", $item->pivot->price)}}</td>
                                            <td>x {{$item->pivot->quantity}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Order Total</th>
                                        <th>${{$order->total()}}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Overall Total</th>
                                    <th>${{$data['week_total']}}</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="month">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['month'] as $order)
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{$item->name}}</td>
                                            <td>${{money_format("%i", $item->pivot->price)}}</td>
                                            <td>x {{$item->pivot->quantity}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Order Total</th>
                                        <th>${{$order->total()}}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Overall Total</th>
                                    <th>${{$data['month_total']}}</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="year">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($data['year'] as $order)
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td>{{$item->name}}</td>
                                            <td>${{money_format("%i", $item->pivot->price)}}</td>
                                            <td>x {{$item->pivot->quantity}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Order Total</th>
                                        <th>${{$order->total()}}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Overall Total</th>
                                    <th>${{$data['year_total']}}</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("javascript")
<script type="text/javascript">
    
</script>
@stop