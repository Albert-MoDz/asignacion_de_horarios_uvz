<?php
namespace Horarios_uv_Zarzal;

class Horarios
{
    private $hora;

    public function __construct($hora)
    {
        $this->hora = $hora;
    }

    public function getHora(): mixed
    {
        return $this->hora;
    }

    public function setHora($hora): void
    {
        $this->hora = $hora;
    }
}
