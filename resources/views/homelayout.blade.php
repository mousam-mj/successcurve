<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="SuccessCurve.in is a combine effort to spread the knowledge towards the needy ones.Successcurve helps students to open their own minds an see the possibilities ahead. Our Successcurve is just a small foot step in inducing this thought to the Society in order to make a prosperous country (better future).">
        <meta name="keywords" content="CUCET,CUCET mock test,Class 12 entrance exam,online course,bihar board,bihar board objective question,live class,free mocktest,chapterwise test,successcurve,cucet question paper,class 12 lecture,daily quiz, chapter wise quiz">



        <title>@yield('title') - SuccessCurve Educational Portal</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('css/style.main02.css')}}">
        <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/newStyle.css')}}">


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

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-32JDC6BSTQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-32JDC6BSTQ');
</script>
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
                        <a class="nav-item nav-link" href=" https://blog.successcurve.in/">Blog</a>

                        <a class="nav-item nav-link" href="{{ url('contact') }}">Contact Us</a>
                        @if(Session::get('user'))

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
                {{-- <div class="book">
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
                </div> --}}
                <div class="loader"></div>
            </div>

        </header>
<!--        End Of Header       -->

<!--        Main Body Section       -->
        <div>
            @yield('content')
        </div>
<!--        End Of Main Body Section       -->

   <!--        Start Footer Section       -->
        <footer class="footer">
		   <div class="row">
				<div class="col-md-3 footer-items">
					<h3>SuccessCurve<sup> .in</sup></h3>
					 <hr class="border1"/>
					<p class="fpara">SuccessCurve.in is a combine effort to spread the knowledge towards the needy ones.Successcurve helps students to open their own minds an see the possibilities ahead. Our successcurve is just a small foot step in inducing this thought to the Society in order to make a prosperous country (better future).</p>
                    <h4 class="follow">Follow Us On</h4>
                    <ul class="social">
						<li>
							<a href="https://www.facebook.com/Successcurve.in" title="facebook"><i class="fab fa-facebook" aria-hidden="true"></i></a>
							<a href="https://twitter.com/successcurvein" title="twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>
							<a href="https://instagram.com/successcurve.in" title="instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
							<a href="https://youtube.com/successcurve" title="Youtube"><i class="fab fa-youtube" aria-hidden="true"></i></a>
							<a href="https://api.whatsapp.com/send?phone=+919473099252" title="Whatsapp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
						</li>
					</ul>
				</div>

               <div class="col-md-6">
                    <div class="row">

                        <div class="col-md-4 footer-items">
                            <h4>Quick Links</h4>
                            <hr class="border2"/>
                            <ul >
                                <li><a href="{{ url('about-us')}}">About Us</a></li>
                                <li><a href="{{  url('courses') }}">Courses</a></li>
                                <li><a href="{{ url('mock-test') }}">Mock Test</a></li>
                                <li><a href="https://blog.successcurve.in/">Blog</a></li>
                                <li><a href=" {{ url('contact-us') }}">Contact Us</a></li>
                                <li><a href="https://blog.successcurve.in/internshipupdate/">Internship</a></li>
                                <li><a href="http://successcurve.in/public/blog/mathepedia/">Scholarship</a></li>
                                <li><a href="http://successcurve.in/public/blog/scholarship/">Mathepedia</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 footer-items">
                            <h4>Entrance Exam</h4>
                            <hr class="border2"/>
                            <ul>
                                <li><a href="https://blog.successcurve.in/class5update/">5th Standard</a></li>
                                <li><a href="https://blog.successcurve.in/class8update/">8th Standard</a></li>
                                <li><a Entrance Examhref="https://blog.successcurve.in/class10update/">10th Standard</a></li>
                                <li><a Entrance Examhref="https://blog.successcurve.in/class12update/">12th Standard</a></li>
                                <li><a href="https://blog.successcurve.in/graduationexamupdate/">Graduation</a></li>
                            </ul>
                        </div>
                        <div class="col-md-4 footer-items">
                            <h4>Study Materials</h4>
                            <hr class="border2"/>
                            <ul>
                                <li><a href="https://blog.successcurve.in/notes-e-books/">Notes/e-Books </a></li>
                                <li><a href="https://blog.successcurve.in/ncert-solution/">NCERT Solution</a></li>
                                <li><a href="https://blog.successcurve.in/previous-years-question-paper-download/">Previous Year Question Papers</a></li>
                            </ul>
                        </div>
                   </div>
               </div>

				<div class="col-md-3 footer-items">
					<h4>Helpful Links</h4>
					<hr class="border2"/>
					<ul>
                        <li><a href="{{ url('terms-and-contition') }}">Terms & Conditions</a></li>
                        <li><a href="{{ url('privacy-policy') }}">Privacy Policy </a></li>
                        <li><a href="{{ url('join-ssp') }}">Join SSP</a></li>
                        <li><a href="{{ url('join-us') }}">Become an Educator/Volunteer</a></li>
                        <li><a href="{{ url('sitemap') }}">Sitemap</a></li>
					</ul>
				</div>
			</div>

			<div class="footer-bottom">
				<p class="text-white">© Copyright {{ date('Y') }} | SuccessCurve | All Rights Reserved</p>
				<p><a class="branding text-white" href="https://accnee.com/" target="_blank">Made With <i class="fa fa-heart"></i> by Accnee Technologies</a></p>
			</div>

		</footer>
<!--        End of Footer Section       -->

<!--        BootStrap Scripts       -->




        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

        <script type="text/javascript" async
          src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_CHTML">
        </script>

        <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

        <script src="{{asset('js/owl.carousel.min.js')}}"></script>
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

        @yield('javascript')

    </body>
</html>
