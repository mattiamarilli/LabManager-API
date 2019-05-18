<?php
class StatsController{
  static function deletedTool($req, $res, $service, $app){
    $stm = $app->db->prepare('SELECT u.id_utensile, u.id_categoria, u.nome, c.nome as categoria from utensile u INNER JOIN categoria c ON u.id_categoria=c.id_categoria WHERE deleted=true');
    $stm->execute();
    $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = array_map(function($entry){
      return [
        'id_utensile' => +$entry['id_utensile'],
        'id_categoria' => +$entry['id_categoria'],
        'nome' => $entry['nome'],
        'categoria' => $entry['categoria'],
      ];
    }, $dbres);
    $res->json($data);
  }

  static function usedTool($req, $res, $service, $app){
    $stm = $app->db->prepare('SELECT utensile.id_utensile, utensile.nome AS NomeUtensile, count(evento.id_utensile) AS utilizzi, SUM(TIMESTAMPDIFF(SECOND, inizio, fine)) AS secondi FROM evento INNER JOIN utensile ON evento.id_utensile = utensile.id_utensile WHERE utensile.deleted = false GROUP BY evento.id_utensile');
    $stm->execute();
    $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);
    $data = array_map(function($entry){
      return [
        'nome' => $entry['NomeUtensile'],
        'utilizzi' => +$entry['utilizzi'],
        'secondi' => +$entry['secondi']
      ];
    }, $dbres);
    $res->json($data);
  }
}
