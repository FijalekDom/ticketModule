<?php

namespace App\Domain\ValueObject;

use App\Application\Exception\InvalidEmailException;
use App\Application\Exception\InvalidRoleException;
use App\Domain\Constant\UserRole;

class User
{
    private string $email;
    private array $roles;

    public function __construct(
        string $email,
        array $roles
    ) {
        if (!$this->isValidEmail($email)) {
            throw new InvalidEmailException(sprintf("Invalid email: %s", $email));
        }

        if (!$this->isValidRoles($roles)) {
            throw new InvalidRoleException(sprintf("Invalid roles: %s Available roles: %s", implode(", ", $roles), implode(", ", UserRole::getAvailableRoles())));
        }

        $this->email = $email;
        $this->roles = $roles;
    }

    private function isValidEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    private function isValidRoles(array $roles): bool
    {
        foreach ($roles as $role) {
            if (!in_array($role, UserRole::getAvailableRoles())) {
                return false;
            }
        }

        return true;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}