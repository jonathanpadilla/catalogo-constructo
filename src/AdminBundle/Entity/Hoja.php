<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hoja
 *
 * @ORM\Table(name="hoja", indexes={@ORM\Index(name="hoj_categoria_fk", columns={"hoj_categoria_fk"})})
 * @ORM\Entity
 */
class Hoja
{
    /**
     * @var integer
     *
     * @ORM\Column(name="hoj_id_pk", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $hojIdPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="hoj_numero", type="integer", nullable=true)
     */
    private $hojNumero;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hoj_categoria_fk", referencedColumnName="cat_id_pk")
     * })
     */
    private $hojCategoriaFk;



    /**
     * Get hojIdPk
     *
     * @return integer 
     */
    public function getHojIdPk()
    {
        return $this->hojIdPk;
    }

    /**
     * Set hojNumero
     *
     * @param integer $hojNumero
     * @return Hoja
     */
    public function setHojNumero($hojNumero)
    {
        $this->hojNumero = $hojNumero;

        return $this;
    }

    /**
     * Get hojNumero
     *
     * @return integer 
     */
    public function getHojNumero()
    {
        return $this->hojNumero;
    }

    /**
     * Set hojCategoriaFk
     *
     * @param \AdminBundle\Entity\Categoria $hojCategoriaFk
     * @return Hoja
     */
    public function setHojCategoriaFk(\AdminBundle\Entity\Categoria $hojCategoriaFk = null)
    {
        $this->hojCategoriaFk = $hojCategoriaFk;

        return $this;
    }

    /**
     * Get hojCategoriaFk
     *
     * @return \AdminBundle\Entity\Categoria 
     */
    public function getHojCategoriaFk()
    {
        return $this->hojCategoriaFk;
    }
}
