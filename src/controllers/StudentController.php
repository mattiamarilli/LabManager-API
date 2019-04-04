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
		$parameters = $req->paramPost();
		$username = $parameters['nome'] . "." . $parameters['cognome']; //username nel formato "nome.cognome"
		$stm = $app->db->prepare('INSERT INTO studente (nome, cognome, id_classe, username, password) VALUES ($parameters['nome'], $parameters['cognome'], $parameters['id_classe'], username, generateRandomPassword())');		
        if($stm->execute()){
			$res->json_encode(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json_encode(["message" => "Studente non aggiunto", "code" => 500 ]);
		}
    }
	
	//Genera stringa alfanumerica random
	function generateRandomPassword($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

}
