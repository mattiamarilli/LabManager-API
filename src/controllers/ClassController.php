<?php
/**
 * Created by EdoardoGenova <genova.edoardo@gmail.com>
 * 04/04/2019
 */

class ClassController {

    //GET /admin/classe
    static function getClasses($req, $res, $service, $app){
		$res->json([]);
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
