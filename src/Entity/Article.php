<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $lang;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $article;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $sub_category;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modify_at;

    /**
     * @ORM\OneToOne(targetEntity=ArticleCover::class, cascade={"persist", "remove"})
     */
    private $cover;

    /**
     * @ORM\Column(type="text")
     */
    private $introduction;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $categoryLogo;

    /**
     * @ORM\OneToOne(targetEntity=ArticleStat::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_stat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $author_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $author_id;

    public function __construct(){
        $this->setCreatedAt(new \DateTime());
        $this->setModifyAt(new \DateTime());
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
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

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(string $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubCategory(): ?string
    {
        return $this->sub_category;
    }

    public function setSubCategory(string $sub_category): self
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

    public function getModifyAt(): ?\DateTimeInterface
    {
        return $this->modify_at;
    }

    public function setModifyAt(\DateTimeInterface $modify_at): self
    {
        $this->modify_at = $modify_at;

        return $this;
    }

    public function getCover(): ?ArticleCover
    {
        return $this->cover;
    }

    public function setCover(?ArticleCover $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getCategoryLogo(): ?string
    {
        return $this->categoryLogo;
    }

    public function setCategoryLogo(string $categoryLogo): self
    {
        $this->categoryLogo = $categoryLogo;

        return $this;
    }

    public function getArticleStat(): ?ArticleStat
    {
        return $this->article_stat;
    }

    public function setArticleStat(ArticleStat $article_stat): self
    {
        $this->article_stat = $article_stat;
        return $this;
    }
    /**
    * @ORM\PostLoad
    */
    public function addView(){
        $this->getArticleStat()->addView();
    }

    public function getAuthorName(): ?string
    {
        return $this->author_name;
    }

    public function setAuthorName(?string $author_name): self
    {
        $this->author_name = $author_name;

        return $this;
    }

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function setAuthorId(?int $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }
}
