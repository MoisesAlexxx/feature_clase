<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Proyecto; //Importacion del modelo

class ProyectoTest extends TestCase
{
    use RefreshDatabase; // Asegura que las migraciones se ejecuten antes de cada prueba
    /**
     * A basic feature test example.
     * 
     * @return void
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function crear_proyecto(){

        // se utiliza para desactivar el manejo de expeciones de laravel

        $this->withoutExceptionHandling();
        
        // simular una solicitud POST para crear un nuevo proyecto
        $response = $this->post('/proyecto',[
            'nombre' => 'prueba',
            'descripcion' => 'Descripcion_prueba',
            
        ]);
        
        // Verifica que la respuesta es correcto
        $response->assertOk();
        //$response->assertStatus(200); // o $response->assertOk();

        //Verificar que se creo un proyecto en la base de datos
        $this->assertCount(1, Proyecto::all());

        //Obtengo el primero registro de la base de datos
        $proyecto = Proyecto::first();

        // Verifica que los campos del proyecto coinciden con lo enviado 
        $this->assertEquals($proyecto->nombre,'prueba');
        $this->assertEquals($proyecto->descripcion,'Descripcion_prueba');

    }

      /** @test */
      public function listar_proyectos(){
        // se utiliza para desactivar el manejo de expeciones de laravel
        $this->withoutExceptionHandling();

        // creo 2 registros de pruebas en la base de datos, espersificamente en la tabla proyectos
        Proyecto::factory('3')->create();

        // mediane HTTP
        $response = $this->get('proyecto');

        // Verificar que la respuesta es correcta
        $response->assertOk();

        //verifica que se obtubieron los 10 proyectos
        $proyecto = Proyecto::all();

        //Comparar los valores en la vista 
        $response->assertViewIs('proyecto.index');
        //->with('proyectos',$proyecto);

        $response->assertViewHas('proyecto', $proyecto);

        var_dump($proyecto);

      }

       /** @test */
      public function actualizar_proyectos(){
        // Se utiliza para desactivar el manejo de excepciones de laravel
        $this->withoutExceptionHandling();
 
         // Creo 1 registro de prueba en la base de datos, especificamente en la tabla proyecto
         $proyecto = Proyecto::factory(1)->create();
 
         // Metodo HTTP
         $response = $this->put("/proyecto/{$proyecto[0]->id}",[
            'nombre' => 'prueba',
            'descripcion' => 'descripcion_prueba',
          ]);
 
          $proyecto = Proyecto::findOrFail($proyecto[0]->id);
          // Verifica que los campos del proyecto coinciden con lo enviado
          $this->assertEquals($proyecto->nombre, 'prueba');
          $this->assertEquals($proyecto->descripcion, 'descripcion_prueba');
 
          $response->assertRedirect("/proyecto/{$proyecto->id}");
 
          var_dump($proyecto);
      }

       /** @test */
       public function actualizar_proyectos_ruta(){
        // se utiliza para desactivar el manejo de expeciones de laravel
        $this->withoutExceptionHandling();

         // creo 1 registros de pruebas en la base de datos, espersificamente en la tabla proyectos
       $proyecto = Proyecto::factory('1')->create();

       // metodo HTTP
       $response = $this->get("/proyecto/{$proyecto[0]->id}");

       $response->assertOk();

       $proyecto = Proyecto::first();

       $response->assertViewIs("proyecto.show");

       //var_dump($proyecto);
      }

      /** @test */
      public function eliminar_proyecto(){

        $this->withoutExceptionHandling();

        $proyecto = Proyecto::factory()->create([
            'nombre' => 'Alex',
            'descripcion' => 'descripcion_oscar',
        ]);

        // Realiza solicitud Delete para eliminar el proyecto
        $response = $this->delete('/proyecto/'.$proyecto->id);
        // verifica que la respuesta sea correcta
        $response->assertOk();
        //Verifica que el proyecto no exista
        $this->assertDatabaseMissing('proyecto',[
          'id' => $proyecto->id,
          'nombre' => 'Alex',
          'descripcion' => 'Descripcion Oscar',
        ]);
      }

      /** @test */
      public function proyecto_nombre_es_requerido(){

        $this->withoutExceptionHandling();

        $response = $this->post('/proyecto',[
          'nombre' => 'Alex',
          'descripcion' => 'descripcion_prueba',          
      ]);

      $response->assertSessionHasErrors(['nombre']);

      }


}
