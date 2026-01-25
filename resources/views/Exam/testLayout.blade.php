<html>
    <head>
         <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title') - SuccessCurve</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('css/style.main02.css')}}">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
        
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        
<!--        Google Fonts    -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    </head>
    <body> 
        
         
<!--        Header Section      -->
        <header>
                    </header>
<!--        End Of Header       -->
        
<!--        Main Body Section       -->
        <div>
            @yield('content')
        </div>
<!--        End Of Main Body Section       -->
        

        
<!--        BootStrap Scripts       -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
        <!-- MathJAX 3.x CDN -->
        <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']],
                displayMath: [['$$', '$$'], ['\\[', '\\]']],
                processEscapes: true,
                processEnvironments: true,
                autoload: {
                    color: [],
                    colorv2: ['color']
                },
                packages: {'[+]': ['ams', 'newcommand', 'configmacros']},
                macros: {
                    pm: '\\pm'
                }
            },
            options: {
                ignoreHtmlClass: 'tex2jax_ignore',
                processHtmlClass: 'tex2jax_process math-content',
                skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code']
            },
            loader: {
                load: ['[tex]/ams', '[tex]/newcommand', '[tex]/configmacros']
            },
            startup: {
                ready: () => {
                    MathJax.startup.defaultReady();
                    MathJax.startup.promise.then(() => {
                        console.log('MathJax is ready');
                        // Process all math content on page
                        if (MathJax.typesetPromise) {
                            MathJax.typesetPromise();
                        }
                    });
                }
            }
        };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js" id="MathJax-script" async></script>
        @yield('javascript')
    </body>
</html>     
