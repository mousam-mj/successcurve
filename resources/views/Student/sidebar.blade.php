<div class="side-nav">
    <ul class="side-ul">
        <li class="side-li">
            <a class="sm-link {{ (request()->is('student/dashboard')) ? 'active' : '' }}" href="{{ URL('student/dashboard') }}">
                <div class="sm-item">
                    <span class="link-icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="link-text">Dashboard</span>

                </div>
            </a>
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('student/profile')) ? 'active' : '' }}" href="{{ URL('student/profile') }}">
                <div class="sm-item">
                    <span class="link-icon"><i class="fas fa-user"></i></span>
                    <span class="link-text"> Profile</span>

                </div>
            </a> 
        </li>
        <li class="side-li">
            <a class="sm-link {{ (request()->is('student/myCourses')) ? 'active' : '' }}" href="{{ URL('student/myCourses') }}">
                <div class="sm-item">
                    <span class="link-icon"><i class="fas fa-book-reader"></i></span>
                    <span class="link-text">My Courses</span>
                </div>
            </a>
        </li> 
        <li class="side-li">
            <a class="sm-link {{ (request()->is('student/tests')) ? 'active' : '' }}" href="{{ URL('student/tests') }}">
                <div class="sm-item">
                    <i class="far fa-list-alt"></i> &nbsp;My Tests
                </div>
            </a>
        </li> 
        <li class="side-li">
            <a class="sm-link {{ (request()->is('student/testSeries')) ? 'active' : '' }}" href="{{ URL('student/testSeries') }}">
                <div class="sm-item">
                    <i class="fas fa-list-ol"></i> &nbsp;Test Series
                </div>
            </a>
        </li>
        <li>
            <a class="sm-link {{ (request()->is('student/testResults')) ? 'active' : '' }}" href="{{ URL('student/testResults') }}">
                <div class="sm-item">
                    <i class="fas fa-file-alt"></i> &nbsp;Test Reports
                </div>
            </a>
        </li>
        <li class="side-li">
            <a class="sm-link" href="#">
                <div class="sm-item">
                    <i class="far fa-question-circle"></i> &nbsp;Doubts
                </div>
            </a>
        </li>
        <li>
            <div class="dropdown">
                <a class="sm-link {{ (request()->is('students/payemnts')) ? 'active' : '' }}" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="float-left">
                        <i class="fas fa-money-bill-alt"></i> &nbsp;Payment History
                    </span>
                    <span class="down-caret float-right mt-15"></span>
                </a>
                <div class="dropdown-menu cdrop-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{url('students/payemnts/courses')}}">Courses</a>
                    <a class="dropdown-item" href="{{url('students/payemnts/tests')}}">Mock Tests</a>
                    <a class="dropdown-item" href="{{url('students/payemnts/testseries')}}">Test Series</a>
                </div>
            </div>
        </li>
        <li class="side-li">
            <a class="sm-link" href="#">
                <div class="sm-item">
                    <i class="far fa-thumbs-up"></i> &nbsp;Feedback
                </div>
            </a>
        </li>
        <li class="side-li">
            <a class="sm-link" href="#">
                <div class="sm-item">
                    <i class="far fa-bell"></i> &nbsp;Notifications
                </div>
            </a>
        </li>
        <li class="side-li">
            <a class="sm-link" href="{{ URL('logout') }}">
                <div class="sm-item">
                    <span class="link-icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span class="link-text">Logout</span> 
                </div>
            </a>
        </li>
    </ul>
</div>