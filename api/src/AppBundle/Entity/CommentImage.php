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
class CommentImage extends \EntityBundle\Entity\Image\AbstractImage
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
     * @var Comment
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Comment")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setComment(Comment $comment): void
    {
        $this->comment = $comment;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }
}