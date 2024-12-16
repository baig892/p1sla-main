<?php
	// $zip_file = "../expense/all-image.zip";
	// touch($zip_file);
	// $zip = new ZipArchive;
	// $this_zip = $zip->open($zip_file);
	// if($this_zip){
	// 	$folder = opendir('./upload');
	// 	if($folder){
	// 		while( false !== ($image = readdir($folder))){
	// 			if($image !== "." && $image !== ".."){
					
	// 				$file_with_path = "./upload/".$image;

	// 				$zip->addFile($file_with_path,$image);
	// 			}
	// 		}
	// 		closedir($folder);
	// 	}
	// 	if(file_exists($zip_file))  
	// 	{ 
	// 		 $demo_name = "your-all-images.zip";
	// 	     header('Content-type: application/zip');  
	// 	     header('Content-Disposition: attachment; filename="'.$demo_name.'"');  
	// 	     readfile($zip_file); // auto download
	// 	     unlink($zip_file);  
	// 	} 




	// }
?>
<?php include '../inc/connection.php' ?>
<?php
$id = $_GET['id'];
    $sql = "SELECT bill from expense where supervisor_id='$id'";
    $rs = mysqli_query($conn, $sql);
    if (mysqli_num_rows($rs) > 0) {
        
        $zip_file = "../expense/all-image.zip";
        touch($zip_file);
        $zip = new ZipArchive;
        $this_zip = $zip->open($zip_file);

        if($this_zip){	
            while ($rowData = mysqli_fetch_array($rs)) {
                $file_with_path = "./upload/".$rowData['bill'];
                $filename = $rowData['bill'];
                $zip->addFile($file_with_path,$filename);
            }
            $zip->close();

            
            if(file_exists($zip_file))  
            { 
                $demo_name = "your-all-images.zip";
                header('Content-type: application/zip');  
                header('Content-Disposition: attachment; filename="'.$demo_name.'"');  
                readfile($zip_file); // auto download
                unlink($zip_file);  
            } 

        } else {
            echo "something went wrong.";
            exit;
        }

    }
?>