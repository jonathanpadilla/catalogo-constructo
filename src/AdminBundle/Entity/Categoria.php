<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoria
 *
 * @ORM\Table(name="categoria", indexes={@ORM\Index(name="cat_padre_fk", columns={"cat_padre_fk"})})
 * @ORM\Entity
 */
class Categoria
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cat_id_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $catIdPk;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_nombre", type="string", length=100, nullable=true)
     */
    private $catNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_foto", type="string", length=100, nullable=true)
     */
    private $catFoto;

    /**
     * @var string
     *
     * @ORM\Column(name="cat_descripcion", type="text", length=65535, nullable=true)
     */
    private $catDescripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="cat_activo", type="integer", nullable=true)
     */
    private $catActivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cat_fecha_registro", type="datetime", nullable=true)
     */
    private $catFechaRegistro;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat_padre_fk", referencedColumnName="cat_id_pk")
     * })
     */
    private $catPadreFk;



    /**
     * Get catIdPk
     *
     * @return integer 
     */
    public function getCatIdPk()
    {
        return $this->catIdPk;
    }

    /**
     * Set catNombre
     *
     * @param string $catNombre
     * @return Categoria
     */
    public function setCatNombre($catNombre)
    {
        $this->catNombre = $catNombre;

        return $this;
    }

    /**
     * Get catNombre
     *
     * @return string 
     */
    public function getCatNombre()
    {
        return $this->catNombre;
    }

    /**
     * Set catFoto
     *
     * @param string $catFoto
     * @return Categoria
     */
    public function setCatFoto($catFoto)
    {
        $this->catFoto = $catFoto;

        return $this;
    }

    /**
     * Get catFoto
     *
     * @return string 
     */
    public function getCatFoto()
    {
        return $this->catFoto;
    }

    /**
     * Set catDescripcion
     *
     * @param string $catDescripcion
     * @return Categoria
     */
    public function setCatDescripcion($catDescripcion)
    {
        $this->catDescripcion = $catDescripcion;

        return $this;
    }

    /**
     * Get catDescripcion
     *
     * @return string 
     */
    public function getCatDescripcion()
    {
        return $this->catDescripcion;
    }

    /**
     * Set catActivo
     *
     * @param integer $catActivo
     * @return Categoria
     */
    public function setCatActivo($catActivo)
    {
        $this->catActivo = $catActivo;

        return $this;
    }

    /**
     * Get catActivo
     *
     * @return integer 
     */
    public function getCatActivo()
    {
        return $this->catActivo;
    }

    /**
     * Set catFechaRegistro
     *
     * @param \DateTime $catFechaRegistro
     * @return Categoria
     */
    public function setCatFechaRegistro($catFechaRegistro)
    {
        $this->catFechaRegistro = $catFechaRegistro;

        return $this;
    }

    /**
     * Get catFechaRegistro
     *
     * @return \DateTime 
     */
    public function getCatFechaRegistro()
    {
        return $this->catFechaRegistro;
    }

    /**
     * Set catPadreFk
     *
     * @param \AdminBundle\Entity\Categoria $catPadreFk
     * @return Categoria
     */
    public function setCatPadreFk(\AdminBundle\Entity\Categoria $catPadreFk = null)
    {
        $this->catPadreFk = $catPadreFk;

        return $this;
    }

    /**
     * Get catPadreFk
     *
     * @return \AdminBundle\Entity\Categoria 
     */
    public function getCatPadreFk()
    {
        return $this->catPadreFk;
    }
}
