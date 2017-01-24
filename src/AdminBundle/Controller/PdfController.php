<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use \stdClass;

class PdfController extends Controller
{
    public function imprimirPaginaCatalogoAction($id)
    {
    	$lista_productos = $this->cargarListaProductos($id);

    	$response = new Response (
    		$this->get('knp_snappy.pdf')->getOutputFromHtml(
	    		$this->renderView('AdminBundle::productos.html.twig', array('lista_productos' => $lista_productos)),
	            array(
	                'lowquality' 		=> false,
	                'print-media-type' 	=> true,
	                'encoding' 			=> 'utf-8',
	                'page-size' 		=> 'Letter',
	                'outline-depth' 	=> 8,
	                'orientation' 		=> 'Portrait',
	                // 'orientation' 		=> 'Landscape',
	                'title'				=> 'Contrato',
	                'header-right'		=>'',
	                'header-font-size'	=>0,
	            )),
                200,
            array(
                'Content-Type'          =>'/',
                'Content-Disposition'   => 'attachment; filename="catalogo.pdf"',
            )
        );

		return $response;
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
                    $datos->catalogo    = $value->getPrtCategoriaFk()->getCatIdPk();
                    $datos->productos   = array();

                    if($producto = $em->getRepository('AdminBundle:Producto')->findBy(array('proTipoFk' => $datos->id, 'proActivo' => 1 )))
                    {
                        foreach($producto as $value2)
                        {
                            $datos2 = new stdClass();

                            $datos2->id             = $value2->getProIdPk();
                            $datos2->codigo         = $value2->getProCodigo();
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
}