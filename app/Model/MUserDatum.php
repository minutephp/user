<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MUserDatum extends ModelEx {
        protected $table      = 'm_user_data';
        protected $primaryKey = 'user_data_id';
    }
}