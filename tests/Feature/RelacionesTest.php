<?php

namespace Tests\Feature;

use App\Models\InventarioReactivos\DonacionReactivo;
use App\Models\InventarioReactivos\Reactivo;
use App\Models\InventarioReactivos\SolicitudReactivo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RelacionesTest extends TestCase
{
    use RefreshDatabase;

    public function test_relacion_1_A_Muchos_entre_usuario_y_reactivos_donados(): void
    {
        $user = User::factory()->create();

        $reactivo = Reactivo::factory()->create();

        $donacion = DonacionReactivo::factory()->create([
            'user_id' => $user->id,
            'reactivo_id' => $reactivo->id
        ]);

        $this->assertModelExists($donacion);

        $this->assertTrue($user->reactivosDonados()->first()->first()->id == $reactivo->id);

        $this->assertTrue($reactivo->donadores()->first()->id == $user->id);
    }

    public function test_relacion_1_A_Muchos_entre_usuario_y_reactivos_solicitados(): void
    {
        $user = User::factory()->create();

        $reactivo = Reactivo::factory()->create();

        $solicitud = SolicitudReactivo::factory()->create([
            'user_id' => $user->id,
            'reactivo_id' => $reactivo->id,
        ]);

        $this->assertModelExists($solicitud);

        $this->assertTrue($reactivo->solicitantes()->first()->id == $user->id);

        $this->assertTrue($user->reactivosSolicitados()->first()->id == $reactivo->id);
    }

    public function test_relacion_1_A_Muchos_entre_usuario_y_articulos(): void
    {

        $this->assertTrue(true);
    }

    public function test_relacion_Muchos_A_Muchos_entre_usuario_y_acopios(): void
    {
        $this->assertTrue(true);
    }

    public function test_relacion_1_A_Muchos_entre_usuario_y_donaciones(): void
    {
        $this->assertTrue(true);
    }

    public function test_relacion_1_A_Muchos_entre_entregas_y_proveedores(): void
    {
        $this->assertTrue(true);
    }

    public function test_relacion_1_A_Muchos_entre_acopios_y_entregas(): void
    {
        $this->assertTrue(true);
    }

    public function test_relacion_1_a_muchos_entre_articulos_y_solicitudes(): void
    {
        $this->assertTrue(true);
    }

    public function test_relacion_1_a_muchos_entre_articulos_y_capturas(): void
    {
        $this->assertTrue(true);
    }

    public function test_relacion_1_a_muchos_entre_usuarios_y_capturas_de_articulos(): void
    {
        $this->assertTrue(true);
    }
}
