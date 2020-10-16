<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ApiResource(
 *     itemOperations={"GET"},
 *     collectionOperations={"GET"},
 *     normalizationContext={"groups"="posts:read", "swagger_definition_name"="read"}
 * )
 * @ApiFilter(OrderFilter::class, properties={"title", "body"})
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"posts:read"})
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"posts:read"})
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"posts:read"})
     * @var string
     */
    private $body;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $externalApiId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     * @var User
     */
    private $owner;

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

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
