<?php

namespace App\Infrastructure\Query;

use App\Domain\Constant\UserRole;
use Doctrine\DBAL\Connection;

class GetAdminEmailQuery
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getResult(): string
    {
        $sql = "SELECT email
                FROM user
                WHERE roles LIKE CONCAT('%', :role, '%')
                LIMIT 1
        ";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('role', UserRole::ROLE_ADMIN);
        $result = $stmt->executeQuery();

        return $result->fetchOne();
    }
}