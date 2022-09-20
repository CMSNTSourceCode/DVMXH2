<?php

class dichvutiktok {
    public function history($type){
        $CMSNT = new DB;
        $params = "&apikey=".$CMSNT->site('apikey_dichvutiktok')."&action=get-orders&order_type=$type";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://dichvutiktok.org/api.php');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        return $response;
    }
    public function create($uid, $amount, $camxuc, $comment, $num_minutes, $days, $id_api, $type_api, $type2_api, $note){
        $CMSNT = new DB;
        $params = "&apikey=".$CMSNT->site('apikey_dichvutiktok')."&action=create-order&order_type=$type_api&seeding_id=$uid&amount=$amount&comment=".urlencode($comment)."&note=$note";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://dichvutiktok.org/api.php');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        return $response;
    }    
    private function get_sessid(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://dichvutiktok.org/login.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        $rs = curl_exec($ch);
        curl_close($ch);

        preg_match('/PHPSESSID=(.*?);/', $rs, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        }
    }
    private function auth($username, $password, $session){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://dichvutiktok.org/api/auth.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'authority' => 'dichvutiktok.org',
            'accept' => 'application/json',
        ]);
        curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $session);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'user=' . $username . '&password=' . $password . '&action=sign-in');
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if ($result && $result['error'] == 'success') {
            return ['error' => 'success', 'sessid' => 'PHPSESSID='.$session];
        } else {
            return [
                'status'    => 'error',
                'message'   => $result['message'] ?? 'Không xác định',
            ];
        }
    }
    private function get_session($username, $password){
        $session = $this->get_sessid();
        if ($session) {
            $session = $this->auth($username, $password, $session);
            if ($session) {
                return $session;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function convertURL($url){
        $CMSNT = new DB;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://dichvutiktok.org/api/api.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'url' => $url,
            'action' => 'get-tiktok-video-id'
        ),
        CURLOPT_HTTPHEADER => array(
            'cookie: '.$this->get_session($CMSNT->site('username_dichvutiktok'), $CMSNT->site('password_dichvutiktok'))['sessid']
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}


