<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 03/12/15
 * Time: 15:39
 */

namespace Itb\Model;


use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;

/**
 * Class BookRepository
 * class to store and serve Book objects (bit like a memory-only database ...)
 * @package Itb\Model
 */
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