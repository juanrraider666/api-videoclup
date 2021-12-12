<?php

namespace App\Controller\Api;

use App\Controller\ApiUtilityController;
use App\Entity\Film;
use App\Entity\FilmOwnerRelation;
use App\Entity\FilmType;
use App\Entity\User;
use App\Form\Model\RentalFilmModel;
use App\Form\RentFilmType;
use App\Provider\FilmProvider;
use App\Repository\FilmOwnerRelationRepository;
use App\Repository\FilmRepository;
use App\Service\Film\FilmFormProcessor;
use App\Service\Rental\RentalFilmHandler;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
    public function getAllByType(int $type, FilmProvider $filmProvider)
    {
        try {
            $typeFilm = $this->getEntityManager()->getRepository(FilmType::class)->findOneByName($type);
            $film = $filmProvider->getByType($typeFilm);

        } catch (Exception $exception) {
            return View::create('Films not found', Response::HTTP_BAD_REQUEST);
        }

         return View::create($film, Response::HTTP_ACCEPTED);
    }


    /**
     * @Rest\Post(path="/films/rental")
     * @Rest\View(serializerGroups={"film"}, serializerEnableMaxDepthChecks=true)
     */
    public function postRent(Request $request, RentalFilmHandler $handler, FilmOwnerRelationRepository $filmOwnerRelationRepository)
    {
        $form = $this->createForm(RentFilmType::class, new RentalFilmModel());
        $code = Response::HTTP_CREATED;
        $pay = 0;
        $userPoints = 0;
        try {
            [$pay, $user] = $handler->process($form, $request);
        }catch (\Exception $exception){
            $code = Response::HTTP_BAD_REQUEST;
        }

        if($code != 400 && $user != null) {
            $userPoints = $filmOwnerRelationRepository->getQuantityPointsUser($user);
        }

        return View::create(['totalPay' => $pay, 'totalUserPoints' => $userPoints], $code);
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
