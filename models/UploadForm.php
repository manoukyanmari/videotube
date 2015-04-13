<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;


/**
 * ContactForm is the model behind the contact form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'maxFiles' => 5], // <--- here!
        ];
    }
}