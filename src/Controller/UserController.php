<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="users.index")
     */
    public function index(Request $request)
    {
        return $this->render('users/index.html.twig');
    }

    /**
     * @Route("/users/{name?}", name="users.show")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Request $request)
    {
        $name = $request->get('name') ? $request->get('name') : 'N/A';
        return $this->render('users/show.html.twig', [
            'name' => $name,
        ]);
    }
}
