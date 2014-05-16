<?php

namespace  AKaplya\Orm\Sql;

/**
 * This class will be generated automatically :)
 *
 * Class Dml
 * @package Sql
 */
class Dml
{
    public function select()
    {
        return new \AKaplya\Orm\Sql\Statement\Select(new \AKaplya\Orm\Db\Mysql\Quote());
    }

    public function update()
    {
        return new \AKaplya\Orm\Sql\Statement\Update(new \AKaplya\Orm\Db\Mysql\Quote());
    }

    public function insert()
    {
        return new \AKaplya\Orm\Sql\Statement\Insert();
    }

    public function delete()
    {
        return new \AKaplya\Orm\Sql\Statement\Delete(new \AKaplya\Orm\Db\Mysql\Quote());
    }

    public function upsert()
    {
        return new \AKaplya\Orm\Sql\Statement\Upsert();
    }

    public function insertSelect()
    {
        return new \AKaplya\Orm\Sql\Statement\Select\Insert();
    }

    public function updateSelect()
    {
        return new \AKaplya\Orm\Sql\Statement\Select\Update();
    }

    public function upsertSelect()
    {
        return new \AKaplya\Orm\Sql\Statement\Select\Upsert();
    }

    public function deleteSelect()
    {
        return new \AKaplya\Orm\Sql\Statement\Select\Delete();
    }

    public function exprComparison($expression)
    {
        return new \AKaplya\Orm\Sql\Expr\ExprComparison($expression, new \AKaplya\Orm\Db\Mysql\Quote());
    }

    public function expr($expression)
    {
        return new \AKaplya\Orm\Sql\Expr($expression);
    }
}
