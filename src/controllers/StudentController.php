<?php
/**
 * Created by vivedo <edoardo.viviani@gmail.com>
 * 29/03/19
 */

class StudentController {

    // GET /admin/studente
    static function getStudents($req, $res, $service, $app){

        $stm = $app->db->prepare('SELECT id_studente, studente.nome, cognome, username, classe.id_classe, classe.nome AS classe, id_gruppo FROM studente INNER JOIN classe ON classe.id_classe = studente.id_classe');
        $stm->execute();
        $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);

        $data = array_map(function($entry){
            return [
                'id' => +$entry['id_studente'],
                'nome' => $entry['nome'],
                'cognome' => $entry['cognome'],
                'username' => $entry['username'],
                'id_gruppo' => $entry['id_gruppo'] ? +$entry['id_gruppo'] : null,
                'id_classe' => +$entry['id_classe'],
                'classe' => $entry['classe']
            ];
        }, $dbres);
        $res->json($data);

    }

    // POST /admin/studente
    static function addStudent($req, $res, $service, $app){
        $parameters = $req->body();
        $parameters = json_decode($parameters, true);
        $password = self::generateRandomPassword();
        $username = $parameters['nome'] . "." . $parameters['cognome']; //username nel formato "nome.cognome"
		$stm = $app->db->prepare('INSERT INTO studente (nome, cognome, id_classe, username, password, id_gruppo) VALUES (:nome, :cognome, :id_classe, :username, :password, null)');
		$stm->bindValue(":nome", $parameters['nome']);
		$stm->bindValue(":cognome", $parameters['cognome']);
		$stm->bindValue(":id_classe", $parameters['id_classe']);
		$stm->bindValue(":username", $username);
		$stm->bindValue(":password", $password);
        if($stm->execute()){
			$res->json(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json(["message" => "Studente non aggiunto", "code" => 500 ]);
		}
    }

	//Genera stringa alfanumerica random
	function generateRandomPassword($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

    static function modifyStudent($req, $res, $service, $app){
        $parameters = $req->body();
        $parameters = json_decode($parameters, true);
        $stm = $app->db->prepare('UPDATE studente SET nome = :nome, cognome = :cognome, id_classe = :id_classe WHERE id_studente = :id_studente');
		$stm->bindValue(":nome", $parameters['nome']);
		$stm->bindValue(":cognome", $parameters['cognome']);
		$stm->bindValue(":id_classe", $parameters['id_classe']);
		$stm->bindValue(":id_studente", $parameters['id_studente']);
		$stm->execute();
        if($stm->rowCount() > 0){
            $res->json(["message" => "OK", "code" => 200 ]);
        }else{
            $res->json(["message" => "Studente non modificato", "code" => 500 ]);
        }
    }

    static function deleteStudent($req, $res, $service, $app){
        $parameters = $req->body();
		$parameters = json_decode($parameters, true);
		$stm = $app->db->prepare('DELETE FROM studente WHERE id_studente=:id_studente');
		$stm->bindValue(":id_studente", $parameters['id_studente']);
		$stm->execute();
		if($stm->rowCount() > 0){
			$res->json(["message" => "OK", "code" => 200 ]);
		}else{
			$res->json(["message" => "Studente non eliminato", "code" => 500 ]);
		}
    }

    static function getMates($req, $res, $service, $app) {
        $token = $req->headers()['token'];
        $data = parseJwt($token);
        $stm = $app->db->prepare('SELECT id_studente, nome, cognome, id_classe, id_gruppo FROM studente WHERE id_studente = :id');
		$stm->bindValue(":id",$ data['id']);
		$stm->execute();
        $user = $stm->fetch(PDO::FETCH_ASSOC);


        $stm = $app->db->prepare('SELECT id_studente, nome, cognome FROM studente WHERE id_classe = :classe');
		$stm->bindValue(":classe", $user['id_classe']);
		$stm->execute();
		$res->json($stm->fetchAll(PDO::FETCH_ASSOC));
    }
}
