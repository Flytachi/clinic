<?php
/* 
    PHP Payment GATE
    Version = 1.7
*/
class PayTach
{
    private $username, $password, $auth;

    public $api_create_user_card = "https://pay.myuzcard.uz/api/userCard/createUserCard";
    public $api_confirm_user_card = "https://pay.myuzcard.uz/api/userCard/confirmUserCardCreate";
    public $api_get_user_card = "https://pay.myuzcard.uz/api/userCard/getAllUserCards?userId=";
    public $api_payment = "https://pay.myuzcard.uz/api/payment/payment";
    public $api_delete_user_card = "https://pay.myuzcard.uz/api/userCard/deleteUserCard?userCardId=";
    
    private $errors = array(
        -101 => "Неправильные входные данные",
        -102 => "Номер карты введен неверно",
        -103 => "Срок карты введен неправильно",
        -104 => "Карта неактивна",
        -105 => "Пользователь не найден",
        -106 => "Не сообщайте этот код посторонним. Этим могут воспользоваться мошенники",
        -107 => "Ошибка в добавлении карты",
        -108 => "Карта существует",
        -109 => "Ошибка при отправке одноразового пароля",
        -110 => "Карта заблокирована из-за превышения лимита OTP",
        -111 => "Пользователь заблокирован из-за превышения лимита OTP",
        -113 => "Время OTP истек",
        -114 => "Карта не найдена",
        -115 => "Нельзя добавить корпоративную карту",
        -116 => "Недостаточно средств на карте",
        -117 => "Ошибка при оплате",
        -118 => "Клиент существует",
    );

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->auth = base64_encode($username.":".$password);
    }

    public function BaseApi()
    {
        return $this->auth;
    }

    public function createUserCard($userId, $cardNumber, $expireDate)
    {
        // TODO | Create User Card
        /*
        if(is_array($item = $pay->createUserCard(3, "8600000000000000", "yymm"))){
            var_dump($item);
        }else {
            echo $item;
        };
        --- Output ---
        array(2) { 
            ["session"]=> int(6198) 
            ["otpSentPhone"]=> string(12) "99893*****52" 
        } 
        */
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->api_create_user_card,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n    
                \"userId\": $userId,\n    
                \"cardNumber\": \"$cardNumber\",\n    
                \"expireDate\": \"$expireDate\"\n
            }",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Basic ". $this->auth
            ),
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if($response['result'] and !$response['error']){
            return $response['result'];
        }elseif(!$response['result'] and $response['error']){
            return "<strong>Ошибка ".$response['error']['errorCode']."</strong> : ".$response['error']['errorMessage'];
        }
    }

    public function confirmUserCardCreate($session, $otp, $isTrusted, $cardName)
    {
        // TODO | Confirm Created User Card
        /* 
        if(is_bool($item = $pay->confirmUserCardCreate(5984, "418388", 1, "opTest2")) ){
            echo "Confirmed";
        }else {
            echo $item;
        };
        --- Output ---
        True
        */
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->api_confirm_user_card,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n    
                \"session\": $session,\n
                \"otp\": \"$otp\",\n    
                \"isTrusted\": $isTrusted,\n
                \"cardName\": \"$cardName\"\n
            }",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Basic ". $this->auth
            ),
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if($response['result'] and !$response['error']){
            return $response['result']['success'];
        }elseif(!$response['result'] and $response['error']){
            return "<strong>Ошибка ".$response['error']['errorCode']."</strong> : ".$response['error']['errorMessage'];
        }
    }
    
    public function getAllUserCards($id)
    {
        // TODO | Get User Cards
        /*
        if(is_array($item = $pay->getAllUserCards(4))){
            var_dump($item);
        }else {
            echo $item;
        };
        --- Output ---
        array(2) { 
            [0]=> array(12) { 
                ["id"]=> int(84) 
                ["userId"]=> int(1) 
                ["cardId"]=> int(19311) 
                ["owner"]=> string(19) "KHAN ROZA VITALEVNA" 
                ["cardName"]=> string(11) "opTestDrive" 
                ["number"]=> string(16) "860003******7037" 
                ["balance"]=> float(1061601.03) 
                ["expireDate"]=> string(4) "2306" 
                ["isTrusted"]=> int(1) 
                ["token"]=> string(32) "B20B7DAC01C91C31E0530100007F9556" 
                ["status"]=> int(0) 
                ["errorCode"]=> int(0) 
            } 
        }
        */
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->api_get_user_card.$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Language: ru",
                "Authorization: Basic ". $this->auth
            ),
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if($response['result'] and !$response['error']){
            if($response['result']['cards']){
                return $response['result']['cards'];
            }else{
                return "Не найдено привязаных кард!";
            }
        }elseif(!$response['result'] and $response['error']){
            return "<strong>Ошибка ".$response['error']['errorCode']."</strong> : ".$response['error']['errorMessage'];
        }
    }

    public function payment($userId, $cardId, $amount)
    {
        // TODO | Payment
        /*
        if(is_array($item = $pay->payment(10, 1, 100))){
            var_dump($item);
        }else {
            echo $item;
        };
        --- Output ---
        array(6) { 
            ["transactionId"]=> int(21931) 
            ["utrno"]=> string(12) "009663356015" 
            ["terminalId"]=> string(8) "92406242" 
            ["merchantId"]=> string(8) "90487501" 
            ["cardNumber"]=> string(16) "860003******7037" 
            ["date"]=> string(26) "2020-10-21T05:23:18.891842" 
        } 
        */
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->api_payment,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n    
                \"userId\": $userId,\n    
                \"cardId\": $cardId,\n    
                \"amount\": $amount\n
            }",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Language: ru",
                "Authorization: Basic ". $this->auth
            ),
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if($response['result'] and !$response['error']){
            return $response['result'];
        }elseif(!$response['result'] and $response['error']){
            return "<strong>Ошибка ".$response['error']['errorCode']."</strong> : ".$response['error']['errorMessage'];
        }
    }

    public function proPayment($id, $amount)
    {
        // TODO | Payment Many cards
        /*
        if(is_array($item = $pay->proPayment(1, 125700))){
            var_dump($item);
        }else {
            echo $item;
        };
        --- Output ---
        array(6) { 
            ["transactionId"]=> int(21931) 
            ["utrno"]=> string(12) "009663356015" 
            ["terminalId"]=> string(8) "92406242" 
            ["merchantId"]=> string(8) "90487501" 
            ["cardNumber"]=> string(16) "860003******7037" 
            ["date"]=> string(26) "2020-10-21T05:23:18.891842" 
        } 
        */
        if(is_array($item = $this->getAllUserCards($id))){
            foreach (array_reverse($item) as $card) {
                if ($card['balance'] >= $amount) {
                    $dumper = false;
                    if(is_array($item = $this->payment($id,  $card['cardId'], $amount))){
                        return $item;
                    }else {
                        return $item;
                    };
                }else {
                    $dumper = true;
                }
            }
            if($dumper){
                return "На картах не достаточно средств!";
            }
        }else {
            return $item;
        };
    }

    public function countUserCard($id)
    {
        // TODO | Count cards
        /*
        echo $pay->countUserCard(1);
        --- Output ---
        2
        */
        $col = 0;
        if(is_array($item = $this->getAllUserCards($id))){
            foreach ($item as $card) {
                $col++;
            }
            return $col;
        }else {
            return $col;
        };
    }

    public function deleteUserCard($id)
    {
        // TODO | Delete User Card
        /*
        if(is_bool($item = $pay->deleteUserCard(64))){
            echo "Card deleted!";
        }else {
            echo $item;
        };
        --- Output ---
        True
        */
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->api_delete_user_card.$id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ". $this->auth
            ),
        ));
        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        if($response['result'] and !$response['error']){
            return $response['result']['success'];
        }elseif(!$response['result'] and $response['error']){
            return "<strong>Ошибка ".$response['error']['errorCode']."</strong> : ".$response['error']['errorMessage'];
        }
    }

    public function deleteAllUserCards($id)
    {
        // TODO | Delete All User Cards
        /*
        if(is_bool($item = $pay->deleteAllUserCards(2))){
            echo "Cards deleted!";
        }else {
            echo $item;
        };
        --- Output ---
        True
        */
        if(is_array($item = $this->getAllUserCards($id))){
            foreach ($item as $value) {
                if(!is_bool($item = $this->deleteUserCard($value['id']))){
                    echo $item;
                }
            }
            return True;
        }else {
            return $item;
        };
    }
};
// $pay = new PayTach('shoxonasavdo', 'mYuZ3$h0x0n@!');

