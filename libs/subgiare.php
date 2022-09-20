<?php

class subgiare{

    public function create(){
        $CMSNT = new DB;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://thuycute.hoangvanlinh.vn/api/service/facebook/sub-vip/order',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'idfb=100038641389494&server_order=sv4&amount=5000&note=',
        CURLOPT_HTTPHEADER => [
                'api-token: '.$CMSNT->site('token_subgiare'),
                'Content-Type: application/x-www-form-urlencoded',
                
            ],
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

}