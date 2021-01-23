<?php

namespace App\Entity;

use App\Repository\ArticleStatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleStatRepository::class)
 */
class ArticleStat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $views;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }
    public function addView(){
        $this->views++;
    }
}
