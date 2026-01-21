<div class="side-nav">
    <ul class="side-ul">
        <li class="side-li">
            <a class="sm-link {{ (request()->is('faculty/dashboard')) ? 'active' : '' }}" href="{{ URL('faculty/dashboard') }}">
                <div class="sm-item">
                    <span class="link-icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="link-text">Dashboard</span>
                </div>
            </a> 
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('faculty/profile')) ? 'active' : '' }}" href="{{ URL('faculty/profile') }}">
                <div class="sm-item">
                    <i class="fas fa-user"></i> &nbsp; Profile
                </div> 
            </a>
        </li> 
        <li class="side-li">
            <a class="sm-link {{ (request()->is('faculty/courses')) ? 'active' : '' }}" href="{{ URL('faculty/courses') }}">
                <div class="sm-item">
                    <i class="fas fa-user"></i> &nbsp;Courses

                </div> 
            </a>
        </li> 
       
        <li>
            <div class="dropdown">
              <a class="sm-link {{ (request()->is('faculty/tests')) ? 'active' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="float-left"><i class="fas fa-file-alt"></i> &nbsp;Mock Test</span>
                  <span class="down-caret float-right mt-15"></span>
              </a>
              <div class="dropdown-menu cdrop-menu" aria-labelledby="dropdownMenuButton">
                
                <a class="dropdown-item" href="{{ URL('faculty/tests') }}">Tests</a>
                {{-- <a class="dropdown-item" href="{{url('faculty/questionReports')}}">Question Reports</a> --}}
              </div>
            </div>
        </li>
        
        <li class="side-li">
            <a class="sm-link {{ (request()->is('faculty/doubts')) ? 'active' : '' }}" href="{{ URL('faculty/doubts') }}">
                <div class="sm-item">
                    <i class="far fa-question-circle"></i> &nbsp;Doubts
                </div>
            </a>
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