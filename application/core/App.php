<?php

    class App{
        protected $controller = 'HomeController';
        protected $method = 'index';
        protected $page404 = 'false';
        protected $params = [];

        public function __construct(){
            $URL_ARRAY = $this->parseUrl();
            $this->getControllleFromUrl($URL_ARRAY);
            $this->getMethodFromUrl($URL_ARRAY);
            $this->getParamsFromUrl($URL_ARRAY);
            call_user_func_array([$this->controller, $this->method], $this->params);
        }
        public function parseUrl(){
            //AQUI NA LINHA DE BAIXO PEGA O CÓDIGO QUE ESTA VINDO NA URL 
            $Request_URI = explode('/', substr(filter_input(INPUT_SERVER, 'REQUEST_URI'), 1)); 
            
        }
        public function getControllleFromUrl($url){
            
            if(!empty([$url[0]]) && isset($url[0])){
                //na linha de baixo verifica se existe arquivo "....Controler.php" na pasta indicada
                if(file_exists('../application/controllers/'.ucfirst($url[0]).'Controller.php')){
                    $this->controller = ucfirst($url[0]).'Controller';
                }else{
                    $this->page404 = true;
                }
            }
            //carregando o arquivo
            require_once '../application/controllers/'. 
            $this->controller.'.php';
            $this->controller = new $this->controller();
        }
        private function getMethodFromUrl(){
            //aqui ele verifica se tem função associada
            if(!empty($url[1]) && isset($url[1])){
                if(method_exists($this->controller, $url[1] && !$this->page404)){
                    $this->method = $url[1];
                }else{
                    $this->method = 'pageNotFound';
                }
            }
        }
        private function getParamsFromUrl($url){
            if(count($url) > 2)
            $this->params = array_slice($url, 2);
        }
    }

?>