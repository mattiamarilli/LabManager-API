<?php
/**
 * Created by vivedo <edoardo.viviani@gmail.com>
 * 29/03/19
 */

class GroupController {

    // POST /user/gruppo
    static function joinGroup($req, $res, $service, $app){
		
        $res->json([]);
    }

    // DELETE /user/gruppo
    static function leaveGroup($req, $res, $service, $app){
		$parameters = $req->body();
        $parameters = json_decode($parameters, true);
        $stm = $app->db->prepare('UPDATE studente SET id_gruppo = NULL WHERE id_studente = :id_studente');
		$stm->bindValue(":id_studente", $parameters['id_studente']);
		$stm->execute();
        if($stm->rowCount() > 0){
            $res->json(["message" => "OK", "code" => 200 ]);
        }else{
            $res->json(["message" => "Gruppo non lasciato", "code" => 500 ]);
        }
    }
	
	// GET /user/gruppo
    static function getGroupMembers($req, $res, $service, $app){
		
        $res->json([]);
    }

}