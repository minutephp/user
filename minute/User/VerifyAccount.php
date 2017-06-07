<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/11/2016
 * Time: 7:03 AM
 */

namespace Minute\User {

    use Minute\Auth\VerificationCode;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserMailEvent;
    use Minute\Event\UserSignupEvent;

    class VerifyAccount {
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var VerificationCode
         */
        private $verifier;

        /**
         * VerifyAccount constructor.
         *
         * @param Dispatcher $dispatcher
         * @param VerificationCode $verifier
         */
        public function __construct(Dispatcher $dispatcher, VerificationCode $verifier) {
            $this->dispatcher = $dispatcher;
            $this->verifier   = $verifier;
        }

        public function sendEmail(UserSignupEvent $event) {
            $user = $event->getUser();
            $data = $user->attributesToArray();

            if (!empty($user->email) && ($data['verified'] === 'false')) {
                $code = $this->verifier->getVerificationCode($user->user_id);
                $event->setUserData(array_merge($data, ['code' => $code, 'reference' => "V$code"]));
                $event->setData('user_account_verify');

                $this->dispatcher->fire(UserMailEvent::USER_SEND_EMAIL, $event);
            }
        }
    }
}