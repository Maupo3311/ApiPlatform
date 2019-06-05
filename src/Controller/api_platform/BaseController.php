<?php

namespace App\Controller\api_platform;

use EntityBundle\Entity\Category;
use EntityBundle\Entity\Product;
use EntityBundle\Entity\User;
use EntityBundle\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BaseController
 * @package App\Controller\api_platform
 */
class BaseController extends Controller
{
    /**
     * @param     $message
     * @param int $code
     * @return Response
     */
    protected function errorResponse($message, $code = 500)
    {
        return new Response($message, $code);
    }

    /**
     * @param $message
     * @return Response
     */
    protected function successResponse($message)
    {
        return new Response($message, 200);
    }

    /**
     * @param $object
     * @return JsonResponse
     */
    protected function jsonResponse($object)
    {
        return $this->json($object);
    }

    /**
     * @param int $id
     * @return object|null
     */
    protected function getProductById(int $id)
    {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->getDoctrine()->getRepository(Product::class);

        return $productRepository->find($id);
    }

    /**
     * @param int $id
     * @return object|null
     */
    protected function getUserById(int $id) {
        $userRepository = $this->getDoctrine()->getRepository(User::class);

        return $userRepository->find($id);
    }

    /**
     * @param int $id
     * @return object|null
     */
    protected function getCategoryById(int $id) {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);

        return $categoryRepository->find($id);
    }
}