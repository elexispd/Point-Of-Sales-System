<?php 

class test extends ceemain {
   
    function sendMail() {
        $to = "promisedeco24@gmail.com";
        $subject = "Testing email";
        $content = "testing 1,2,4";
        $a = mail_model::sendEmail($to, $subject, $content);
        echo "<pre>";
        print_r($a);
        echo "</pre>";

    }

    function sendSms() {
        // $phone = "2349028273967";
        $phone = "2347018350738";
        $message = "Testing SMS";
        $response = sms_model::sendSms($phone, $message);
        echo "<pre>";
        print_r($response);
        echo "</pre>";
    }

     function update() {
        $table = 'users';
        $data = [
            'role' => 'supervisor_agent',
            // ID is not included in data, it should be passed in where
        ];
        $where = [
            'role' => 'supervisor', 
        ];
        $response = DB::update($table, $data, $where);
        echo "<pre>"; print_r($response); echo "</pre>";
    }
    

}
