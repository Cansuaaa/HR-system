<?php

use Yee\Managers\Controller\Controller;
use Yee\Managers\RoutingCacheManager;
use Yee\Managers\CacheManager;
use App\Library\Mailer;
use Yee\Yee;
use App\Models\ACL;
use App\Models\ApproversModel;
use App\Models\ApproveUsersModel;

class TimeOffController extends Controller
{

    const maxFileSize = '512000';

    /**
     * @Route('/timeoff')
     * @Name('timeoff.timeoff')
     */
    public function timeoffAction()
    {
        $app = $this->getYee();

        if ( !ACL::canAccess( $this->getName() ) ) {
            $app->redirect( '/' );
        }

        $approvers = new ApproversModel();
        $getapprovers = $approvers->getDatabase();

        $users = new ApproveUsersModel();
        $getusers = $users->getDatabase();

        $javascript = array(
            '/assets/plugins/fileuploads/js/dropify.min.js',
            '/assets/js/listItemsFromDatabaseValidation.js',
            '/assets/js/uploadfile_function.js'
        );

        $data = array(
            "css" => ["/assets/plugins/fileuploads/css/dropify.min.css" ],
            'javascript' => $javascript,
            'approvers' => $getapprovers,
            'title' => 'Add description',
            'database' => $getusers,
            "languages" => $_SESSION['language']
        );

        $app->render( '/forms/timeOffForm.twig', $data );
    }

    /**
     * @Route('/timeoff')
     * @Name('timeoff.post')
     * @Method('POST')
     */
    public function aftersubmitAction()
    {
        $app = $this->getYee();

        $from = $app->request()->post( "from" );
        $to = $app->request()->post( "to" );
        $type = $app->request()->post( "type" );
        $approvers = $app->request()->post( "approver" );
        $description = $app->request()->post( "descriptionArea" );

        if ( $from == '' || $to == '' || $type == 'Choose' || $approvers == null ) {
            $error = 'Fields with * are required!';
        }

        //if the requiered fields are filled
        elseif ( $from != '' && $to != '' && $type != 'Choose' && $approvers != null ) {
            //if there isn't an uploaded file just send the data as usual
            //submitted data
            $offdays = array(
                array(
                    'from' => $from,
                    'to' => $to,
                    'type' => $type,
                    'approvers' => $approvers,
                    'description' => $description
                )
            );
        }

        //uploading files
        if ( $_FILES['pic']['name'] != '' && !isset( $error ) ) {
            $uploadfileName = $_FILES['pic']['name'];
            $fulluploadfileExtension = explode( "/", $_FILES['pic']['type'] );
            $seconduploadfileExtension = $fulluploadfileExtension[1];
            $fileSize = $_FILES['pic']['size'];

            $allowExtensions = array(
                'jpeg' => 'jpeg',
                'octet-stream' => 'octet-stream',
                'png' => 'png',
                'pdf' => 'pdf',
                'bmp' => 'bmp'
            );

            //File size check
            if ( $fileSize < self::maxFileSize ) {

                //File extension check
                if ( $seconduploadfileExtension == array_key_exists( $seconduploadfileExtension, $allowExtensions ) ) {
                    $target_dir = '../UploadedFiles/';
                    $fileExtention = explode( '.', $uploadfileName );
                    $target_file = $target_dir . sha1( time() ) . "." . $fileExtention[1];
                    move_uploaded_file( $_FILES["pic"]["tmp_name"], $target_file );

                    //submitted data
                    $offdays = array(
                        array(
                            'from' => $from,
                            'to' => $to,
                            'type' => $type,
                            'approvers' => $approvers,
                            'description' => $description
                        )
                    );
                } else {
                    $error = 'Wrong file format!';
                }
            } else {
                $error = 'Maximum file size is 0,5mb.';
            }
        }//end if there is a file
        if ( !isset( $error ) ) {
            $success = 'Your timeoff request was successfully sent!';

            $data = array(
                'offdays' => $offdays,
                'message' => $success,
                'status' => true
            );
        } else {
            $data = array(
                'message' => $error,
                'status' => false
            );
        }

        echo json_encode( $data );
    }

    /**
     * @Route('/approve')
     * @Name('approve.post')
     * @Method ('POST')
     */
    public function approve()
    {

        $app = $this->getYee();

        $id = $app->request()->post( 'id' );

        $mail_data = array( 'activation_code' => "It's approved!" );
        $emailSender = $app->container->get( "mailer" );
        $emailSender->init( 'info@kinguin.com', 'a.k.shtarbev93@gmail.com', 'approve', $mail_data, 'Approve' );
        $emailSender->buildEmail()->sendEmail();

        if ( $id ) {
            $data = array(
                'status' => "Approved!",
                'id' => $id
            );
        }

        echo json_encode( $data );
    }

    /**
     * @Route('/decline')
     * @Name('decline.post')
     * @Method ('POST')
     */
    public function decline()
    {
        /** @var Yee\Yee $yee */
        $app = $this->getYee();

        $id = $app->request()->post( 'id' );

        $mail_data = array( 'activation_code' => "It's approved!", );
        $emailSender = $app->container->get( "mailer" );
        $emailSender->init( 'krenel30@gmail.com', 'cansua.ali@gmail.com', 'decline', $mail_data, 'Decline' );
        $emailSender->buildEmail()->sendEmail();

        if ( $id ) {
            $data = array(
                'status' => "Decline!",
                'id' => $id
            );
        }
        
        echo json_encode( $data );
    }
}
