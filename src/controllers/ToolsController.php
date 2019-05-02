<?php
class ToolsController{
    //GET /admin/utensile
    static function getTools($req, $res, $service, $app){
        $stm = $app->db->prepare('SELECT u.id_utensile,u.nome,u.id_categoria,u.segnala, c.nome AS categoria FROM utensile u INNER JOIN categoria c ON u.id_categoria=c.id_categoria');
        $stm->execute();
        $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);

        $data = array_map(function($entry){
            return [
                'id_utensile' => +$entry['id_utensile'],
                'nome' => $entry['nome'],
                'id_categoria' => $entry['id_categoria'],
                'segnala' => $entry['segnala'],
                'categoria' => $entry['categoria'],
            ];
        }, $dbres);

        $res->json($data);
    }
    
     //POST /admin/utensile
    static function addTool($req, $res, $service, $app){
			$parameters = $req->body();
			$paramaters = json_decode($parameters, true);
			$stm = $app->db->prepare('INSERT INTO utensile (nome, id_categoria, segnala) VALUES (:nome, :id_categoria, false)');
			$stm->bindValue(":nome", $paramaters['nome']);
			$stm->bindValue(":id_categoria", $paramaters['id_categoria']);
	    if($stm->execute()){
				$res->json(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json(["message" => "Utensile non aggiunto", "code" => 500 ]);
		}
    }
    
    //DELETE /admin/utensile
    static function removeTool($req, $res, $service, $app){
			$parameters = $req->body();
			$paramaters = json_decode($parameters, true);
			$stm = $app->db->prepare('DELETE FROM utensile WHERE id_utensile=:id');
			$stm->bindValue(":id", $paramaters['id']);
	    if($stm->execute()){
				$res->json(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json(["message" => "Utensile non rimosso", "code" => 500 ]);
		}
    }
    
    //DELETE /admin/utensile/segnalazione
    static function removeAlertTool($req, $res, $service, $app){
			$parameters = $req->body();
			$paramaters = json_decode($parameters, true);
			$stm = $app->db->prepare('UPDATE utensile SET segnala=false WHERE id_utensile=:id');
			$stm->bindValue(":id", $paramaters['id']);
	    if($stm->execute()){
				$res->json(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json(["message" => "Seganlazione non rimossa", "code" => 500 ]);
		}
    }
    

    //GET /admin/categoria
    static function getCategories($req, $res, $service, $app){
        $stm = $app->db->prepare('SELECT nome,id_categoria FROM categoria');
        $stm->execute();
        $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);

        $data = array_map(function($entry){
            return [
                'id_categoria' => $entry['id_categoria'],
                'nome' => $entry['nome'],
            ];
        }, $dbres);

        $res->json($data);
    }
    
    //POST /admin/categoria
    static function addCategory($req, $res, $service, $app){
			$parameters = $req->body();
			$paramaters = json_decode($parameters, true);
			$stm = $app->db->prepare('INSERT INTO categoria (nome) VALUES (:nome)');
			$stm->bindValue(":nome", $paramaters['nome']);
	    if($stm->execute()){
				$res->json(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json(["message" => "Categoria non aggiunta", "code" => 500 ]);
		}
    }

    // GET /user/utensile
    static function getUserTools($req, $res, $service, $app){ 
      // SELECT id_utensile, utensile.nome, utensile.id_categoria, categoria.nome AS categoria FROM utensile INNER JOIN categoria ON categoria.id_categoria = utensile.id_categoria WHERE id_utensile IN (SELECT id_utensile FROM evento INNER JOIN studente_evento ON studente_evento.id_evento = evento.id_evento AND studente_evento.id_studente = 1)

      $token = $req->headers()['token'];
      $data = parseJwt($token);
      $stm = $app->db->prepare('SELECT id_studente, nome, cognome, id_classe, id_gruppo FROM studente WHERE id_studente = :id');
      $stm->bindValue(":id", $data['id']);
      $stm->execute();
      $user = $stm->fetch(PDO::FETCH_ASSOC);

      $stm = $app->db->prepare('SELECT id_utensile, utensile.nome, utensile.id_categoria, categoria.nome AS categoria FROM utensile INNER JOIN categoria ON categoria.id_categoria = utensile.id_categoria WHERE id_utensile IN (SELECT id_utensile FROM evento INNER JOIN studente_evento ON studente_evento.id_evento = evento.id_evento AND studente_evento.id_studente = :id AND evento.fine IS NULL)');
      $stm->bindValue(":id", $user['id_studente']);
      $stm->execute();

      $res->json($stm->fetchAll(PDO::FETCH_ASSOC));

    }

}


?>