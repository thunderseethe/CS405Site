@extends("layout")

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
    .edit_promo{
        width:50px;
        padding:0;
        margin:0;
    }
    .content{margin-bottom:5px;}
</style>
@stop

@section("content")
    <div class="row" id>
        <div class="col-lg-12">
            <div class="widget">
                <div class="header">
                    <span>Promotions</span>
                </div>
                <div class="content">
                    @foreach($data['items'] as $index=>$item)
                    @if($index != 0)
                        <hr/>
                    @endif
                    <div class="row">
                        <div class="col-lg-9">
                            <span class="name">{{$item->name}}</span>
                        </div>
                        <div class="col-lg-2">
                           % <span class="promo">{{(1 - $item->pivot->promotion_rate) * 100}}</span>
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
        var promo = $(event.currentTarget).parent().parent().find('.promo');
        var num = promo.text();
        var input = $('<input/>', {type:'number', class:'edit_promo', value:num, min:0, max:100});
        promo.html(input);
        var icon = $(event.currentTarget).find('i');
        icon.removeClass('glyphicon-pencil');
        icon.addClass('glyphicon-floppy-disk');
        $(event.currentTarget).removeClass('edit');
        $(event.currentTarget).addClass('save');
        $(event.currentTarget).off('click', editClick);
        $(event.currentTarget).on('click', saveClick);
    }
    
    saveClick = function(event){
        var promo = $(event.currentTarget).parent().parent().find('.promo');
        var input = promo.find('input')
        var icon = $(event.currentTarget).find('i');
        var id = $(event.currentTarget).attr("data-id");
        var num = input.val();
        $.get('edit', {id:id, num:num}, function(data){
            promo.html(data.num);
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