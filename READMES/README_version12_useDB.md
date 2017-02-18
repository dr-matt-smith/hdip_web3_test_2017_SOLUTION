
## version 12 - get repository to work with MySQL database

1. add statements to `/public/index.php` to declare the 4 expected database constants:

        <?php
        // the DatabaseManager class needs the following 4 constants to be defined in order to create the DB connection
        define('DB_HOST', 'localhost');
        define('DB_USER', 'fred');
        define('DB_PASS', 'smith');
        define('DB_NAME', 'hdip_test');

        // load classes
        // ---------------------------------------
        require_once __DIR__ . '/../vendor/autoload.php';

        use Itb\WebApplication;
        $app = new WebApplication();
        $app->run();

1. create a database `hdip_test` and in it a table `books` with the `Book` class structure in MySQL

1. seed the database with the 3 records

    NOTE - either do this by hand (in PHPMyAdmin), or convert the BookRepository constructor into a /public/seed.php script to save time ...

        <?php
        // the DatabaseManager class needs the following 4 constants to be defined in order to create the DB connection
        define('DB_HOST', 'localhost');
        define('DB_USER', 'fred');
        define('DB_PASS', 'smith');
        define('DB_NAME', 'hdip_test');

        // load classes
        // ---------------------------------------
        require_once __DIR__ . '/../vendor/autoload.php';

        use Itb\Model\Book;
        use Itb\Model\BookRepository;

        $repo = new BookRepository();

        $b1 = new Book();
        $b1->setId(1239);
        $b1->setTitle('brown');
        $b1->setImage('father_brown.jpg');
        $b1->setNumPages(320);
        $repo->create($b1);

        $b2 = new Book();
        $b2->setId(8761);
        $b2->setTitle('marple');
        $b2->setImage('miss_marple.jpg');
        $b2->setNumPages(201);
        $repo->create($b2);

        $b3 = new Book();
        $b3->setId(3003);
        $b3->setTitle('holmes');
        $b3->setImage('sherlock_holmes.jpg');
        $b3->setNumPages(432);
        $repo->create($b3);

        NOTE - if seeding with code, you'll need to manually edit the IDs, since they'll default to 1,2,3 through auto-incrementing ...


1. add the `pdo-crud-for-free-repositories` package to this project

        $ composer require mattsmithdev/pdo-crud-for-free-repositories

1. refactor `BookRepository` to subclass `DatabaseTableRepository`, and to contain just a constructor (all the other methods will now be inherited from the package superclass `DatabaseTableRepository`):

        <?php
        /**
         * Created by PhpStorm.
         * User: matt
         * Date: 03/12/15
         * Time: 15:39
         */

        namespace Itb\Model;


        use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;

        class BookRepository extends DatabaseTableRepository
        {
            public function __construct()
            {
                $namespace = 'Itb\Model';
                $classNameForDbRecords = 'Book';
                $tableName = 'books';
                parent::__construct($namespace, $classNameForDbRecords, $tableName);
            }
        }


that's it - the data from `BookRepository` is now from the database rather than a locally maintained array of objects