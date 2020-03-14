<?
namespace wtf;

class Controller{

    public function __construct()
    {
        
    }

    public function view($view, $params = []){
        $path = get_class($this);
        $path = str_replace('controllers\\', '/../views/', $path);
        $path = dirname(__FILE__).strtolower($path);
        $fullView = $path.'/'.$view.'.php';
        ob_start();
        include($fullView);
        $html = ob_get_clean();
        echo $html;
    }

}