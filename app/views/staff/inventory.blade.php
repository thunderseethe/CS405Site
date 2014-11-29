@extends('layout')

@section("css")
<style type="text/css">
    .name{
        text-transform:capitalize;
    }
    span{
        line-height:28px;
    }
    span.name{
        margin-left:5px;   
    }
    .edit_quantity{
        width:50px;
        padding:0;
        margin:0;
    }
    .content{margin-bottom:5px;}
</style>
@stop

@section("content")
    <div class="row">
        <div class="col-lg-12">
            <div class="widget">
                <div class="header">
                    <span>Inventory</span>
                </div>
                <div class="content">
                    @foreach($data['items'] as $index=>$item)
                    @if($index != 0)
                        <hr/>
                    @endif
                    <div class="row">
                        <div class="col-lg-10">
                            <span class="name">{{$item->name}}</span>
                        </div>
                        <div class="col-lg-1">
                            <span class="quantity">{{$item->pivot->quantity}}</span>
                        </div>
                        <div class="col-lg-1">
                            <button class="btn btn-default edit" data-id="{{$item->id}}"><i class="glyphicon glyphicon-pencil"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop

@section("javascript")
<script type="text/javascript">
    editClick = function(event){
        var quant = $(event.currentTarget).parent().parent().find('.quantity');
        var num = quant.text();
        var input = $('<input/>', {type:'number', class:'edit_quantity', value:num, min:1});
        quant.html(input);
        var icon = $(event.currentTarget).find('i');
        icon.removeClass('glyphicon-pencil');
        icon.addClass('glyphicon-floppy-disk');
        $(event.currentTarget).removeClass('edit');
        $(event.currentTarget).addClass('save');
        $(event.currentTarget).off('click', editClick);
        $(event.currentTarget).on('click', saveClick);
    }
    
    saveClick = function(event){
        var quant = $(event.currentTarget).parent().parent().find('.quantity');
        var input = quant.find('input')
        var icon = $(event.currentTarget).find('i');
        var id = $(event.currentTarget).attr("data-id");
        var num = input.val();
        console.log(input);
        console.log(num);
        $.get('edit', {id:id, num:num}, function(data){
            //Error handling here maybe?
            quant.html(data.num);
            icon.removeClass('glyphicon-floppy-disk');
            icon.addClass('glyphicon-pencil');
            $(event.currentTarget).removeClass('save');
            $(event.currentTarget).addClass('edit');
            $(event.currentTarget).off('click', saveClick);
            $(event.currentTarget).on('click', editClick);
        }, "json");
    }
        
    $('.edit').on('click', editClick);
</script>
@stop