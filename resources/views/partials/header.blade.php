<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('product.index') }}">116Shop</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><i class="fa fa-th-list" aria-hidden="true"></i> Каталог<span
                                class="caret"></span></a>
                    <ul class="dropdown-menu">
                            <li><a href="#">Краски</a></li>
                            <li><a href="#">Инструмент</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('product.shoppingCart') }}">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Корзина
                        <span class="badge" id="cartnum">{{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i> Профиль <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @if(Auth::check())
                            <li><a href="{{ route('user.profile') }}">Моя страница</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('user.logout') }}">Выход</a></li>
                        @else
                            <li><a href="{{ route('user.signup') }}">Регистрация</a></li>
                            <li><a href="{{ route('user.signin') }}">Вход</a></li>
                        @endif
                    </ul>
                </li>

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>