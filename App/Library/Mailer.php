<?php
namespace App\Library;


class Mailer {

	private $sender;
	private $receiver;
	private $template;
	private $data;
	private $htmlmessage;
	private $subject;

	public function init($sender, $receiver, $template, $data, $subject) {
		$this->sender = $sender;
		$this->receiver = $receiver;
		$this->template = $template;
		$this->data = $data;
		$this->subject = $subject;
	}

	public function buildEmail() {

		$app = \Yee\Yee::getInstance();

		$app->view()->appendData( $this->data );
		$this->htmlmessage = $app->view()->render('/mail/'. $this->template .'.twig');
		return $this;

	}

	public function sendEmail() {
		$headers  = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: <". $this->sender . ">" ."\r\n";

		mail($this->receiver, $this->subject, $this->htmlmessage, $headers);

    }
}