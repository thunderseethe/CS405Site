@extends("layout")

@section("css")
<style type="text/css">
    .desc-label{
        background-color:#eee;
        color:#555;
        padding:5px 5px 5px 10px;
        width:100%;
        border:1px solid #ccc;
        border-radius: 4px 4px 0px 0px;
    }
    textarea.form-control{
        border-radius: 0px 0px 4px 4px;
        border-top:transparent;
    }
    .widget{
        margin-bottom:15px;   
    }
    .widget .content{
        margin: 5px 0px 0px 5px;   
    }
</style>
@stop

@section("content")
    <div class="row">
        <div class="col-lg-12 error_alert">
            @if(Session::has('alert'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('alert')}}
                </div>
            @endif
        </div>
        <div class="col-lg-12">
            <div class="widget">
                <div class="header">
                    <span>Manage</span>
                </div>
                
                <div class="content">
                    <form id="manage_store" method="get" action="store">
                        <input type="hidden" name="create" value="{{$data['create']}}" />
                        <div class="input-group">
                            <span class="input-group-addon">Name</span>
                            <input id="name" name="name" value="{{$data['name']}}" class="form-control"/>
                        </div>
                        <br/>
                        <div class="desc-label">Description</div>
                        <textarea id="description" name="description" class="form-control" rows=8>{{$data['description']}}</textarea>
                        <hr/>
                        <div style="display:flex; flex-direction:row-reverse;">
                            <input type="submit" class="btn btn-default" value="Save" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($data['stock'])
    <div class="row">
        <div class="col-lg-12">
            <div class="widget">
                <div class="header">
                    <div class="row">
                        <div class="col-lg-6">
                            <span>Stock</span>
                        </div>
                        <div class="col-lg-6" style="display:flex; flex-direction:row-reverse;">
                            <i class="glyphicon glyphicon-plus" id="add_item" style="padding-right:5px;padding-top:1px;"></i>
                        </div>
                    </div>
                </div>
                <div class="content" id="stock">
                    @foreach($data['stock'] as $item)
                    <div class="row" id="item{{$item->id}}">
                        <div class="col-lg-7">
                            <span style="text-transform:capitalize;">{{$item->name}}</span>
                            <p>{{$item->description}}</p>
                        </div>
                        @if($item->pivot->type == 0)
                        <div class="col-lg-2">
                            {{$item->pivot->price}}
                        </div>
                        <div class="col-lg-2">
                            {{$item->pivot->quantity}}
                        </div>
                        @else
                        <div class="col-lg-2">
                            {{$item->auction($data['id'])->highest_bid()}}
                        </div>
                        <div class="col-lg-2">
                            {{date("Y-m-d", strtotime($item->auction($data['id'])->end))}}
                        </div>
                        @endif
                        <div class="col-lg-1">
                            <span class="glyphicon glyphicon-remove remove" data-id="{{$item->id}}"></span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="modal fade" id="add_item_modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Item</h4>
          </div>
          <div class="modal-body">
            <form id="item_form">
                
                <div class="input-group">
                    <span class="input-group-addon">Name</span>
                    <input id="item_name" name="name" class="form-control"/>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Description</span>
                    <input id="item_desc" name="desc" class="form-control"/>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Keywords</span>
                    <input id="item_keyword" name="keyword" class="form-control" />
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Type</span>
                    <select id="item_type" name="type" class="form-control">
                        <option value="0">Sell</option>
                        <option value="1">Auction</option>
                    </select>
                </div>
                <div id="type0" class="type">
                    <div class="input-group">
                        <span class="input-group-addon">Price</span>
                        <input id="item_price" name="price" class="form-control"/>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Quantity</span>
                        <input id="item_quantity" name="quantity" class="form-control"/>
                    </div>
                </div>
                <div id="type1" class="type" style="display:none;">
                    <div class="input-group">
                        <span class="input-group-addon">End</span>
                        <input type="date" id="item_end" name="end" class="form-control" />
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="add">Add</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section("javascript")
<script type="text/javascript">
    $("#add_item").on('click', function(event){
         $('#add_item_modal').modal('show');
    });
    $('.remove').on('click', function(event){
        var id = $(this).data('id');
        var t = $(this);
        $.get('item_del', {id:id}, function(data){
            console.log(data);
            $('#item'+data).remove();
        }, "json");
    });
    
    $('#item_type').on('change', function(event){
        var t = $(this);
        $('.type').hide();
        $('#type'+t.val()).show();
    });
    
    $('#add').on('click', function(event){
        var data = $('#item_form').serialize();
        $.get('item_add', data, function(data){
            console.log(data);
            $('#stock').append('<div class="row"><div class="col-lg-7"><span style="text-transform:capitalize;">'+data.name+'</span><p>'+data.description+'</p></div><div class="col-lg-2">'+data.first+'</div><div class="col-lg-2">'+data.second+'</div><div class="col-lg-1"><span class="glyphicon glyphicon-remove remove" data-id="'+data.id+'"></span></div></div>'); 
            $('#add_item_modal').modal('hide');
        }, "json");
    });
</script>
@stop