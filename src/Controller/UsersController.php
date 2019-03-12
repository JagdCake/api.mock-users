<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;

class UsersController extends AbstractController
{
    /**
     * @Route("/mock_users", name="showUsers", methods={"GET"})
     */
    public function showUsers() {
        $users = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();

        if (!$users) {
            throw $this->createNotFoundException(
                'No users have been found'
            );
        }

        // TODO return all users as json
        return $this->json([
            'first_name' => $users[0]->getFirstName(),
        ]);
    }
}
