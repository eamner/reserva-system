<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Resource;

class ResourceControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_create_resource(): void
    {
        $data = [
            'name' => 'Sala de Reuniones Test',
            'capacity' => 10,
        ];

        $response = $this->postJson('/api/resources', $data);

        $response->assertStatus(201)
            ->assertJsonFragment($data);

        $this->assertDatabaseHas('resources', $data);
    }

    public function test_can_list_resources(): void
    {
        //CREA DATOS DE PRUEBA
        Resource::create(['name' => 'Sala A', 'capacity' => 5]);
        Resource::create(['name' => 'Sala B', 'capacity' => 10]);

        //LLAMANDO GET /api/resources
        $response = $this->getJson('/api/resources');
        //VERIFICA RESPUESTA 200 Y QUE TENGA LOS DATOS CREADOS
        $response->assertStatus(200)
            ->assertJsonCount(2);
        //VERIFICAMOS QUE LOS DATOS ESTEN EN LA RESPUESTA
        $response->assertJsonFragment(['name' => 'Sala A', 'capacity' => 5]);
        $response->assertJsonFragment(['name' => 'Sala B', 'capacity' => 10]);
    }

    public function test_cannot_create_duplicate_resource(): void
    {
        //CREAR RECURSO INICIAL USANDO ELOQUENT
        Resource::create([
            'name' => 'Sala Única',
            'capacity' => 8
        ]);

        //INTENTAR CREAR DUPLICADO VIA ENDPOINT POST
        $data = [
            'name' => 'Sala Única',
            'capacity' => 10
        ];

        $response = $this->postJson('/api/resources', $data);

        //DEBE DEVOLVER 422 UNPROCESSABLE ENTITY
        $response->assertStatus(422);

        //VALIDAR QUE LA COLUMNA 'NAME' DIO ERROR
        $response->assertJsonValidationErrors(['name']);
    }

    public function test_can_update_a_resource(): void
    {
        //CREAR RECURSO INICIAL
        $resource = Resource::factory()->create([
            'name' => 'Proyector',
            'capacity' => 20
        ]);

        $response = $this->putJson("/api/resources/{$resource->id}", [
            'name' => 'Updated Proyector',
            'capacity' => 30
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => 'Updated Proyector',
                'capacity' => 30
            ]);

        $this->assertDatabaseHas('resources', [
            'id' => $resource->id,
            'name' => 'Updated Proyector',
            'capacity' => 30
        ]);
    }

    /** @test */
    public function test_cannot_update_to_duplicate_name(): void
    {
        //CREAR DOS RECURSOS INICIALES
        $resource1 = Resource::factory()->create(['name' => 'Room A']);
        $resource2 = Resource::factory()->create(['name' => 'Room B']);

        //INTENTAR ACTUALIZAR EL SEGUNDO RECURSO PARA QUE TENGA EL MISMO NOMBRE QUE EL PRIMERO
        $response = $this->putJson("/api/resources/{$resource2->id}", [
            'name' => 'Room A', // NOMBRE DUPLICADO
            'capacity' => 10
        ]);

        //DEBE DEVOLVER 422 UNPROCESSABLE ENTITY
        $response->assertStatus(422);

        //VALIDAR QUE LA COLUMNA 'NAME' DIO ERROR
        $response->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function test_can_delete_a_resource(): void
    {
        //CREAR RECURSO INICIAL
        $resource = Resource::factory()->create();

        //LLAMAR AL ENDPOINT DELETE
        $response = $this->deleteJson("/api/resources/{$resource->id}");

        //VERIFICAR RESPUESTA 204 NO CONTENT
        $response->assertStatus(204);

        //VERIFICAR QUE EL RECURSO YA NO EXISTA EN LA BASE DE DATOS
        $this->assertDatabaseMissing('resources', ['id' => $resource->id]);
    }

    /** @test */
    public function test_cannot_delete_nonexistent_resource()
    {
        //INTENTAR BORRAR UN RECURSO QUE NO EXISTE
        $response = $this->deleteJson("/api/resources/99999"); // ID QUE NO EXISTE   
        //DEBE DEVOLVER 404 NOT FOUND
        $response->assertStatus(404);
    }
}
