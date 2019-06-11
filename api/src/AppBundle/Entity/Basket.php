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
class Basket
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
     * @var User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $user;

    /**
     * @var Product
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $basketProduct;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     */
    private $numberOfProduct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setBasketProduct(Product $basketProduct): void
    {
        $this->basketProduct = $basketProduct;
    }

    public function getBasketProduct(): Product
    {
        return $this->basketProduct;
    }

    public function setNumberOfProduct(int $numberOfProduct): void
    {
        $this->numberOfProduct = $numberOfProduct;
    }

    public function getNumberOfProduct(): int
    {
        return $this->numberOfProduct;
    }
}
