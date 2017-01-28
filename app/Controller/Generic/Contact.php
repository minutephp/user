<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Generic {

    use Minute\Config\Config;
    use Minute\Event\Dispatcher;
    use Minute\Event\RawMailEvent;
    use Minute\Http\HttpRequestEx;
    use Minute\View\Redirection;
    use Swift_Message;

    class Contact {
        /**
         * @var Config
         */
        private $config;
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var Swift_Message
         */
        private $message;

        /**
         * Contact constructor.
         *
         * @param Config $config
         * @param Dispatcher $dispatcher
         * @param Swift_Message $message
         */
        public function __construct(Config $config, Dispatcher $dispatcher, Swift_Message $message) {
            $this->config     = $config;
            $this->dispatcher = $dispatcher;
            $this->message    = $message;
        }

        public function index(HttpRequestEx $request) {
            $referer   = $_SERVER['HTTP_REFERER'] ?? '/contact';
            $domain    = $this->config->getPublicVars('domain');
            $toEmail   = $this->config->get('private/owner_email', sprintf('support@%s', $domain));
            $fromEmail = sprintf('noreply@%s', $domain);
            $params    = $request->getParameters();
            $body      = '';

            foreach ($params as $key => $value) {
                if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $fromEmail = $value;
                }

                $body .= "$key: $value\n";
            }

            $body .= sprintf("Ip address: %s", getenv('REMOTE_ADDR'));

            $this->message->setFrom($fromEmail);
            $this->message->setTo($toEmail);
            $this->message->setSubject("New message from contact page");
            $this->message->setBody("The following message was received:\n\n$body\n\nSent via contact form ($referer)");

            $rawMailEvent = new RawMailEvent($this->message);
            $this->dispatcher->fire(RawMailEvent::MAIL_SEND_RAW, $rawMailEvent);

            $msg = $rawMailEvent->isHandled() ? 'You message was successfully sent' : 'There was a problem sending your message';

            return new Redirection(sprintf("%s?%s", $referer, http_build_query(['msg' => $msg])));
        }
    }
}