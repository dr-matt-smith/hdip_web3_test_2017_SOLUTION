
## version 6 - make MyApplication a subclass of Silex Application


1. install the Twig resources via Composer at the command line:

        $ composer require silex/silex

1. Refactor`/src/WebApplication.php` to be a subclass of Silex\Application

    In the constructor we need to setup the controller service provider, and then call the Twig and route setup methods:


        <?php
        namespace Itb;


        use Silex\Application;

        class WebApplication extends Application
        {
            private $myTemplatesPath = __DIR__ . '/../templates';


            public function __construct()
            {
                parent::__construct();

                $this['debug'] = true;
                $this->setupTwig();
                $this->addRoutes();
            }

1. Refactor`/src/WebApplication.php` to have new methods setupTwig() and setupRoutes():


        public function setupTwig()
        {
            // register Twig with Silex
            // ------------
            $this->register(new \Silex\Provider\TwigServiceProvider(),
                [
                    'twig.path' => $this->myTemplatesPath
                ]
            );
        }

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
        }

1. We now have to refactor MainController to store a reference to $app, a WebApplication object, rather than $twig:

        <?php
        namespace Itb;


        class MainController
        {
            private $app;

            public function __construct(WebApplication $app)
            {
                $this->app = $app;
            }

            public function indexAction()
            {
                // get reference to our repository
                $bookRepository = new BookRepository();
                $books = $bookRepository->getAll();

                $argsArray = [
                    'books' => $books
                ];
                $templateName = 'index';
                return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }