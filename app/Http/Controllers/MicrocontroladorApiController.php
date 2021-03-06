<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Microcontrolador;
use DB;
use Carbon\Carbon;

class MicrocontroladorApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $microcontroladores = Microcontrolador::all();
        return response()->json($microcontroladores,200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function storeGet($nombre, $temperatura, $monoxido, $radiacion, $latitud, $longitud)
    {
        // cambiar horrible apuro
        $uv = 0;
        if ($radiacion < 227) {
            $uv = 1;
        }else if ($radiacion < 318 && $radiacion >=227) {
            $uv = 2;
        }else if ($radiacion < 408 && $radiacion >=318) {
            $uv = 3;
        }else if ($radiacion < 503 && $radiacion >=408) {
            $uv = 4;
        }else if ($radiacion < 606 && $radiacion >=503) {
            $uv = 5;
        }else if ($radiacion < 696 && $radiacion >=606) {
            $uv = 6;
        }else if ($radiacion < 795 && $radiacion >=696) {
            $uv = 7;
        }else if ($radiacion < 881 && $radiacion >=795) {
            $uv = 8;
        }else if ($radiacion < 976 && $radiacion >=881) {
            $uv = 9;
        }else if ($radiacion < 1079 && $radiacion >=976) {
            $uv = 10;
        } 
        else {
            $uv = 11;
        }
        

        try{
            $micontrolador = new Microcontrolador([
                'nombre'        => $nombre,
                'temperatura'   => $temperatura,
                'monoxido'      => $monoxido,
                'radiacion'     => $uv,
                'latitud'       => $latitud,
                'longitud'      => $longitud
                ]);
            $micontrolador->save();
            if (!isset($micontrolador)) {
                return response()->json(['status'=>true,'Great thanks'],200);
            }
        }catch (\Exception $e){
            Log::critical("grupo no creado {$e->getCode()}, {$e->getLine()}, {$e->getMessage()}");
            return response('Error al insertar', 500); 
        }
    }


    public function buscarDia($fecha)
    {


        $microcontroladores = DB::table('microcontroladores')->whereDate('created_at', $fecha)->get();
       // $result = json_decode($microcontroladores, true);

        $datos = array();


        for ($i=0; $i < 24; $i++) { 

            $micro = null;
            $totalSegundos = 10000000000000000000000000000000000;

            foreach ($microcontroladores as $microcontrolador) {

                $carbon         = new Carbon($microcontrolador->created_at);
                $carbonHora     = Carbon::create(2000, 1, 1, $i, 0, 0);
                $menorTiempo    = ($carbon->diffInHours($carbonHora))*3600 + ($carbon->diffInMinutes($carbonHora))*60+ ($carbon->diffInSeconds($carbonHora));
                

                if ($menorTiempo < $totalSegundos && $carbon->hour == $carbonHora->hour && $carbon->minute < 30)  {
                    
                    $totalSegundos = $menorTiempo;
                    $micro = $microcontrolador;
                }


                
              
            }

            $datos[$i] = $micro;
            
        }
            

        return $datos;

    }

    public function ultimoIngresado()
    {
        $microcontroladores = Microcontrolador::all();
        $microcontrolador = $microcontroladores->last();

        return response()->json($microcontrolador,200);
    }
}
