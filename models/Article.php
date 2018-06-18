<?php

namespace app\models;


use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $date
 * @property string $image
 * @property int $viewed
 * @property int $user_id
 * @property int $status
 * @property int $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    public function saveImage($filename){
        $this->image = $filename;

        return $this->save(false); // default validation is on (set value 'true'), if you want off this - set value 'false'
    }

    //when article was deleted this method  deleting old file from folder
    public function deleteImage(){

        $imageDownloadModel = new ImageDownload();
        $imageDownloadModel->deleteCurrentImage($this->image);

    }

    public function getImage(){

        return ($this->image) ? '/uploads/' . $this->image : '/no-image.gif';

    }

    public function beforeDelete(){

        $this->deleteImage();

        return parent::beforeDelete();

    }

    //function for add Category for Article
    public function getCategory(){

        return $this->hasOne(Category::className(), ['id' => 'category_id']);

    }

    //return list of categories for add category for Article
    public function getListOfCategories(){

      return  ArrayHelper::map(Category::find()->all(), 'id', 'title');

    }

    //functioin for save category of Article
    public function saveCategory($category_id){

        $category = Category::findOne($category_id);

        if($category != null){

            $this->link('category', $category);

            return true;

        }
    }
}
