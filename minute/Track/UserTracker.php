<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 8:59 AM
 */
namespace Minute\Track {

    use Minute\Config\Config;
    use Minute\Crypto\JwtEx;

    class UserTracker {
        /**
         * @var Config
         */
        private $config;
        /**
         * @var JwtEx
         */
        private $jwtEx;

        /**
         * UserTracker constructor.
         *
         * @param Config $config
         * @param JwtEx $jwtEx
         */
        public function __construct(Config $config, JwtEx $jwtEx) {
            $this->config = $config;
            $this->jwtEx  = $jwtEx;
        }

        public function createAuthUrl(int $user_id, string $eventName = '', string $data = '', string $link = '') {
            return $this->createTrackingUrl($user_id, $eventName, $data, $link, true);
        }

        public function createTrackingUrl(int $user_id, string $eventName = '', string $data = '', string $link = '', bool $authorize = false) {
            if ($user_id > 0) {
                $data = ['user_id' => $user_id, 'authorize' => $authorize, 'eventName' => $eventName, 'eventData' => $data];

                return sprintf("%s/auth/fwd?jwt=%s&url=%s", $this->config->getPublicVars('host'), $this->jwtEx->encode((object) $data, '+2 day'), urlencode($link));
            } else {
                return $link;
            }
        }
    }
}