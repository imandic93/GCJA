<?php


namespace App\Contract\Repository;


use App\Entity\Post;

interface PostRepositoryInterface
{
    /**
     * @return Post[]
     */
    public function getAll(): array;
}