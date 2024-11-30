<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto; 
use Validator;//Importacion del modelo

class ProyectoController extends Controller
{

    //metodo para crear los registros (se le puede poner las reglas que desas que cumpla el campo)
    public function store(Request $request){

        // valido con el metodo
        $request->validate([
            "nombre" => 'required',
            "descripcion" => 'required',
        ]);   
        
        

    //creo el nuevo registro en la tabla proyecto

    Proyecto::create($request->only('nombre', 'descripcion'));
    //Proyecto::create($request->all());

   
    return response()->json(['message' => 'Proyecto creado'], 200);
}

//metodo para obtener los registros en la tabla proyectos
public function index(){

    //obtengo todos los proyectos creados
    $proyecto = Proyecto::all();

    // retornar la vista en 'proyecto.index'
    return view('proyecto.index',compact('proyecto'));
}

//metodo para actualizar un registros en la tabla proyectos
 // Metodo para actualizar un registro
 public function update(Request $request, Proyecto $proyecto){
    // Obtengo todos los proyectos creados
    $proyecto->update($request->all());

    return redirect()->route('proyecto.index')->with('success', 'Proyecto actualizado correctamente');

   
}




public function show($id){

    $proyecto = Proyecto::find($id);

// si el proyecto no existe , redirecciono a la lista proyectos 
    if (!$proyecto){
        return redirect()->route('proyecto.index')->with('error','Registro no encontrado');
    }
    return view('proyecto.show',compact('proyecto'));    
    
}
// metodo para eliminar un registro
public function destroy(Proyecto $proyecto){
    $proyecto->delete();
    //return response()->json(['message'=> 'proyecto eliminado con exito'],200 );
    return redirect()->route('proyecto.index')->with('success','Proyecto eliminado correctamente');

        
}



}
