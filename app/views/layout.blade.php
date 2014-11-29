<html>
    <head>
        <title>{{isset($title) ? $title : "StoreRUs"}}</title>
        <link rel="shortcut icon" href="../../favicon.ico" />
        <!-- Latest compiled and minified CSS -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">-->
        {{HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css')}}
        <!-- Optional theme -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
        {{HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css')}}
        {{HTML::style('css/style.css')}}
        @yield("css")
        
    </head>
    <body>
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collpased" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--<a class="navbar-brand" href="#">Home</a>-->
                </div>
                
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="{{isset($data['active_home']) ? 'active' : ''}}">{{HTML::linkRoute('index', 'Home')}}</li>
                        @if(Auth::check())
                            <li class="{{isset($data['active_order']) ? 'active' : ''}}">{{HTML::linkRoute('users_orders', 'Orders')}}</li>
                            <li class="{{isset($data['active_bid']) ? 'active' : ''}}">{{HTML::linkRoute('users_bids', 'Bids')}}</li>
                            @if(Auth::user()->type >= 2)
                            <li class="dropdown {{isset($data['active_store']) ? 'active' : ''}}">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Store</a>
                                <ul class="dropdown-menu" role="menu">
                                    @if(Auth::user()->type == 2)
                                    <li>{{HTML::linkRoute('staff_manage', 'Manage')}}</li>
                                    <li>{{HTML::linkRoute('staff_bids', 'Auctions')}}</li>
                                    @endif
                                    <li>{{HTML::linkRoute('staff_inventory', 'Inventory')}}</li>
                                    <li>{{HTML::linkRoute('staff_orders', 'Orders')}}</li>
                                </ul>
                            </li>
                            @endif
                            @if(Auth::user()->type >= 4)
                            <li class="dropdown {{isset($data['active_sales']) ? 'active' : ''}}">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Sales</a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>{{HTML::linkRoute('sales_stats','Statistics')}}</li>
                                    <li>{{HTML::linkRoute('sales_promo', 'Promotions')}}</li>
                                </ul>
                            </li>
                            @endif
                        @endif
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if(!Auth::check())
                            <li>{{HTML::linkRoute('login', 'Login')}}</li>
                            <li>{{HTML::linkRoute('user.create', 'Register')}}</li>
                        @else
                            <li class="{{isset($data['active_cart']) ? 'active' : ''}}">{{HTML::linkRoute('cart', 'Cart')}}</li>
                            <li>{{HTML::linkRoute('logout', 'Logout')}}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class='container-fluid'>
            @yield('content')
        </div>
        <!-- Latest compiled and minified JavaScript -->
        <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.js"></script>
        {{HTML::script('js/Chart.js')}}
        @yield("javascript")
    </body>
</html>