<?php

/**
 * This is the model class for table "{{export_report}}".
 *
 * The followings are the available columns in table '{{export_report}}':
 * @property integer $id
 * @property string $name
 * @property string $model_name
 * @property string $parameters
 * @property integer $include_headers
 *
 * The followings are the available model relations:
 * @property ExportLog[] $exportLogs
 */
class ExportReport extends CActiveRecord
{
    /**
     * @var string $header the header of the column
     */
    public $header;

    public $value;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ExportReport the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{export_report}}';
	}


    public function behaviors() {

        return Yii::app()->getModule('d_export')->exportReportBehaviors;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, model_name, include_headers', 'required'),
			array('name', 'length', 'max'=>45),
			array('model_name', 'length', 'max'=>128),
            array('include_headers', 'numerical', 'integerOnly'=>true),
            array('parameters', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, model_name, parameters', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'logs' => array(self::HAS_MANY, 'ExportLog', 'export_id'),
		);
	}



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'model_name' => 'Model Name',
			'parameters' => 'Parameters',
            'include_headers'=>'Include Headers?',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('parameters',$this->parameters,true);
        $criteria->compare('include_headers',$this->include_headers);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function scopes()
    {
        return array(
            'forModel'
        );
    }

    public function forModel($modelName)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>'model_name="'.$modelName.'"',
        ));
        return $this;

    }

    public function afterFind()
    {

        if($this->parameters===NULL)
        {
            $this->parameters = array();
        }
        else
        {
            $this->parameters = unserialize($this->parameters);
        }
        return parent::afterFind();

    }
    public function beforeSave()
    {
        if(count($this->parameters)>0)
        {
            foreach($this->parameters as $i=>$parameter)
            {
                $output[]=array($parameter['header'] => $parameter['value']);
            }
            $this->parameters = serialize($output);

        }
        else
            $this->parameters = serialize($this->parameters);

        return parent::beforeSave();

    }

    public static function getAllModels($modelId=false)
    {
        $rootDir = Yii::getPathOfAlias('application.models');
        $modulesDir = Yii::getPathOfAlias('application.modules');


        $list = array();
        $modules = scandir($modulesDir);
        $files = scandir($rootDir);

        foreach($modules as $moduleName)
        {
            if($moduleName != '.' &&  $moduleName != '..')
            {
                if(is_dir($modulesDir.'/'.$moduleName.'/models'))
                {
                    $models = scandir($modulesDir.'/'.$moduleName.'/models');
                    $files = array_merge($models,$files);

                }
            }
        }

        foreach($files as $ind_file){

            if(!preg_match("/php$/",$ind_file))
                continue;
            else
            {
                $ind_file = str_replace('.php','',$ind_file);
                $list[$ind_file] = $ind_file;

            }
        }
        asort($list);

        return ($modelId)?$list[$ind_file]:$list;

    }

    public static function getAllModelsList($modelId=false)
    {
        $list = array();
        if(!$modelId)
        {
            foreach (self::getAllModels() as $key=>$controller)
                $list[] = array('id'=>$key, 'name'=>$key);
        }
        else
        {
            foreach (self::getAllModels($modelId) as $key=>$action)
                $list[] = array('id'=>$action, 'name'=>$action);
        }
        return $list;

    }
}