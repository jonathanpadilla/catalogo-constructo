<?php
namespace AdminBundle\Services;

use Doctrine\ORM\EntityManager;
 
class Parameters
{
    private $lang 				= 'es';
    private $class_body 		= '';
    private $header_title 		= 'Admin';
    private $header_keywords 	= 'Catalogo constructor admin';
    private $header_description = 'Administrador de catalogo constructor';
    private $header_autor		= 'http://tuciudad.cl/';

    private $breadcrumbs_key;
    private $breadcrumbs_value;

    private $em;
 
    public function __construct(EntityManager $entityManager)
    {
    	$this->em = $entityManager;
    }

    private function buildBreadcrumbs()
    {
    	$return = array();

    	if(!is_array($this->breadcrumbs_key))
    	{
    		if($this->breadcrumbs_key == 'categoria')
    		{
    			$categoria = $this->em->getRepository('AdminBundle:Categoria')->findOneBy(array('catIdPk' => $this->breadcrumbs_value ));

    			$new_breadcrumb = array('Catalogo' => 'url');
    			if($categoria->getCatPadreFk())
    			{
    				$new_breadcrumb[$categoria->getCatPadreFk()->getCatNombre()] = 'url';
    			}
    			$new_breadcrumb[$categoria->getCatNombre()] = $categoria->getCatNombre();
    			$return = $new_breadcrumb;
    		}

    	}else{
    		$return = $this->breadcrumbs_key;
    	}

    	return $return;
    }

    private function isAssoc(array $arr)
	{
	    if (array() === $arr) return false;
	    return array_keys($arr) !== range(0, count($arr) - 1);
	}

	// SETTERS

    public function setLang($lang)
    {
    	$this->lang = $lang;
    }

    public function setClassBody($class_body)
    {
    	$this->class_body = $class_body;
    }

    public function setHeaderTitle($header_title)
    {
    	$this->header_title = $header_title;
    }

    public function setHeaderKeywords($header_keywords)
    {
    	$this->header_keywords = $header_keywords;
    }

    public function setHeaderDescription($header_description)
    {
    	$this->header_description = $header_description;
    }

    public function setHeaderAutor($header_autor)
    {
    	$this->header_autor = $header_autor;
    }

    public function setBreadcrumbs($key, $value = false)
    {
    	if(is_numeric($value))
    	{
    		$this->breadcrumbs_value = $value;
    	}

    	$this->breadcrumbs_key = $key;
    }

    // GETTERS
    public function getAll()
    {
    	return array(
    		'lang' 			=> $this->lang,
			'class_body' 	=> $this->class_body,
			'header' 		=> array(
								'title' 		=> $this->header_title,
								'keywords' 		=> $this->header_keywords,
								'description' 	=> $this->header_description,
								'autor' 		=> $this->header_autor,
							),
			'breadcrumbs'	=> $this->buildBreadcrumbs(),
    	);
    }
}