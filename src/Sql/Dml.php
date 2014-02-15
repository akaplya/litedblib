<?php

namespace Sql;

/**
 * Class Clause
 * @package Sql
 */
class Dml
{
    public function select()
    {
        return new \Sql\Statement\Select(new \Db\Mysql\Quote());
    }

    public function update()
    {
        return new \Sql\Statement\Update(new \Db\Mysql\Quote());
    }

    public function insert()
    {
        return new \Sql\Statement\Insert();
    }

    public function delete()
    {
        return new \Sql\Statement\Delete();
    }

    public function upsert()
    {
        return new \Sql\Statement\Upsert();
    }

    public function insertSelect()
    {
        return new \Sql\Statement\Select\Insert();
    }

    public function updateSelect()
    {
        return new \Sql\Statement\Select\Update();
    }

    public function upsertSelect()
    {
        return new \Sql\Statement\Select\Upsert();
    }

    public function deleteSelect()
    {
        return new \Sql\Statement\Select\Delete();
    }
}
