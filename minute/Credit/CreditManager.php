<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 1/16/2017
 * Time: 3:55 PM
 */
namespace Minute\Credit {

    use App\Model\MUserGroup;
    use Carbon\Carbon;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserCreditEvent;
    use Minute\User\UserInfo;

    class CreditManager {
        /**
         * @var UserInfo
         */
        private $userInfo;
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * CreditManager constructor.
         *
         * @param UserInfo $userInfo
         * @param Dispatcher $dispatcher
         */
        public function __construct(UserInfo $userInfo, Dispatcher $dispatcher) {
            $this->userInfo   = $userInfo;
            $this->dispatcher = $dispatcher;
        }

        public function addCredits(UserCreditEvent $event) {
            if ($this->updateCredits($event->getUserId(), $event->getGroupName(), $event->getCredits(), $event->getUserData())) {
                $event->setHandled(true);
            }
        }

        public function deductCredits(UserCreditEvent $event) {
            if ($this->updateCredits($event->getUserId(), $event->getGroupName(), -1 * abs($event->getCredits()), $event->getUserData())) {
                $event->setHandled(true);
            }
        }

        protected function updateCredits($user_id, $group_name, $credits, $data = []) {
            $now = Carbon::now();

            if (!($group = MUserGroup::where('user_id', '=', $user_id)->where('expires_at', '>', Carbon::now())->where('group_name', '=', $group_name)->first())) {
                $group = new MUserGroup();
                $group->setRawAttributes(['user_id' => $user_id, 'group_name' => $group_name, 'created_at' => $now, 'updated_at' => $now->addMonth(1), 'expires_at' => $now, 'credits' => 1,
                                          'comments' => 'Created by CreditManager']);

            }

            $group->credits += $credits;

            if ($group->credits > 0) {
                return $group->save();
            } else {
                $this->dispatcher->fire(UserCreditEvent::USER_NO_CREDITS, new UserCreditEvent($user_id, $group_name, $data));
            }

            return false;
        }
    }
}