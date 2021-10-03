<?php

namespace App\Kavenegar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function MongoDB\BSON\toJSON;


class Kavenegar
{
   public function sendSms($receptor, $message, $template)
   {
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $apiKey = "6472716C7133636D62436F677A32496E444462704F6F5966524759506347724F713774514F505374306A633D";
       Curl_setopt($ch, CURLOPT_URL, "https://api.kavenegar.com/v1/" . $apiKey . "/verify/lookup.json?receptor=$receptor&token=$message&template=$template");
       $res = Curl_exec($ch);
       Curl_close($ch);
       return json_decode($res)->return->status;
   }


    public function sendsmsm2($receptor, $message, $template)
    {
        $sender = "100047778";
        $api = new \Kavenegar \KavenegarApi("6472716C7133636D62436F677A32496E444462704F6F5966524759506347724F713774514F505374306A633D");
       return $api->Send( $sender,$receptor,$message);
   }
}