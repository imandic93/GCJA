<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;

/**
 * @ApiResource(
 *     collectionOperations={"GET"},
 *     itemOperations={"GET"},
 *     normalizationContext={"groups"="users:read", "swagger_definition_name"="read"}
 * )
 * @ApiFilter(OrderFilter::class, properties={"name", "username", "email"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users:read"})
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:read"})
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:read"})
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users:read"})
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $externalApiId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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
