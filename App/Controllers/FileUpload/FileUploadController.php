<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\RoutingCacheManager;
use Yee\Managers\CacheManager;
use Yee\Yee;

class FileUploadController extends Controller
{

    const maxFileSize = '512000';


    /**
     *  View form.
     * @Route('/upload')
     * @Name('upload.index')
     */

    public function showFileForm() {
        $app = $this->getYee();

        $javascript = array(
            '/assets/js/uploadfile_function.js',
        );

        $data = array(
            'title' => 'Add description',
            'javascript' => $javascript,
            "languages" => $_SESSION['language']
        );
        $app->render('addformview.twig', $data);
    }

    /**
     * Uploading file function.
     * @Route('/ajax/upload')
     * @Name('ajax/upload.post')
     * @Method ('POST')
     */

    public function uploadTestFile()
    {
        $app = $this->getYee();

        $description = $app->request()->post('descriptionArea');

        if( empty($_FILES['pic']['name']) ){
            $error = 'No attached file!';
        }
        else {
            if ($_FILES['pic']['size'] > self::maxFileSize) {
                $error = 'Maximum file size is 1mb.';
            }
            $allowExtensions = array(
                'jpeg' => 'jpeg',
                'octet-stream' => 'octet-stream',
                'png' => 'png',
                'pdf' => 'pdf',
                'bmp' => 'bmp'
            );
            if ($_FILES['pic']['type'] != "") {
                $fulluploadfileExtension = explode("/", $_FILES['pic']['type']);
                $seconduploadfileExtension = $fulluploadfileExtension[1];
                if ($seconduploadfileExtension != array_key_exists($seconduploadfileExtension, $allowExtensions)) {
                    $error = 'Wrong file format!';
                }
            }
        }
        if(!isset($error)) {
            $uploadfileName = $_FILES['pic']['name'];
            $target_dir = '../UploadedFiles/';
            $fileExtention = explode('.', $uploadfileName);
            $target_file = $target_dir . sha1(time()) . "." . $fileExtention[1];
            move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file);

            $data = array(
                'error' => 'File Uploaded!',
                'bool' => true
            );
        }
        else {
            $data = array(
                'error' => $error,
                'bool' => false
            );
        }
        echo json_encode($data);
    }
}