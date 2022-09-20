<?php

class hacklike17 {
    public function history($id){
        $CMSNT = new DB;
        $body = [
            'token'         => $CMSNT->site('apikey_hacklike17'),
            'order_ids[]'   => $id
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://hacklike17.com/api/facebook/get-orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($body, '&'),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;

    }
    public function create($uid, $amount, $camxuc, $comment, $num_minutes, $days, $id_api, $type_api, $type2_api, $note){
        $CMSNT = new DB;
        $body = [
            'token'             => $CMSNT->site('apikey_hacklike17'),
            'url'               => $uid,
            $type2_api          => $uid,
            'name'              => $uid,
            'count'             => $amount,
            'server'            => $id_api,
            'speed_server_1'    => 'low',
            'speed_server_2'    => 'low',
            'speed_server_3'    => 0,
            'reaction'          => $camxuc,
            'list_comment'      => $comment,
            'messages'          => $comment,
            'comments'          => $comment,
            'list_sticker'      => '',
            'list_link'         => '',
            'speed'             => 0,
            'discount_code'     => '',
            'note'              => $note,
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://hacklike17.com/api/'.$type_api,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query($body, '&'),
        ));
          
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public function convertURL($url){
        $CMSNT = new DB;
        $body = [
            'token'  => $CMSNT->site('apikey_hacklike17'),
            'link'   => $url
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://hacklike17.com/api/get_link_uid',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($body, '&'),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}


