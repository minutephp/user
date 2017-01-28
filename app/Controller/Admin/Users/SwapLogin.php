<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\Users {

    use Minute\Http\HttpResponseEx;
    use Minute\Session\Session;
    use Minute\View\Redirection;

    class SwapLogin {
        /**
         * @var HttpResponseEx
         */
        private $response;

        /**
         * SwapLogin constructor.
         *
         * @param HttpResponseEx $response
         */
        public function __construct(HttpResponseEx $response) {
            $this->response = $response;
        }

        public function index() {
            $this->response->setCookie(Session::COOKIE_NAME, $_COOKIE[Session::ADMIN_COOKIE_NAME]);
            $this->response->setCookie(Session::ADMIN_COOKIE_NAME, null);

            $redir = $_COOKIE[LoginAs::ADMIN_REFERRER] ?: '/admin';
            return new Redirection(preg_match('~/admin~', $redir) ? $redir : '/admin');
        }
    }
}