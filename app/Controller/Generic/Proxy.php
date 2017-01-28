<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Generic {

    use Minute\Error\ProxyError;
    use Minute\Event\Dispatcher;
    use Minute\Event\ProxyEvent;
    use Minute\Event\UserUploadEvent;
    use Minute\Http\Browser;
    use Minute\Session\Session;

    class Proxy {
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Browser
         */
        private $browser;

        /**
         * S3Uploader constructor.
         *
         * @param Dispatcher $dispatcher
         * @param Session $session
         * @param Browser $browser
         */
        public function __construct(Dispatcher $dispatcher, Session $session, Browser $browser) {
            $this->dispatcher = $dispatcher;
            $this->session    = $session;
            $this->browser    = $browser;
        }

        public function index(string $url) {
            $host = parse_url($url, PHP_URL_HOST);

            if (!empty($host) && !preg_match('/s3\.amazonaws\.com/i', $host) && !preg_match('/cloudfront\.net/i', $host) && !preg_match('/youtube\.com/i', $host)) {
                if ($file = $this->browser->downloadCached($url)) {
                    try {
                        $event = new UserUploadEvent($this->session->getLoggedInUserId(), $file, basename($url) ?: basename($file));
                        $this->dispatcher->fire(UserUploadEvent::USER_UPLOAD_FILE, $event);
                    } finally {
                        unlink($file);
                    }

                    if ($url = $event->getUrl()) {
                        return json_encode(['url' => $url]);
                    }
                } else {
                    $this->dispatcher->fire(ProxyEvent::PROXY_URL_ERROR, new ProxyEvent($url));

                    throw new ProxyError("Url error");
                }
            }

            return json_encode(['url' => $url]);
        }
    }
}