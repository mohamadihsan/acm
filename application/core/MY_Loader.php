<?php 
class MY_Loader extends CI_Loader {
    public function template($template_name, $vars = array(), $return = FALSE)
    {
        if($return):
        $content  = $this->view('templates/header', $vars, $return);
        $content .= $this->view($template_name, $vars, $return);
        $content .= $this->view('templates/footer', $vars, $return);

        return $content;
    else:
        $this->view('templates/header', $vars);
        $this->view($template_name, $vars);
        $this->view('templates/footer', $vars);
    endif;
    }

    public function controller_api($file_name){
        $CI = & get_instance();
      
        $file_path = APPPATH.'controllers/api/'.$file_name.'.php';
        $object_name = $file_name;
        $class_name = ucfirst($file_name);
      
        if(file_exists($file_path)){
            require $file_path;
          
            $CI->$object_name = new $class_name();
        }
        else{
            show_error("Unable to load the requested controller class: ".$class_name);
        }
    }
}