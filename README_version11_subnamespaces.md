
## version 11 - separate classes into subnamespaces and folders

1. create directories /src/model and /src/controllers

1. move MainController into /src/controllers, and re-namespace this class Itb\Controller

        <?php
        namespace Itb\Controller;


        class MainController
        {

1. move Book and BookRepository into /src/model, and re-namespace them Itb\Model

        <?php

        namespace Itb\Model;

        /**
         * Class Book to represent book objects
         * @package Itb\Model;
         */
        class Book

1. re-run the Composer dump-autoload command

1. add uses statements in the classes, where code in a class now refers to classes in a different namespace

    e.g. In MainController we need to use Itb\Model\BookRepository and Itb\WebApplication:

        <?php
        namespace Itb\Controller;


        use Itb\WebApplication;
        use Itb\Model\BookRepository;

        class MainController
        {