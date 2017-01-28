<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Generic {

    use Minute\Event\Dispatcher;
    use Minute\Event\UserUploadEvent;
    use Minute\Http\HttpRequestEx;
    use Minute\Routing\RouteEx;
    use Minute\Session\Session;
    use Minute\View\Helper;
    use Minute\View\View;

    class UploadData {
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * UploadData constructor.
         *
         * @param Session $session
         * @param Dispatcher $dispatcher
         */
        public function __construct(Session $session, Dispatcher $dispatcher) {
            $this->session    = $session;
            $this->dispatcher = $dispatcher;
        }

        public function index(HttpRequestEx $request) {
            if (($file = $request->getParameter('file')) && ($data = $request->getParameter('data'))) {
                $file = basename($file);

                if (preg_match('~data:image/(\w+);base64,(.*)~', $data, $matches)) {
                    $file = sprintf('%s.%s', pathinfo($file, PATHINFO_FILENAME), in_array($matches[1], ['png', 'jpg', 'gif']) ? $matches[1] : 'jpg');
                    $data = base64_decode($matches[2]);
                }

                $event = new UserUploadEvent($this->session->getLoggedInUserId(), $data, $file, 'data');
                $this->dispatcher->fire(UserUploadEvent::USER_UPLOAD_FILE, $event);

                $url = $event->getUrl();
            }

            return json_encode(['url' => $url ?? '']);
        }
    }
}