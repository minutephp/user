<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin\Users {

    use Minute\Error\UserLoginError;
    use Minute\Http\HttpRequestEx;
    use Minute\Http\HttpResponseEx;
    use Minute\Session\Session;
    use Minute\View\Redirection;

    class LoginAs {
        const ADMIN_REFERRER = "admin_referrer";
        /**
         * @var Session
         */
        private $session;
        /**
         * @var HttpResponseEx
         */
        private $response;
        /**
         * @var HttpRequestEx
         */
        private $request;

        /**
         * LoginAs constructor.
         *
         * @param Session $session
         * @param HttpResponseEx $response
         * @param HttpRequestEx $request
         */
        public function __construct(Session $session, HttpResponseEx $response, HttpRequestEx $request) {
            $this->session  = $session;
            $this->response = $response;
            $this->request  = $request;
        }

        public function index($users) {
            if ($user_id = $users[0]->user_id) {
                $this->response->setCookie(self::ADMIN_REFERRER, $this->request->getParameter('redir', getenv('HTTP_REFERER') ?? '/admin'));
                $this->session->startSession($this->session->getLoggedInUserId(), true);
                $this->session->startSession($user_id);

                return new Redirection('/members');
            }

            throw new UserLoginError("Cannot determine user_id");
        }
    }
}