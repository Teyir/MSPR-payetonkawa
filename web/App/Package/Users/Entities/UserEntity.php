<?php

namespace WEB\Entity\Users;

class UserEntity
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $dateCreated;
    private string $dateUpdated;
    private string $lastLogin;
    private bool $isAdmin;

    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $dateCreated
     * @param string $dateUpdated
     * @param string $lastLogin
     * @param bool $isAdmin
     */
    public function __construct(int $id, string $firstName, string $lastName, string $email, string $dateCreated, string $dateUpdated, string $lastLogin, bool $isAdmin)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->dateCreated = $dateCreated;
        $this->dateUpdated = $dateUpdated;
        $this->lastLogin = $lastLogin;
        $this->isAdmin = $isAdmin;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDateCreated(): string
    {
        return $this->dateCreated;
    }

    public function getDateUpdated(): string
    {
        return $this->dateUpdated;
    }

    public function getLastLogin(): string
    {
        return $this->lastLogin;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param array $res
     * @return \WEB\Entity\Users\UserEntity
     * @desc Map json return to a @UserEntity
     */
    public static function map(array $res): UserEntity
    {
        return new self(
            $res['id'],
            $res['first_name'],
            $res['last_name'],
            $res['email'],
            $res['date_created'],
            $res['date_updated'],
            $res['last_login'],
            $res['is_admin'],
        );
    }

}