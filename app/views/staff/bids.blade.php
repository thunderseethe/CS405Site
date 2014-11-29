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
    h4{
        margin-left:7px;   
    }
    span.capitalize{
        text-transform:capitalize;   
    }
</style>
@stop

@section("content")
    <div class="row" id>
        <div class="col-lg-12">
            <div class="widget">
                <div class="header">
                    <h4>Auctions</h4>    
                </div>
                <div class="content">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        @foreach($data['auctions'] as $index=>$auction)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading{{$index}}">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$index}}" aria-expanded="false" aria-controls="collapse{{$index}}">
                                        Auction #{{$auction->id}}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$index}}">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12 error_alert">
                                            
                                        </div>
                                        <div class="col-lg-6">
                                            <p>Item: <span class="capitalize">{{$auction->item['name']}}</span></p>
                                            <p>Status: <span class="status">{{$auction->status}}</span></p>
                                            <p>Auction Ends: {{date("Y-m-d", strtotime($auction->end))}} </p>
                                            @if($auction->status == "Pending")
                                                <button class="btn btn-default ship" data-id="{{$auction->id}}">Ship To Winner</button>
                                            @else
                                                <span class="shipped">Shipped</span>
                                            @endif
                                        </div>
                                        <div class="col-lg-6">
                                            {{--<p>Name: {{ucwords($bid->item->name)}}</p>
                                            <p>Description: {{$bid->item->description}}</p>
                                            <p>Highest Bid: ${{money_format("%n", $bid->item->highest_bid())}}</p>--}}
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Bid User</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($auction->bids as $bid)
                                                    <tr>
                                                        <td style="text-transform:capitalize">
                                                            {{$bid->user->first_name}} {{$bid->user->last_name}}
                                                        </td>
                                                        <td>
                                                            $ {{money_format("%i", $bid->amount)}}
                                                        </td>
                                                        <td>
                                                            {{date("Y-m-d", strtotime($bid->date))}}
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
        $.get('auction', {id:id}, function(data){
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