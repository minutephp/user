<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Menu {

    use Minute\Event\ImportEvent;
    use Minute\Http\HttpRequestEx;
    use Minute\Routing\Router;

    class UserMenu {
        /**
         * @var Router
         */
        private $router;

        /**
         * UserMenu constructor.
         *
         * @param Router $router
         */
        public function __construct(Router $router) {
            $this->router = $router;
        }

        public function adminLinks(ImportEvent $event) {
            $links = ['user' => ['title' => 'Users', 'href' => '/admin/users', 'icon' => 'fa-users', 'priority' => 2]];

            $event->addContent($links);
        }

        public function adminUserTabs(ImportEvent $event) {
            $user_id = $this->router->getLastMatchingRoute()->getDefault('user_id');
            $links   = [
                ['label' => 'User Info', 'href' => "/admin/users/edit/$user_id", 'icon' => 'fa-edit', 'priority' => 1],
                ['label' => 'User Groups', 'href' => "/admin/users/groups/$user_id", 'icon' => 'fa-lock', 'priority' => 2],
                ['label' => 'Activity Log', 'href' => "/admin/users/logs/$user_id", 'icon' => 'fa-paw', 'priority' => 99],
            ];

            $event->addContent($links);
        }
    }
}