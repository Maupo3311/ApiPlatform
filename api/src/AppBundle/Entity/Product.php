<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 *
 * @see http://schema.org/Product Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Product")
 */
class Product
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $price;

    /**
     * @var string|null a description of the item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/description")
     */
    private $description;

    /**
     * @var Collection<Category>|null A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     * @ApiProperty(iri="http://schema.org/category")
     */
    private $categories;

    /**
     * @var bool
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $active;

    /**
     * @var Collection<ProductImage>|null
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ProductImage")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     */
    private $images;

    /**
     * @var Collection<BasketItem>|null
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     */
    private $basketItems;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $number;

    /**
     * @var Collection<Comment>|null
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Comment")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     */
    private $comments;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @Assert\NotNull
     */
    private $rating;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->basketItems = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
    }

    public function removeCategory(Category $category): void
    {
        $this->categories->removeElement($category);
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param bool $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    public function addImage(ProductImage $image): void
    {
        $this->images[] = $image;
    }

    public function removeImage(ProductImage $image): void
    {
        $this->images->removeElement($image);
    }

    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param BasketItem $basketItem
     */
    public function addBasketItem($basketItem): void
    {
        $this->basketItems[] = $basketItem;
    }

    /**
     * @param BasketItem $basketItem
     */
    public function removeBasketItem($basketItem): void
    {
        $this->basketItems->removeElement($basketItem);
    }

    public function getBasketItems(): Collection
    {
        return $this->basketItems;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function addComment(Comment $comment): void
    {
        $this->comments[] = $comment;
    }

    public function removeComment(Comment $comment): void
    {
        $this->comments->removeElement($comment);
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    public function getRating(): float
    {
        return $this->rating;
    }
}
