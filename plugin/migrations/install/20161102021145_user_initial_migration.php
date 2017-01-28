<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class UserInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_user_activities
        $table = $this->table('m_user_activities', array('id' => 'user_activity_id'));
        $table
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('event_name_id', 'integer', array('limit' => 11))
            ->addColumn('event_data', 'string', array('null' => true, 'limit' => 255))
            ->addIndex(array('user_id'), array())
            ->addIndex(array('event_name_id', 'event_data'), array())
            ->create();


        // Migration for table m_user_data
        $table = $this->table('m_user_data', array('id' => 'user_data_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('key', 'string', array('limit' => 255))
            ->addColumn('data', 'text', array('null' => true, 'limit' => MysqlAdapter::TEXT_LONG))
            ->addIndex(array('user_id', 'key'), array('unique' => true))
            ->create();


    }
}