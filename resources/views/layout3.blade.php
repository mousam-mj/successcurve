<html>
    <head>
         <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
          
        @yield('meta')
        
        <title>@yield('title') - SuccessCurve</title>
        
        
        
         
        
        
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
        
        <link rel="stylesheet" href="{{asset('css/style.main02.css')}}">
        <link rel="stylesheet" href="{{asset('css/newStyle.css')}}">
        <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
        
<!--        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />-->
        
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        
        <link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css" />
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
        
<!--        Google Fonts    -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        <script src="{{asset('js/bf43df44d7.js')}}"></script>
    </head>
    <body onload="funLoad()"> 
        
         
<!--        Header Section      -->
        <header>
            <nav class="navbar navbar-expand-xl navbar-dark bg-transparent shadow-sm fixed-top pd-20">
                <a class="navbar-brand" href="#">
<!--                    <img src="{{ URL::asset('imgs/logo.png') }}" alt="SuccessCurve" class="logo"/>-->
                    SUCCESSCURVE<sup class="in"> .IN</sup>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ml-auto">
                       
                        <a class="nav-item nav-link active" href="/">Home <span class="sr-only">(current)</span></a>
                        <a class="nav-item nav-link" href="{{URL('about-us')}}">About Us</a>
                        <a class="nav-item nav-link" href="{{URL('courses')}}">Courses</a>
                        <a class="nav-item nav-link" href="{{URL('mock-test')}}">Mock Test</a>
                        <a class="nav-item nav-link" href="{{URL('testSeries')}}">Test Series</a>
                        <a class="nav-item nav-link" href="https://blog.successcurve.in/">Blog</a>
                        
                        <a class="nav-item nav-link" href="{{ url('contact') }}">Contact Us</a> @if(Session::get('user'))
           
                        <div class="btn-group">
						  	<button type="button" class="btn btn-custom2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    	{{Session::get('user')}} 
						  	</button>
						  	<div class="dropdown-menu dropdown-menu-right">
							    
							    <a class="dropdown-item" type="button" href="{{ URL('student/dashboard') }}">Dashboard</a>
							    <a class="dropdown-item" type="button"  href="{{ URL('logout') }}">Logout</a>
						  	</div>
						</div>
                        
                        @elseif(Session::get('fuser'))
           
                        <div class="btn-group">
						  	<button type="button" class="btn btn-custom2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    	{{Session::get('fuser')}} 
						  	</button>
						  	<div class="dropdown-menu dropdown-menu-right">
							    
							    <a class="dropdown-item" type="button" href="{{ URL('faculty/dashboard') }}">Dashboard</a>
							    <a class="dropdown-item" type="button"  href="{{ URL('logout') }}">Logout</a>
						  	</div>
						</div>
                        
                        @elseif(Session::get('auser'))
           
                        <div class="btn-group">
						  	<button type="button" class="btn btn-custom2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    	{{Session::get('auser')}} 
						  	</button>
						  	<div class="dropdown-menu dropdown-menu-right">
							    <a class="dropdown-item" type="button" href="{{ URL('admin/dashboard') }}">Dashboard</a>
							    <a class="dropdown-item" type="button"  href="{{ URL('logout') }}">Logout</a>
						  	</div>
						</div>

                        @elseif(Session::get('qaUser'))
           
                        <div class="btn-group">
						  	<button type="button" class="btn btn-custom2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    	{{Session::get('qaUser')}} 
						  	</button>
						  	<div class="dropdown-menu dropdown-menu-right">
							    <a class="dropdown-item" type="button" href="{{ URL('qas/dashboard') }}">Dashboard</a>
							    <a class="dropdown-item" type="button"  href="{{ URL('logout') }}">Logout</a>
						  	</div>
						</div>
                        @else
                        <a class="nav-item nav-link" href="{{ URL('login') }}">Login</a>
                        @endif
                        
                    </div>
                </div>
            </nav>
            
            <div class="preloader" id="preloader"> 
                <div class="book">
                  <div class="inner">
                    <div class="left"></div>
                    <div class="middle"></div>
                    <div class="right"></div>
                  </div>
                  <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                  </ul>
                </div>
            </div>
            
        </header>
<!--        End Of Header       -->
        
<!--        Main Body Section       -->
        <div>
            @yield('content')
        </div>

<!--        End Of Main Body Section       -->
        

        
<!--        BootStrap Scripts       -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <script>
        function funLoad(){
            var preloader = document.getElementById('preloader');
            preloader.style.display = 'none';
        }
        </script>
        <script>
             $(window).on("scroll", function(){
                if($(window).scrollTop()){
                    $('nav').removeClass('bg-transparent');
                    $('nav').removeClass('pd-20');
                    $('nav').addClass('bg-dark');
                }
                else{
                    $('nav').removeClass('bg-dark');
                    $('nav').addClass('bg-transparent');
                    $('nav').addClass('pd-20');
                }
            });
        </script>
    </body>
</html>     
