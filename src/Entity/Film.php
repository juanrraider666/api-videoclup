<?php

namespace App\Entity;

use App\Entity\Util\TimeStampableEntity;
use App\Form\Model\FilmDataModel;
use App\Repository\FilmRepository;
use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FilmRepository::class)
 */
class Film
{
    use TimeStampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"film"})
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     maxMessage="Describe your film in 50 chars or less"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"film"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"film"})
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"film"})
     */
    private $isPublished;

    /**
     * @var FilmType
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\FilmType")
     * @ORM\JoinColumn(nullable=true)
     * */
    private $filmType;

    /**
     * @ORM\OneToMany(targetEntity=FilmOwnerRelation::class, mappedBy="film")
     */
    private $filmOwnerRelation;

    public function __construct()
    {
        $this->filmOwnerRelation = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * The description of the cheese as raw text.
     *
     * @Groups({"film:write", "user:write"})
     * @SerializedName("description")
     */
    public function setDescription(?string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public static function create($title, $description, $price): Film
    {
        $film = new self();
        $film->setTitle($title);
        $film->setDescription($description);
        $film->setPrice($price);
        $film->markAsPublished();
        return $film;
    }


    public static function createFromModel(FilmDataModel $filmDataModel): Film
    {
        $film = new self();
        $film->setTitle($filmDataModel->title);
        $film->setDescription($filmDataModel->description);
        $film->setPrice($filmDataModel->price);
        $film->markAsPublished();
        return $film;
    }

    public function update(
        string $title,
        ?string $description,
        ?int $price
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
    }

    public function markAsPublished()
    {
        $this->isPublished = true;
    }

    /**
     * @return FilmType
     */
    public function getFilmType(): FilmType
    {
        return $this->filmType;
    }

    /**
     * @param FilmType $filmType
     */
    public function setFilmType(FilmType $filmType): void
    {
        $this->filmType = $filmType;
    }


    /**
     * @return Collection|FilmOwnerRelation[]
     */
    public function getFilmOwnerRelation(): Collection
    {
        return $this->filmOwnerRelation;
    }

    public function addUser(FilmOwnerRelation $user): self
    {
        if (!$this->filmOwnerRelation->contains($user)) {
            $this->filmOwnerRelation[] = $user;
            $user->setFilmListings($this);
        }

        return $this;
    }

    public function removeUser(FilmOwnerRelation $user): self
    {
        if ($this->filmOwnerRelation->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getFilmListings() === $this) {
                $user->setFilmListings(null);
            }
        }

        return $this;
    }

}
