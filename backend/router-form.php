<?php

use Timber\Timber;

$context = Timber::get_context();

global $params;

$form = $params["form"];

if(isset($_SESSION[$form])){
        
    $formServerConfig = $_SESSION[$form];

    $value = preg_replace(
        "/^[\w]+\./",
        "",
        openssl_decrypt(base64_decode($params["form"]),FORM_METHOD,FORM_SECRET)
    );


    $formClientConfig = json_decode($value,true);


    foreach($formServerConfig as $index => $value){
        if($value !== $formClientConfig[$index]){
            Timber::render('views/pages/form/error.twig', $context);
            break;
        }
    }

    $data = [];

    $tbody = "";

    foreach($_POST as $index => $value){ 
        if(strpos($index,"form:") === 0){
            $key = str_replace("form:","",$index);
            $data[$key] = strip_tags($value);
            $tbody.= "<tr>
                <td>".$key."</td>
                <td>".$value."</td>
            </tr>";
        }
    }

    $context["form"] = [
        "config"=>$formServerConfig,
        "data" => $data,
    ];


    wp_mail(
        $formServerConfig["to"],
        $formServerConfig["subject"],
        "<table>".$tbody."</table>",
        "Content-Type: text/html; charset=UTF-8"
    );


    Timber::render('views/pages/form/success.twig', $context);

    unset($_SESSION[$form]);
}else{
    Timber::render('views/pages/form/error.twig', $context);
}
