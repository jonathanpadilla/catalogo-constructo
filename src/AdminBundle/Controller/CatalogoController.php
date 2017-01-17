<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Categoria;
use AdminBundle\Entity\ProductoTipo;
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
            $lista_categorias = $this->cargarListaCategoria($id);
            $parameters->setBreadcrumbs('categoria', $id);

            $lista_productos = $this->cargarListaProductos($id);
    	}else{
    		$parameters->setBreadcrumbs(array('Catalogo' => 'Catalogo'));
    		$lista_categorias = $this->cargarListaCategoria();

            $lista_productos = false;
    	}

        if($lista_productos)
        {
            $vista_productos = $this->renderView('AdminBundle::productos.html.twig', array('lista_productos' => $lista_productos));
        }else{
            $vista_productos = false;
        }

    	// echo '<pre>';print_r($lista_productos);exit;
        return $this->render('AdminBundle::catalogo.html.twig', array(
        	'default_data' 			=> $parameters->getAll(),
        	'menu_categorias' 		=> $menu_categoria,
        	'lista_categoria_padre'	=> $lista_categoria_padre,
        	'lista_categorias'		=> $lista_categorias,
            'vista_productos'       => $vista_productos,
            'id_categoria'          => $id
        	));

    }

    public function guardarCategoriaAction(Request $request)
    {
    	if( $request->getMethod() == 'POST' )
    	{
            $id_update  = ucfirst($request->get('id_update', false));
    		$nombre 	= ucfirst($request->get('nombre', false));
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

            if(!$categoria = $em->getRepository('AdminBundle:Categoria')->findOneBy(array('catIdPk' => $id_update)))
            {
    		  $categoria = new Categoria();  
    		  $categoria->setCatActivo(1);
    		  $categoria->setCatFechaRegistro(new \DateTime(date("Y-m-d H:i:s")));
            }

            $categoria->setCatNombre($nombre);
            $categoria->setCatFoto($dir_image);
            $categoria->setCatDescripcion($comentario);
    		$categoria->setCatPadreFk($fk_padre);
    		$em->persist($categoria);
    		$em->flush();
    	}

    	return $this->redirectToRoute('admin_catalogo');
    }

    public function eliminarCategoriaAction(Request $request)
    {
        $id = $request->get('id', false);
        $em = $this->getDoctrine()->getManager();

        if($categoria = $em->getRepository('AdminBundle:Categoria')->findOneBy(array('catIdPk' => $id)))
        {
            $categoria->setCatActivo(0);
            $em->persist($categoria);
            $em->flush();
        }

        echo json_encode(array(true));
        exit;
    }

    public function guardarTablaAction(Request $request)
    {
        if( $request->getMethod() == 'POST' )
        {
            $id_categoria   = $request->get('id_categoria');
            $nombre         = ucfirst($request->get('nombre'));
            $subtexto       = ucfirst($request->get('subtexto'));
            $imagen         = $request->files->get('imagen', null);

            $dir_image = $this->subirImagen($imagen);

            $em = $this->getDoctrine()->getManager();

            $fk_categoria = $em->getRepository('AdminBundle:Categoria')->findOneBy(array('catIdPk' => $id_categoria));

            $tabla = new ProductoTipo();
            $tabla->setPrtNombre($nombre);
            $tabla->setPrtSubtexto($subtexto);
            $tabla->setPrtImagen($dir_image);
            $tabla->setPrtActivo(1);
            $tabla->setPrtFechaRegistro(new \DateTime(date("Y-m-d H:i:s")));
            $tabla->setPrtCategoriaFk($fk_categoria);
            $em->persist($tabla);
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

                        if($active == $value2->getCatIdPk())
                        {
                            $data->active  = true;
                            $data2->active = true;
                        }

                        // activar menu

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

    private function cargarListaProductos($id = false)
    {
        $result = false;

        if($id)
        {
            $em = $this->getDoctrine()->getManager();

            if($producto_tipo = $em->getRepository('AdminBundle:ProductoTipo')->findBy(array('prtCategoriaFk' => $id, 'prtActivo' => 1 )))
            {
                $lista = array();
                foreach($producto_tipo as $value)
                {
                    $datos = new stdClass();

                    $datos->id          = $value->getPrtIdPk();
                    $datos->nombre      = $value->getPrtNombre();
                    $datos->subtext     = $value->getPrtSubtexto();
                    $datos->imagen      = $value->getPrtImagen();
                    $datos->productos   = array();

                    if($producto = $em->getRepository('AdminBundle:Producto')->findBy(array('proTipoFk' => $datos->id, 'proActivo' => 1 )))
                    {
                        foreach($producto as $value2)
                        {
                            $datos2 = new stdClass();

                            $datos2->id             = $value2->getProIdPk();
                            $datos2->codigo_factura = $value2->getProCodigoFactusol();
                            $datos2->producto       = $value2->getProProducto();
                            $datos2->cantidad       = $value2->getProCantidad();
                            $datos2->precioReal     = $value2->getProPrecioReal();
                            $datos2->precioVenta    = $value2->getProPrecioVentas();

                            $datos->productos[] = $datos2;
                        }
                    }

                    $lista[] = $datos;

                }

                $result = $lista;

            }
        }

        return $result;
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
            if($obj['filetype'] == 'image/png' || $obj['filetype'] == 'image/jpeg')
            {
                echo '123';
                $foto->move($obj['filenewpath'], $obj['filenewname']);
                $result = $obj['filenewname'];
            }
        }
        return $result;
    }
}