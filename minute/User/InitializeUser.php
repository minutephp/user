<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 1/17/2017
 * Time: 7:06 PM
 */

namespace Minute\User {

    use App\Model\MUserGroup;
    use Carbon\Carbon;
    use Minute\Config\Config;
    use Minute\Event\UserSignupEvent;

    class InitializeUser {
        /**
         * @var UserInfo
         */
        private $userInfo;
        /**
         * @var Config
         */
        private $config;

        /**
         * InitializeUser constructor.
         *
         * @param UserInfo $userInfo
         * @param Config $config
         */
        public function __construct(UserInfo $userInfo, Config $config) {
            $this->userInfo = $userInfo;
            $this->config   = $config;
        }

        public function assignDefaultGroup(UserSignupEvent $event) {
            $user_id = $event->getUserId();
            $groups  = $this->userInfo->getUserGroups($user_id);
            $default = $this->config->get('private/default_user_group', 'trial');

            if (empty($groups)) { //skip if user has already been assigned to some group by some other handler
                MUserGroup::unguard();

                $now           = Carbon::now();
                $group_name    = $default['group_name'] ?? 'trial';
                $expires_after = $default['expires_after_days'] ?? 30;
                $credits       = $default['credits'] ?? 1;
                $expires_at    = Carbon::now()->addDays($expires_after);

                MUserGroup::create(['user_id' => $user_id, 'group_name' => $group_name, 'created_at' => $now, 'updated_at' => $now, 'expires_at' => $expires_at, 'credits' => $credits,
                                    'comments' => 'Added by InitializeUser']);
            }
        }
    }
}