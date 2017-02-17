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
