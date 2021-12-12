<?php


namespace App\Form\Model;


use App\Entity\Film;
use Symfony\Component\Validator\Constraints as Assert;

class FilmDataModel
{
    /**
     * @var null
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=2,
     *     max=50,
     *     maxMessage="Describe your film in 50 chars or less"
     * )
     */
    public $title = null;


    public $description = null;
    public $price = null;

    public static function createEmpty(): self
    {
        return new self();
    }

    public static function createFromFilm(Film $film): self
    {
        $model = new self();
        $model->title = $film->getTitle();
        $model->description = $film->getDescription();
        return $model;
    }

}