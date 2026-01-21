<div class="side-nav">
    <ul class="side-ul">
        <li class="side-li">
            <a class="sm-link {{ (request()->is('qas/dashboard')) ? 'active' : '' }}" href="{{ URL('qas/dashboard') }}">
                <div class="sm-item">
                    <span class="link-icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="link-text">Dashboard</span>

                </div>
            </a> 
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('qas/profile')) ? 'active' : '' }}" href="{{ URL('qas/profile') }}">
                <div class="sm-item">
                    <i class="fas fa-user"></i> &nbsp;QA Profile

                </div> 
            </a>
        </li>
        <li>
            <div class="dropdown">
              <a class="sm-link {{ (request()->is('qas/qbs')) ? 'active' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="float-left"><i class="fas fa-file-alt"></i> &nbsp;Question Bank</span>
                  <span class="down-caret float-right mt-15"></span>
              </a>
              <div class="dropdown-menu cdrop-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{url('qas/qbs')}}">Question Bank</a>
              </div>
            </div>
        </li>
       
        <li class="side-li">
            <a class="sm-link" href="{{ URL('logout') }}">
                <div class="sm-item">
                    <i class="fas fa-sign-out-alt"></i> &nbsp;Logout
                </div>
            </a>
        </li> 
    </ul>
</div>