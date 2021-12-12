<?php


namespace App\Service\Rental;


use App\Entity\Film;
use App\Entity\FilmOwnerRelation;
use App\Entity\FilmType;
use App\Provider\FilmProvider;
use Doctrine\ORM\EntityManagerInterface;

class RentalFilmHandler
{
    /**
     * @var FilmProvider
     */
    private $filmProvider;
    private $entityManager;

    public function __construct(FilmProvider $filmProvider, EntityManagerInterface $entityManager)
    {
        $this->filmProvider = $filmProvider;
        $this->entityManager = $entityManager;
    }


    public function rental($user, $filmId, $countFilms = 1, $days = 1)
    {
        $films = [];
        $quantityPrice = 0;

        for ($i = 1; $i <= $countFilms; $i++) {
            //todo: mejorar :(
            $originFilm = $this->filmProvider->getById($filmId);
            $filmType = $originFilm->getFilmType();

            $quantityPrice += $originFilm->getPrice();

            /*if ($filmType->getId() == FilmType::NEW_RELEASE_TYPE && $days > $filmType->getValidDays()) {
                $daySum = $days - $filmType->getValidDays();
                $quantityPrice += $originFilm->getPrice() * $daySum;
            }
            */

            $filmOwnerRelation = new FilmOwnerRelation(
                $originFilm,
                $user,
                $originFilm->getFilmType()->getPoint()
            );

            $this->entityManager->persist($filmOwnerRelation);

            $films[] = $originFilm;
        }

       $totalPrice = $quantityPrice * $days;

        return $totalPrice;

    }
}