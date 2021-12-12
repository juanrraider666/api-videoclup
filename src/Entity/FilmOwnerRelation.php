<?php

namespace App\Entity;

use App\Repository\FilmOwnerRelationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FilmOwnerRelationRepository::class)
 */
class FilmOwnerRelation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Film
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Film", inversedBy="filmOwnerRelation")
     * @Groups({"user:read", "user:write"})
     * @Assert\Valid()
     */
    private $filmListings;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="filmOwnerRelation")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"film:read", "film:write"})
     * @Assert\Valid()
     */
    private $owner;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pointValue;

    public function __construct(Film $filmListings, User $owner, int $pointValue)
    {
        $this->filmListings = $filmListings;
        $this->owner = $owner;
        $this->pointValue = $pointValue;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Film
     */
    public function getFilmListings(): Film
    {
        return $this->filmListings;
    }

    /**
     * @param Film $filmListings
     */
    public function setFilmListings(Film $filmListings): void
    {
        $this->filmListings = $filmListings;
    }


    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPointValue()
    {
        return $this->pointValue;
    }

    /**
     * @param mixed $pointValue
     */
    public function setPointValue($pointValue): void
    {
        $this->pointValue = $pointValue;
    }


}
