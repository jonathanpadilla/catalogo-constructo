<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Categoria;
use \stdClass;

class CatalogoController extends Controller
{
    public function indexAction($id)
    {
    	// default data
    	$parameters = $this->get('service.parameters');
    	$parameters->setHeaderTitle('Catalogo');

    	// cargar menu
    	$menu_categoria = $this->cargarMenuCategoria($id);

    	// cargar select de formulario agregar nueva categoria
    	$lista_categoria_padre = $this->cargarSelectCategoriaPadre();

    	if($id)
    	{

    	}else{
    		$parameters->setBreadcrumbs(array('Catalogo' => 'Catalogo'));
    		$lista_categorias = $this->cargarListaCategoria();
    	}

    	// if($id)
    	// {
    	// 	$menu_categoria = $this->cargarCategoria(true);

    	// 	$categoria_seleccionada = $em->getRepository('AdminBundle:Categoria')->findOneBy(array('catIdPk' => $id ));
    	// 	$parameters->setBreadcrumbs('categoria', $categoria_seleccionada->getCatIdPk());
    	// }else{
    	// 	$menu_categoria = $this->cargarCategoria();
    	// 	$parameters->setBreadcrumbs(array('Catalogo' => 'url'));
    	// }

    	// echo '<pre>';print_r($lista_categorias);exit;

        return $this->render('AdminBundle::catalogo.html.twig', array(
        	'default_data' 			=> $parameters->getAll(),
        	'menu_categorias' 		=> $menu_categoria,
        	'lista_categoria_padre'	=> $lista_categoria_padre,
        	'lista_categorias'		=> $lista_categorias
        	));
    }

    public function guardarCategoriaAction(Request $request)
    {
    	if( $request->getMethod() == 'POST' )
    	{
    		$nombre 	= $request->get('nombre', false);
    		$padre 		= $request->get('padre', false);
    		$imagen 	= $request->files->get('imagen', null);
    		$comentario = $request->get('comentario', false);

    		$dir_image = $this->subirImagen($imagen);

    		$em = $this->getDoctrine()->getManager();

    		$fk_padre = null;
    		if($padre != 'default')
    		{
    			$fk_padre = $em->getRepository('AdminBundle:Categoria')->findOneBy(array('catIdPk' => $padre));
    		}

    		$categoria = new Categoria();
    		$categoria->setCatNombre($nombre);
    		$categoria->setCatFoto($dir_image);
    		$categoria->setCatDescripcion($comentario);
    		$categoria->setCatActivo(1);
    		$categoria->setCatFechaRegistro(new \DateTime(date("Y-m-d H:i:s")));
    		$categoria->setCatPadreFk($fk_padre);
    		$em->persist($categoria);
    		$em->flush();
    	}

    	return $this->redirectToRoute('admin_catalogo');
    }

    private function cargarMenuCategoria($active = false)
    {
    	$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();

		$result = array();

		$q  = $qb->select(array('c'))
            ->from('AdminBundle:Categoria', 'c')
            ->where($qb->expr()->andX(
                        $qb->expr()->isNull('c.catPadreFk'),
                        $qb->expr()->eq('c.catActivo', 1)
                    )
            	)
            ->getQuery();

        if($resultQuery = $q->getResult())
        {
        	foreach($resultQuery as $value)
        	{
        		$data = new stdClass();

        		$data->id 		= $value->getCatIdPk();
        		$data->nombre 	= $value->getCatNombre();

        		if($sub = $em->getRepository('AdminBundle:Categoria')->findBy(array('catPadreFk' => $value->getCatIdPk(), 'catActivo' => 1 )))
        		{
        			foreach($sub as $value2)
        			{
        				$data2 = new stdClass();

        				$data2->id 		= $value2->getCatIdPk();
        				$data2->nombre 	= $value2->getCatNombre();

        				$data->sub[] = $data2;
        			}
        		}

        		$result[] = $data;
        	}
        }

        return $result;
    }

    private function cargarSelectCategoriaPadre()
    {
    	$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();
		$return = false;

		$q  = $qb->select(array('c'))
            ->from('AdminBundle:Categoria', 'c')
            ->where($qb->expr()->andX(
                        $qb->expr()->isNull('c.catPadreFk'),
                        $qb->expr()->eq('c.catActivo', 1)
                    )
            	)
            ->getQuery();
        if($resultQuery = $q->getResult())
        {
        	$return = $resultQuery;
        }

        return $return;
    }

    private function cargarListaCategoria($padre = false)
    {
    	$return = false;
    	$em = $this->getDoctrine()->getManager();

    	if(!$padre)
    	{
			$qb = $em->createQueryBuilder();

			$q  = $qb->select(array('c'))
	            ->from('AdminBundle:Categoria', 'c')
	            ->where($qb->expr()->andX(
	                        $qb->expr()->isNull('c.catPadreFk'),
	                        $qb->expr()->eq('c.catActivo', 1)
	                    )
	            	)
	            ->getQuery();
	        if($resultQuery = $q->getResult())
	        {
	        	$return = $resultQuery;
	        }
    	}elseif(is_numeric($padre)){
    		if($sub = $em->getRepository('AdminBundle:Categoria')->findBy(array('catPadreFk' => $padre, 'catActivo' => 1 )))
    		{
    			$return = $sub;
    		}
    	}

    	return $return;
    }

    private function subirImagen($foto)
    {
        $result = null;
        if($foto)
        {
            $obj = array(
                'filesize'      => $foto->getClientSize(),
                'filetype'      => $foto->getClientMimeType(),
                'fileextension' => $foto->getClientOriginalExtension(),
                'filenewname'   => uniqid().".".$foto->getClientOriginalExtension(),
                'filenewpath'   => __DIR__.'/../../../web/uploads/img'
            );
            if($obj['filesize'] <= 5242880 && ($obj['filetype'] == 'image/png' || $obj['filetype'] == 'image/jpeg') )
            {
                $foto->move($obj['filenewpath'], $obj['filenewname']);
                $result = $obj['filenewname'];
            }
        }
        return $result;
    }
}