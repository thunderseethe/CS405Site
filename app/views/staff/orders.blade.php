@extends("layout")

@section("css")
<style type="text/css">
    span.shipped{
        border:1px solid #999;
        border-radius:5px;
        padding:5px;
        color:#666;
        box-shadow:1px 1px 1px 1px #eee;
    }
</style>
@stop

@section("content")
    <div class="row">
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
                                            <p>Customer: {{$order->user->first_name}} {{$order->user->last_name}}</p>
                                            <p>Status: <span class="status">{{$order->status}}</span></p>
                                            <p>Order Placed: {{$order->date}} </p>
                                            @if($order->status == "Pending")
                                                <button class="btn btn-default ship" data-id="{{$order->id}}">Ship It</button>
                                            @else
                                                <span class="shipped">Shipped</span>
                                            @endif
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

@section("javascript")
<script type="text/javascript">
    $('.ship').on('click', function(event){
        var id = $(this).attr("data-id");
        $.get('ship', {id:id}, function(data){
            if(data.error){
                var err = $(event.currentTarget).parent().parent().find('.error_alert');
                err.html('<div class="alert alert-danger alert-dismissible" role="alert">' +
                            '<button type="button" class="close" data-dismiss="alert">'+
                                '<span aria-hidden="true">&times;</span>'+
                                '<span class="sr-only">Close</span>'+
                            '</button>'+
                            '<strong>Error</strong> There are only '+data.max+' of '+data.name+
                        '</div>');
                return;
            }
            $(event.currentTarget).parent().append($('<span></span>', {text:"Shipped", class:"shipped"}));
            $(event.currentTarget).parent().find('span.status').html('Shipped');
            $(event.currentTarget).remove();
        }, "json");
    });
</script>
@stop