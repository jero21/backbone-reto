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
                $settlements[$key]['name'] = strtoupper($value->d_asenta);
                $settlements[$key]['zone_type'] = strtoupper($value->d_zona);
                $settlements[$key]['settlement_type']['name'] = $value->d_tipo_asenta;                
            }
            
            return response()->json([
                'zip_code' => $zipFirst->d_codigo,
                'locality' => $zipFirst->d_ciudad ? strtoupper($zipFirst->d_ciudad) : "",
                'federal_entity' => [
                    'key' => intval($zipFirst->c_estado),
                    'name' => strtoupper($zipFirst->d_estado),
                    'code' => null
                ],
                'settlements' => $settlements,
                'municipality' => [
                    "key" => intval($zipFirst->c_mnpio),
                    "name" => strtoupper($zipFirst->D_mnpio)
                ]
            ]);
            
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
}
