<?php
class StatsController{
  static function deletedTool($req, $res, $service, $app){
    $stm = $app->db->prepare('SELECT u.nome, c.nome as categoria from utensile u INNER JOIN categoria c ON u.id_categoria=c.id_categoria WHERE deleted=true');
    $stm->execute();
    $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = array_map(function($entry){
      return [
        'nome' => $entry['nome'],
        'categoria' => $entry['categoria'],
      ];
    }, $dbres);
    $res->json($data);
  }

  static function usedTool($req, $res, $service, $app){
    $stm = $app->db->prepare('SELECT u.nome AS NomeUtensile, count(e.id_utensile) AS utilizzi FROM evento e INNER JOIN utensile u ON e.id_utensile  = u.id_utensile WHERE u.deleted = false GROUP BY e.id_utensile');
    $stm->execute();
    $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = array_map(function($entry){
      return [
        'nome' => $entry['NomeUtensile'],
        'utilizzi' => +$entry['utilizzi'],
      ];
    }, $dbres);
    $res->json($data);
  }
}
