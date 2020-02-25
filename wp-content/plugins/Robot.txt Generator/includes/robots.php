<?php
//create the robots.txt file contents
$robots_file = "";
$user_agent = "User-Agent: ";
$newRobots = [];

if(isset($_POST['all'])){
    if(strcmp('allow',$_POST['all']) == 0 ){
        $robots_file .= $user_agent . " * \r\n" . "Disallow: \r\n\r\n";
    }else{
        $robots_file .= $user_agent . " * \r\n" . "Disallow: / \r\n\r\n";
    }
}

$i = 0;
foreach($_POST['robot'] as $robot){
    if(array_key_exists($robot,$newRobots) == false){
        $newRobots[$robot] = $_POST['action'][$i]."#".$_POST['files'][$i] ."*";
    }else{
        $newRobots[$robot] .= $_POST['action'][$i]."#".$_POST['files'][$i] ."*";
    }
    $i++;
}
foreach($newRobots as $key => $value){

        $info = explode('*',$value);
    if(strcmp($key,'all') != 0){
        $robots_file .= $user_agent . $key . "\r\n";
    }

        foreach($info as $data){
            if(!empty($data)){
                $data = explode('#',$data);
                if(strcmp($data[0],'None') != 0){
                    $robots_file .= $data[0].": /".$data[1]. "\r\n";
                }

            }
        }
        $robots_file .=  "\r\n";

}

if(isset($_POST['sitemap']) && !empty($_POST['sitemap'])){
    if(strpos($_POST['sitemap'], ",")){
        $maps = explode(",", $_POST['sitemap']);
        foreach ($maps as $map){
            $robots_file .= "Sitemap: " . $map . "\r\n";
        }
    }else{
        $robots_file .= "Sitemap: " . $_POST['sitemap'] . "\r\n\r\n";
    }
    
}
if(file_exists("robots.txt")){
        unlink("robots.txt");
        $fp = fopen("robots.txt", "w+");
        fputs($fp,$robots_file , strlen($robots_file));
        fclose($fp);
    }else{
        $fp = fopen("robots.txt", "w+");
        fputs($fp,$robots_file , strlen($robots_file));
        fclose($fp);
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=robots.txt"); 

    }
echo $robots_file;
