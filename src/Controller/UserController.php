<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    private $entityManager;

    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        if (!$users) {
            return $this->json(['message' => 'No Users found!'], 404);
        }

        $json_arr = [
            'total' => count($users),
            'table' => 'user',
            'operation' => 'list',
            'status' => '200'
        ];

        foreach ($users as $u) {
            $userArray = [
                'id' => $u->getId(),
                'name' => $u->getName()
            ];
            array_push($json_arr, $userArray);
        }

        return $this->json($json_arr, 200);
    }

    #[Route('/user/create', name: 'app_user_create', methods: "POST")]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Validate request data
        $user = new User();
        $user->setName($data['name']);

        $entityManager->persist($user);
        $entityManager->flush();

        $json_arr = [
            'msg' => 'Saved new product with id ' . $user->getId(),
            'table' => 'user',
            'operation' => 'create',
            'status' => '200'
        ];
        return $this->json($json_arr, 200);
    }

    #[Route('/user/insert', name: 'app_user_insert')]
    public function insert(EntityManagerInterface $entityManager)
    {
        $user = new User();
        $user->setName('aka');

        $entityManager->persist($user);
        $entityManager->flush();

        $json_arr = [
            'msg' => 'Saved new product with id ' . $user->getId(),
            'table' => 'user',
            'operation' => 'insert',
            'status' => '200'
        ];
        return $this->json($json_arr, 200);
    }
}
