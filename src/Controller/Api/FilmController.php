<?php

namespace App\Controller\Api;

use App\Controller\ApiUtilityController;
use App\Entity\Film;
use App\Entity\FilmType;
use App\Entity\User;
use App\Provider\FilmProvider;
use App\Repository\FilmRepository;
use App\Service\Film\FilmFormProcessor;
use App\Service\Rental\RentalFilmHandler;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FilmController extends ApiUtilityController
{
    /**
     * @Rest\Get(path="/films")
     * @Rest\View(serializerGroups={"film"}, serializerEnableMaxDepthChecks=true)
     */
    public function list(FilmRepository $filmRepository)
    {
        return $filmRepository->findAll();
    }

    /**
     * @Rest\Get(path="/films/{type}")
     * @Rest\View(serializerGroups={"film"}, serializerEnableMaxDepthChecks=true)
     */
    public function getSingleByType($type, FilmProvider $filmProvider)
    {
        try {
            $typeFilm = $this->getEntityManager()->getRepository(FilmType::class)->findOneByName($type);
            $film = $filmProvider->getByType($typeFilm);
        } catch (Exception $exception) {
            return View::create('Film not found', Response::HTTP_BAD_REQUEST);
        }
        return $film;
    }


    /**
     * @Rest\Post(path="/films/rental/{user}/{film}/{count}/{days}")
     * @Rest\View(serializerGroups={"film"}, serializerEnableMaxDepthChecks=true)
     */
    public function postRent($user, $film, int $count, int $days, FilmProvider $filmProvider, RentalFilmHandler $handler)
    {
        $owner = $this->getEntityManager()->find(User::class, $user);
        $totalQuantity = $handler->rental($owner, $film, $count, $days);
        return $this->createApiResponse(['total' => $totalQuantity]);
    }


    /**
     * @Rest\Post(path="/films")
     * @Rest\View(serializerGroups={"film"}, serializerEnableMaxDepthChecks=true)
     */
    public function postAction(
        FilmFormProcessor $formProcessor,
        Request $request
    ) {
        [$book, $error] = ($formProcessor)($request);
        $statusCode = $book ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST;
        $data = $book ?? $error;
        return View::create($data, $statusCode);
    }
}
