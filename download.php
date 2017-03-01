<?php
  include("incl/functions.php");
  include("incl/config.php");
  
  if($do_file_download) {
    doLog('in do_file_download');
    //create zip file
    $selected_file_paths = array();
    foreach($_REQUEST['selected_files'] as $selected_file) {
      $selected_file_path = $save_dir . basename($selected_file);
      if(is_readable($selected_file_path)) {
        array_push($selected_file_paths, $selected_file_path);
		doLog('added '.$selected_file_path);
      }
    }
    $zipfile_path =  $temp_dir . 'scanned_' . time() . '.zip';
	doLog('zip name is '.$zipfile_path);
    if(sizeof($selected_file_paths) > 0) {
      create_zip($selected_file_paths, $zipfile_path, true);
      if(is_readable($zipfile_path)) {
        //output path to created file
        echo $zipfile_path;
		doLog('output name is '.$zipfile_path);
      }
	  else{
	    doLog('output not readable '.$zipfile_path);
	  }
    }
	else{
	  doLog('no files in list to zip');
	}
  }
  
  function doLog($txt){
     $logfile='./tmp/phpsane.log';
     error_log($txt.'\r', 3, $logfile);
  }
  
  /* creates a compressed zip file */
  function create_zip($files = array(),$destination = '',$overwrite = false) {
    doLog('in create_zip');
    //if the zip file already exists and overwrite is false, return false
    if(file_exists($destination) && !$overwrite) { 
	    doLog('file already exists and no overwrite!');
		return false; 
	}
    //vars
    $valid_files = array();
    //if files were passed in...
    if(is_array($files)) {
      //cycle through each file
      foreach($files as $file) {
        //make sure the file exists
        if(file_exists($file)) {
          $valid_files[] = $file;
        }
      }
    }
    //if we have good files...
    if(count($valid_files)) {
	  if(class_exists('ZipArchive')==false){
	     doLog('ZipArchive class not exists!');
	     return false;
	  }
      //create the archive
      $zip = new ZipArchive();
      if($zip->open($destination, ZipArchive::OVERWRITE | ZipArchive::CREATE) !== true) {
	    doLog('zip-open failed for "'.$destination.'"');
        return false;
      }

      //add the files
      foreach($valid_files as $file) {
	    doLog('zip-add '.$file);
        $zip->addFile($file, basename($file));
      }
      
      //close the zip
      $zip->close();
	  
      doLog('returning with '.$destination);
      //check to make sure the file exists
      return file_exists($destination);
    }
    else
    {
	  doLog('no files to zip ');
      return false;
    }
  }
?>