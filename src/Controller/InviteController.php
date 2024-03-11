<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Invite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class InviteController extends AbstractController
{
    #[Route('/invite', name: 'app_invite')]
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

    #[Route('/invite/send', name: 'app_invite_send', methods: "POST")]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        // Validate request data
        $invite = new Invite();
        $invite->setInvFrom($data['inv_from']);
        $invite->setInvTo($data['inv_to']);
        $invite->setStatus(0);

        $entityManager->persist($invite);
        $entityManager->flush();

        $json_arr = [
            'msg' => 'Saved new invitation with id ' . $invite->getId(),
            'table' => 'invite',
            'operation' => 'send',
            'status' => '200'
        ];
        return $this->json($json_arr, 200);
    }

    #[Route('/invite/cancel/{id}', name: 'app_invite_cancel', methods: "DELETE")]
    public function cancel(EntityManagerInterface $entityManager, int $id): Response
    {
        $invite = $entityManager->getRepository(Invite::class)->find($id);
        if (!$invite) {
            throw $this->createNotFoundException(
                'No invite found for id ' . $id
            );
        }

        $entityManager->remove($invite);
        $entityManager->flush();

        $json_arr = [
            'msg' => 'Cancelled invitation with id ' . $id,
            'table' => 'invite',
            'operation' => 'cancel',
            'status' => '200'
        ];
        return $this->json($json_arr, 200);
    }

    #[Route('/invite/decline/{id}', name: 'app_invite_decline', methods: "PUT")]
    public function decline(EntityManagerInterface $entityManager, int $id): Response
    {
        $invite = $entityManager->getRepository(Invite::class)->find($id);
        if (!$invite) {
            throw $this->createNotFoundException(
                'No invite found for id ' . $id
            );
        }

        $invite->setStatus(2);

        // $entityManager->persist($invite);
        $entityManager->flush();

        $json_arr = [
            'msg' => 'Declined invitation with id ' . $id,
            'table' => 'invite',
            'operation' => 'decline',
            'status' => '200'
        ];
        return $this->json($json_arr, 200);
    }

    #[Route('/invite/accept/{id}', name: 'app_invite_accept', methods: "PUT")]
    public function accept(EntityManagerInterface $entityManager, int $id): Response
    {
        $invite = $entityManager->getRepository(Invite::class)->find($id);
        if (!$invite) {
            throw $this->createNotFoundException(
                'No invite found for id ' . $id
            );
        }

        $invite->setStatus(1);

        $entityManager->persist($invite);
        $entityManager->flush();

        $json_arr = [
            'msg' => 'Accepted invitation with id ' . $id,
            'table' => 'invite',
            'operation' => 'accept',
            'status' => '200'
        ];
        return $this->json($json_arr, 200);
    }
}
