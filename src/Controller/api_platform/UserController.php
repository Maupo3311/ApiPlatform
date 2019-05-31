<?php

namespace App\Controller\api_platform;

use App\Services\ApiHelperService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use EntityBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @Route("/api")
 * @package App\Controller\api_platform
 */
class UserController extends BaseController
{
    /**
     * @Route(
     *     "/me",
     *     name="get_me",
     *     methods={"GET"}
     *     )
     * @return JsonResponse|Response
     */
    public function getMeAction()
    {
        if (!$user = $this->getUser()) {
            return $this->errorResponse('You are not logged in', 401);
        } else {
            return $this->jsonResponse($user);
        }
    }

    /**
     * @Route(
     *     "/users/{id}/basket",
     *     name="get_basket_items_by_user",
     *     methods={"GET"}
     *     )
     * @param int $id
     * @return JsonResponse|Response
     */
    public function getBasketItemsAction(int $id)
    {
        /** @var User $user */
        if (!$user = $this->getUserById($id)) {
            return $this->errorResponse('User not found', 404);
        } else {
            return $this->jsonResponse($user->getBasketItems());
        }
    }

    /**
     * @Route(
     *     "/users/{id}/comments",
     *     name="get_comments_by_user",
     *     methods={"GET"}
     *     )
     * @param int $id
     * @return JsonResponse|Response
     */
    public function getCommentsAction(int $id)
    {
        /** @var User $user */
        if (!$user = $this->getUserById($id)) {
            return $this->errorResponse('User not found', 404);
        } else {
            return $this->jsonResponse($user->getComments());
        }
    }

    /**
     * @Route(
     *     "/users/{id}",
     *     name="put_user",
     *     methods={"PUT"}
     *     )
     * @param int     $id
     * @param Request $request
     * @return bool|string|Response
     */
    public function putAction(int $id, Request $request)
    {
        /** @var User $user */
        if (!$user = $this->getUserById($id)) {
            return $this->errorResponse('User not found', 404);
        }

        /** @var User $currentUser */
        if (!$currentUser = $this->getUser()) {
            return $this->errorResponse('You are not logged in', 401);
        }

        if (!$currentUser->hasRole('ROLE_ADMIN')) {
            return $this->errorResponse('You cannot change users', 403);
        }

        if ($user->hasRole('ROLE_ADMIN')) {
            return $this->errorResponse('You cannot change an administrator', 403);
        }

        /** @var ApiHelperService $apiHelper */
        $apiHelper = $this->get('app.api_helper');

        $possibleChange = [
            'firstName',
            'lastName',
            'username',
        ];

        return $apiHelper->putEntity($request, $user, $possibleChange);
    }

    /**
     * @Route(
     *     "/users/{id}",
     *     name="delete_user",
     *     methods={"DELETE"}
     *     )
     * @param int $id
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteAction(int $id)
    {
        /** @var User $user */
        if (!$user = $this->getUserById($id)) {
            return $this->errorResponse('User not found', 404);
        }

        /** @var User $currentUser */
        if (!$currentUser = $this->getUser()) {
            return $this->errorResponse('You are not logged in', 401);
        }

        if (!$currentUser->hasRole('ROLE_ADMIN')) {
            return $this->errorResponse('You cannot delete users', 403);
        }

        if ($user->hasRole('ROLE_ADMIN')) {
            return $this->errorResponse('You cannot delete an administrator', 403);
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($user);
        $em->flush();

        return $this->successResponse('User successful removed');
    }
}