<?php

namespace WEB\Model\Users;

use WEB\Entity\Users\UserEntity;
use WEB\Manager\Api\APIManager;
use WEB\Manager\Api\APITypes;
use WEB\Manager\Package\AbstractModel;
use WEB\Manager\Requests\HttpMethodsType;

class UsersModel extends AbstractModel
{
    /**
     * @return bool
     * <p>Check if credentials are correct. If credentials are correct, we are storing user object in session.</p>
     */
    public function login(string $email, string $password): bool
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::POST,
            APITypes::CUSTOMERS,
            'customers/login',
            false,
            [
                'email' => $email,
                'password' => $password,
            ],
        );

        if (!isset($req['id'])) {
            return false;
        }

        $this->storeLocalUser(UserEntity::map($req));

        return true;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return \WEB\Entity\Users\UserEntity|null
     */
    public function register(string $firstName, string $lastName, string $email, string $password): ?UserEntity
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::POST,
            APITypes::CUSTOMERS,
            'customers',
            false,
            [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => $password,
            ],
        );

        if (!isset($req['id'])) {
            return null;
        }

        $user = $this->getUser($req['id']);

        if (!$user) {
            return null;
        }

        $this->storeLocalUser($user);

        return $user;
    }

    /**
     * @param int $id
     * @return \WEB\Entity\Users\UserEntity|null
     */
    public function getUser(int $id): ?UserEntity
    {
        $req = APIManager::getInstance()->send(
            HttpMethodsType::GET,
            APITypes::CUSTOMERS,
            "customers/$id",
            false,
        );

        if (!isset($req['id'])) {
            return null;
        }

        return UserEntity::map($req);
    }

    /**
     * @param \WEB\Entity\Users\UserEntity $data
     * @return void
     * @desc Set user session
     */
    private function storeLocalUser(UserEntity $data): void
    {
        $_SESSION['PAYETONKAWA_USER'] = $data;
    }

    /**
     * @return void
     * @desc Destroy user session
     */
    public function logout(): void
    {
        unset($_SESSION['PAYETONKAWA_USER']);
    }

    /**
     * @return \WEB\Entity\Users\UserEntity|null
     */
    public function getCurrentUser(): ?UserEntity
    {
        return $_SESSION['PAYETONKAWA_USER'] ?? null;
    }

    /**
     * @return bool
     */
    public function isLogged(): bool
    {
        return isset($_SESSION['PAYETONKAWA_USER']);
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        if (!$this->isLogged()) {
            return false;
        }

        return $this->getCurrentUser()?->isAdmin() ?? false;
    }

}