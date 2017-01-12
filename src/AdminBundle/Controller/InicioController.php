<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InicioController extends Controller
{
    public function indexAction()
    {
    	return $this->redirectToRoute('admin_catalogo');
    }
}