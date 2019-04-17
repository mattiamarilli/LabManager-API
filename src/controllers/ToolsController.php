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

}


?>