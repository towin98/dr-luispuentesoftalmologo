<?php

namespace Tests\Feature\Controllers\Paciente;

use App\Models\Paciente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PacienteControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_listar_registros_correctamente()
    {
        $this->withoutExceptionHandling();

        // Crando registros para pruebas.
        Paciente::factory(5)->create();

        // Creando registros temporales en memoria para realizar consulta.
        $response = $this->get('/consultorio-oftamologico/paciente/listar');

        $response->assertJsonStructure([
            'current_page',
            'data'=> [
                '*' => [
                    'id_lote',
                    'fecha_propagacion',
                    'fecha_transplante',
                    'accion',
                    'estado_lote',
                    'dias_transcurridos',
                    'color'
                ]
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links' => [
                '*' => [
                    "url",
                    "label",
                    "active",
                ]
            ],
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total'
        ]);

        // $response->assertValid();
        $response->assertStatus(200);
    }

    /**
     * Test para comprobar que se guarda paciente correctamente.
     *
     * @return void
     */
    public function test_guardar_paciente_correctamente()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('consultorio-oftamologico/paciente',[
            ''                => "100",
        ]);

        // $response->assertValid();
        $response->assertStatus(201);
    }
}