// if(is_array($item = $pay->createUserCard(2, "8600030475287037", "2306"))){
//     var_dump($item);
// }else {
//     echo $item;
// };

// if(is_bool($item = $pay->confirmUserCardCreate(6195, "906833", 1, "opTestDrive")) ){
//     echo "Confirmed";
// }else {
//     echo $item;
// };

// if(is_array($item = $pay->getAllUserCards(1))){
//     var_dump($item);
// }else {
//     echo $item;
// };

// if(is_array($item = $pay->payment(3, 19311, 100))){
//     var_dump($item);
// }else {
//     echo $item;
// };

// if(is_bool($item = $pay->deleteUserCard(75))){
//     echo "Card deleted!";
// }else {
//     echo $item;
// };

// if(is_bool($item = $pay->deleteAllUserCards(2))){
//     echo "Cards deleted!";
// }else {
//     echo $item;
// };

// if(is_array($item = $pay->proPayment(1, 125700))){
//     var_dump($item);
// }else {
//     echo $item;
// };

// echo $pay->countUserCard(1);

// array(6) { 
//     ["transactionId"]=> int(21931) 
//     ["utrno"]=> string(12) "009663356015" 
//     ["terminalId"]=> string(8) "92406242" 
//     ["merchantId"]=> string(8) "90487501" 
//     ["cardNumber"]=> string(16) "860003******7037" 
//     ["date"]=> string(26) "2020-10-21T05:23:18.891842" 
// } 
?>
