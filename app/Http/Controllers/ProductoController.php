<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all(); // Trae todos los productos
        return view('index', compact('productos'));
    }

    public function productos()
    {
        $productos = Producto::all();
        return view('productos.productos', compact('productos'));
    }
    
        public function guardar(Request $request)
    {
        try {
            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->precio = $request->precio;
            $producto->descripcion = $request->descripcion;

            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();

                // Asegurarse que la carpeta exista
                $rutaDestino = public_path('storage/imagenes_productos');
                if (!file_exists($rutaDestino)) {
                    mkdir($rutaDestino, 0755, true);
                }

                // Mover la imagen al destino
                $imagen->move($rutaDestino, $nombreImagen);

                // Guardar el nombre/ruta en la base de datos
                $producto->imagen = 'imagenes_productos/' . $nombreImagen;
            }

            $producto->save();

            return redirect()->route('productos.productos')->with('success', 'Producto creado exitosamente.');
        } catch (\Exception $e) {
            dd($e->getMessage()); // Si algo falla, muestra el error real
        }
    }

    public function editar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable'
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos.productos')
                        ->with('success', 'Producto actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.productos')
                        ->with('success', 'Producto eliminado correctamente.');
    }

    private function moveImage($imagen)
    {
        $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
        $rutaDestino = public_path('storage/imagenes_productos');

        // Asegúrate que la carpeta existe
        if (!file_exists($rutaDestino)) {
            mkdir($rutaDestino, 0755, true);
        }

        // Mover imagen
        $imagen->move($rutaDestino, $nombreImagen);

        return 'imagenes_productos/' . $nombreImagen; // Ruta para base de datos
    }

}
