<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->entityManager;
    }
}
