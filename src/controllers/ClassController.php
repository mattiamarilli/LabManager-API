<?php
/**
 * Created by EdoardoGenova <genova.edoardo@gmail.com>
 * 04/04/2019
 */

class ClassController {

    //GET /admin/classe
    static function getClasses($req, $res, $service, $app){
        $stm = $app->db->prepare('SELECT id_classe, nome, anno, abilita FROM classe');
        $stm->execute();
        $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);

        $data = array_map(function($entry){
            return [
                'id_classe' => +$entry['id_classe'],
                'nome' => $entry['nome'],
                'anno_scolastico' => $entry['anno'],
                'enabled' => $entry['abilita'],
            ];
        }, $dbres);

        $res->json($data);
    }

    // POST /admin/classe
    static function addClass($req, $res, $service, $app){	
		$parameters = $req->paramPost();
		$stm = $app->db->prepare('INSERT INTO classe (nome, anno, abilita) VALUES (:nome, :anno_scolastico, false)');	
		$stm->bindValue(":nome", $parameters['nome']);
		$stm->bindValue(":anno_scolastico", $parameters['anno_scolastico']);
        if($stm->execute()){
			$res->json_encode(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json_encode(["message" => "Classe non aggiunta", "code" => 500 ]);
		}
    }
	
	//POST /admin/classe/enable
	static function activateClass($req, $res, $service, $app){
		$parameters = $req->paramPost();
		$stm = $app->db->prepare('UPDATE classe SET abilita = true WHERE id_classe = :id_classe');	
		$stm->bindValue(":id_classe", $paramaters['id_classe']);
		$stm->execute();
		if($stm->rowCount() > 0)
		{
			$res->json_encode(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json_encode(["message" => "Classe non attivata", "code" => 500 ]);
		}
	}
	//DELETE /admin/classe/enable
	static function disableClass($req, $res, $service, $app){
		$parameters = $req->paramPost();
		$stm = $app->db->prepare('UPDATE classe SET abilita = false WHERE id_classe = :id_classe');	
		$stm->bindValue(":id_classe", $paramaters['id_classe']);
		$stm->execute();
		if($stm->rowCount() > 0)
		{
			$res->json_encode(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json_encode(["message" => "Classe non disabilitata", "code" => 500 ]);
		}
	}
}
