<?php

//namespace app\Helpers;
//use IP2LocationLaravel;



class General
{
    public static function getInfo($id)
    {
        return DB::table('campaing_customers')->where("campaign_id", $id)->count();
    }

    public static function getAws($id)
    {
        return DB::table('campaing_customers')->where(["campaign_id" => $id, "aws" => 1])->count();
    }

    public static function getComplaint($id)
    {
        return DB::table('campaing_customers')->where(["campaign_id" => $id,"complaint" => 1])->count();
    }

    public static function getDeliveri($id)
    {
        return DB::table('campaing_customers')->where(["campaign_id" => $id,"delivered" => 1])->count();
    }

    public static function getOpen($id)
    {
        return DB::table('campaing_customers')->where(["campaign_id" => $id,"opened" => 1])->count();
    }

    public static function getBounced($id)
    {
        return DB::table('campaing_customers')->where(["campaign_id" => $id,"bounced" => 1])->count();
    }

    public static function getUnsuscribe($id)
    {
        return DB::table('campaing_customers')->where(["campaign_id" => $id,"unsuscribe" => 1])->count();
    }

    public static function getCountFile($id)
    {
        return DB::table('file_contacts')->where("file_id", $id)->count();
    }

    public static function countFiles($id)
    {
        return DB::table('file_contacts')->where("file_id", $id)->count();
    }
}
