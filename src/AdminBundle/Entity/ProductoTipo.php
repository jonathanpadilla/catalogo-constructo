<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoTipo
 *
 * @ORM\Table(name="producto_tipo", indexes={@ORM\Index(name="prt_categoria_fk", columns={"prt_categoria_fk"}), @ORM\Index(name="prt_hoja_fk", columns={"prt_hoja_fk"})})
 * @ORM\Entity
 */
class ProductoTipo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="prt_id_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $prtIdPk;

    /**
     * @var string
     *
     * @ORM\Column(name="prt_nombre", type="string", length=100, nullable=true)
     */
    private $prtNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="prt_subtexto", type="string", length=100, nullable=true)
     */
    private $prtSubtexto;

    /**
     * @var string
     *
     * @ORM\Column(name="prt_imagen", type="string", length=100, nullable=true)
     */
    private $prtImagen;

    /**
     * @var integer
     *
     * @ORM\Column(name="prt_activo", type="integer", nullable=true)
     */
    private $prtActivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="prt_fecha_registro", type="datetime", nullable=true)
     */
    private $prtFechaRegistro;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prt_categoria_fk", referencedColumnName="cat_id_pk")
     * })
     */
    private $prtCategoriaFk;

    /**
     * @var \Hoja
     *
     * @ORM\ManyToOne(targetEntity="Hoja")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prt_hoja_fk", referencedColumnName="hoj_id_pk")
     * })
     */
    private $prtHojaFk;



    /**
     * Get prtIdPk
     *
     * @return integer 
     */
    public function getPrtIdPk()
    {
        return $this->prtIdPk;
    }

    /**
     * Set prtNombre
     *
     * @param string $prtNombre
     * @return ProductoTipo
     */
    public function setPrtNombre($prtNombre)
    {
        $this->prtNombre = $prtNombre;

        return $this;
    }

    /**
     * Get prtNombre
     *
     * @return string 
     */
    public function getPrtNombre()
    {
        return $this->prtNombre;
    }

    /**
     * Set prtSubtexto
     *
     * @param string $prtSubtexto
     * @return ProductoTipo
     */
    public function setPrtSubtexto($prtSubtexto)
    {
        $this->prtSubtexto = $prtSubtexto;

        return $this;
    }

    /**
     * Get prtSubtexto
     *
     * @return string 
     */
    public function getPrtSubtexto()
    {
        return $this->prtSubtexto;
    }

    /**
     * Set prtImagen
     *
     * @param string $prtImagen
     * @return ProductoTipo
     */
    public function setPrtImagen($prtImagen)
    {
        $this->prtImagen = $prtImagen;

        return $this;
    }

    /**
     * Get prtImagen
     *
     * @return string 
     */
    public function getPrtImagen()
    {
        return $this->prtImagen;
    }

    /**
     * Set prtActivo
     *
     * @param integer $prtActivo
     * @return ProductoTipo
     */
    public function setPrtActivo($prtActivo)
    {
        $this->prtActivo = $prtActivo;

        return $this;
    }

    /**
     * Get prtActivo
     *
     * @return integer 
     */
    public function getPrtActivo()
    {
        return $this->prtActivo;
    }

    /**
     * Set prtFechaRegistro
     *
     * @param \DateTime $prtFechaRegistro
     * @return ProductoTipo
     */
    public function setPrtFechaRegistro($prtFechaRegistro)
    {
        $this->prtFechaRegistro = $prtFechaRegistro;

        return $this;
    }

    /**
     * Get prtFechaRegistro
     *
     * @return \DateTime 
     */
    public function getPrtFechaRegistro()
    {
        return $this->prtFechaRegistro;
    }

    /**
     * Set prtCategoriaFk
     *
     * @param \AdminBundle\Entity\Categoria $prtCategoriaFk
     * @return ProductoTipo
     */
    public function setPrtCategoriaFk(\AdminBundle\Entity\Categoria $prtCategoriaFk = null)
    {
        $this->prtCategoriaFk = $prtCategoriaFk;

        return $this;
    }

    /**
     * Get prtCategoriaFk
     *
     * @return \AdminBundle\Entity\Categoria 
     */
    public function getPrtCategoriaFk()
    {
        return $this->prtCategoriaFk;
    }

    /**
     * Set prtHojaFk
     *
     * @param \AdminBundle\Entity\Hoja $prtHojaFk
     * @return ProductoTipo
     */
    public function setPrtHojaFk(\AdminBundle\Entity\Hoja $prtHojaFk = null)
    {
        $this->prtHojaFk = $prtHojaFk;

        return $this;
    }

    /**
     * Get prtHojaFk
     *
     * @return \AdminBundle\Entity\Hoja 
     */
    public function getPrtHojaFk()
    {
        return $this->prtHojaFk;
    }
}
