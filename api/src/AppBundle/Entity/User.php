<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * The most generic type of item.
 *
 * @see http://schema.org/Thing Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Thing")
 */
class User extends \FOS\UserBundle\Model\User
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
     * @var Collection<Feedback>|null
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Feedback")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     */
    private $feedbacks;

    /**
     * @var Collection<Basket>|null
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Basket")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     */
    private $basketItems;

    /**
     * @var Collection<Comment>|null
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Comment")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     */
    private $comments;

    public function __construct()
    {
        $this->feedbacks = new ArrayCollection();
        $this->basketItems = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function addFeedback(Feedback $feedback): void
    {
        $this->feedbacks[] = $feedback;
    }

    public function removeFeedback(Feedback $feedback): void
    {
        $this->feedbacks->removeElement($feedback);
    }

    public function getFeedbacks(): Collection
    {
        return $this->feedbacks;
    }

    public function addBasketItem(Basket $basketItem): void
    {
        $this->basketItems[] = $basketItem;
    }

    public function removeBasketItem(Basket $basketItem): void
    {
        $this->basketItems->removeElement($basketItem);
    }

    public function getBasketItems(): Collection
    {
        return $this->basketItems;
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
}
