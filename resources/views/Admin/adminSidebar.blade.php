<div class="side-nav">
    <ul class="side-ul">
        <li class="side-li">
            <a class="sm-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}" href="{{ URL('admin/dashboard') }}">
                <div class="sm-item">
                    <span class="link-icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="link-text">Dashboard</span>

                </div>
            </a> 
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('admin/profile')) ? 'active' : '' }}" href="{{ URL('admin/profile') }}">
                <div class="sm-item">
                    <i class="fas fa-user"></i> &nbsp;Admin Profile

                </div> 
            </a>
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('admin/subjectMaster')) ? 'active' : '' }}" href="{{ URL('admin/subjectMaster') }}">
                <div class="sm-item">
                    <i class="fas fa-user"></i> &nbsp;Subjects

                </div> 
            </a>
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('admin/classes')) ? 'active' : '' }}" href="{{ URL('admin/classes') }}">
                <div class="sm-item">
                    <i class="fas fa-user"></i> &nbsp;Classes

                </div> 
            </a>
        </li> 
        <li class="side-li">
            <a class="sm-link {{ (request()->is('admin/courses')) ? 'active' : '' }}" href="{{ URL('admin/courses') }}">
                <div class="sm-item">
                    <i class="fas fa-user"></i> &nbsp;Courses

                </div> 
            </a>
        </li> 
        <li>
            <div class="dropdown">
              <a class="sm-link {{ (request()->is('admin/tests')) ? 'active' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="float-left"><i class="fas fa-file-alt"></i> &nbsp;Mock Test</span>
                  <span class="down-caret float-right mt-15"></span>
              </a>
              <div class="dropdown-menu cdrop-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{url('admin/subjectTopic')}}">Subject Topic</a>
                <a class="dropdown-item" href="{{url('admin/createTC')}}">Test Series</a>
                <a class="dropdown-item" href="{{url('admin/instructions')}}">Instructions</a>
                <a class="dropdown-item" href="{{ URL('admin/tests') }}">Tests</a>
                <a class="dropdown-item" href="{{url('admin/qbs')}}">Question Bank</a>
                <a class="dropdown-item" href="{{url('admin/questionReports')}}">Question Reports</a>
              </div>
            </div>
        </li>
        <li>
            <div class="dropdown">
              <a class="sm-link {{ (request()->is('admin/users')) ? 'active' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="float-left"><i class="fas fa-file-alt"></i> &nbsp;Users</span>
                  <span class="down-caret float-right mt-15"></span>
              </a>
              <div class="dropdown-menu cdrop-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{url('admin/users/admins')}}">Admins</a>
                <a class="dropdown-item" href="{{url('admin/users/instructors')}}">Instructors</a>
                <a class="dropdown-item" href="{{url('admin/users/users')}}">Users</a>
                <a class="dropdown-item" href="{{url('admin/users/qas')}}">Question Uploader</a>
                
              </div>
            </div>
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('admin/sliders')) ? 'active' : '' }}" href="{{ URL('admin/sliders') }}">
                <div class="sm-item">
                    <i class="far fa-images"></i> &nbsp; Slider
                </div>
            </a>
        </li>
        <!--<li class="side-li">-->
        <!--    <a class="sm-link {{ (request()->is('admin/addInstructor')) ? 'active' : '' }}" href="{{ URL('admin/addInstructor') }}">-->
        <!--        <div class="sm-item">-->
        <!--            <i class="fas fa-user-plus"></i> &nbsp;Add Instructor-->
        <!--        </div>-->
        <!--    </a>-->
        <!--</li>-->
        <!--<li class="side-li">-->
        <!--    <a class="sm-link {{ (request()->is('admin/addAdmin')) ? 'active' : '' }}" href="{{ URL('admin/addAdmin') }}">-->
        <!--        <div class="sm-item">-->
        <!--            <i class="fas fa-user-plus"></i> &nbsp;Add Admin-->
        <!--        </div>-->
        <!--    </a>-->
        <!--</li>-->
        <li class="side-li">
            <a class="sm-link {{ (request()->is('admin/coupons')) ? 'active' : '' }}" href="{{ URL('admin/coupons') }}">
                <div class="sm-item">
                    <i class="far fa-money-check-alt"></i> &nbsp;Coupons
                </div>
            </a>
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('admin/doubts')) ? 'active' : '' }}" href="{{ URL('admin/doubts') }}">
                <div class="sm-item">
                    <i class="far fa-question-circle"></i> &nbsp;Doubts
                </div>
            </a>
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('admin/contacts')) ? 'active' : '' }}" href="{{ URL('admin/contacts') }}">
                <div class="sm-item">
                    <i class="fas fa-envelope-open-text"></i> &nbsp;Contacts
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