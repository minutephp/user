<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/18/2016
 * Time: 12:56 PM
 */
namespace Minute\Event {

    class UserUploadEvent extends UserEventHandler {
        const USER_UPLOAD_FILE    = "user.upload.file";
        const USER_UPLOAD_CONTENT = "user.upload.content";

        /**
         * @var string
         */
        protected $fileData;
        /**
         * @var string
         */
        private $localPath;
        /**
         * @var string
         */
        private $remotePath;
        /**
         * @var string
         */
        private $url;

        /**
         * UserUploadEvent constructor.
         *
         * @param int $user_id
         * @param null $pathOrData
         * @param null $remotePath
         * @param string $type
         */
        public function __construct(int $user_id, $pathOrData = null, $remotePath = null, $type = 'file') {
            parent::__construct($user_id);

            $this->localPath  = $type == 'file' ? $pathOrData : null;
            $this->fileData   = $type == 'data' ? $pathOrData : null;
            $this->remotePath = $remotePath;
        }

        /**
         * @return mixed|null
         */
        public function getLocalPath() {
            return $this->localPath;
        }

        /**
         * @param mixed|null $localPath
         *
         * @return $this
         */
        public function setLocalPath($localPath) {
            $this->localPath = $localPath;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getRemotePath() {
            return $this->remotePath;
        }

        /**
         * @param mixed $remotePath
         */
        public function setRemotePath($remotePath) {
            $this->remotePath = $remotePath;
        }

        /**
         * @return string
         */
        public function getUrl() {
            return $this->url;
        }

        /**
         * @param string $url
         *
         * @return $this
         */
        public function setUrl($url) {
            $this->url = $url;

            return $this;
        }

        /**
         * @return string
         */
        public function getFileData() {
            if (!empty($this->fileData)) {
                return $this->fileData;
            } elseif (!empty($this->localPath)) {
                return file_get_contents($this->localPath);
            }

            return null;
        }

        /**
         * @param string $fileData
         *
         * @return $this
         */
        public function setFileData($fileData) {
            $this->fileData = $fileData;

            return $this;
        }
    }
}