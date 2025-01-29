<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Error\Error;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/riot/summoner', function (Request $request) {
    $summonerName = $request->query('summonerName');
    $summonerTag = $request->query('summonerTag');
    $region = $request->query('region');

    if (!$summonerName || !$summonerTag) {
        return response()->json(['error' => 'Summoner Name y Tag son requeridos.'], 400);
    }

    $apiKey = env('API_KEY', 'default_key_if_not_set');
    $endpointGetPuuid = "https://{$region}.api.riotgames.com/riot/account/v1/accounts/by-riot-id/{$summonerName}/{$summonerTag}";

    try {
        $response = Http::withHeaders([
            'X-Riot-Token' => $apiKey,
        ])->get($endpointGetPuuid);

        if ($response->successful()) {
            return $response->json();

        }else{
            return response()->json(['error' => 'No se encontró el puuid.'], 404);
        }

    } catch (\Exception $e) {
        return response()->json(['error' => 'Ocurrió un error en la solicitud.'], 500);
    }
});

Route::get('/riot/matches', function (Request $request) {
    $region = $request->query('region');
    $puuid = $request->query('puuid');
    $apiKey = env('API_KEY', 'default_key_if_not_set');

    $endpointListHistorial = "https://{$region}.api.riotgames.com/tft/match/v1/matches/by-puuid/{$puuid}/ids?start=0&count=5";
    $response = Http::withHeaders([
        'X-Riot-Token' => $apiKey,
    ])->get($endpointListHistorial);

    if ($response->status() !== 200) {
        return response()->json(['error' => 'Error al obtener el historial de partidas.'], $response->status());
    }

    $historial = $response->json();

    if (!is_array($historial)) {
        return response()->json(['error' => 'El historial no es válido.'], 500);
    }

    $matchDetails = [];

    // Iterar sobre los IDs de las partidas y obtener detalles
    foreach ($historial as $matchId) {
        $matchResponse = Http::withHeaders([
            'X-Riot-Token' => $apiKey,
        ])->get("https://{$region}.api.riotgames.com/tft/match/v1/matches/{$matchId}");

        if ($matchResponse->status() === 200) {
            $matchData = $matchResponse->json();

            // Asegurarse de que siempre haya una propiedad "info"
            if (!isset($matchData['info'])) {
                $matchData['info'] = null; // O puedes asignar un valor vacío si prefieres
            }

            $matchDetails[] = $matchData;
        } else {
            $matchDetails[] = [
                'match_id' => $matchId,
                'error' => 'No se pudo obtener información de la partida.',
                'info' => null, // Asegura que siempre haya un "info"
            ];
        }
    }

    return response()->json($matchDetails);
});