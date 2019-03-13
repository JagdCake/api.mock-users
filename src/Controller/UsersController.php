<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

        return new JsonResponse($users);
    }

    /**
     * @Route("/mock_users", name="addUser", methods={"POST"})
     */
    public function addUser(Request $request) {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();

        $user = new Users();
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setAge($data['age']);
        $user->setSex($data['sex']);

        $entityManager->persist($user);

        $entityManager->flush();

        $message = 'Saved new user with id '.$user->getId()."\n";

        $response = new JsonResponse(
            ['message' => $message],
            Response::HTTP_CREATED
        );

        return $response;
    }
}
