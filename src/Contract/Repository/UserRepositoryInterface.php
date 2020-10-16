<?php


namespace App\Contract\Repository;


use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function getAll(): array;
}