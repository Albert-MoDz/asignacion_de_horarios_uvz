<?php

use PHPUnit\Framework\TestCase;
use Horarios_uv_Zarzal\Horarios; // Asegúrate de usar exactamente el namespace y clase definidos

class HorarioTest extends TestCase
{
    public function testGetHora()
    {
        $horario = new Horarios("08:00 AM");
        $this->assertEquals("08:00 AM", $horario->getHora());
    }

    public function testSetHora()
    {
        $horario = new Horarios("08:00 AM");
        $horario->setHora("09:00 AM"); // Ajusta si tienes un método setHora (no se muestra en el código actual)
        $this->assertEquals("09:00 AM", $horario->getHora());
    }
}
