<?php


namespace App\Form\Model;


use App\Entity\Film;

class FilmDataModel
{
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