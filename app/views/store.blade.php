@extends('layout')

@section("css")
<style type="text/css">
    .granite{
        color:#666;   
        font-weight:bold;
    }
    ul.list-group{
        text-transform:capitalize;   
    }
    .modal-title{
        text-transform:capitalize;   
    }
</style>
@stop

@section('content')
    @if(Session::has('alert'))
        <div class="alert alert-success" role="alert">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
            {{Session::get('alert')}}
        </div>
    @endif
    <div class="row" id>
        <div class="col-lg-8">
            @foreach($data['stores'] as $store)
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                        <h3 class="store_name">{{$store->name}}</h3>
                        <hr/>
                    </div>
                    @foreach($store->items as $item)
                        <div class="col-md-4 col-sm-12 col-xs-12 col-lg-4 item">
                            <div class="widget">
                                <div class="header">
                                    <h4>{{$item->name}}</h4>
                                </div>
                                <div class="content">
                                    @if($item->pivot->type == 0)
                                        <span>$ {{money_format("%n", $item->pivot->price * $item->pivot->promotion_rate)}}</span>
                                        @if($item->pivot->promotion_rate != 1)
                                            <span class='granite'>({{(1 - $item->pivot->promotion_rate)*100}}% off)</span>
                                        @endif
                                    @else
                                        $ <span id="bid{{$store->id}}{{$item->id}}">{{money_format("%n", $item->auction($store->id)->highest_bid())}}</span>
                                    @endif
                                    <p>{{$item->description}}</p>
                                    
                                    @if(Auth::check())
                                    <div class="btn-group" role="group" aria-label="...">
                                        @if($item->pivot->type == 0)
                                            <button type="button" class="btn btn-default add_cart" data-store="{{$store->id}}" data-item="{{$item->id}}" >Add to Cart</button>
                                        @else
                                            <button type="button" class="btn btn-default add_bid" data-store="{{$store->id}}" data-item="{{$item->id}}" data-toggle="modal" data-target="#bid_modal" data-name="{{$item->name}}" data-bid="{{$item->auction($store->id)->highest_bid()}}">
                                                Place Bid
                                            </button>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        @if(Auth::check())
        <div class="col-lg-4">
            <h3>Recommended Items</h3>
            <hr/>
            <ul class="list-group">
                @foreach($data['rec'] as $item)
                    <li class="list-group-item">{{$item->name}}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <div class="modal fade" id="bid_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form id="bid_form">
                <input type="hidden" id="store_id" name="store" />
                <input type="hidden" id="item_id" name="item" />
                Bid Amount: <input type="number" id="amount" name="amount" />
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="place">Place</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section("javascript")
<script>
$('.add_cart').on('click', function(event){
    var t = $(event.currentTarget);
    var item = t.attr('data-item');
    var store = t.attr('data-store');
    $.get('cart/add/'+store+'/'+item, {}, function(data){
        console.log(data);
    }, 'json');
});
    
$('#bid_modal').on('show.bs.modal', function(event){
    var item = $(event.relatedTarget);
    var name = item.data('name');
    var bid = item.data('bid');
    var store = item.data('store');
    var id = item.data('item');
    $('#store_id').val(store);
    $('#item_id').val(id);
    $('#amount').val(bid);
    $('.modal-title').text(name);
});
    
$('#place').on('click', function(event){
    event.preventDefault();
    var data = $('#bid_form').serialize();
    $.get('bid/add', data, function(data){
        $('#bid'+data.store+data.item).text(data.amount);
        $('#bid_modal').modal('hide');
    }, 'json');
});
</script>
@stop