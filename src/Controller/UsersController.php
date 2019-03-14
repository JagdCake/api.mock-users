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
            $statusCode = Response::HTTP_NOT_FOUND;
            throw $this->createNotFoundException(
                'No users have been found'
            );
        }

        $statusCode = Response::HTTP_OK;

        $response = new JsonResponse($users, $statusCode);

        return $response;
    }

    /**
     * @Route("/mock_users/{id}", name="showUser", methods={"GET"})
     */
    public function showUser($id) {
        try {
            $query = $this->getDoctrine()->getManager()
                ->createQuery('select u.first_name, u.last_name, u.age, u.sex from App\Entity\Users u where u.id = '.$id);
            $user = $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $err) {
            $user = null;
        }

        if (!$user) {
            $statusCode = Response::HTTP_NOT_FOUND;
            throw $this->createNotFoundException('No user found with ID: '.$id);
        }

        $statusCode = Response::HTTP_OK;

        $response = new JsonResponse($user, $statusCode);

        return $response;
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

        $message = 'Added a new user: '.$user->getFirstName().' '.$user->getLastName()."\n";

        $response = new JsonResponse(
            ['message' => $message],
            Response::HTTP_CREATED
        );

        return $response;
    }

    /**
     * @Route("/mock_users/{id}", name="editUser", methods={"PUT"})
     */
    public function editUser($id, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Users::class)->find($id);

        if (!$user) {
            $statusCode = Response::HTTP_NOT_FOUND;
            throw $this->createNotFoundException('No user found with ID: '.$id);
        }

        $data = json_decode($request->getContent(), true);

        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setAge($data['age']);
        $user->setSex($data['sex']);

        $entityManager->flush();

        $message = 'Updated data for user: '.$user->getFirstName().' '.$user->getLastName()."\n";
        $statusCode = Response::HTTP_OK;

        $response = new JsonResponse(
            ['message' => $message],
            $statusCode
        );

        return $response;
    }

    /**
     * @Route("/mock_users/{id}", name="deleteUser", methods={"DELETE"})
     */
    public function deleteUser($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Users::class)->find($id);

        if (!$user) {
            $statusCode = Response::HTTP_NOT_FOUND;
            throw $this->createNotFoundException('No user found with ID: '.$id);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $message = "Deleted a user\n";
        $statusCode = Response::HTTP_OK;

        $response = new JsonResponse(
            ['message' => $message],
            $statusCode
        );

        return $response;
    }

}
