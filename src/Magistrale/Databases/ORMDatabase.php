<?php namespace Magistrale\Databases;

use Molecule\ORM;
use Molecule\ORMFactory;

/**
 * Class ORMDatabase
 * @package Magistrale\Databases
 * @property ORM medias
 */
class ORMDatabase extends ORMFactory
{
    public function users(): ORM
    {
        return $this->tables['users'];
    }
}
