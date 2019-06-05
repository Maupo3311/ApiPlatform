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
            return $this->errorResponse('You are not logged in', 401);
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

    /**
     * @Route(
     *     "/product",
     *     name="post_product",
     *     methods={"POST"}
     *     )
     * @param Request $request
     * @return Response
     */
    public function postAction(Request $request)
    {
        /** @var User $user */
        if (!$user = $this->getUser()) {
            return $this->errorResponse('You are not logged in', 401);
        }

        try {
            if (!$category = $request->query->get('category_id')) {
                return $this->errorResponse('Category not found', 404);
            }

            $product = new Product();
            $product->setDescription($request->query->get('description'))
                ->setNumber($request->query->get('number'))
                ->setRating($request->query->get('rating'))
                ->setCategory($category)
                ->setPrice($request->query->get('price'))
                ->setTitle($request->query->get('title'))
                ->setActive(1);

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            $this->successResponse('Product successful created');
        } catch (\Exception $exception) {
            $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}