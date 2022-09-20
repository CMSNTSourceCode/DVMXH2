<?php

class autofb88{
    public function history($type){
        $CMSNT = new DB;
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://'.$CMSNT->site('domain_autofb88').'/api/v2/list-order?model='.$type,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'api-token: '.$CMSNT->site('token_autofb88')
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public function create($uid, $amount, $camxuc, $comment, $num_minutes, $days, $id_api, $type_api, $type2_api, $note){
        $CMSNT = new DB;
        
        // FIX COMMENT
        $comment = str_replace(PHP_EOL, '\r\n', $comment);

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://'.$CMSNT->site('domain_autofb88').'/api/v2/'.$type_api.'/order',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{ 
            "package_name": "'.$id_api.'", 
            "object_id": "'.$uid.'", 
            "quantity": '.$amount.',
            "object_type": "'.$camxuc.'",
            "list_messages":"'.$comment.'",
            "review": "",
            "num_minutes": '.$num_minutes.',
            "notes": "'.$note.'",
            "days" : '.$days.',
            "start": ""
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'api-token: '.$CMSNT->site('token_autofb88')
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }    
}


