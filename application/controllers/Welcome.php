<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->library('diff');

		$sourceDir = getcwd()."\\websites\\v1";
		$destinationDir = getcwd()."\\websites\\v2";
		$baseDir = "v2";		

		$list['list_1'] = $this->findFilesRecursive($sourceDir, $destinationDir, $baseDir);

		$sourceDir = getcwd()."\\websites\\v2";
		$destinationDir = getcwd()."\\websites\\v1";
		$baseDir = "v1";		

		$list['list_2'] = $this->findFilesRecursive($sourceDir, $destinationDir, $baseDir);

		$this->load->view('welcome_message',$list);
	}

	public	function findFilesRecursive($sourceDir, $destDir, $baseDir)
	{
		$invalidFiles = array('.','..','.svn','.project','log','compile','scribd.log','log.txt');
		$list = array();
		$diff = array();
		$handle = opendir($sourceDir);
		while(($file = readdir($handle))!==false)
		{
			if(in_array($file,$invalidFiles))
				continue;
			$sourcepath = $sourceDir.DIRECTORY_SEPARATOR.$file;
			$destpath = $destDir.DIRECTORY_SEPARATOR.$file;
			$finalPath = $baseDir.DIRECTORY_SEPARATOR.$file;
			$isFile = is_file($sourcepath);
			
			if($isFile){
				if(is_file($destpath) && file_exists($destpath)){
					if(md5_file($sourcepath) === md5_file($destpath)){
						$list[] = array('file'=>$finalPath,'message'=>'Match', 'txtcolor'=>'green');		
					}else{
						$list[] = array('file'=>$finalPath,'file_name'=>$file,'message'=>'Mis-Match', 'txtcolor'=>'red');
					}
				}else{
					$list[] = array('file'=>$finalPath,'message'=>'New File', 'txtcolor'=>'blue');
				}
			}else{
				$list = array_merge($list,$this->findFilesRecursive($sourcepath, $destpath, $finalPath));
			}
		}
		closedir($handle);
		return $list;
	}

}
