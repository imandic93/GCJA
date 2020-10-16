<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={"GET"},
 *     collectionOperations={"GET"},
 *     normalizationContext={"groups"="posts:read", "swagger_definition_name"="read"}
 * )
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"posts:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"posts:read"})
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"posts:read"})
     */
    private $body;

    /**
     * @ORM\Column(type="integer")
     */
    private $externalApiId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getExternalApiId(): ?int
    {
        return $this->externalApiId;
    }

    public function setExternalApiId(int $externalApiId): self
    {
        $this->externalApiId = $externalApiId;

        return $this;
    }
}
