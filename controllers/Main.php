<? 
namespace controllers;

use models\Site;
use wtf\Controller;

class Main extends Controller {

    public function actionIndex(){
        
        $site = new Site();

        $config = $site->where([
            'url' => $_SERVER['HTTP_HOST']
        ], true);
        
        $this->view('index',[
            'config' => $config
        ]);
    
    }

    public function actionAbout(){
        
        $this->view('index',[
            'foo' =>  'foo',
            'bar' => 'bar'
        ]);
    
    }

}