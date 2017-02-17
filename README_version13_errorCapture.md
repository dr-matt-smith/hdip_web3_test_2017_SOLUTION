
## version 13 - error capture

Remeber you can look up HTTP status codes here:

- http://www.restapitutorial.com/httpstatuscodes.html

1. create a 404 error Twig template, /templates/error404.html.twig

        {% extends '_base.html.twig' %}

        {% block pageTitle %}404 error{% endblock %}

        {% block main %}

        <h1>Error - code 404</h1>

        <p>
            404 - sorry the requested resource could not be found
            <br>
            {{ errorMessage }}
        </p>

        {% endblock %}

1. create a general error Twig template, /templates/error.html.twig

        {% extends '_base.html.twig' %}

        {% block pageTitle %}general error{% endblock %}

        {% block main %}

        <h1>Whoops - an error occurred</h1>

        <p class="error">
            {{ errorMessage }}
        </p>

        {% endblock %}


1. add a new class /src/controllers/ErrorController:

        <?php
        namespace Itb\Controller;


        use Itb\WebApplication;

        class ErrorController
        {
            private $app;

            public function __construct(WebApplication $app)
            {
                $this->app = $app;
            }


            public function errorAction(\Exception $e)
            {
                $statusCode = $e->getStatusCode();
                $errorMessage = $e->getMessage();

                // default - general error
                // ------------
                $templateName = 'error';

                // special message for 404 not found errors...
                if(404 == $statusCode){
                    $templateName = 'error404';
                }

                $argsArray = array(
                    'errorMessage' => $errorMessage
                );

                return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
            }
        }



1. add an error handling method to class WebApplication, handleErrorsAndExceptions():


        public function handleErrorsAndExceptions()
        {
            ErrorHandler::register();

            //register an error handler
            $this->error(function (\Exception $e) {
                $errorController = new ErrorController($this);
                return $errorController->errorAction($e);
            });
        }

1. When WebApplication is constructed, call the new method to handle errors

        public function __construct()
        {
            parent::__construct();


            // setup Service controller provider
            $this->register(new \Silex\Provider\ServiceControllerServiceProvider());

            $this['debug'] = true;
            $this->setupTwig();
            $this->addRoutes();

            $this->handleErrorsAndExceptions();
        }

1. We can now 'abort' the processing of a request if, for example, something was requested but not found (e.g. no book for an ID)

    E.g. MainController->showAction($id) when no book found for the ID:

        public function showAction($id)
        {
            // get reference to our repository
            $bookRepository = new BookRepository();
            $book = $bookRepository->getOneById($id);

            if(null == $book){
                $errorMessage = 'no book found with id = ' . $id;
                $this->app->abort(404, $errorMessage);
            }

            $argsArray = [
                'book' => $book
            ];
            $templateName = 'show';
            return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
        }

    E.g. MainController->showNoIdAction() when no Id provided:

        public function showNoIdAction()
        {
            $errorMessage = 'you must provide an isbn for the show page (e.g. /show/123)';
            // 400 - bad request
            $this->app->abort(400, $errorMessage);
        }