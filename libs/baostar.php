<?php

class baostar{
    public function history($type){
        $CMSNT = new DB;
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.baostar.pro/api/logs-order',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "type":"'.$type.'"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'api-key: '.$CMSNT->site('cookie_baostar')
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    public function create($uid, $amount, $camxuc, $comment, $num_minutes, $days, $id_api, $type_api, $type2_api, $note){
        // FIX COMMENT
        $comment = str_replace(PHP_EOL, '\n', $comment);
        $CMSNT = new DB;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.baostar.pro/api/'.$type_api.'/buy',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{ 
            "object_id":"'.$uid.'", 
            "package_name": "'.$id_api.'", 
            "list_message":"'.$comment.'",
            "quantity": '.$amount.',
            "object_type": "'.$camxuc.'",
            "review": "",
            "num_minutes": '.$num_minutes.',
            "notes": "'.$note.'",
            "days" : '.$days.',
            "start": ""
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'api-key: '.$CMSNT->site('cookie_baostar')
        ),
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
  // public function convertURL($url, $type){
  //   $CMSNT = new DB;
  //   $curl = curl_init();
  //   curl_setopt_array($curl, array(
  //     CURLOPT_URL => 'https://dichvu.baostar.pro/api/convert-uid',
  //     CURLOPT_RETURNTRANSFER => true,
  //     CURLOPT_ENCODING => '',
  //     CURLOPT_MAXREDIRS => 10,
  //     CURLOPT_TIMEOUT => 0,
  //     CURLOPT_FOLLOWLOCATION => true,
  //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //     CURLOPT_CUSTOMREQUEST => 'POST',
  //     CURLOPT_POSTFIELDS =>'{
  //       "type": "'.$type.'",
  //       "link": "'.$url.'"
  //   }',
  //     CURLOPT_HTTPHEADER => array(
  //       'api-key: '.$CMSNT->site('cookie_baostar'),
  //       'content-type: application/json'
  //     ),
  //   ));
  //   $response = curl_exec($curl);
  //   curl_close($curl);
  //   return $response;
  // }

    
}


