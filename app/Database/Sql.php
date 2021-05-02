<?php

namespace App\Database;

use PDO;

/**
 * Responsable for the database connection and executing queries.
 */
class Sql 
{
    /**
     * PDO connection instance.
     */
    private $connection;

    public function __construct()
    {
        switch (config('db.connection')) {
            case 'mysql':
                $dsn = 'mysql:dbname=' . config('db.name') . ';host=' . config('db.host');
                break;

            case 'sqlsrv':
                $dsn = 'sqlsrv:Server=' . config('db.host') . ';Database=' . config('db.name');
                break;
        }

        try {
            $this->connection = new PDO($dsn, config('db.username'), config('db.password'),[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * Execute a select statement.
     * 
     * @param string $rawQuery      Query To be executed.
     * @param array $parameters     Parameters to be binded to the query.
     * @return array|false          Array containing query results or false if the statement failed.
     */
    public function select(string $rawQuery, $parameters = array())
    {
        $statement = $this->connection->prepare($rawQuery);
    
        $result = $statement->execute($parameters);

        return ($result === false) ? false : $statement->fetchAll();
    }

    /**
     * Execute a insert, update or delete statement.
     * 
     * @param string $rawQuery      Query To be executed.
     * @param array $paramters      Paramter to be binded to the query.
     * @return boolean              True if the statement succeeded.
     */
    public function query(string $rawQuery, $parameters = array())
    {
        $statement = $this->connection->prepare($rawQuery);

        return $statement->execute($parameters);
    }

    /**
     * Returns the last inserted Id in a table.
     * 
     * @return integer      Id inserted.
     */
    public function lastInsertId()
    {
        return (int) $this->connection->lastInsertId();
    }

    /**
     * Begin PDO transaction.
     */
    public function beginTransaction() 
    {
        $this->connection->beginTransaction();
    }

    /**
     * Commit current PDO transaction.
     */
    public function commit()
    {
        $this->connection->commit();
    }

    /**
     * Rollback current PDO transaction.
     */
    public function rollback()
    {
        $this->connection->rollback();
    }
}
