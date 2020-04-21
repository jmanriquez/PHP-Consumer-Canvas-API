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