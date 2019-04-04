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
		$res->json([]);
    }
	
	//POST /admin/classe/enable
	static function activateClass($req, $res, $service, $app){
		$res->json([]);
	}
	//DELETE /admin/classe/enable
	static function disableClass($req, $res, $service, $app){
		$res->json([]);
	}
}
