<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->redirect('users');
    }

    /**
     * @Route("/jsonFunction", name="jsonFunction")
     */
    public function jsonFunction()
    {
        return $this->json([
            'message' => 'List all products'
        ]);
    }

    /**
     * @Route("/responseClass/{name?}", name="responseClass.show")
     */
    public function responseClass(Request $request)
    {
        $name = $request->get('name') ? $request->get('name') : 'N/A';
        return new Response("<h1>Hello My $name</h1>");
    }

}
