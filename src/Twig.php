<?php

class Twig extends \Twig\Environment
{
    protected $viewsPath;
    protected $tmp;
    protected $cache;
    protected $debug;
    protected $pv;

    /**
     *    Class constructor
     *    return object
     **/
    function __construct($pv)
    {
        $this->viewsPath = $pv->get('VIEWS_PATH');
        $this->tmp = $pv->get('VIEWS_CACHE_PATH');
        $this->cache = $pv->get('DEBUG') > 0 ? false : $this->tmp;
        $this->debug = $pv->get('DEBUG') > 0 ? true : false;
        $this->pv = $pv;

        $loader = new \Twig\Loader\FilesystemLoader($this->viewsPath);
        parent::__construct($loader, ['cache' => $this->cache, 'debug' => $this->debug]);

        $this->addExtension(new \Twig\Extension\DebugExtension());
        $this->twigFunctions();
    }

    /**
     *  all customized function for using
     *  in twig templates
     */
    public function twigFunctions()
    {
        /*
        * asset function
        * convert path assets to full url address
        * @params file path
        * @return full address file path
        * */
        $function = new \Twig\TwigFunction('asset', function ($path) {
            $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
            $base = $this->pv->get('BASE_URL_PROJECT');
            $baseUrl = $scheme . '://' . $_SERVER['SERVER_NAME'] . $base;
            return $baseUrl . $path;
        });
        $this->addFunction($function);

        /*
         * route function
         * convert route name to url
         * @params route name
         * @return url
         * */
        $functionRoute = new \Twig\TwigFunction('route', function ($path, $prameters = []) {
            $routeUrl = $this->pv->alias($path, $prameters);
            return $routeUrl;
        });
        $this->addFunction($functionRoute);

        /*
        * controller function
        * call controller and function and return the result
        * @params function name
        * @return result of function
        * */
        $controllerCall = new \Twig\TwigFunction('controller', function ($controllerAndFunction, $prameters = []) {
            $result = $this->pv->call($controllerAndFunction, $prameters, 'beforeroute,afterroute');
            return $result;
        });
        $this->addFunction($controllerCall);


    }

}
