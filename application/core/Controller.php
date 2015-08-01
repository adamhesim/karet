<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 * Whenever a controller is created, we also
 * 1. initialize a session
 * 2. check if the user is not logged in anymore (session timeout) but has a cookie
 */
class Controller
{
    /** @var View View The view object */
    public $View;
    public $Must;

    /**
     * Construct the (base) controller. This happens when a real controller is constructed, like in
     * the constructor of IndexController when it says: parent::__construct();
     */
    function __construct()
    {
        // always initialize a session
        Session::init();

        // user is not logged in but has remember-me-cookie ? then try to login with cookie ("remember me" feature)
        if (!Session::userIsLoggedIn() AND Request::cookie('remember_me')) {
            header('location: ' . Config::get('URL') . 'login/loginWithCookie');
        }

        // create a view object to be able to use it inside a controller, like $this->View->render();
        $this->View = new View();
        $this->Must = new MustView(array(
            'loader' => new Mustache_Loader_FilesystemLoader(Config::get('PATH_VIEW'),
                ['extension' => '.html']),
            'partials_loader' => new Mustache_Loader_FilesystemLoader(Config::get('PATH_PARTIAL'),
                ['extension' => '.html']),
            'cache' => Config::get('PATH_TEMPLATES_CACHE'),
            'logger' => new MustacheLogger(Mustache_Logger::DEBUG),
        ));
    }
}
