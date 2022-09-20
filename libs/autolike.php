<?php

class autolike{
    public function login($username, $password){
        $CMSNT = new DB;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.'.$CMSNT->site('domain_autolike').'/public-api/v1/users/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "username": "'.$username.'",
            "password": "'.$password.'",
            "device_id": "496f79c0-e674-11ec-b497-8124621d4a7e"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public function create($uid, $amount, $camxuc, $comment, $id_api, $type_api, $type2_api){
        $CMSNT = new DB;
        if($camxuc == 'like' || $camxuc == ''){
            $camxuc = 'Like';
        }
        if($camxuc == 'care'){
            $camxuc = 'Care';
        }
        if($camxuc == 'sad'){
            $camxuc = 'Sad';
        }
        if($camxuc == 'haha'){
            $camxuc = 'Haha';
        }
        if($camxuc == 'love'){
            $camxuc = 'Love';
        }
        if($camxuc == 'angry'){
            $camxuc = 'Angry';
        }
        if($CMSNT->site('domain_autolike') == 'autolike.cc'){
            $domain = 'https://api.autolike.cc/public-api/v1/users/services/create-permission';
        }else if($CMSNT->site('domain_autolike') == 'mottrieu.com'){
            $domain = 'https://api.mottrieu.com/public-api/v1/users/services/create';
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $domain ,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "'.$type2_api.'": "'.$uid.'",
            "type": "'.$id_api.'",
            "speed": "'.$type_api.'",
            "reaction_types": [
                "'.$camxuc.'"
            ],
            "warranty_type": 7,
            "number": '.$amount.'
        }',
        CURLOPT_HTTPHEADER => array(
            'token: '.$CMSNT->site('token_autolike').'',
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public function history($limit){
        $CMSNT = new DB;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.".$CMSNT->site('domain_autolike')."/public-api/v1/users/services/all",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "service_code": "",
            "uid": "",
            "type": [],
            "status": [],
            "offset": "",
            "limit": '.$limit.',
            "from_time": null,
            "to_time": null,
            "day_left": null
        }',
        CURLOPT_HTTPHEADER => array(
            'token: '.$CMSNT->site('token_autolike').'',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}