<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="producto", indexes={@ORM\Index(name="pro_tipo_fk", columns={"pro_tipo_fk"})})
 * @ORM\Entity
 */
class Producto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pro_id_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $proIdPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_codigo_factusol", type="integer", nullable=true)
     */
    private $proCodigoFactusol;

    /**
     * @var string
     *
     * @ORM\Column(name="pro_producto", type="string", length=200, nullable=true)
     */
    private $proProducto;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_cantidad", type="integer", nullable=true)
     */
    private $proCantidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_precio_real", type="integer", nullable=true)
     */
    private $proPrecioReal;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_precio_ventas", type="integer", nullable=true)
     */
    private $proPrecioVentas;

    /**
     * @var integer
     *
     * @ORM\Column(name="pro_activo", type="integer", nullable=true)
     */
    private $proActivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pro_fecha_registro", type="datetime", nullable=true)
     */
    private $proFechaRegistro;

    /**
     * @var \ProductoTipo
     *
     * @ORM\ManyToOne(targetEntity="ProductoTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pro_tipo_fk", referencedColumnName="prt_id_pk")
     * })
     */
    private $proTipoFk;



    /**
     * Get proIdPk
     *
     * @return integer 
     */
    public function getProIdPk()
    {
        return $this->proIdPk;
    }

    /**
     * Set proCodigoFactusol
     *
     * @param integer $proCodigoFactusol
     * @return Producto
     */
    public function setProCodigoFactusol($proCodigoFactusol)
    {
        $this->proCodigoFactusol = $proCodigoFactusol;

        return $this;
    }

    /**
     * Get proCodigoFactusol
     *
     * @return integer 
     */
    public function getProCodigoFactusol()
    {
        return $this->proCodigoFactusol;
    }

    /**
     * Set proProducto
     *
     * @param string $proProducto
     * @return Producto
     */
    public function setProProducto($proProducto)
    {
        $this->proProducto = $proProducto;

        return $this;
    }

    /**
     * Get proProducto
     *
     * @return string 
     */
    public function getProProducto()
    {
        return $this->proProducto;
    }

    /**
     * Set proCantidad
     *
     * @param integer $proCantidad
     * @return Producto
     */
    public function setProCantidad($proCantidad)
    {
        $this->proCantidad = $proCantidad;

        return $this;
    }

    /**
     * Get proCantidad
     *
     * @return integer 
     */
    public function getProCantidad()
    {
        return $this->proCantidad;
    }

    /**
     * Set proPrecioReal
     *
     * @param integer $proPrecioReal
     * @return Producto
     */
    public function setProPrecioReal($proPrecioReal)
    {
        $this->proPrecioReal = $proPrecioReal;

        return $this;
    }

    /**
     * Get proPrecioReal
     *
     * @return integer 
     */
    public function getProPrecioReal()
    {
        return $this->proPrecioReal;
    }

    /**
     * Set proPrecioVentas
     *
     * @param integer $proPrecioVentas
     * @return Producto
     */
    public function setProPrecioVentas($proPrecioVentas)
    {
        $this->proPrecioVentas = $proPrecioVentas;

        return $this;
    }

    /**
     * Get proPrecioVentas
     *
     * @return integer 
     */
    public function getProPrecioVentas()
    {
        return $this->proPrecioVentas;
    }

    /**
     * Set proActivo
     *
     * @param integer $proActivo
     * @return Producto
     */
    public function setProActivo($proActivo)
    {
        $this->proActivo = $proActivo;

        return $this;
    }

    /**
     * Get proActivo
     *
     * @return integer 
     */
    public function getProActivo()
    {
        return $this->proActivo;
    }

    /**
     * Set proFechaRegistro
     *
     * @param \DateTime $proFechaRegistro
     * @return Producto
     */
    public function setProFechaRegistro($proFechaRegistro)
    {
        $this->proFechaRegistro = $proFechaRegistro;

        return $this;
    }

    /**
     * Get proFechaRegistro
     *
     * @return \DateTime 
     */
    public function getProFechaRegistro()
    {
        return $this->proFechaRegistro;
    }

    /**
     * Set proTipoFk
     *
     * @param \AdminBundle\Entity\ProductoTipo $proTipoFk
     * @return Producto
     */
    public function setProTipoFk(\AdminBundle\Entity\ProductoTipo $proTipoFk = null)
    {
        $this->proTipoFk = $proTipoFk;

        return $this;
    }

    /**
     * Get proTipoFk
     *
     * @return \AdminBundle\Entity\ProductoTipo 
     */
    public function getProTipoFk()
    {
        return $this->proTipoFk;
    }
}
