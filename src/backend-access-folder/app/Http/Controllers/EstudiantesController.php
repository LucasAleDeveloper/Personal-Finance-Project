<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
namespace App\Http\Controllers;

use App\Models\Estudiantes;
use Illuminate\Http\Request;

class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo "wtf";
        $estudiantes = Estudiantes::all();
        $data =[
            'success'=>false,
            'estudiantes'=>$estudiantes
        ];
        return response()->json([
            $data,200,[]
        ]);
        echo "csmaaaa";header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");
        $estudiantes = Estudiantes::all();
        return $estudiantes;
    }

    public function all()
    {
        //lo cree para ver si puedo reotnar 1 json (dedsde el front end response.json() no parsea con index())
        //echo "wtf";
        $estudiantes = Estudiantes::all();
        $data =[
            'success'=>true,
            'estudiantes'=>$estudiantes
        ];
        return response()->json([
            $data,200,[]
        ]);
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
        $estudiante = Estudiantes::create($request->all());
        return $estudiante;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function show(Estudiantes $estudiantes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function edit(Estudiantes $estudiantes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estudiantes $estudiantes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudiantes  $estudiantes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudiantes $estudiantes)
    {
        //
    }
}
