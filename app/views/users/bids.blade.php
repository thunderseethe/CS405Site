@extends("layout")

@section("content")
<div class="row">
    <div class="col-lg-12">
        <div class="widget">
            <div class="header">
                <span>Bids</span>
            </div>
            <div class="content">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach($data['bids'] as $index=>$bid)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading{{$index}}">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$index}}" aria-expanded="false" aria-controls="collapse{{$index}}">
                                    Bid #{{$bid->id}}
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$index}}">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12 error_alert">

                                    </div>
                                    <div class="col-lg-6">
                                        <p>Store: {{$bid->auction->store->name}}</p>
                                        <p>Status: <span class="status">{{$bid->auction->status}}</span></p>
                                        <p>Bid Placed: {{date("Y-m-d", strtotime($bid->date))}}</p>
                                        <p>Bid amount: ${{money_format("%n", $bid->amount)}}</p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p>Name: {{ucwords($bid->auction->item->name)}}</p>
                                        <p>Description: {{$bid->auction->item->description}}</p>
                                        <p>Highest Bid: ${{money_format("%n", $bid->auction->highest_bid())}}</p>
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
@stop