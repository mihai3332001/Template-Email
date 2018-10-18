<?php

/**

 * Template Settings

 *

 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/template-settings.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see     https://docs.woocommerce.com/document/template-structure/

 * @author  WooThemes

 * @package WooCommerce/Templates

 * @version 3.3.0

 */



if ( ! defined( 'ABSPATH' ) ) {

	exit;

}







//$photoAgent = $_FILES['photoAgent'];

//$photoLogo = $_FILES['photoLogo'];
//var_dump($_FILES);
$files = $_FILES;
$templateEmail = new WP_Email_Template($_POST, $files);

$templateEmail->templateConfig();



class WP_Email_Template {

	var $post = array();

	var $emailTheme;
	
	var $photoAgent = array();

	var $photoLogo = array();

	var $files = array();

	var $message = "";



	public function __construct($array, $files) {

		$this->post = $array;
		if(is_array($files) && !empty($files)) {
			$this->files = $files;
		}

	}

	public function filesUpload() {
		$files = $this->files;
		$filesReturn = array();
		foreach($files as $name => $file) {
	
			if(!empty($file['name'])) {

			$path = get_template_directory() . '/uploads/';

			$fileSave = $path . basename($file['name']);

			$checkIMG = getimagesize($file['tmp_name']);

			}
			if($file['size'] > 2097152) {
					$this->message .= $file['name'] . ' is too big! Maximum upload is 2 mb.';
			}	
			if(!empty($checkIMG)) {
		$move = move_uploaded_file($file['tmp_name'], $fileSave) ?  $file['name'] : null;
		$filesReturn[$name] = $move;
			} 

		}

		return $filesReturn;
	}

	public function templateConfig() {

		$post = $this->post;
		

		if(!empty($post['template'])) {

				

			$template = $post['template'];

			$uploads = $this->uploads();
			$validation = $this->validation();

			$message = $this->message;
			if(empty($message)) {	

			$emailTemplate = $this->selectTemplate($template);

			$replaceTemplate = $this->replaceTemplate($post, $emailTemplate , $uploads);

			echo $this->sendEmail($post, $replaceTemplate, $uploads);

			echo $replaceTemplate;	

			}	else  {
				echo '<div class="alert-warning p-5 text-center">' . $message . '</div>';
			}

		} else {

			echo "You didn't select any email template! If in step 1 is no template you must buy first.";

		}

	}

	private function validation() {
		$post = $this->post;
		//var_dump($post);
		foreach($post as $key=>$value) {
			switch ($key) {
				case 'template':
					if(empty($value)) {
						$this->message .= 'You haven\'t select any email template! If in step 1 is no template you must buy first.';   
					}
					break;
					case 'mlsNumber':
					if(!empty($this->findNumber($value))) {
						$this->message .= '<strong class="text-danger">' . $value . '</strong> Only numbers are allowed.<br />' ;
					}
					break;
					case 'listPrice':
					if(!empty($this->findNumber($value))) {
						$this->message .= '<strong class="text-danger">' . $value . '</strong> Only numbers are allowed.<br />' ;
					}
					break;
					case 'agentName':
					if(!empty($this->findCharacter($value))) {
						$this->message .= '<strong class="text-danger">' . $value . '</strong> Only letters are allowed.<br />' ;
					}
					break;
					case 'phoneNumber':
					if(!empty($this->findPhone($value))) {
						$this->message .= '<strong class="text-danger">' . $value . '</strong> Only phone numbers are allowed.<br />' ;
					}
					break;
					case 'color2':
					if(!empty($this->findColor($value))) {
						$this->message .= '<strong class="text-danger">' . $value . '</strong> Only hex codes are allowed.<br />' ;
					}
					break;
				default:
					# code...
					break;
			}
		}
	}

	private function findMLSReplace($value) {
		return !empty(preg_match('/[^#^\d]/', $value));
	}
	private function findNumber($value) {
		return !empty(preg_match('/[^\d]/', $value));
	}
	private function findCharacter($value) {
		return !empty(preg_match('/[^a-z+^A-Z+\s]/', $value));
	}
	private function findPhone($value) {
		return !empty(preg_match('/[^(\d)\-\s\+]/', $value));
	}
	private function findColor($value) {
		return !empty(preg_match('/[^\w\#]/', $value));
	}


	private function selectTemplate($template) {

		if($template == 210) {

			$template210 = file_get_contents(get_template_directory_uri() . '/email/210/index.html');

			return $template210;

		} else if($template == 213) {

			$template213 = file_get_contents(get_template_directory_uri() . '/email/213/index.html');

			return $template213;

		} else if($template == 208) {

			$template208 = file_get_contents(get_template_directory_uri() . '/email/208/index.html');

			return $template208;

		}  else if($template == 215) {

			$template215 = file_get_contents(get_template_directory_uri() . '/email/215/index.html');

			return $template215;

		}


	}

