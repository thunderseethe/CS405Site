@extends("layout")

@section("css")
<style type="text/css">
    /*.widget{
        margin:0 auto;
        width: 60%;
        border:1px solid #999;
        border-radius:10px;
        background-color:white;
    }
    .widget .header{
        background:linear-gradient(#fff, #f8f8f8);
        padding:5px;
        border-radius: 9px 9px 0px 0px;
        border-bottom:1px solid #ccc;
        box-shadow:inset 0 1px 0 rgba(255,255,255,.15),0 1px 5px rgba(0,0,0,.075);
    }
    .widget .header span{
        color:#666;
        font-size:16px;
        margin-left:5px;
    }
    .widget .content{
        padding:5px;   
    }*/
    .widget .content .quantity input{
        width:75px;   
    }
    .name{
        text-transform:capitalize;   
    }
    .item.row{
     padding-left:10px;   
    }
    hr {
        margin: 5px 0;
    }
    .remove{
        margin-top:10px;
    }
    #total{
        margin-left:5px;
        margin-top:5px;
    }
    hr:nth-child(2){
        display:none;   
    }
</style>
@stop

@section("content")
    <div class="row">
        <div class="col-lg-12" id>
            <div class="widget">
                <div class="header">
                    <span>Cart</span>
                </div>
                <div class="content">
                    {{Form::open(array('action' => array('cart_create'), 'id'=>'form'))}}
                    @foreach($data['cart'] as $store=>$items)
                        @foreach($items as $index=>$item)
                            <hr/>
                            <div class="item row" id="cart_{{$index}}">
                                <div class="col-lg-6">
                                    <div class="name">{{$item['name']}}</div>
                                    <div class="description">{{$item['description']}}</div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="price" value="{{$item['pivot']['price'] * $item['pivot']['promotion_rate']}}">{{money_format("%i", $item['pivot']['price'] * $item['pivot']['promotion_rate'])}}</div>
                                            <div class="quantity">Quantity: <input type="number" class="quantity" name="quantity[{{$store}}][{{$item['id']}}]" min="1" data-name="{{$item['name']}}" value="1"/></div>
                                        </div>
                                        <div class="col-lg-4 remove">
                                            <i class="glyphicon glyphicon-remove" id="{{$index}}" store="{{$store}}"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                    <hr/>
                    <div class="row">
                        <div class="col-lg-10">
                            <div id="total">
                                Total: $<span id="cost">{{$data['sum']}}</span>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-default" id="purchase">Purchase</button>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@stop

@section("javascript")
<script type="text/javascript">
    function update_sum(){
        var sum = 0;
        $('.item').each(function(index){
            var price = $(this).find('.price').attr("value");
            var quantity = $(this).find('input.quantity').val();
            sum += price * quantity;
        });
        sum = Math.round(sum*100)/100.0
        $('#cost').html(sum);
    }
    
    $('.quantity').on('focusout', function(event){
        update_sum();
    });
    
    $('.glyphicon-remove').on('click', function(event){
        event.preventDefault();
        var id = $(this).attr("id");
        var store = $(this).attr("store");
        $.post('cart/delete/'+store+'/'+id, "{}", function(data){
            console.log(data);
            $('#cart_'+id).next('hr').remove();
            $('#cart_'+id).remove();
            update_sum();
        }, "json").fail(function(data){
            console.log(data);
        });
    });
</script>
@stop