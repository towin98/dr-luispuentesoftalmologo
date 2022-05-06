<?php

namespace Tests\Feature\Controllers\Paciente;

use App\Models\Paciente;
use App\Models\Parametro\Eps;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PacienteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_listar_registros_correctamente()
    {
        $this->withoutExceptionHandling();

        Eps::create([
            "id"  => 1,
            "codigo" => "PRUEBA",
            "descripcion" => "prueba descripcion",
            "estado" => "ACTIVO"
        ]);

        // Crando registros para pruebas.
        Paciente::factory(5)->create();

        // Creando registros temporales en memoria para realizar consulta.
        $response = $this->get('/consultorio-oftamologico/paciente/listar');

        $response->assertJsonStructure([
            'data'=> [
                '*' => [
                ]
            ],
            'filtrados',
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

        $eps = Eps::create([
            "codigo" => "PRUEBA",
            "descripcion" => "prueba descripcion",
            "estado" => "ACTIVO"
        ]);

        $response = $this->post('consultorio-oftamologico/paciente',[
            'tipo_documento'    => 'CC',
            'numero_documento'  => '728232',
            'nombre'            => 'cristian',
            'apellido'          => 'segura',
            'correo'            => 'cristian@gmail.com',
            'celular'           => '23728328',
            'direccion'         => 'cra 20',
            'departamento'      => 'HUILA',
            'municipio'         => 'GARZON',
            'fecha_nacimiento'  => '1998-01-16',
            'edad'              => '24',
            'ocupacion'         => 'NADA',
            'foto'              => '',
            'id_p_eps'          => $eps->id,
            'fecha_creacion'    => '2022-10-10'
        ]);

        // $response->assertValid();
        $response->assertStatus(201);
    }
}
