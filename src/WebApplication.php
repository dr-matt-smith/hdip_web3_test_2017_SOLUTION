<?php
namespace Itb;


use Silex\Application;
use Itb\Controller\MainController;
use Symfony\Component\Debug\ErrorHandler;
use Itb\Controller\ErrorController;


class WebApplication extends Application
{
    private $myTemplatesPath = __DIR__ . '/../templates';


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
        $this->get('/show/{id}', 'main.controller:showAction');
        $this->get('/show', 'main.controller:showNoIdAction');
    }


    public function handleErrorsAndExceptions ()
    {
        ErrorHandler::register();

        //register an error handler
        $this->error(function (\Exception $e) {
            $errorController = new ErrorController($this);
            return $errorController->errorAction($e);
        });
    }

}