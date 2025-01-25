<?php
//namespace App;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="instalaciones")
 **/
class Instalacion
{
    /** 
     * @ORM\Id 
     * @ORM\Column(type="integer") 
     * @ORM\GeneratedValue 
     **/
    protected $id;

    /** 
     * @ORM\Column(type="string") 
     **/
    protected $nombre;

    /** 
     * @ORM\Column(type="string") 
     **/
    protected $direccion;

    /** 
     * @ORM\Column(type="integer") 
     **/
    protected $capacidad;

    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipo") 
     * @ORM\JoinColumn(name="equipo_id", referencedColumnName="id")
     **/
    protected $equipo;

    // Getters and setters...

    public function __construct() {
        $this->instalaciones = new ArrayCollection();
    }
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getCapacidad() {
        return $this->capacidad;
    }

    public function setCapacidad($capacidad) {
        $this->capacidad = $capacidad;
    }

    public function getEquipo() {
        return $this->equipo;
    }

    public function setEquipo($equipo) {
        $this->equipo = $equipo;
    }
}