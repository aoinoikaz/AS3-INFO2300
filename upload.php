<?php

$MAX_FILE_SIZE = 10000000;

$INVALID_FILE_TYPES_UPLOADED = "Invalid file types uploaded!";
$FILES_TOO_LARGE = "The uploaded files are too large - please try again!";
$ALREADY_UPLOADED = "Already uploaded these files - please try again!";
$GOVT_ID_INVALID_IMAGE_TYPE = "Government ID file type invalid: PNG, JPG or JPEG are the only supported image types!";
$BSNS_LIC_INVALID_IMAGE_TYPE = "Business license file type invalid: PNG, JPG or JPEG are the only supported image types!";
$UNKNOWN_ERROR = "Unknown error - contact administration!";

if(empty($_FILES['governmentID']) || empty($_FILES['businessLicense']))
{
	echo $UNKNOWN_ERROR;
}
else
{
	// Check if image file is a actual image or fake image
	// We must add the '@' operator to suppress errors when the file isn't an image.
	// Normally this wouldnt be ideal, but because we don't need the data
	// returned from the getimagesize() call (and only the state), we can use the error as
	// indication that it's not an actual image file!
	$govtIdCheck = @getimagesize($_FILES['governmentID']['tmp_name']);
	$businessLicCheck = @getimagesize($_FILES['businessLicense']['tmp_name']);
	
	if($govtIdCheck !== false && $businessLicCheck !== false) 
	{
		// The path which will store the signup data
		$baseUploadDirectory = "uploads/";
		
		// Get the file 
		$baseGovernmentIdFileName = $_FILES['governmentID']['name'];
		$baseBusinessLicenseFileName = $_FILES['businessLicense']['name'];
		
		// Generate a unique id derived from the file names, which is also used as directory name
		// for both folders
		$uploadRequestHash = md5($baseGovernmentIdFileName . $baseBusinessLicenseFileName);
		
		$requestDirectory = $baseUploadDirectory . $uploadRequestHash . "/";
		
		$governmentIdFilePath = $requestDirectory . basename($baseGovernmentIdFileName);
		$businessLicenseFilePath = $requestDirectory . basename($baseBusinessLicenseFileName);
		
		$governmentIdFileType = strtolower(pathinfo($governmentIdFilePath, PATHINFO_EXTENSION));	
		$businessLicenseFileType = strtolower(pathinfo($businessLicenseFilePath, PATHINFO_EXTENSION));	
		
		// Check file extensions
		if($governmentIdFileType != "jpg" && $governmentIdFileType != "jpeg" && $governmentIdFileType != "png")
		{
			echo $GOVT_ID_INVALID_IMAGE_TYPE;
		}
		else
		{
			if($businessLicenseFileType != "jpg" && $businessLicenseFileType != "jpeg" && $businessLicenseFileType != "png")
			{
				echo $BSNS_LIC_INVALID_IMAGE_TYPE;
			}
			else
			{
				// Check file size
				if ($_FILES['governmentID']['size'] < $MAX_FILE_SIZE && $_FILES['businessLicense']['size'] < $MAX_FILE_SIZE) 
				{	
					if(!file_exists($requestDirectory))
					{
						mkdir($requestDirectory);
						
						if (move_uploaded_file($_FILES['governmentID']['tmp_name'], $governmentIdFilePath) &&
						move_uploaded_file($_FILES['businessLicense']['tmp_name'], $businessLicenseFilePath))
						{
							$governmentIdUploadUrl = "https://services.thedistro.ca/" . $governmentIdFilePath;
							$businessLicenseUploadUrl = "https://services.thedistro.ca/" . $businessLicenseFilePath;
							
							echo "SUCCESS|" . $governmentIdUploadUrl . "|" . $businessLicenseUploadUrl;
						}
						else
						{
							echo $UNKNOWN_ERROR;
						}
					}
					else
					{
						echo $ALREADY_UPLOADED;
					}
				}
				else
				{
					echo $FILES_TOO_LARGE;
				}
			}
		}
	}
	else
	{
		echo $INVALID_FILE_TYPES_UPLOADED;
	}
}	
?>