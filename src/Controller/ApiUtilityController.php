<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

abstract class ApiUtilityController extends AbstractController
{

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    public function addFlashCustom($message, $positiveNotice = true)
    {
        /** @var Request $request */
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $noticeKey = $positiveNotice ? 'notice_happy' : 'notice_sad';
        $request->getSession()->getFlashbag()->add($noticeKey, $message);
    }

    /**
     * Atajo para agregar log.
     *
     * @param string $level
     * @param string $message
     * @param array|null $context
     */
    protected function addLog(string $level, string $message, ?array $context): void
    {
        $this->logger->log($level, $message, $context);
    }

    protected function getResponseJson($data): JsonResponse
    {
        $response = new JsonResponse();
        $response->setData([
            'success' => true,
            'data' => $data
        ]);

        return $response;
    }

    protected function createApiResponse($data, $statusCode = 200)
    {
        $json = $this->serialize($data);
        return new Response($json, $statusCode, array(
            'Content-Type' => 'application/json'
        ));
    }

    protected function serialize($data, $format = 'json')
    {
        return $this->container->get('jms_serializer')
            ->serialize($data, $format);
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }
}
