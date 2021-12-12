<?php


namespace App\Provider;

use App\Entity\FilmType;
use App\Exception\FilmNotFoundException;
use App\Repository\FilmRepository;
use Ramsey\Uuid\Nonstandard\Uuid;

class FilmProvider
{

    /**
     * @var FilmRepository
     */
    private $filmRepository;

    public function __construct(FilmRepository $filmRepository)
   {
       $this->filmRepository = $filmRepository;
   }

    public function getById(string $id)
    {
        $film = $this->filmRepository->find(Uuid::fromString($id));
        if (!$film) {
            FilmNotFoundException::throwException(sprintf('Umm, Film Not found with id %s', $id));
        }

        return $film;
    }

    public function getByType(FilmType $type)
    {
        return $this->filmRepository->findOneBy(['filmType' => $type]);
    }
}