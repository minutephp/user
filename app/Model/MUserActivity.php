<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MUserActivity extends ModelEx {
        protected $table      = 'm_user_activities';
        protected $primaryKey = 'user_activity_id';
    }
}