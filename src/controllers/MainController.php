<?php
namespace Itb\Controller;


use Itb\WebApplication;
use Itb\Model\BookRepository;

class MainController
{
    private $app;

    public function __construct(WebApplication $app)
    {
        $this->app = $app;
    }

    public function indexAction()
    {
        $argsArray = [];
        $templateName = 'index';
        return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
    }

    public function listAction()
    {
        // get reference to our repository
        $bookRepository = new BookRepository();
        $books = $bookRepository->getAll();

        $argsArray = [
            'books' => $books
        ];
        $templateName = 'list';
        return $this->app['twig']->render($templateName . '.html.twig', $argsArray);
    }

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

    public function showNoIdAction()
    {
        $errorMessage = 'you must provide an isbn for the show page (e.g. /show/123)';
        // 400 - bad request
        $this->app->abort(400, $errorMessage);
    }
}