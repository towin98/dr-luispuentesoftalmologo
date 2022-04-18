<?php

namespace Tests\Feature\Controllers\CrearCliente;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonaJuridicaControllerTest extends TestCase
{
        /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_listar_registros_de_transplante_a_bolsa_por_un_rango_de_fechas_correctamente()
    {
        $this->withoutExceptionHandling();

        // Crando registros para pruebas.
        Cliente::factory(5)->create();

        // Creando registros temporales en memoria para realizar consulta.
        $response = $this->get('/consultorio-oftamologico/crear-cliente/persona-juridica/listar');

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
     * Test para comprobar que se guarda una persona jurifica correctamente.
     *
     * @return void
     */
    public function test_guardar_persona_jurifica_correctamente()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('consultorio-oftamologico/crear-cliente/persona-juridica',[
            ''                => "100",
        ]);

        // $response->assertValid();
        $response->assertStatus(201);
    }
}
