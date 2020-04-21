<?php

header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';

global $host, $access_key;

$option = isset($_GET['option']) ? $_GET['option'] : false;

switch ($option) {
    case 'getConferences' :
        // $course_id = $_GET['courseid'];
        $endPoint = "/api/v1/conferences";        
        $getConferences = $host . $endPoint;

        $conferences = getCurlData($getConferences);

        echo json_encode($conferences);

    break;
    case 'getStudentsCourse' :
        $course_id = $_GET['courseid'];
        $endPoint = "/api/v1/courses/$course_id/students";
        $getStudentsCourseURI = $host . $endPoint;

        $users = getCurlData($getStudentsCourseURI);
        
        foreach($users as $keyUser => $user) {
            $user_id = $user['id'];
            $getStudentsCompletationEP = "/api/v1/courses/$course_id/modules?student_id=$user_id&include[]=items";
            $getStudentsCompletationURI = $host . $getStudentsCompletationEP;
            $userCompletation = getCurlData($getStudentsCompletationURI);
            foreach ($userCompletation as $keyModule => $module) {
                $users[$keyUser]['module-'.$keyModule.'-id'] = $module['id'];
                $users[$keyUser]['module-'.$keyModule.'-name'] = $module['name'];
                $users[$keyUser]['module-'.$keyModule.'-state'] = $module['state'];
                $users[$keyUser]['module-'.$keyModule.'-items_count'] = $module['items_count'];
            }
            // print_r($userCompletation);
            if($keyUser > 2) break;
        }
        echo json_encode($users);
    break;
    case 'getStudentsCourseDebug' :
        $course_id = $_GET['courseid'];
        $endPoint = "/api/v1/courses/$course_id/students";
        $getStudentsCourseURI = $host . $endPoint;

        
        $users = array(
            array("id"=>"29359","name"=>"Pablo Esteban Aqueveque Navarro","created_at"=>"2020-03-25T20:42:25-03:00","sortable_name"=>"Aqueveque Navarro\, Pablo Esteban","short_name"=>"Pablo Esteban Aqueveque Navarro","sis_user_id"=>"200600029172","login_id"=>"paaqueve@udec.cl"),
            array("id"=>"24195","name"=>"Julio Bernardo Aracena Lucero","created_at"=>"2020-03-25T20:18:35-03:00","sortable_name"=>"Aracena Lucero\, Julio Bernardo","short_name"=>"Julio Bernardo Aracena Lucero","sis_user_id"=>"200800127604","login_id"=>"jaracena@udec.cl"),
            array("id"=>"16029","name"=>"Hugo Gonzalo Arancibia Farias","created_at"=>"2020-03-25T19:40:18-03:00","sortable_name"=>"Arancibia Farias\, Hugo Gonzalo","short_name"=>"Hugo Gonzalo Arancibia Farias","sis_user_id"=>"200800127058","login_id"=>"harancib@udec.cl"),
            array("id"=>"5719","name"=>"Rodrigo Sebastian Arancibia Gonzalez","created_at"=>"2020-03-25T18:50:44-03:00","sortable_name"=>"Arancibia Gonzalez\, Rodrigo Sebastian","short_name"=>"Rodrigo Sebastian Arancibia Gonzalez","sis_user_id"=>"201558898862","login_id"=>"rarancibia@udec.cl"),
            array("id"=>"24074","name"=>"Francisco Jose Araneda Carrasco","created_at"=>"2020-03-25T20:18:02-03:00","sortable_name"=>"Araneda Carrasco\, Francisco Jose","short_name"=>"Francisco Jose Araneda Carrasco","sis_user_id"=>"200600027873","login_id"=>"fraraneda@udec.cl"),
            array("id"=>"27886","name"=>"Alberto Eduardo Araneda Castillo","created_at"=>"2020-03-25T20:35:16-03:00","sortable_name"=>"Araneda Castillo\, Alberto Eduardo","short_name"=>"Alberto Eduardo Araneda Castillo","sis_user_id"=>"200900018463","login_id"=>"aaraneda@udec.cl"),
            array("id"=>"16242","name"=>"Eugenia Alejandra Araneda Hernandez","created_at"=>"2020-03-25T19:41:17-03:00","sortable_name"=>"Araneda Hernandez\, Eugenia Alejandra","short_name"=>"Eugenia Alejandra Araneda Hernandez","sis_user_id"=>"200600015845","login_id"=>"euaraned@udec.cl"),
            array("id"=>"13292","name"=>"Jaime Andres Araneda Sepulveda","created_at"=>"2020-03-25T19:27:06-03:00","sortable_name"=>"Araneda Sepulveda\, Jaime Andres","short_name"=>"Jaime Andres Araneda Sepulveda","sis_user_id"=>"200800128279","login_id"=>"jaraneda@udec.cl"),
            array("id"=>"19820","name"=>"Hugo Augusto Aranguiz Aburto","created_at"=>"2020-03-25T19:58:43-03:00","sortable_name"=>"Aranguiz Aburto\, Hugo Augusto","short_name"=>"Hugo Augusto Aranguiz Aburto","sis_user_id"=>"200900017873","login_id"=>"harangui@udec.cl"),
            array("id"=>"7888","name"=>"Paula Veronica Aravena Bustos","created_at"=>"2020-03-25T19:00:54-03:00","sortable_name"=>"Aravena Bustos\, Paula Veronica","short_name"=>"Paula Veronica Aravena Bustos","sis_user_id"=>"200800125830","login_id"=>"paularavena@udec.cl"),
            array("id"=>"13287","name"=>"Marcelo Andres Aravena Mendez","created_at"=>"2020-03-25T19:27:04-03:00","sortable_name"=>"Aravena Mendez\, Marcelo Andres","short_name"=>"Marcelo Andres Aravena Mendez","sis_user_id"=>"200800130161","login_id"=>"maravenam@udec.cl"),
        );

        // print_object($users);
        // die;


        foreach($users as $keyUser => $user) {
            $user_id = $user['id'];
            $getStudentsCompletationEP = "/api/v1/courses/$course_id/modules?student_id=$user_id&include[]=items";
            $getStudentsCompletationURI = $host . $getStudentsCompletationEP;
            $userCompletation = getCurlData($getStudentsCompletationURI);
            foreach ($userCompletation as $keyModule => $module) {
                $users[$keyUser]['module-'.$keyModule.'-id'] = $module['id'];
                $users[$keyUser]['module-'.$keyModule.'-name'] = $module['name'];
                $users[$keyUser]['module-'.$keyModule.'-state'] = $module['state'];
                $users[$keyUser]['module-'.$keyModule.'-items_count'] = $module['items_count'];
            }
            // print_r($userCompletation);
            // if($keyUser > 2) break;
        }
        // print_object($users);
        // print_r($users);
        echo json_encode($users);
    break;
    default:
        sendError(428, 'Not founf option param.');
    break;
}

function sendError($code, $message) {
    echo json_encode(['code'=>$code,'message'=>$message]);
}

function getCurlData($uri) {
    global $access_key;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$uri);
    curl_setopt($curl, CURLOPT_TIMEOUT, 60);

    $headers = array(
        "Authorization: Bearer $access_key",
        "Content-Type: application/json; charset=utf-8",
        "Strict-Transport-Security: max-age=31536000"
    );
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);

    /**
     * POST OPTIONS
     */
    // curl_setopt($curl, CURLOPT_POST,TRUE);
    // $postfields = array();
    // curl_setopt($curl, CURLOPT_POSTFIELDS,$postfields);//$postfields is an array of parameters specified by the API docs
    
    if( ($json = curl_exec( $curl )) === false) {
        curl_close($curl);
        return array("error"=>'Curl error: ' . curl_error($curl));
    }
    curl_close($curl);
    // $json = curl_exec( $curl );

    $json = trim($json);
    return json_decode($json,true);
}

function print_object($obj) {
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
}