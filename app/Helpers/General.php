<?php
//namespace app\Helpers;
//use IP2LocationLaravel;



class General {
     public static function getInfo($id) {
		return DB::table('send_emails')->where("campaing_id",$id)->count();
	}

     public static function getDeliveri($id) {
		return DB::table('send_emails')->where(["campaing_id"=>$id,"delivered"=>1])->count();
	}

     public static function getOpen($id) {
		return DB::table('send_emails')->where(["campaing_id"=>$id,"opened"=>1])->count();
	}

     public static function getBounced($id) {
		return DB::table('send_emails')->where(["campaing_id"=>$id,"bounced"=>1])->count();
	}

	public static function getUnsuscribe($id) {
		return DB::table('send_emails')->where(["campaing_id"=>$id,"unsuscribe"=>1])->count();
	}

	


     
}