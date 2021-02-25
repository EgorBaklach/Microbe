<?php namespace Infrastructure\Inflectors;

use Framework\Inflectors\InflectorAbstract;
use Molecule\ORM;
use Molecule\ORMFactory;
use PDO;

class ORMInflector extends InflectorAbstract
{
    public function __invoke(ORMFactory $factory)
    {
        $rs = $factory->database()->connection()->query('show tables');

        while($table = $rs->fetch(PDO::FETCH_COLUMN))
        {
            $factory->$table = new ORM($table, $factory->database());
        }
    }
}
