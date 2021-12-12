<?php


namespace App\Service\Rental;


use App\Entity\Film;
use App\Entity\FilmOwnerRelation;
use App\Entity\FilmType;
use App\Entity\User;
use App\Form\Model\RentalFilmModel;
use App\Provider\FilmProvider;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

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


    public function process(FormInterface $form, $request)
    {
        $content = json_decode($request->getContent(), true);
        $form->submit($content);
        if (!$form->isSubmitted()) {
            throw new Exception('No submit!');
        }
        if (!$form->isValid()) {
            throw new Exception('Invalid form');
        }
        /** @var RentalFilmModel $rentalData */
        $rentalData = $form->getData();

        return $this->rental($rentalData->user, $rentalData->film, $rentalData->count, $rentalData->days);

    }

    private function rental(int $userId, int $filmId, int $countFilms, int $days): array
    {
        $quantityPrice = 0;
        $user = $this->entityManager->find(User::class, $userId);

        if (!$user instanceof User) {
            throw new Exception('Og men! user no identifier');
        }

        $originFilm = $this->filmProvider->getById($filmId);
        $filmType = $originFilm->getFilmType();

        for ($i = 1; $i <= $countFilms; $i++) {
            $quantityPrice += $originFilm->getPrice();

            if ($filmType->getId() == FilmType::NORMAL_TYPE && $days > $filmType->getValidDays()) {
                $daySum = $days - $filmType->getValidDays();
                $quantityPrice += $originFilm->getPrice() * $daySum;
            }

            if ($filmType->getId() == FilmType::OLD_TYPE && $days > $filmType->getValidDays()) {
                $daySum = $days - $filmType->getValidDays();
                $quantityPrice += $originFilm->getPrice() * $daySum;
            }

            $filmOwnerRelation = new FilmOwnerRelation(
                $originFilm,
                $user,
                $originFilm->getFilmType()->getPoint()
            );

            $this->entityManager->persist($filmOwnerRelation);
        }

        $this->entityManager->flush();

        if ($filmType->getId() == FilmType::NEW_RELEASE_TYPE) {
            $totalPrice =  $quantityPrice  * $days;
        }else{
            $totalPrice = $quantityPrice;
        }

        return [$totalPrice, $user];

    }
}