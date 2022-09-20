<?php

class shoptanglike {
    public function cURL($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 150);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    public function history($id){
        $CMSNT = new DB;
        $response = curl_get("https://shoptanglike.com/list/buff/?token=".$CMSNT->site('token_shoptanglike')."&sub_page=$id");
        return $response;

    }
    public function create($uid, $amount, $camxuc, $comment, $num_minutes, $days, $id_api, $type_api, $type2_api, $note){
        $CMSNT = new DB;
        $url = "https://shoptanglike.com/".$type_api;
        $data = [
            $type2_api  => $uid,
            'goi'       => $amount,
            'ghichu'    => $note,
            'server'    => $id_api,
            'token'     => $CMSNT->site('token_shoptanglike')
            ];
            
        $request = $this->cURL($url, $data);
        return $request;
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


