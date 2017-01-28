<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Panel {

    use App\Model\User;
    use Carbon\Carbon;
    use Minute\Event\ImportEvent;

    class UserPanel {
        public function adminDashboardPanel(ImportEvent $event) {
            $yesterday = Carbon::create(date('Y'), date('m'), date('d'), 0, 0, 0, 'UTC');
            $count     = User::where('created_at', '>', $yesterday)->count();

            $panels = [
                ['type' => 'positive', 'title' => 'Users', 'stats' => "$count signups", 'icon' => 'fa-users', 'priority' => 1, 'href' => '/admin/users', 'cta' => 'View users..', 'bg' => 'bg-green']
            ];

            $event->addContent($panels);
        }
    }
}