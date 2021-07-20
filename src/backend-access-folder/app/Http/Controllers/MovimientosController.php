<?php

namespace App\Http\Controllers;

use App\Models\Movimientos;
use Illuminate\Http\Request;
use DB;
class MovimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movimientos = Movimientos::all();
        return $movimientos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request['user'];
        if($request['tipo'])
        {
            //Tengo que crear una transacción donde edito también el valor del saldo
            DB::transaction(function() {
                //DB::update('update usuariosaldo set saldo = ? where user = ?',[$request['monto'],$user]);
                
            });
        }
        $movimiento = Movimientos::create($request->all());
        return $movimiento;
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movimientos  $movimientos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movimientos = DB::select('SELECT * FROM movimientos WHERE user = ?',[$id]);
        return $movimientos;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movimientos  $movimientos
     * @return \Illuminate\Http\Response
     */
    public function edit(Movimientos $movimientos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movimientos  $movimientos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movimientos $movimientos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movimientos  $movimientos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimientos $movimientos)
    {
        //
    }

    public function ultimosMovimientos($cantidad = 1)
    {
        echo $cantidad;
        return DB::table('movimientos')->limit($cantidad)->get();
    }

    /*
     *   Obtiene el saldo de un usuario
     *   @param id de usuario
     *   saldo del usuario 
     */
    public function saldo($id)
    {
        return DB::table('usuariosaldo')
                ->select('saldo')
                ->where('usuario',$id)
                ->get();
    }

}
