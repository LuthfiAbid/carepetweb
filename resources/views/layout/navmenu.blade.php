<li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{asset('assets/img/user.png')}}" class="img-circle" alt="Avatar"> <span>{{$data}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
        <ul class="dropdown-menu">
            <li onclick="Logout()"><a href=""><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
        </ul>
    </li>
    <input id="id_logout" type="hidden" value="1">