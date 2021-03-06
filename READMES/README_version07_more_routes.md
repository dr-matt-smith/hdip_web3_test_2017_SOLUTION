
## version 7 - define index and list routes

1. make a copy of `/templates/index.html.twig` named `list.html.twig`

1. edit the content of `/templates/index.html.twig` to output a page that looks like the home page screenshot from the test paper

        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>MGW - home page</title>
            <style>
                @import 'css/style.css';
            </style>
        </head>

        <body>
        <a href="/">home</a>
        <hr>

        <h1>Welcome - home page of great detectives Book website</h1>

        <p>
            All you need to know about the best detective books
        </p>

        <ul>
            <li>
                <a href="/index.php/list">list all great books</a>
            </li>
        </ul>


        </body>
        </html>


1. Add a `/list` route to `/src/WebApplication.php`, to call `MainController->listAction()`:


    public function addRoutes()
    {
        // setup Service controller provider
        $this->register(new \Silex\Provider\ServiceControllerServiceProvider());

        // map routes to controller class/method
        //-------------------------------------------

        //==============================
        // controllers as a service
        //==============================
        $this['main.controller'] = function() { return new MainController($this);   };

        //==============================
        // now define the routes
        //==============================

        // -- main --
        $this->get('/', 'main.controller:indexAction');
        $this->get('/list', 'main.controller:listAction');
    }

1. in class `MainController` copy method `indexAction()` naming the copy `listAction()`, and then refactor `indexAction()` as follows:

        public function indexAction()
        {
            $argsArray = [];
            $templateName = 'index';
            return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
        }