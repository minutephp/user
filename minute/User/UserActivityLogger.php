<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 9/5/2016
 * Time: 8:55 AM
 */
namespace Minute\User {

    use App\Model\MUserActivity;
    use Carbon\Carbon;
    use Minute\Config\Config;
    use Minute\Event\UserEvent;
    use Minute\EventManager\EventManager;
    use Minute\Http\HttpRequestEx;
    use Minute\Http\HttpResponseEx;

    class UserActivityLogger {
        const ACTIVITY_COOKIE = 'activities';
        /**
         * @var EventManager
         */
        private $eventManager;
        /**
         * @var HttpResponseEx
         */
        private $response;
        /**
         * @var Config
         */
        private $config;

        /**
         * UserActivityLogger constructor.
         *
         * @param EventManager $eventManager
         * @param HttpResponseEx $response
         * @param Config $config
         */
        public function __construct(EventManager $eventManager, HttpResponseEx $response, Config $config) {
            $this->eventManager = $eventManager;
            $this->response     = $response;
            $this->config       = $config;
        }

        public function log($event) {
            if ($event instanceof UserEvent) {
                if ($user_id = $event->getUserId()) {
                    $eventName = $event->getName();
                    $eventData = $event->getData() ?: null;
                    if ($eventNameId = $this->eventManager->getEventIdByEventName($eventName)) {
                        $activities = json_decode(substr($_COOKIE[self::ACTIVITY_COOKIE] ?? '[]', 0, 9999), true) ?: [];
                        $activity   = sprintf("%s_%s%s", $user_id, $eventNameId, !empty($eventData) && is_scalar($eventData) ? "_$eventData" : '');

                        if (!in_array($activity, $activities)) {
                            MUserActivity::unguard(true);

                            try {
                                $data = is_string($event->getData()) ? $event->getData() : '';

                                if (MUserActivity::create(['created_at' => Carbon::now(), 'user_id' => $user_id, 'event_name_id' => $eventNameId, 'event_data' => $data])) {
                                    $activities[] = $activity;
                                    @$this->response->setCookie(self::ACTIVITY_COOKIE, json_encode($activities), '+1 year');
                                }
                            } catch (\Throwable $e) {
                            }
                        }
                    }
                }
            }
        }
    }
}