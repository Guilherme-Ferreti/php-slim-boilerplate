<?php

namespace App\Database;

use PDO;

/**
 * Responsable for the database connection and executing queries.
 */
class Sql 
{
    private $shouldLogQueries; 

    /**
     * PDO connection instance.
     */
    private $connection;

    public function __construct()
    {
        switch (settings('db.connection')) {
            case 'mysql':
                $dsn = 'mysql:dbname=' . settings('db.name') . ';host=' . settings('db.host');
                break;

            case 'sqlsrv':
                $dsn = 'sqlsrv:Server=' . settings('db.host') . ';Database=' . settings('db.name');
                break;
        }

        $this->connection = new PDO($dsn, settings('db.username'), settings('db.password'),[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $this->shouldLogQueries = settings('app.environment') === 'dev';
    }

    /**
     * Execute a select statement.
     * 
     * @param string $rawQuery      Query To be executed.
     * @param array $parameters     Parameters to be binded to the query.
     * @return array|false          Array containing query results or false if the statement failed.
     */
    public function select(string $rawQuery, array $parameters = [])
    {
        $this->logQuery($rawQuery);

        $statement = $this->connection->prepare($rawQuery);
    
        $result = $statement->execute($parameters);

        return ($result === false) ? [] : $statement->fetchAll();
    }

    /**
     * Execute a insert, update or delete statement.
     * 
     * @param string $rawQuery      Query To be executed.
     * @param array $paramters      Paramter to be binded to the query.
     * @return boolean              True if the statement succeeded.
     */
    public function query(string $rawQuery, array $parameters = [])
    {
        $this->logQuery($rawQuery);
        
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

    private function logQuery(string $query): void
    {
        if ($this->shouldLogQueries) {
            logger('queries')->debug(trim(preg_replace('/\s+/', ' ', $query)));
        }
    }

    
    public function __destruct()
    {
        if ($this->shouldLogQueries) {
            logger('queries')->debug('----------------------------------------------------------------');
        }
    }
}
