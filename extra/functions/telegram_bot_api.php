<?php

	class TelegramBotApi {

		public $token;

		public $url;

		public function __construct($token){
			$this->token = $token;
			$this->url = 'https://api.telegram.org/bot' . $token.'/';
		}

		public function getToken(){
			echo $this->token;
			echo $this->url;
		}

		public function getUrl(){
			echo $this->url;
		}


		public function getUpdate(){

			$url = "https://api.telegram.org/bot" . $this->token .  "/getUpdates?offset=-1";


			$arr = json_decode(file_get_contents($url),true);

			print_r($arr);

			$arr1 = end($arr["result"]);

			$id = $arr1['message']['from']['id'];

			$name = $arr1["message"]["chat"]["first_name"];

			$message =  $arr1["message"]["text"];

		  return ['id' => $id, 'name' => $name, 'message' => $message];
		}

		private function send($id, $message,$keyboard) {

			//Удаление клавы
			if($keyboard == "DEL"){
				$keyboard = array(
					'remove_keyboard' => true
				);
			}
			if($keyboard){
				//Отправка клавиатуры
				$encodedMarkup = json_encode($keyboard);

				$data = array(
					'chat_id'      => $id,
					'text'     => $message,
					'reply_markup' => $encodedMarkup
				);
			}else{
				//Отправка сообщения
				$data = array(
					'chat_id'      => $id,
					'text'     => $message
				);
			}

	        $out = $this->request('sendMessage', $data);
	        return $out;
	    }


      public  function request($method, $data = array()) {

          $get = "";

          foreach ($data as $key => $value) {

              $get .= $key ."=".$value."&";
          }

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.telegram.org/bot1482069935:AAGG3N-NcKxeVch-oUA6JVmoM8kLuplthV8/$method?$get",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
          ));

          $response = curl_exec($curl);

          curl_close($curl);
          echo $response;
	    }

	    public function requestMessage($method, $params = array()) {
		    if ( !empty($params) ) {
		        $url = $this->url . $method . "?" . http_build_query($params);
		        echo $url;
		    } else {
		        $url = $this->url . $method;
		    }
            echo $this->url."\n";

		    return json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
		}

	}


?>
