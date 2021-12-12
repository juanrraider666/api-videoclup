<?php


namespace App\Service\Rental;


use App\Entity\Film;
use App\Entity\FilmOwnerRelation;
use App\Entity\FilmType;
use App\Provider\FilmProvider;

class RentalFilmHandler
{
    /**
     * @var FilmProvider
     */
    private $filmProvider;

    public function __construct(FilmProvider $filmProvider)
    {
        $this->filmProvider = $filmProvider;
    }


    public function rental($user, $filmId, $countFilms = 1, $days = 1)
    {
        /**
         3 peliculas x 3 dias
         */

        $films = [];
        $quantityPrice = 0;

        for ($i = 1; $i <= $countFilms; $i++) {
            //todo: mejorar :(
            $originFilm = $this->filmProvider->getById($filmId);
            $filmType = $originFilm->getFilmType();

            if($filmType == FilmType::NEW_RELEASE_TYPE) {
                $quantityPrice += $originFilm->getPrice();
            }

            if($filmType == FilmType::NORMAL_TYPE) {
                $quantityPrice += $originFilm->getPrice();
            }

            $quantityPrice += $originFilm->getPrice();
            $films[] = $originFilm;
        }

       $totalPrice = $quantityPrice * $days;

    }
}