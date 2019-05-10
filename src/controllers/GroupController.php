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

            $token = $req->headers()['token'];
            $data = parseJwt($token);
            $stm = $app->db->prepare('SELECT id_studente, nome, cognome, id_classe, id_gruppo FROM studente WHERE id_studente = :id');
            $stm->bindValue(":id", $data['id']);
            $stm->execute();
            $user = $stm->fetch(PDO::FETCH_ASSOC);


            $stm = $app->db->prepare('UPDATE studente SET id_gruppo=:id_gruppo WHERE id_studente IN (:id1, :id2)');
            $stm->bindValue(":id_gruppo", $idGruppo);
            $stm->bindValue(":id1", +$user['id_studente']);   // current user
            $stm->bindValue(":id2", +$parameters['id_studente']);// other user
            $stm->execute();

            $res->json(['id_gruppo' => $idGruppo, 'studenti' => [ 'a' => +$parameters['id_studente'], 'b' => +$user['id_studente']]]);

    }

    // DELETE /user/gruppo
    static function leaveGroup($req, $res, $service, $app){
        $token = $req->headers()['token'];
        $data = parseJwt($token);
        $stm = $app->db->prepare('SELECT id_studente, nome, cognome, id_classe, id_gruppo FROM studente WHERE id_studente = :id');
        $stm->bindValue(":id", $data['id']);
        $stm->execute();
        $user = $stm->fetch(PDO::FETCH_ASSOC);


        $stm = $app->db->prepare('UPDATE studente SET id_gruppo = NULL WHERE id_studente = :id_studente');
		$stm->bindValue(":id_studente", $user['id_studente']);
		$stm->execute();

        $res->json(["message" => "OK", "code" => 200 ]);
    }

	// GET /user/gruppo
    static function getGroupMembers($req, $res, $service, $app){
        $token = $req->headers()['token'];
        $data = parseJwt($token);
        $stm = $app->db->prepare('SELECT id_studente, nome, cognome, id_classe, id_gruppo FROM studente WHERE id_studente = :id');
        $stm->bindValue(":id", $data['id']);
        $stm->execute();
        $user = $stm->fetch(PDO::FETCH_ASSOC);

        $stm = $app->db->prepare('SELECT id_studente, nome, cognome from studente where id_gruppo = :id_gruppo');
		$stm->bindValue(":id_gruppo", $user['id_gruppo']);
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
