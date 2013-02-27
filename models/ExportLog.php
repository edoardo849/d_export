<?php

/**
 * This is the model class for table "{{export_log}}".
 *
 * The followings are the available columns in table '{{export_log}}':
 * @property string $id
 * @property integer $export_id
 * @property string $export_filter
 * @property integer $user_id
 * @property string $timestamp
 * @property string $ip_address
 *
 * The followings are the available model relations:
 * @property ExportReport $export
 * @property User $user
 */
class ExportLog extends CActiveRecord
{
    public $reportModelName;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ExportLog the static model class
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
		return '{{export_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('export_id, user_id, timestamp, ip_address, export_filter', 'required'),
			array('export_id, user_id', 'numerical', 'integerOnly'=>true),
			array('ip_address', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('reportModelName, export_filter, id, export_id, user_id, timestamp, ip_address', 'safe', 'on'=>'search'),
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
			'report' => array(self::BELONGS_TO, 'ExportReport', 'export_id'),
			'user' => array(self::BELONGS_TO, Yii::app()->getModule('d_export')->userModel, 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'export_id' => 'Report',
			'user_id' => 'User',
			'timestamp' => 'Timestamp',
			'ip_address' => 'Ip Address',
            'export_filter'=>'Export Filter',
            'reportModelName'=>'Model Name'
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

        $criteria->with = array('report');

		$criteria->compare('id',$this->id,true);
		$criteria->compare('export_id',$this->export_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('ip_address',$this->ip_address,true);
        $criteria->compare('export_filter',$this->export_filter,true);

        $criteria->compare('report.model_name',$this->reportModelName);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function defaultScope()
    {
        return array(
            'order'=>'timestamp DESC'
        );
    }

    public function getIpLink()
    {
        return CHtml::link($this->ip_address, array('http://whatismyipaddress.com/ip/'.$this->ip_address),array('target'=>'_blank'));
    }

    public function renderFilter($data, $row)
    {
        $html ='<pre>';

        $html .= print_r(CJSON::decode($data->export_filter),true);

        return $html.='</pre>';

    }

}