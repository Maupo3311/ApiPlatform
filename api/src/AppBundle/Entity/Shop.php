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
 * The most generic type of item.
 *
 * @see http://schema.org/Thing Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Thing")
 */
class Shop
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
     * @var string|null the name of the item
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\")
     * @ApiProperty(iri="http://schema.org/name")
     */
    private $name;

    /**
     * @var string|null a description of the item
     *
     * @ORM\Column(type="text", nullable=true)
     * @ApiProperty(iri="http://schema.org/description")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $lon;

    /**
     * @var Collection<Category>|null
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     */
    private $categories;

    /**
     * @var Collection<ShopImage>|null
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ShopImage")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     */
    private $images;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string|null $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $lat
     */
    public function setLat($lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param string $lon
     */
    public function setLon($lon): void
    {
        $this->lon = $lon;
    }

    /**
     * @return string
     */
    public function getLon()
    {
        return $this->lon;
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

    public function addImage(ShopImage $image): void
    {
        $this->images[] = $image;
    }

    public function removeImage(ShopImage $image): void
    {
        $this->images->removeElement($image);
    }

    public function getImages(): Collection
    {
        return $this->images;
    }
}
