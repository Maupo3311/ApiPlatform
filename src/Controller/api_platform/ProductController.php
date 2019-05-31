<?php

namespace App\Controller\api_platform;

use App\Services\ApiHelperService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use EntityBundle\Entity\Product;
use EntityBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @Route("/api")
 * @package App\Controller\api_platform
 */
class ProductController extends BaseController
{
    /**
     * @Route(
     *     "/product/{id}/get-shop",
     *     name="get_shop_by_product",
     *     methods={"GET"}
     *     )
     * @param int $id
     * @return JsonResponse|Response
     */
    public function getShopAction(int $id)
    {
        if (!$product = $this->getProductById($id)) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->jsonResponse($product->getCategory()->getShop());
    }

    /**
     * @Route(
     *     "/product/{id}/get-category",
     *     name="get_category_by_product",
     *     methods={"GET"}
     *     )
     * @param int $id
     * @return JsonResponse|Response
     */
    public function getCategoryAction(int $id)
    {
        /** @var Product $product */
        if (!$product = $this->getProductById($id)) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->jsonResponse($product->getCategory());
    }

    /**
     * @Route(
     *     "/product/{id}/get-comments",
     *     name="get_comments_by_product",
     *     methods={"GET"}
     *     )
     * @param int $id
     * @return JsonResponse|Response
     */
    public function getCommentsAction(int $id)
    {
        /** @var Product $product */
        if (!$product = $this->getProductById($id)) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->jsonResponse($product->getComments());
    }

    /**
     * @Route(
     *     "/product/{id}",
     *     name="delete_product",
     *     methods={"DELETE"}
     *     )
     * @param int $id
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteAction(int $id)
    {
        if (!$product = $this->getProductById($id)) {
            return $this->errorResponse('product not found', 404);
        }

        /** @var User $user */
        if (!$user = $this->getUser()) {
            return $this->errorResponse('You are not logged in');
        }

        if (!$user->hasRole('ROLE_ADMIN')) {
            return $this->errorResponse('You cannot delete products', 403);
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($product);
        $em->flush();

        return $this->successResponse('product successful removed');
    }

    /**
     * @Route(
     *     "/product/{id}",
     *     name="put_product",
     *     methods={"PUT"}
     *     )
     * @param int     $id
     * @param Request $request
     * @return bool|string|Response
     */
    public function putAction(int $id, Request $request)
    {
        /** @var Product $product */
        if (!$product = $this->getProductById($id)) {
            return $this->errorResponse('Product not found', 404);
        }
        /** @var User $user */
        if (!$user = $this->getUser()) {
            return $this->errorResponse('You are not logged in');
        }

        if (!$user->hasRole('ROLE_ADMIN')) {
            return $this->errorResponse('You cannot delete products', 403);
        }

        /** @var ApiHelperService $apiHelper */
        $apiHelper = $this->get('app.api_helper');

        $possibleChange = [
            'number',
            'title',
            'description',
            'price',
            'rating',
        ];

        return $apiHelper->putEntity($request, $product, $possibleChange);
    }
}