<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends Controller
{

    /**
     * @Route("/")
     * @return RedirectResponse
     */
    public function indexAction()
    {
        return $this->redirect('/api');
    }
}