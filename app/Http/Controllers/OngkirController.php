<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use LDAP\Result;

class OngkirController extends Controller
{
    public function provinces()
    {
        $response = Http::withHeaders([
            'key' => '46594cc7061666c918d0a0f66ad455da'
        ])->get('https://api.rajaongkir.com/starter/province');

        $provinces = $response['rajaongkir']['results'];
        
        return response()->json($provinces);
    }

    public function cities(Request $request)
    {
        $response = Http::withHeaders([
            'key' => '46594cc7061666c918d0a0f66ad455da'
        ])->get('https://api.rajaongkir.com/starter/city?province='.$request->provincy_id);

        $cities = $response['rajaongkir']['results'];
        
        return response()->json($cities);
    }

    public function cost(Request $request)
    {
        $response = Http::withHeaders([
            'key' => '46594cc7061666c918d0a0f66ad455da'
        ])->post('https://api.rajaongkir.com/starter/cost/', [
            'origin' => 445,
            'destination' => $request->destination,
            'weight' => 1000,
            'courier' => $request->courier
        ]);

        $costs = $response['rajaongkir']['results'];

        return response()->json($costs);
    }
}
