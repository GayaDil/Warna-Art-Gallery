<?php
require '../App/General.php';

$upload = 'err'; 
if(!empty($_FILES['file'])){ 
     
    // File upload configuration
    $targetDir = '../assets/artworks/temp/';

    if ( isset($_POST['this_id'])) {
        $targetDir = '../assets/artworks/'.$_POST['this_id'].'/';
    }
    
    $allowTypes = array('jpg', 'png'); 
     
    $fileName = basename($_FILES['file']['name']); 
    $targetFilePath = $targetDir.$fileName; 
     
    // Check whether file type is valid 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $newFileName = time().'.'.$fileType;
    $newFileNameFull = $targetDir.$newFileName;

    if(in_array($fileType, $allowTypes)){ 
        // Upload file to the server 
        if(move_uploaded_file($_FILES['file']['tmp_name'], $newFileNameFull)){ 
            $upload = 'ok'; 

            if ( file_exists($newFileNameFull)) {

				$file_name = 'w_'. time() . '.jpg';
				$file_name_path = $targetDir.$file_name;

				$img = new General();
			    $img->convertImage($newFileNameFull, $file_name_path);
			}

        } 
    } 
} 

$response = [
    'status' => $upload,
    'filename' => $file_name,
];

header('Content-Type: application/json');
echo json_encode($response);

?>