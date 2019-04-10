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

}


?>