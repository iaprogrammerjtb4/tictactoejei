<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Utilities;
use Illuminate\Support\Facades\Log;

use App\Services\FirebaseService;

class GameController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param request Object data game
     */
    public function newGame(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'game' => 'required|numeric',
                'player' => 'required|string',                
                'position'=> 'required|string',                
                'figure'=> 'required|string',                
            ]);
            if ($validator->fails()) {
                Log::error('Los datos ingresados son inválidos: ' . $validator->errors());
                return Utilities::sendMessage(
                    Utilities::COD_RESPONSE_ERROR_CREATE,
                    'Error datos invalidos',
                    true,
                    Utilities::COD_RESPONSE_HTTP_BAD_REQUEST,
                    $validator->errors()
                );
            }
            $game = $request->game;
            $player = $request->player;            
            $position = $request->position;
            $figure = $request->figure;
            $firebase = new FirebaseService();
            $insert = $firebase->createNewGame($game,$player,$position,$figure);            
            return Utilities::sendMessage(
                Utilities::COD_RESPONSE_SUCCESS,
                'Datos registrados correctamente',
                false,
                Utilities::COD_RESPONSE_HTTP_OK,
                $insert
            );
        } catch (\Exception $e) {
            Log::error('Error creando nuevo juego: '.$e->getMessage());
            return Utilities::sendMessage(
                Utilities::COD_RESPONSE_ERROR_CREATE,
                'Ocurrió un error inesperado creando el juego',
                true,
                Utilities::COD_RESPONSE_HTTP_ERROR,
                null
            );
        }

        
    }

    /**
     * @param $game = id del juego
     * @return array con los detalles del juego
     */
    public function loadGame($game){
        try {                        
            $firebase = new FirebaseService();
            $gameData = $firebase->getGame($game);            
            $arrGame = [];
            $count = 0;
            foreach($gameData as $val){
                foreach($val as $k => $g){                    
                    $arrGame[$count][$k] = $g;                    
                }
                $count++;
            }
            return Utilities::sendMessage(
                Utilities::COD_RESPONSE_SUCCESS,
                'Datos traidos correctamente',
                false,
                Utilities::COD_RESPONSE_HTTP_OK,
                $arrGame
            );
        } catch (\Exception $e) {
            Log::error('Error cargando datos del juego: '.$e->getMessage());
            return Utilities::sendMessage(
                Utilities::COD_RESPONSE_ERROR_CREATE,
                'Ocurrió un error inesperado cargando el juego',
                true,
                Utilities::COD_RESPONSE_HTTP_ERROR,
                null
            );
        }
    }
}
