<?php
if (true) { //C
    error_reporting( E_ALL );
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

if (isset($_POST["submit"])){

    //extracts file ingo
    $file = $_FILES["token-image"];
    print_r($file);
    $fileName = $file["name"];
    $filePath = $file["full_path"];
    $fileType = $file["type"];
    //temp location of file storgae
    $fileTmpLoc = $file["tmp_name"] ;
    $fileError = $file["error"];
    $fileSize = $file["size"];

    $fileExtenstion = explode('.', $fileName);
    //gets the last element in
    $fileActExtension = strtolower(end($fileExtenstion));

    $validFiles = array ('jpg','jpeg','png');

    $uploadErrors= [];

    if(in_array($fileActExtension,$validFiles )){
        if($fileError === 0 ){
            if($fileSize <500000){
                $uniqueFileName = uniqid('', true) . "login-system" .$fileActExtension;
                $fileDestination = 'uploads/'.$uniqueFileName;
                move_uploaded_file($fileTmpLoc,$fileDestination);
                echo "File upload success";
                header("Location: ../public/dashboard.php?uploadsuccess=true");
                die();

            }else {
                $uploadErrors["file-large"] = "File exceeds maximum size (500mb)";
            }
        } else{
            $uploadErrors["unknown"] = "Error, please try again";
        }


    } else {
        $uploadErrors["invalid-format"] = "Please a file with valid format i.e jpg, jpeg,png";
    }


    if($uploadErrors){
        $_SESSION["errors_upload"] = $uploadErrors;
        header("Location: ../public/dashboard.php?uploadsuccess=false");
        die();
    }



}