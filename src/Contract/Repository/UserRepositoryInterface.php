<?php


namespace App\Contract\Repository;


interface UserRepositoryInterface
{
    public function getAll(): array;
}