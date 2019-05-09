<?php
class StatsController{
  static function deletedTool($req, $res, $service, $app){
    $stm = $app->db->prepare('SELECT u.nome, c.nome as categoria from utensile u INNER JOIN categoria c ON u.id_categoria=c.id_categoria WHERE deleted=true');
    $stm->execute();
    $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = array_map(function($entry){
      return [
        'nome' => $entry['id_utensile'],
        'categoria' => $entry['nome'],
      ];
    }, $dbres);
    $res->json($data);
  }
}
