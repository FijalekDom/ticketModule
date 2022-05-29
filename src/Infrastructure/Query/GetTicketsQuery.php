<?php

namespace App\Infrastructure\Query;

use Doctrine\DBAL\Connection;

class GetTicketsQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getResult(): array
    {
        $sql = "
                SELECT *
                FROM ticket
        ";

        $stmt = $this->connection->prepare($sql);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

}