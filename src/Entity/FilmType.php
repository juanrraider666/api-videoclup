<?php

namespace App\Entity;

use App\Entity\Util\TimeStampableEntity;
use App\Repository\FilmTypeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilmTypeRepository::class)
 */
class FilmType
{
    use TimeStampableEntity;

    public const NEW_RELEASE_TYPE = 1;
    public const NORMAL_TYPE = 3;
    public const OLD_TYPE = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $active;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $visible;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $point;


    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    private $validDays;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(?bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return int
     */
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * @param int $point
     */
    public function setPoint(int $point): void
    {
        $this->point = $point;
    }

    /**
     * @return int
     */
    public function getValidDays(): int
    {
        return $this->validDays;
    }

    /**
     * @param int $validDays
     */
    public function setValidDays(int $validDays): void
    {
        $this->validDays = $validDays;
    }
}
