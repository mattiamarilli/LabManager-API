<?php
/**
 * Created by vivedo <edoardo.viviani@gmail.com>
 * 29/03/19
 */

class GroupController {

    // POST /user/gruppo
    static function joinGroup($req, $res, $service, $app){
		    $parameters = $req->body();
            $parameters = json_decode($parameters, true);

            $stm = $app->db->prepare('SELECT id_gruppo FROM studente WHERE id_studente = :id_studente');
            $stm->bindValue(":id_studente", $parameters['id_studente']);
            $stm->execute();
            
            $idGruppo = $stm->fetch(PDO::FETCH_ASSOC)['id_gruppo'];

            if(!$idGruppo) {

                $stm = $app->db->prepare('INSERT INTO gruppo () VALUES ()');
                $stm->execute();
                
                $idGruppo = $app->db->lastInsertId();
            }


            $stm = $app->db->prepare('UPDATE studente SET id_gruppo=:id_gruppo WHERE id_studente IN (:id1, :id2)');
            $stm->bindValue(":id_gruppo", $idGruppo);
            $stm->bindValue(":id1", $_SESSION['user']['id']);   // current user
            $stm->bindValue(":id2", $parameters['id_studente']);// other user
            $stm->execute();
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
        $url = $req->uri();
        $query_str = parse_url($url, PHP_URL_QUERY);
        parse_str($query_str, $query_params);
        //print_r($query_params);
        $stm = $app->db->prepare('SELECT id_studente, nome, cognome from studente where id_gruppo = :id_gruppo');
		$stm->bindValue(":id_gruppo", $query_params['id_gruppo']);
		$stm->execute();
        $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = array_map(function($entry){
            return [
                'id_studente' => $entry['id_studente'],
                'nome' => $entry['nome'],
                'cognome' => $entry['cognome'],
            ];
        }, $dbres);
        $res->json($data);
    }

}
