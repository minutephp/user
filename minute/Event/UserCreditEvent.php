<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/29/2016
 * Time: 7:50 AM
 */
namespace Minute\Event {

    class UserCreditEvent extends UserEvent {
        const USER_NO_CREDITS = 'user.no.credits';

        const USER_ADD_CREDITS    = 'user.add.credits';
        const USER_DEDUCT_CREDITS = 'user.deduct.credits';
        /**
         * @var string
         */
        private $group_name;
        /**
         * @var bool
         */
        private $handled = false;
        /**
         * @var int
         */
        private $credits;

        /**
         * UserCreditEvent constructor.
         *
         * @param int $user_id
         * @param string $group_name
         * @param array $userData
         * @param int $credits
         */
        public function __construct(int $user_id, string $group_name, array $userData = [], int $credits = 1) {
            parent::__construct($user_id, $userData);
            $this->group_name = $group_name;
            $this->credits    = $credits;
        }

        /**
         * @return int
         */
        public function getCredits(): int {
            return $this->credits;
        }

        /**
         * @param int $credits
         *
         * @return UserCreditEvent
         */
        public function setCredits(int $credits): UserCreditEvent {
            $this->credits = $credits;

            return $this;
        }

        /**
         * @return bool
         */
        public function isHandled(): bool {
            return $this->handled;
        }

        /**
         * @param bool $handled
         *
         * @return UserCreditEvent
         */
        public function setHandled(bool $handled): UserCreditEvent {
            $this->handled = $handled;

            return $this;
        }

        /**
         * @return string
         */
        public function getGroupName(): string {
            return $this->group_name;
        }

        /**
         * @param string $group_name
         *
         * @return UserCreditEvent
         */
        public function setGroupName(string $group_name): UserCreditEvent {
            $this->group_name = $group_name;

            return $this;
        }
    }
}