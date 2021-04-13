
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          YT
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          Yajra Telecom
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="{{ (request()->is('home')) ? 'active' : '' }}">
            <a href="{{route('home')}}">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="{{ (request()->is('payroll')) ? 'active' : '' }}">
            <a href="{{route('payroll')}}">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Payroll</p>
            </a>
          </li>
          <li>
            <a href="./map.html">
              <i class="now-ui-icons location_map-big"></i>
              <p>Maps</p>
            </a>
          </li>
        </ul>
      </div>
