<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/users/email/{email}", name="get_user_by_email", methods={"GET"})
     */
    public function getUserByEmail(string $email): JsonResponse
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $responseData = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'firstname' => $user->getFirstname(),
            'tel' => $user->getTel(),
            'clients' => $user->getClients(),
            'admin' => $user->getAdmin(),
            'submissions' => $user->getSubmissions(),
            'documents' => $user->getDocuments(),
            'roles' => $user->getRoles(),
        ];

        return new JsonResponse($responseData);
    }
}