	private function uploads() {
		$files = $this->filesUpload();
		$path = array();
		foreach($files as $key=>$value) {
			if(!empty($value)) {
				$path[$key] = get_template_directory_uri() . '/uploads/' . $value;
			}
		}
		return $path;
	}

	private function replaceTemplate($replace, $emailTemplate, $uploads = array()) {

		extract($replace);

		//var_dump($replace);

		$listPrice = '$' . $listPrice;

		
		$path = $uploads;
		//var_dump($path);

		$replace = array($mlsNumber, $mlsArea, $fullAddress, $listPrice, $headline, $description, $highlight1, $highlight2, $highlight3, $highlight4, $highlight5, $highlight6, $highlight7, $highlight8, $highlight9, $businessAddress, $businessName, $agentName, $phoneNumber, $emailAddress);

		$search = array('MlsNumber', 'MlsArea', 'AddressProperty', 'Price', 'Headline1', 'Description', 'Hightlight1', 'Hightlight2', 'Hightlight3', 'Hightlight4', 'Hightlight5', 'Hightlight6', 'Hightlight7', 'Hightlight8', 'Hightlight9', 'AddressName', 'BusinessName', 'AgentName', 'PhoneNumber', 'emailAddress');

		$newEmailTemplate = str_replace($search, $replace, $emailTemplate);

		$dom = new DOMDocument;

		$dom->loadHTML($newEmailTemplate);

		if(!empty($path['propertyImage1'])) {
			$imgProperty1 = $dom->getElementById('propertyImg1');
			$imgProperty1->setAttribute('src', $path['propertyImage1']);
		}

		if(!empty($path['propertyImage2'])) {
			$imgProperty2 = $dom->getElementById('propertyImg2');
			$imgProperty2->setAttribute('src', $path['propertyImage2']);
		}

		if(!empty($path['propertyImage3'])) {
			$imgProperty3 = $dom->getElementById('propertyImg3');
			$imgProperty3->setAttribute('src', $path['propertyImage3']);
		}

		if(!empty($path['propertyImage4'])) {
			$imgProperty4 = $dom->getElementById('propertyImg4');
			$imgProperty4->setAttribute('src', $path['propertyImage4']);
		}

		if(!empty($path['propertyImage5']) && !empty($dom->getElementById('propertyImg5'))) {
			$imgProperty5 = $dom->getElementById('propertyImg5');
			$imgProperty5->setAttribute('src', $path['propertyImage5']);
		}

		if(!empty($color2)) {

			$color = $dom->getElementById('logoPhoto');

			$color->setAttribute('bgcolor', $color2);

		}

			$img = $dom->getElementById('agentPhoto');
			$link = $dom->createElement('a');
			$imgCreate = $dom->createElement('img');
			$imgBorder = $dom->createAttribute('border');
			$imgBorder->value = '0';
			$imgStyle = $dom->createAttribute('style');
			$imgStyle->value = 'display:block';
			$imgSrc = $dom->createAttribute('src');
			$imgLogoCompany = $dom->getElementById('logoPhoto');
			$linkLogoCompany = $dom->createElement('a');
			$imgCreateLogoCompany = $dom->createElement('img');
			$imgBorderLogoCompany = $dom->createAttribute('border');
			$imgBorderLogoCompany->value = '0';
			$imgStyleLogoCompany = $dom->createAttribute('style');
			$imgStyleLogoCompany->value = 'display:block';
			$imgSrcLogoCompany = $dom->createAttribute('src');

			if(!empty($path['photoAgent'])) {
				$imgSrc->value = $path['photoAgent'];
			} else {
				$imgSrc->value = 'http://eflyer2day.com/wp-content/themes/understrap-master/email/208/agent.png';
			}

			$imgHeight = $dom->createAttribute('height');
			$imgHeight->value = "91";

			if(!empty($logourl)) {

			$linkHref = $dom->createAttribute('href');
			$linkTarget = $dom->createAttribute('target');
			$linkHref->value = $logourl;
			$linkTarget->value = "_blank";
			$linkHrefLogoCompany = $dom->createAttribute('href');
			$linkTargetLogoCompany = $dom->createAttribute('target');
			$linkHrefLogoCompany->value = $logourl;
			$linkTargetLogoCompany->value = "_blank";
			$link->appendChild($linkHref);
			$link->appendChild($linkTarget);
			$linkLogoCompany->appendChild($linkHrefLogoCompany);
			$linkLogoCompany->appendChild($linkTargetLogoCompany);

			}		

			if(!empty($logourl)) {
			$img->appendChild($link);
			$link->appendChild($imgCreate);
			} else {
			$img->appendChild($imgCreate);
			}

			$imgCreate->appendChild($imgBorder);
			$imgCreate->appendChild($imgStyle);
			$imgCreate->appendChild($imgSrc);
			$imgCreate->appendChild($imgHeight);

			if(!empty($path['photoLogo'])) {
				$imgSrcLogoCompany->value = $path['photoLogo'];
			} else {
				$imgSrcLogoCompany->value = 'http://eflyer2day.com/wp-content/themes/understrap-master/email/208/logo.png';
			}

			$imgHeightLogoCompany = $dom->createAttribute('height');
			$imgHeightLogoCompany->value = "91";	

			if(!empty($logourl)) {
			$imgLogoCompany ->appendChild($linkLogoCompany);
			$linkLogoCompany->appendChild($imgCreateLogoCompany);
			} else {
			$imgLogoCompany->appendChild($imgCreateLogoCompany);
			}	
			
			$imgCreateLogoCompany->appendChild($imgBorderLogoCompany);
			$imgCreateLogoCompany->appendChild($imgStyleLogoCompany);
			$imgCreateLogoCompany->appendChild($imgSrcLogoCompany);
			$imgCreateLogoCompany->appendChild($imgHeightLogoCompany);
		
			if(!empty($linkUrl)) {
			$readMore = $dom->getElementById('readMore');
			if(empty($linkDescription)) {
				$linkDescription = "Read More";
			} 

			$linkReadMore = $dom->createElement('a', $linkDescription);	
			$linkReadMoreHref = $dom->createAttribute('href');
			$linkReadMoreTarget = $dom->createAttribute('target');		
			$linkReadMoreHref->value = $linkUrl;
			$linkReadMoreTarget->value = "_blank";		
			$readMore->appendChild($linkReadMore);
			$linkReadMore->appendChild($linkReadMoreHref);
			$linkReadMore->appendChild($linkReadMoreTarget);

			}
			
		return $dom->saveHTML();	

	}



