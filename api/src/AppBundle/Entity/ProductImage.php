<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
class ProductImage extends \EntityBundle\Entity\Image\AbstractImage
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
     * @var Product
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}