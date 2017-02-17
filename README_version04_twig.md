
## version 4 - twig

1. change `/public/index.php` to create a `$twig` object and pass to the MainController

        <?php
        // load classes
        // ---------------------------------------
        require_once __DIR__ . '/../vendor/autoload.php';

        $myTemplatesPath = __DIR__ . '/../templates';
        $twig = new Twig_Environment(new Twig_Loader_Filesystem($myTemplatesPath));

        use Itb\MainController;
        $mainController = new MainController($twig);

        $html = $mainController->indexAction();
        print $html;


1. edit `MainController->indexAction()` to build `$argsArray` and then return result of rendering the `index.html.twig` template.

    Notice we make the code simpler by passing in and storing a reference to the Twig object via the MainController constructor:

        <?php
        namespace Itb;


        class MainController
        {
            private $twig;

            public function __construct(\Twig_Environment $twig)
            {
                $this->twig = $twig;
            }

            public function indexAction()
            {
                // get reference to our repository
                $bookRepository = new BookRepository();
                $books = $bookRepository->getAllBooks();

                $argsArray = [
                    'books' => $books
                ];
                $templateName = 'index';
                return $this->twig->render($templateName . '.html.twig', $argsArray);
            }
        }

1. in `/templates` change `index.php` to `index.html.twig`, and change the PHP for-loop into a Twig for-loop:


        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>books</title>
            <style>
                @import 'css/style.css';
            </style>
        </head>

        <body>

        <h1>Great Detective Books</h1>

        <table>
            {% for book in books %}
               <tr>
                    <td>{{ book.title }}</td>
                    <td><img src="/images/{{ book.image }}"></td>
               </tr>
            {% endfor %}
        </table>

        </body>
        </html>