<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Zip;

class BackbonesApiController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $zip_code
     * @return \Illuminate\Http\Response
     */
    public function show($zip_code)
    {
        try { 
            $zipArray = Zip::where('d_codigo', $zip_code)->get();
            $zipFirst = Zip::where('d_codigo', $zip_code)->first();
            $settlements = [];
            foreach ($zipArray as $key => $value) {
                $settlements[$key]['key'] = intval($value->id_asenta_cpcons);
                $settlements[$key]['name'] = strtoupper($this->deleteAccents($value->d_asenta));
                $settlements[$key]['zone_type'] = strtoupper($value->d_zona);
                $settlements[$key]['settlement_type']['name'] = $this->deleteAccents($value->d_tipo_asenta);
            }
            
            return response()->json([
                'zip_code' => $zipFirst->d_codigo,
                'locality' => $zipFirst->d_ciudad ? strtoupper($this->deleteAccents($zipFirst->d_ciudad)) : "",
                'federal_entity' => [
                    'key' => intval($zipFirst->c_estado),
                    'name' => strtoupper($this->deleteAccents($zipFirst->d_estado)),
                    'code' => null
                ],
                'settlements' => $settlements,
                'municipality' => [
                    "key" => intval($zipFirst->c_mnpio),
                    "name" => strtoupper($this->deleteAccents($zipFirst->D_mnpio))
                ]
            ]);
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    public function deleteAccents($cadena) {

        // we replace letters
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $cadena
        );
    
        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),$cadena
        );
    
        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $cadena
        );
    
        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $cadena
        );
    
        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $cadena
        );
        return $cadena;
    }
}
