<?php

namespace Sql;

/**
 * Class Dml
 * @package Sql
 */
class Constant
{
    /**#@+
     * SQL constants
     */
    const SQL_SELECT                    = 'SELECT';
    const SQL_INSERT                    = 'INSERT';
    const SQL_UPDATE                    = 'UPDATE';
    const SQL_DELETE                    = 'DELETE';

    const SQL_FROM                      = 'FROM';
    const SQL_WHERE                     = 'WHERE';
    const SQL_JOIN_INNER                = 'INNER JOIN';
    const SQL_JOIN_LEFT                 = 'LEFT JOIN';
    const SQL_JOIN_RIGHT                = 'RIGHT JOIN';
    const SQL_JOIN_CROSS                = 'CROSS JOIN';
    const SQL_AS                        = 'AS';
    const SQL_ON                        = 'ON';
    const SQL_AND                       = 'AND';
    const SQL_OR                        = 'OR';
    const SQL_BETWEEN                   = 'BETWEEN';
    const SQL_LIKE                      = 'LIKE';
    const SQL_NOT                       = 'NOT';

    const SQL_SET                       = 'SET';
    const SQL_VALUES                    = 'VALUES';
    const SQL_VALUE                     = 'VALUE';
    const SQL_ON_DUPLICATE_KEY_UPDATE   = 'ON DUPLICATE KEY UPDATE';
}
