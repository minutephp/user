<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 3:22 PM
 */
namespace Minute\Event {

    class UserErrorEvent extends UserEventHandler {
        const USER_MAIL_BOUNCE = "user.mail.bounce";

        /**
         * @var array
         */
        private $userInfo;

        /**
         * UserErrorEvent constructor.
         *
         * @param array $userInfo
         */
        public function __construct(array $userInfo) {
            parent::__construct();

            $this->userInfo = $userInfo;
        }

        /**
         * @return array
         */
        public function getUserInfo(): array {
            return $this->userInfo;
        }

        /**
         * @param array $userInfo
         *
         * @return UserErrorEvent
         */
        public function setUserInfo(array $userInfo): UserErrorEvent {
            $this->userInfo = $userInfo;

            return $this;
        }
    }
}