	public function sendEmail($variables, $templateEmail, $uploads = array()) {

		extract($variables);

		//var_dump($variables);


		$to = 'support@eflyer2day.com';

		$user_id = get_current_user_id();

		$customer = new WC_Customer($user_id);

		$email = $customer->get_email();

		$username = $customer->get_username();

		//$user = $customer->get_customer($user_id);

		//var_dump($username);

		$path = ABSPATH  . "wp-content/uploads/automation/" . $agentName . date('Y-m-d-H:i:s') . ".zip";

		$zip = new ZipArchive;

		$res = $zip->open($path, ZipArchive::CREATE);
		
		if($res == true) {
		$zip->addFromString('test.txt', $templateEmail);
		
		foreach ($uploads as $key=>$file) {
			$download_file = file_get_contents(esc_url($file));
    	#add it to the zip
    	$zip->addFromString(basename($file), $download_file);
			//var_dump(basename($file));
			//$zip->addFile($value, basename($value));
		}
		$zip->close();


		
		$message = '<div class="alert-success p-5 m-5 text-center">The file has been save';
		} else {  $message = "Failed to save!";}

		$subject = 'Email Template Configuration For User: ' . $username . ' Nr: ' . $template;

		$headers = 'From: Eflyer Template Custom <support@eflyer2day.com>' . "\r\n";
		
		$body =  $businessAddress ."\n" . $businessName . "\n" . $agentName . "\n" . $email . "\n";	
		
		$attachments = array($path);
		$wp_mail_return = wp_mail($to, $subject, $body, $headers, $attachments);

		if($wp_mail_return) {
			$message .= ' and send to support@eflyer@2day.com</div>';
			
		} else {
			$message .= "Failed to send!";
		}
		echo $message;
		$this->saveDB($variables, $templateEmail);

	}



	private function saveDB($variables, $templateEmail) {

		extract($variables);
		//$photosLink = $uploads;

		global $wpdb;
		//$photolink = json_encode($photosLink, JSON_UNESCAPED_SLASHES);
		//var_dump($photolink);
		//$photolink = json_encode(array('photoAgent' => $photoAgent, 'photoLogo' => $photo));
		//var_dump($photolink);
		$agent = json_encode(array("agent" => $agentName, "email" => $emailAddress, "phone" => $phoneNumber, 'businessName' => $businessName, 'businessAddress' => $businessAddress));
		//var_dump($agent);

		$highlight = json_encode(array('hightlight1' => $highlight1, 'hightlight2' => $highlight2, 'hightlight3' => $highlight3, 'hightlight4' => $highlight4, 'hightlight5' => $highlight5, 'hightlight6' => $highlight6, 'hightlight7' => $highlight7, 'hightlight8' => $highlight8, 'hightlight9' => $highlight9,));

		$property = json_encode(array('mlsNumber' => $mlsNumber, 'mlsArea' => $mlsArea, 'addressProperty' => $fullAddress, 'price' => $listPrice, 'headline' => $headline, 'description' => $description, 'logourl' => $logourl, 'color2' => $color2, 'linkUrl' => $linkUrl, 'linkDescription' => $linkDescription));

		$tablename = $wpdb->prefix . 'email_template';

		$wpdb->insert($tablename, array (

				'template_email' => $templateEmail, 			

				'agent' => $agent,

				'highlight' => $highlight,

				'property' => $property

				//'photos' => $photolink
				)

		);



	}

}


