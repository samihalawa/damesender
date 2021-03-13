<?php
//namespace app\Helpers;
//use IP2LocationLaravel;



class General {
     public static function getInfo($id) {
		return DB::table('send_emails')->where("campaing_id",$id)->count();
	}
}