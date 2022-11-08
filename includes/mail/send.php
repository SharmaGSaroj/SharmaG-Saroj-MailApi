<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");



if ($_POST){
    $receipient = "sarojsharma5462@gmail.com"
    $subject=" Email from my protofolio site"
    $visitor_name="";
    $visitor_email = "";
    $message = "";
    $fail = array();
//Checks for the first name and cleans the text
    if(isset($_POST['firstname'])&& !empty($_POST['firstname'])){
        $visitor_name .= filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);

    }else{
        array_push($fail, "firstname")
    }

    //Checks for the lastname name and cleans the text
    if(isset($_POST['lastname'])&& !empty($_POST['lastname'])){
        $visitor_name .= " ".filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);

    }else{
        array_push($fail, "lastname")
    }
    //Checks for the email name and cleans the text
    if (isset($_POST['email']) && !empty($_POST['email'])) {
       $visitor_email .= str_replace(array("\r","\n", "%0a", "%0d"),"", $_POST['email']);
       $visitor_email .= filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
    } else {
       array_push($fail, "email");
    }
    
    if (isset($_POST['message']) && !empty($_POST['message'])) {
        $clean = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
        $message = htmlspecialchars($clean);
    } else {
        array_push($fail, "message");
    }
    


    $header = "From: the variable that holds their email"."\r\n".
    "Reply-To: Again an email from the person"."\r\n"."X-Mailer: PHP/".phpversion();
    

    if (count($fail==0)) {
        mail($receipient,$subject, $message,$header);
        $results['message']= sprintf("Thank you fro contacting us, %s We will get back to you in 24 hours.",$visitor_name);
    } else {
        header('HTTP/1.1 488 Stop being lazy, fill out the form;');
        die(json_encode(["message"=>$fail]));
    }
    
}else{
    $results['message']="Please fill out the form.";
}


echo json_encode($results);



?>