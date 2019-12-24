
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container ">
    <a class="navbar-brand" href="{{ route('home') }}">Weibo</a>
    <ul class="navbar-nav justify-content-end">

      @if(Auth::check())
        <li class="nav-item">
          <a class="nav-link" href="#">用户列表</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">{{ Auth::user()->name }}</a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">个人中心</a>
            <a class="dropdown-item" href="#">编辑资料</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="logout" href="#">
              <form action="{{ route('logout') }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="sumit" class="btn btn-block btn-danger" name="button">退出</button>
              </form>
            </a>
        </li>


      @else

      <li class="nav-item">
        <a class="nav-link" href="{{ route('help') }}">帮助</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">登录</a>
      </li>
      @endif


    </ul>
  </div>

</nav>
