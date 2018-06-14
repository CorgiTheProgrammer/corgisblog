<?

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageDownload extends Model{

    public $image; //class attribute

    //validation
    public function rules(){
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg, png']
        ];
    }

    //class methods

    //this method download image on public folder - web
    public function uploadImage($file, $currentImage)
    {

        $this->image = $file;

        if($this->validate()){

          $this->deleteCurrentImage($currentImage);//delete old image

          return $this->saveImage();//save image with unique filename

        }

    }
    //this method was created because of not want spamming 'Yii::getAlias('@web') . 'uploads/' again and again
    private function getFolder(){

        return Yii::getAlias('@web') . 'uploads/';

    }
    //this method was created for generate unique filename
    private function generateFilename(){

        return strtolower(md5(uniqid($this->image->baseName)). '.' . $this->image->extension);

    }
    //method deleting old file from folder
    public function deleteCurrentImage($currentImage){

        if($this->fileExists($currentImage)){

            unlink($this->getFolder() . $currentImage);

        }

    }
    //checking have file
    public function fileExists($currentImage){

        if(!empty($currentImage) && $currentImage != null){

            return file_exists($this->getFolder() . $currentImage);

        }

    }
    public function saveImage(){

        $filename = $this->generateFilename();//creating a unique name for downloaded image

        $this->image->saveAs($this->getFolder() . $filename);

        return $filename;
    }

}
