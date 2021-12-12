<?php


namespace App\Service\Film;


use App\Entity\Film;
use App\Form\FilmFormType;
use App\Form\Model\FilmDataModel;
use App\Provider\FilmProvider;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class FilmFormProcessor
{

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var FilmRepository
     */
    private $filmRepository;
    /**
     * @var FilmProvider
     */
    private $filmProvider;
    private  $entityManager;

    public function __construct(FormFactoryInterface $formFactory, FilmRepository $filmRepository, FilmProvider $filmProvider, EntityManagerInterface $entityManager)
    {
        $this->formFactory = $formFactory;
        $this->filmRepository = $filmRepository;
        $this->filmProvider = $filmProvider;
        $this->entityManager = $entityManager;
    }

    public function __invoke(Request $request, ?string $bookId = null): array
    {
        $film = null;

        if ($bookId === null) {
            $filmDto = FilmDataModel::createEmpty();
        } else {
            $film = $this->filmProvider->getByIdString($bookId);
            $filmDto = FilmDataModel::createFromFilm($film);
        }

        $content = json_decode($request->getContent(), true);
        $form = $this->formFactory->create(FilmFormType::class, $filmDto);

        $form->submit($content);
        if (!$form->isSubmitted()) {
            return [null, 'Form is not submitted'];
        }
        if (!$form->isValid()) {
            return [null, $form];
        }

        if ($film === null) {
            $film = $this->postCreate($filmDto);
        } else {
            $this->postUpdate($film, $filmDto);
        }

//        $this->filmRepository->save($film);

        $this->entityManager->persist($film);
        $this->entityManager->flush();

        return [$film, null];
    }


    private function postCreate(FilmDataModel $dataModel): Film
    {
        return Film::createFromModel($dataModel);
    }

    private function postUpdate(Film $film, FilmDataModel $dataModel)
    {
       $film->update($dataModel->title, $dataModel->description, $dataModel->price);
    }
}