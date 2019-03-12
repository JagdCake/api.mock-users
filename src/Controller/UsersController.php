<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends AbstractController
{
    /**
     * @Route("/mock_users", name="showUsers", methods={"GET"})
     */
    public function showUsers() {
        $query = $this->getDoctrine()->getManager()
            ->createQuery('select u from App\Entity\Users u');
        $users = $query->getArrayResult();

        if (!$users) {
            throw $this->createNotFoundException(
                'No users have been found'
            );
        }

        return new JsonResponse(['mock_users' => $users]);
    }
    }
}
