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

