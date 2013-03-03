<?php
/**
 * @author edoardo849 <edoardo.s@daviom.com>
 * @copyright Copyright &copy; Daviom 2011-2013
 * Date: 2/19/13 - 11:18 AM
 */
class DExportModule extends CWebModule
{
    /**
     * Roles that can access to the Module
     * @var $accessPermissionRoles
     */
    public $accessPermissionRoles = array();

    /**
     * Users that can access the module
     * @var $accessPermissionUsers
     */
    public $accessPermissionUsers = array();

    /**
     * Name of the User Module
     * @var $userModule
     */
    public $userModel;

    /**
     * if set to true, it will create the required tables in the DB
     * @var bool
     */
    public $install = false;

    /**
     * Behaviors to attach to the export Report
     * @var array
     */
    public $exportReportBehaviors = array();

    public $exportWidgetViewPath = 'd_export.views.exportWidget';
    /**
     * @var string $layout The layout to be used in all controllers, defaults to column1
     */
    public $layout = '//layouts/column1';

    /**
     * The id of the administrator as-in the table "User"
     * @var string|int $adminUserId
     */
    public $adminUserId;

    public function init()
    {
        $this->defaultController = 'ExportReport';
        if($this->install)
        {
            $this->createTables();
        }
        $this->setImport(array(
            'd_export.models.*',
        ));



    }
    public function beforeControllerAction($controller, $action)
    {
        if(parent::beforeControllerAction($controller, $action))
        {
            $controller->layout = $this->layout;
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }

    protected function createTables()
    {
        $db = Yii::app()->db;
        if($db)
        {
            $prefix = $db->tablePrefix;
            $dbName  = explode('=', $db->connectionString);
            $dbName = $dbName[2];

            $userModel = $this->userModel;
            $userTableSchema = $userModel::model()->tableSchema;
            $userTable = $userTableSchema->name;
            $userIdType = $userTableSchema->columns['id']->dbType;
            //$userTable =


            $transaction = $db->beginTransaction();

            if(!in_array($prefix.'export', $db->getSchema()->tableNames))
            {
                $sql = "CREATE TABLE IF NOT EXISTS `{$prefix}export_report` (
                     `id` INT NOT NULL AUTO_INCREMENT ,
                      `name` VARCHAR(45) NOT NULL ,
                      `model_name` VARCHAR(128) NOT NULL ,
                      `parameters` LONGTEXT NOT NULL ,
                      `include_headers` INT(1) NOT NULL ,
                      PRIMARY KEY  (`id`))
                      ENGINE = InnoDB;";
                $db->createCommand($sql)->execute();
            }
            if(!in_array($prefix.'export_log', $db->getSchema()->tableNames))
            {
                $sql = "CREATE TABLE IF NOT EXISTS `{$prefix}export_log` (
                  `id` BIGINT NOT NULL AUTO_INCREMENT ,
                  `export_id` INT NOT NULL ,
                  `export_filter` MEDIUMTEXT NOT NULL ,
                  `user_id` {$userIdType} NOT NULL ,
                  `timestamp` TIMESTAMP NOT NULL ,
                  `ip_address` VARCHAR(128) NOT NULL ,
                  PRIMARY KEY (`id`) ,
                  INDEX `fk_d_export_log_d_export1_report_idx` (`export_id` ASC) ,
                  INDEX `fk_d_export_log_d_user1_report_idx` (`user_id` ASC) ,
                  CONSTRAINT `fk_d_export_log_d_export1_report`
                    FOREIGN KEY (`export_id` )
                    REFERENCES `{$dbName}`.`{$prefix}export_report` (`id` )
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION,
                  CONSTRAINT `fk_wep_export_log_wep_user1`
                    FOREIGN KEY (`user_id` )
                    REFERENCES `{$dbName}`.`{$userTable}` (`id` )
                    ON DELETE NO ACTION
                    ON UPDATE NO ACTION)
                  ENGINE = InnoDB;";
                $db->createCommand($sql)->execute();
            }

            $transaction->commit();
        }
        else throw new CException('Database connection is not working');
    }


}
