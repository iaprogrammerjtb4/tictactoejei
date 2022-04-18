<?php

namespace App\Services;

require base_path().'/vendor/autoload.php';

use Kreait\Firebase;
use Kreait\Firebase\Factory;

class FirebaseService
{
    private $firebase;
    private $db;
    private $table = "games";

    public function __construct()
    {
        $this->firebase = ( new Factory )->withServiceAccount(base_path().'/key/tictactoe-37e0e-be81c57a115d.json');
        $this->db = $this->firebase->createDatabase();
    }

    public function getGame($game)
    {
        $reference = $this->db->getReference($this->table.'/'.$game);
        $registros = $reference->getValue();
        
        return $registros;   
    }

    public function createNewGame($game,$player,$position,$figure){
        $id = $game;        
        if($id == 0){
            $lastGame = $this->db->getReference($this->table)            
            ->orderByChild('game')            
            ->getSnapshot()            
            ->getValue();        
            $lastGameRe = array_reverse($lastGame);        
            $keys = array_keys($lastGameRe[0]);
            //var_dump($lastGameRe[0][$keys[0]]);die;     
            $id = $lastGameRe[0][$keys[0]]['game'];
            //var_dump($id);die;
            $id++;
        }                         
        $newGameKey = $this->db->getReference($this->table.'/'.$id)->push()->getKey();
        $data = [
            "indexOn"=>"game",
            'game'=>$id,
            'player'=>$player,            
            'position'=>$position,
            'figure'=>$figure
        ];
        //$insertData = $this->db->getReference($this->table.'/'.$game)->push($data);

        $updates = [            
            $this->table.'/'.$id.'/'.$newGameKey => $data,
        ];
        $dbResult = $this->db->getReference() // this is the root reference
            ->update($updates);
        return $id;
    }

    /**
     * actualiza los datos de un juego
     */
    public function updateDataGame($game,$pOne,$pTwo,$position){        
        $data = [
            'game'=>$game,
            'playerOne'=>$pOne,
            'playerTwo'=>$pTwo,
            'position'=>$position
        ];

        // Create a key for a new post
        $newPostKey = $this->db->getReference($this->table)->push()->getKey();

        $updates = [
            'posts/'.$newPostKey => $data,
            'user-posts/'.$game.'/'.$newPostKey => $data,
        ];

        $this->db->getReference() // this is the root reference
        ->update($updates);
    }
}   