
## version 2 - Composer autoloader
1. add class to composer.json and generate autoloader

        "autoload": {
            "psr-4" : {
                "Itb\\": "src"
            }
        },

1. replace individual class requires with autoload require `/public/index.php`

        require_once __DIR__ . '/../vendor/autoload.php';


## version 3 - front controller, MainController and template

1. change `/public/index.php` to front controller code

        <?php
        // load classes
        // ---------------------------------------
        require_once __DIR__ . '/../vendor/autoload.php';

        use Itb\MainController;
        $mainController = new MainController();

        $mainController->indexAction();


1. create directory `/src` and in this create class `MainController`:

        <?php
        namespace Itb;


        class MainController
        {
            public function indexAction()
            {
                // get reference to our repository
                $bookRepository = new BookRepository();
                $books = $bookRepository->getAllBooks();

                require_once __DIR__  . '/../templates/index.php';
            }
        }

1. create directory `/templates` and in this create `index.php`:


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
            <?php
            foreach($books as $book){
                $html = '';
                $html .= '<tr>';
                $html .= '<th>';
                $html .= $book->getTitle();
                $html .= '</th>';
                $html .= '<td>';
                $html .= '<img src="/images/' . $book->getImage() . '">';
                $html .= '</td>';
                $html .= '</tr>';
                print $html;
            }
            ?>
        </table>

        </body>
        </html>
