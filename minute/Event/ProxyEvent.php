<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/19/2016
 * Time: 1:12 AM
 */
namespace Minute\Event {

    class ProxyEvent extends Event {

        const PROXY_URL_ERROR = 'PROXY_URL_ERROR';
        /**
         * @var string
         */
        private $url;

        /**
         * ProxyEvent constructor.
         *
         * @param string $url
         */
        public function __construct(string $url) {
            $this->url = $url;
        }

        /**
         * @return string
         */
        public function getUrl(): string {
            return $this->url;
        }

        /**
         * @param string $url
         *
         * @return ProxyEvent
         */
        public function setUrl(string $url): ProxyEvent {
            $this->url = $url;

            return $this;
        }

    }
}