<?php

namespace App\Controller;

use App\Repository\DistrictRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route(['/', '/{app}'], name: 'app_default', priority: 0)]
    public function index(DistrictRepository $repository): Response
    {
        return $this->render('default/index.html.twig');
    }
}
