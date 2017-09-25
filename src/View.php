<?php
namespace Basic;
class View{
    function setView($name,$data=null,$print=true){
        if($name=='404'){
            header('HTTP/1.0 404 Not Found');
        }
        $filename=ROOT.'view/'.$name.'.php';
        $data['data']=$data;
        $data['viewName']=$name;
        if(file_exists($filename)){
            extract($data);
            ob_start();
            require_once($filename);
            $output = ob_get_contents();
            ob_end_clean();
            if($print){
                print $output;
            }else{
                return $output;
            }
        }else{
            die('<h1>Error</h1>View <b>'.$filename.'</b> not found');
        }
    }
}
