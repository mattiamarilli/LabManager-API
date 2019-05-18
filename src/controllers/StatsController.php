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
        'id_utensile' => +$entry['id_utensile'],
        'nome' => $entry['NomeUtensile'],
        'utilizzi' => +$entry['utilizzi'],
        'secondi' => +$entry['secondi']
      ];
    }, $dbres);
    $res->json($data);
  }
  
  static function restoreTool($req, $res, $service, $app){
    $paramaters = $req->body();
		$paramaters = json_decode($paramaters, true);
    $stm = $app->db->prepare('UPDATE utensile SET deleted = false WHERE id_utensile = :id_utensile AND id_categoria=:id_categoria');
    $stm->bindValue(":id_utensile", $paramaters['id_utensile']);
    $stm->bindValue(":id_categoria", $paramaters['id_categoria']);
    $stm->execute();
    if($stm->rowCount() > 0)
		{
			$res->json(["message" => "OK", "code" => 200 ]);
		}
		else{
			$res->json(["message" => "Errore nel recuperare uno strumento", "code" => 500 ]);
		}
  }

  static function storicoUtilizziClassi($req, $res, $service, $app){
    $paramaters = $req->body();
    $paramaters = json_decode($paramaters, true);
    $stm = $app->db->prepare('SELECT classe.nome AS classe, COUNT(studente.nome) AS utilizzi, MIN(evento.inizio) AS inizio, MAX(evento.fine) AS fine FROM studente_evento INNER JOIN studente ON studente_evento.id_studente=studente.id_studente INNER JOIN classe ON classe.id_classe=studente.id_classe INNER JOIN evento ON evento.id_evento=studente_evento.id_evento WHERE evento.id_utensile=:id_utensile GROUP BY classe.nome');
    $stm->bindValue("id_utensile", $paramaters['id_utensile']);
    if($stm->execute()){
      $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);
      $data = array_map(function($entry){
        return [
            'classe' => $entry['classe'],
            'uttilizzi' => +$entry['uttilizzi'],
            'inizio' => $entry['inizio'],
            'fine' => $entry['fine'],
        ];
    }, $dbres);
      $res->json(["message" => "Ok", "code" => 500, "data"=> $dbres ]);
    }else{
      $res->json(["message" => "Errore", "code" => 500 ]);
    }
  }
}
