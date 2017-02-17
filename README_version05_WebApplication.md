
## version 5 - simplify Front Controller with WebApplication class

1. Create new class `/src/WebApplication.php` which creates the Twig object and calls the MainController method:

        <?php
        namespace Itb;


        class WebApplication
        {
            private $myTemplatesPath = __DIR__ . '/../templates';

            public function run()
            {
                $twig = new \Twig_Environment(new \Twig_Loader_Filesystem($this->myTemplatesPath));
                $mainController = new MainController($twig);
                $html = $mainController->indexAction();
                print $html;
            }


        }

1. refactor `/public/index.php` to simply create an instance-object of the WebApplication class, and then call its run() method:

        <?php
        // load classes
        // ---------------------------------------
        require_once __DIR__ . '/../vendor/autoload.php';

        use Itb\WebApplication;
        $app = new WebApplication();
        $app->run();

