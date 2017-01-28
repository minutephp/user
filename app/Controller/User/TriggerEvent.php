<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\User {

    use Minute\Event\Dispatcher;
    use Minute\Event\UserEvent;
    use Minute\Routing\RouteEx;
    use Minute\Session\Session;
    use Minute\View\Helper;
    use Minute\View\View;

    class TriggerEvent {
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var Session
         */
        private $session;

        /**
         * TriggerEvent constructor.
         *
         * @param Dispatcher $dispatcher
         * @param Session $session
         */
        public function __construct(Dispatcher $dispatcher, Session $session) {
            $this->dispatcher = $dispatcher;
            $this->session    = $session;
        }

        public function index(string $eventName, $eventData) {
            if (!empty($eventName) && !empty($eventData) && preg_match('/^user\./', $eventName)) {
                if ($user_id = $this->session->getLoggedInUserId()) {
                    $result = $this->dispatcher->fire($eventName, new UserEvent($user_id, $eventData));
                }
            }

            return !empty($result) ? 'Pass' : 'Fail';
        }
    }
}