<?php

/**
* Upload Controller
*/
class UploadController extends Controller
{
	public function notUpload()
	{
		echo "1";
	}

	public function index()
	{
		$this->uploadFile();
	}

	public function indexDelete()
	{
		if (!$this->validateField()) {
			echo "Error while deleting file!";
			exit();
		}

		if ($this->url->post('page') == 'media') {
			$this->deleteMedia();
		}
		elseif ($this->url->post('page') == 'galler' ) {
			$this->deleteGallery();
		} else {
			$this->deleteMedia();
		}
	}

	public function attachfilebase64($data)
	{
		
	}

	public function attachFile()
	{
		$ds = DIRECTORY_SEPARATOR;  
		$storeFolder = 'public/uploads/';
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$newname = time();
		$rand = rand(100, 999);
		$postfix = date('Ymd');
		$file_name = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
		$name = $file_name.$postfix.$newname.$rand.'.'.$ext; 
		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name'];  

			$targetPath = $storeFolder . $ds;

			$targetFile =  $targetPath. $name;

			move_uploaded_file($tempFile,$targetFile);

			$data['name'] = $name;
			$data['type_id'] = $this->url->post('id');
			$data['type'] = $this->url->post('type');

			$this->commonsModel = new Commons();
			$result = $this->commonsModel->insertAttchedFile($data);

			echo $name;
		}
	}

	protected function uploadFile()
	{
		$ds = DIRECTORY_SEPARATOR;  
		$storeFolder = 'public/uploads';
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$newname = time();
		$rand = rand(100, 999);
		$postfix = date('Ymd');
		$file_name = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
		$name = $file_name.$postfix.$newname.$rand.'.'.$ext; 

		if (!empty($_FILES)) {

			$tempFile = $_FILES['file']['tmp_name'];  

			$targetPath = $storeFolder . $ds;

			$targetFile =  $targetPath. $name;

			$res= move_uploaded_file($tempFile,$targetFile);

			echo $name;
		}
	}

	protected function deleteMedia()
	{
		$file = $this->url->post('name');

		if (!is_string($file)) {
			echo "Invalid file name!";
			exit();
		}
		
		if (!unlink('public/uploads/'.$file))
		{
			echo ("Error deleting $file");
		} else
		{
			echo 1;
		}
	}

	public function deleteAttachedFiles()
	{
		$file = $this->url->post('name');

		if (!is_string($file)) {
			echo "Invalid file name!";
			exit();
		}

		if (file_exists('public/uploads/'.$file)) {
			if (!unlink('public/uploads/'.$file))
			{
				echo ("Error deleting $file");
			}
			else
			{
				$data['name'] = $file;
				$data['type'] = $this->url->post('type');

				$this->commonsModel = new Commons();
				$result = $this->commonsModel->deleteAttchedFile($data);

				echo 1;
			}
		} else {
			$data['name'] = $file;
			$data['type'] = $this->url->post('type');

			$this->commonsModel = new Commons();
			$result = $this->commonsModel->deleteAttchedFile($data);

			echo 1;
		}
		
		
	}

	protected function validateField()
	{
		if ( (strlen($this->url->post('page')) == 6 ) || is_string($this->url->post('page'))) {
			return true;
		}
		elseif (is_string($this->url->post('name'))) {
			return true;
		}
		else {
			return false;
		}
	}
}