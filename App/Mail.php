<?php

Class Mail{

	//Send Mail
	public function send($reciever_name, $reciever_email, $subject, $template ){


		$data = array(
		    'sender' => array(
		        'name' => 'Warna.lk',
		        'email' => 'info@warna.lk',
		    ),

		    'to' => array([
		            'name' => $reciever_name,
		            'email' => $reciever_email,
		        ],
		    ),
		    'subject' => $subject,
		    'htmlContent' => $template
		);

		$payload = json_encode($data);

		$headers = [
		    'Accept: application/json',
		    'api-key: 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',
		    'content-type: application/json'
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"https://api.sendinblue.com/v3/smtp/email");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output = curl_exec ($ch);
		curl_close ($ch);



	}

}


?>