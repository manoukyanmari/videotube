<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "videos".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $embed_code
 * @property string $created
 * @property string $updated
 *
 * @property Image[] $images
 * @property Tag[]   $tags
 */
class Video extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'videos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'embed_code', 'created', 'updated'], 'required'],
            [['created', 'updated'], 'safe'],
            [['title', 'description', 'embed_code'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'embed_code' => 'Embed Code',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Images::className(), ['video_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'video_id'])->viaTable('video_tag',['tag_id'=>'id']);
    }
    public function getDropTags()
    {
        $data = Tag::find()->asArray()->all();
        //dirty hack because of select2 bug :/
        $tags= array_merge([0 => ""], ArrayHelper::map($data, 'id','name'));
        return $tags;
    }
    public function getStringTags(){
        $data = Tag::find()->asArray()->all();
        $tags= ArrayHelper::map($data, 'id','name');
        return implode(',', $tags);
    }
}
