<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/14/2016
 * Time: 8:01 AM
 */
namespace Minute\Profile {

    use Minute\Event\ImportEvent;

    class UserProfile {
        public function getFields(ImportEvent $event) {
            $event->addContent([
                ['field' => 'phone', 'label' => 'Phone number', 'type' => 'tel'],
                ['field' => 'country', 'label' => 'Country', 'type' => 'country']
            ]);
        }
    }
}