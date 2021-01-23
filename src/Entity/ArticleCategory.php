<?php

namespace App\Entity;

use App\Repository\ArticleCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleCategoryRepository::class)
 */
class ArticleCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="array")
     */
    private $sub_category = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $logotype;

    public function __construct(){
        $this->setCreatedAt(new \Datetime());
    }
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

    public function getSubCategory(): ?array
    {
        return $this->sub_category;
    }

    public function setSubCategory(array $sub_category): self
    {
        $this->sub_category = $sub_category;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getLogotype(): ?string
    {
        return $this->logotype;
    }

    public function setLogotype(string $logotype): self
    {
        $this->logotype = $logotype;

        return $this;
    }
}
