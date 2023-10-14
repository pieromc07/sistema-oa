<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\PermisosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PublicaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SubCategoriaController;
use App\Http\Controllers\TipoCategoriaController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


/**
 * RUTAS PROTEGIDAS
 */
Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // TODO: Rutas de Colaboradores
    Route::get('colaborador', [ColaboradorController::class, 'index'])->name('colaborador.index');
    Route::get('colaborador/create', [ColaboradorController::class, 'create'])->name('colaborador.create');
    Route::post('colaborador', [ColaboradorController::class, 'store'])->name('colaborador.store');
    Route::get('colaborador/{colaborador}', [ColaboradorController::class, 'show'])->name('colaborador.show');
    Route::get('colaborador/{colaborador}/edit', [ColaboradorController::class, 'edit'])->name('colaborador.edit');
    Route::put('colaborador/{colaborador}', [ColaboradorController::class, 'update'])->name('colaborador.update');
    Route::delete('colaborador/{colaborador}', [ColaboradorController::class, 'destroy'])->name('colaborador.destroy');
    Route::post('colaborador/verificarEliminar', [ColaboradorController::class, 'verificarEliminar'])->name('colaborador.verificarEliminar');

    // TODO: Rutas de Usuarios
    Route::get('usuario', [UserController::class, 'index'])->name('usuario.index');
    Route::get('usuario/create', [UserController::class, 'create'])->name('usuario.create');
    Route::post('usuario', [UserController::class, 'store'])->name('usuario.store');
    Route::get('usuario/{usuario}', [UserController::class, 'show'])->name('usuario.show');
    Route::get('usuario/{usuario}/edit', [UserController::class, 'edit'])->name('usuario.edit');
    Route::put('usuario/{usuario}', [UserController::class, 'update'])->name('usuario.update');
    Route::delete('usuario/{usuario}', [UserController::class, 'destroy'])->name('usuario.destroy');
    Route::post('usuario/verificarEliminar', [UserController::class, 'verificarEliminar'])->name('usuario.verificarEliminar');

    // TODO: Rutas de Roles
    Route::get('rol', [RoleController::class, 'index'])->name('rol.index');
    Route::get('rol/create', [RoleController::class, 'create'])->name('rol.create');
    Route::post('rol', [RoleController::class, 'store'])->name('rol.store');
    Route::get('rol/{rol}', [RoleController::class, 'show'])->name('rol.show');
    Route::get('rol/{rol}/edit', [RoleController::class, 'edit'])->name('rol.edit');
    Route::put('rol/{rol}', [RoleController::class, 'update'])->name('rol.update');
    Route::delete('rol/{rol}', [RoleController::class, 'destroy'])->name('rol.destroy');
    Route::post('rol/verificarEliminar', [RoleController::class, 'verificarEliminar'])->name('rol.verificarEliminar');

    // TODO: Rutas de Productos
    Route::get('producto', [ProductoController::class, 'index'])->name('producto.index');
    Route::get('producto/create', [ProductoController::class, 'create'])->name('producto.create');
    Route::post('producto', [ProductoController::class, 'store'])->name('producto.store');
    Route::get('producto/{producto}', [ProductoController::class, 'show'])->name('producto.show');
    Route::get('producto/{producto}/edit', [ProductoController::class, 'edit'])->name('producto.edit');
    Route::put('producto/{producto}', [ProductoController::class, 'update'])->name('producto.update');
    Route::delete('producto/{producto}', [ProductoController::class, 'destroy'])->name('producto.destroy');
    Route::get('producto/buscar/codigo/{codigo}', [ProductoController::class, 'buscarCodigo'])->name('producto.buscarCodigo');
    Route::get('producto/buscar/id/{id}', [ProductoController::class, 'buscarId'])->name('producto.buscarId');

    // TODO: Rutas de Tipo Categorias
    Route::get('tipocategoria', [TipoCategoriaController::class, 'index'])->name('tipocategoria.index');
    Route::get('tipocategoria/create', [TipoCategoriaController::class, 'create'])->name('tipocategoria.create');
    Route::post('tipocategoria', [TipoCategoriaController::class, 'store'])->name('tipocategoria.store');
    Route::get('tipocategoria/{tipocategoria}', [TipoCategoriaController::class, 'show'])->name('tipocategoria.show');
    Route::get('tipocategoria/{tipocategoria}/edit', [TipoCategoriaController::class, 'edit'])->name('tipocategoria.edit');
    Route::put('tipocategoria/{tipocategoria}', [TipoCategoriaController::class, 'update'])->name('tipocategoria.update');
    Route::delete('tipocategoria/{tipocategoria}', [TipoCategoriaController::class, 'destroy'])->name('tipocategoria.destroy');
    Route::post('tipocategoria/verificarEliminar', [TipoCategoriaController::class, 'verificarEliminar'])->name('tipocategoria.verificarEliminar');

    // TODO: Rutas de Categorias
    Route::get('categoria', [CategoriaController::class, 'index'])->name('categoria.index');
    Route::get('categoria/create', [CategoriaController::class, 'create'])->name('categoria.create');
    Route::post('categoria', [CategoriaController::class, 'store'])->name('categoria.store');
    Route::get('categoria/{categoria}', [CategoriaController::class, 'show'])->name('categoria.show');
    Route::get('categoria/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categoria.edit');
    Route::put('categoria/{categoria}', [CategoriaController::class, 'update'])->name('categoria.update');
    Route::delete('categoria/{categoria}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');
    Route::post('categoria/verificarEliminar', [CategoriaController::class, 'verificarEliminar'])->name('categoria.verificarEliminar');

    // TODO: Rutas de Subcategorias
    Route::get('subcategoria', [SubCategoriaController::class, 'index'])->name('subcategoria.index');
    Route::get('subcategoria/create', [SubCategoriaController::class, 'create'])->name('subcategoria.create');
    Route::post('subcategoria', [SubCategoriaController::class, 'store'])->name('subcategoria.store');
    Route::get('subcategoria/{subcategoria}', [SubCategoriaController::class, 'show'])->name('subcategoria.show');
    Route::get('subcategoria/{subcategoria}/edit', [SubCategoriaController::class, 'edit'])->name('subcategoria.edit');
    Route::put('subcategoria/{subcategoria}', [SubCategoriaController::class, 'update'])->name('subcategoria.update');
    Route::delete('subcategoria/{subcategoria}', [SubCategoriaController::class, 'destroy'])->name('subcategoria.destroy');
    Route::post('subcategoria/verificarEliminar', [SubCategoriaController::class, 'verificarEliminar'])->name('subcategoria.verificarEliminar');

    // TODO: Rutas de Marcas
    Route::get('marca', [MarcaController::class, 'index'])->name('marca.index');
    Route::get('marca/create', [MarcaController::class, 'create'])->name('marca.create');
    Route::post('marca', [MarcaController::class, 'store'])->name('marca.store');
    Route::get('marca/{marca}', [MarcaController::class, 'show'])->name('marca.show');
    Route::get('marca/{marca}/edit', [MarcaController::class, 'edit'])->name('marca.edit');
    Route::put('marca/{marca}', [MarcaController::class, 'update'])->name('marca.update');
    Route::delete('marca/{marca}', [MarcaController::class, 'destroy'])->name('marca.destroy');
    Route::post('marca/verificarEliminar', [MarcaController::class, 'verificarEliminar'])->name('marca.verificarEliminar');

    // TODO: Rutas de Modelo
    Route::get('modelo', [ModeloController::class, 'index'])->name('modelo.index');
    Route::get('modelo/create', [ModeloController::class, 'create'])->name('modelo.create');
    Route::post('modelo', [ModeloController::class, 'store'])->name('modelo.store');
    Route::get('modelo/{modelo}', [ModeloController::class, 'show'])->name('modelo.show');
    Route::get('modelo/{modelo}/edit', [ModeloController::class, 'edit'])->name('modelo.edit');
    Route::put('modelo/{modelo}', [ModeloController::class, 'update'])->name('modelo.update');
    Route::delete('modelo/{modelo}', [ModeloController::class, 'destroy'])->name('modelo.destroy');
    Route::post('modelo/verificarEliminar', [ModeloController::class, 'verificarEliminar'])->name('modelo.verificarEliminar');

    // TODO: Rutas de Unidad Medida
    Route::get('unidadmedida', [UnidadMedidaController::class, 'index'])->name('unidadmedida.index');
    Route::get('unidadmedida/create', [UnidadMedidaController::class, 'create'])->name('unidadmedida.create');
    Route::post('unidadmedida', [UnidadMedidaController::class, 'store'])->name('unidadmedida.store');
    Route::get('unidadmedida/{unidadmedida}', [UnidadMedidaController::class, 'show'])->name('unidadmedida.show');
    Route::get('unidadmedida/{unidadmedida}/edit', [UnidadMedidaController::class, 'edit'])->name('unidadmedida.edit');
    Route::put('unidadmedida/{unidadmedida}', [UnidadMedidaController::class, 'update'])->name('unidadmedida.update');
    Route::delete('unidadmedida/{unidadmedida}', [UnidadMedidaController::class, 'destroy'])->name('unidadmedida.destroy');
    Route::post('unidadmedida/verificarEliminar', [UnidadMedidaController::class, 'verificarEliminar'])->name('unidadmedida.verificarEliminar');

    // TODO: Rutas de Permisos
    Route::get('permiso', [PermisosController::class, 'index'])->name('permiso.index');
    Route::get('permiso/create', [PermisosController::class, 'create'])->name('permiso.create');
    Route::post('permiso', [PermisosController::class, 'store'])->name('permiso.store');
    Route::get('permiso/{permiso}', [PermisosController::class, 'show'])->name('permiso.show');
    Route::get('permiso/{permiso}/edit', [PermisosController::class, 'edit'])->name('permiso.edit');
    Route::put('permiso/{permiso}', [PermisosController::class, 'update'])->name('permiso.update');
    Route::delete('permiso/{permiso}', [PermisosController::class, 'destroy'])->name('permiso.destroy');

    // TODO: Rutas de Clientes
    Route::get('cliente', [ClienteController::class, 'index'])->name('cliente.index');
    Route::get('cliente/create', [ClienteController::class, 'create'])->name('cliente.create');
    Route::post('cliente', [ClienteController::class, 'store'])->name('cliente.store');
    Route::get('cliente/{cliente}', [ClienteController::class, 'show'])->name('cliente.show');
    Route::get('cliente/{cliente}/edit', [ClienteController::class, 'edit'])->name('cliente.edit');
    Route::put('cliente/{cliente}', [ClienteController::class, 'update'])->name('cliente.update');
    Route::delete('cliente/{cliente}', [ClienteController::class, 'destroy'])->name('cliente.destroy');
    Route::post('cliente/verificarEliminar', [ClienteController::class, 'verificarEliminar'])->name('cliente.verificarEliminar');
    Route::post('cliente/registrar', [ClienteController::class, 'registrar'])->name('cliente.registrar');

    //TODO: Rutas de Ventas
    Route::get('venta', [VentaController::class, 'index'])->name('venta.index');
    Route::get('venta/create', [VentaController::class, 'create'])->name('venta.create');
    Route::post('venta', [VentaController::class, 'store'])->name('venta.store');
    Route::get('venta/{venta}', [VentaController::class, 'show'])->name('venta.show');
    Route::get('venta/{venta}/edit', [VentaController::class, 'edit'])->name('venta.edit');
    Route::put('venta/{venta}', [VentaController::class, 'update'])->name('venta.update');
    Route::delete('venta/{venta}', [VentaController::class, 'destroy'])->name('venta.destroy');
    Route::get('venta/correlativo/{serie}', [VentaController::class, 'correlativo'])->name('venta.correlativo');
});

/**
 * RUTAS PUBLICAS
 */

Route::get('/departamentos', [PublicaController::class, 'departamentos'])->name('departamentos');
Route::get('/provincias', [PublicaController::class, 'provincias'])->name('provincias');
Route::get('/distritos', [PublicaController::class, 'distritos'])->name('distritos');
Route::get('/bucarPorDistrito', [PublicaController::class, 'bucarPorDistrito'])->name('bucarPorDistrito');
