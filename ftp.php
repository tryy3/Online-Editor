<?php

	#####################
	# Online editor #####
	#####################
	# Version: 0.1 ######
	# Author: tryy3 #####
	# Credits: bonney12 #
	#####################
	

	
	#############################################################################################################
	# Debug function ############################################################################################
	#############################################################################################################
	# $value = The message, usually an array! ###################################################################
	# $var_dump = If the function is going to use vardump() or print_r() ########################################
	# Description: Makes debug messages look nicer. #############################################################
	# Future: Planning on adding a few security features such as checking if the $value is an array or not etc. #
	######### Nicer output style! ###############################################################################
  	#############################################################################################################

	function debug($value, $var_dump = false)
	{
		echo "<pre>";
			if($var_dump)
			{
				var_dump($value);
			}
			else
			{
				print_r($value);
			}
		echo "</pre>";
	}


  	###############################################################################################
	# Size Function ###############################################################################
	###############################################################################################
	# $size = Size in bytes! ######################################################################
	# Description: Converts bytes to the next size up, kb, mb, gb. ################################
	# Future: Planning on making it reversed too and larger sizes, and able to choose the format! #
	###############################################################################################

	function size($size)
	{
		if($size < 1024)
		{
			$returnSize = $size / 1024;
			$returnFormat = "KB";
		}
		else if($size < 1048576)
		{
			$returnSize = $size / 1024 / 1024;
			$returnFormat = "MB";
		}
		else
		{
			$returnSize = $size / 1024 / 1024 / 1024;
			$returnFormat = "GB";
		}

		return $returnSize . " " . $returnFormat;
	}


	###################################################################################
	# Error function ##################################################################
	###################################################################################
	# $message = The error message! ###################################################
	# Description: Sends a nice error message in the form of an alert. ################
	# Future: Planning on maybe expanding it to success, alert, multiline etc. later! #
	###################################################################################

	function error($message)
	{
		echo '<div class="alert alert-danger">Error!!!<br>';
		echo $message;
		echo '</div>';
	}


	# Just a some Variables that need to be used later!

	$currentPathIsDir = false;
	$filePath = "";


	# Checks if the file is in a different folder to the current one
	# If it is, then add the path from ?file= to the default home dir
	# If not, just save the default home dir in $folderpath

	if (isset($_GET["file"]) && $_GET != "")
	{
		$filePath = $_GET["file"];
		$folderPath = "/home/ExpandHosting/www" . $filePath;
	}
	else
	{
		$folderPath = "/home/ExpandHosting/www";
	}


	# The start of the upload process
	#
	# Checks if the global variable $_FILES has the key uploadfield

	if(isset($_FILES["uploadfield"]))
	{


		# Adds a variable in case there is an error

		$error = false;


		# Checks if there were any errors uploading the file,
		# if there were, it will send the error message to the error function and set $error to true
		# else it will continue with the uploading process

		if($_FILES["uploadfield"]["error"] > 0)
		{
			error($_FILES["uploadfield"]["error"]);
			$error = true;
		}
		else
		{


			# Sets the $file variable so I don't need to type $_FILES["uploadfield"] all the time!
			# Adds the $fileSize variable so people don't upload files that are too big, default 5gb!

			$file = $_FILES["uploadfield"];
			$fileSize = pow(1024, 3) * 5;


			# Checks the uploaded file size if its less then $fileSize!
			# Else it continue wit the uploading process!

			if ($file["size"] > $fileSize)
			{
				error("File is too large!");
				$error = true;
			}
			else
			{


				# Adds the variable $customFileName so that it can output the file name even if they set a custom name or not!

				$customFileName = "";


				# Checks if the user set a upload name and if its empty!
				# If its set and not empty it will change the uploaded name to name that the user wants!
				# Else it will use the uploaded files name!

				if(isset($_POST["uploadname"]) && $_POST["uploadname"] != "")
				{


					# Checks if the file exists or not!
					# If it exists, send an error!
					# If it doesn't exist then move the file temporarily to the folder the user is in
					# and name the file as the user specified

					if(file_exists($folderPath . "/" . $_POST["uploadname"]))
					{
						error("File already exists!!!");
						$error = true;
					}
					else
					{
						move_uploaded_file($file["tmp_name"], $folderPath . "/" . $_POST["uploadname"]);
						$customFileName = $_POST["uploadname"];
					}
				}
				else
				{


					# Checks if the file exists or not!
					# If it exists, send an error!
					# If it doesn't exist then move the file temporarily to the folder the user in
					# and name the file as the user specified
					if (file_exists($folderPath . "/" . $file["name"]))
					{
						error("File already exists!!!");
						$error = true;
					}
					else
					{
						move_uploaded_file($file["tmp_name"], $folderPath . "/" . $file["name"]);
						$customFileName = $file["name"];
					}
				}


				# Checks if there are no errors!
				# If there is an error then just don't do anything because there should already be an error popping up!
				# If there is no error then output a success alert with some information about the file (currently only the name and the file size)!

				if(!$error)
				{
					echo '<div class="alert alert-success"> SUCCESS!!! <br>';
					echo "File uploaded! <br>";
					echo 'Name: ' . $customFileName . "<br>";
					echo 'Size: ' . $file["size"];
					echo "</div>";
				}
			}
		}
	}


	# The start of the rename process!
	#
	# Checks if the renameFile and renameName key is in the global variable $_POST

	if (isset($_POST["renameFile"]) && isset($_POST["renameName"]))
	{


		# Sets some variables to replace the use of $_POST

		$file = $_POST["renameFile"];
		$fileName = $_POST["renameName"];


		# Sets the error variable so I can cancel the process more easily!

		$error = false;


		# Checks if the file $fileName exists!
		# If it does exist then send an error and set $error to true!
		# if it doesn't exist then continue with the process!

		if(file_exists($folderPath . "/" . $fileName))
		{
			error($fileName . " already exists!!!");
			$error = true;
		}


		# Checks if $file doesn't exist!
		# If it does exist then just continue with the process!
		# If it doesn't exist then send an error and set $error to true!

		if(!file_exists($folderPath . "/" . $file))
		{
			error($file . " does not exist!!!");
			$error = true;
		}


		# Checks if there were any errors!
		# If there were no errors, then rename the file and send a success alert!
		# If there were errors then don't do anything, because there should already be errors popping up!

		if(!$error)
		{
			rename($folderPath . "/" . $file, $folderPath . "/" . $fileName);

			echo '<div class="alert alert-success"> SUCCESS!!! <br>';
			echo "Renamed file " . $file . " to " . $fileName . "!";
			echo '</div>';
		}
	}


	# The start of the file creation process!
	#
	# Checks if the createFile key is in the global variable $_POST

	if (isset($_POST["createFile"]))
	{


		# Sets a variable for the createFile key, to make it easier for us!

		$file = $_POST["createFile"];


		# Checks if the file you want to create already exists!
		# If it exists then send an error!
		# if not then continue with the creation process!

		if(file_exists($folderPath . "/" . $file))
		{
			error("File already exists!!!");
		}


		# If there were no errors above, then, open a file handler (if the file doesn't exist it will automatically create a file)
		# when the handler is open, close it to save the file and send a success alert!

		else
		{
			$createHandle = fopen($folderPath . "/" . $file, "w");
			fclose($createHandle);

			echo '<div class="alert alert-success"> SUCCESS!!! <br>';
			echo "Created file " . $file . "!";
			echo '</div>';
		}
	} 



	# The start of file removal process!
	#
	# Checks if the key deleteFile is in the global variable $_POST

	if (isset($_POST["deleteFile"]))
	{


		# Sets a variable to make it easier to work with

		$file = $_POST["deleteFile"];


		# Checks if the file doesn't exist!
		# If it doesn't exist then send an error!
		# If it does exist then unlink the file (unlink will make the system forget about the file, aka delete it)!

		if(!file_exists($folderPath . "/" . $file))
		{
			error("File does not exist!!!");
		}
		else
		{
			unlink($folderPath . "/" . $file);
		}
	}


	# The start of the file writing procedure
	#
	# Checks if the key textarea in the global variable $_POST is set!
	# If it is, then open a file handler, write to the file and then close it to save the file!

	if(isset($_POST["textarea"]))
	{
		$fileWrite = fopen($folderPath, 'w');

		fwrite($fileWrite, $_POST["textarea"]);

		fclose($fileWrite);
	}


	# Checks if the path you're in is a file or a dir!

	if (is_dir($folderPath))
	{
		$currentPathIsDir = true;
	}


	# If the current path is a dir then start the process of showing the directory process!

	if($currentPathIsDir)
	{


		# Adds a few array variables that need to be used later!

		$fileResult = array();
		$folderResult = array();
		$newFileResult = array();
		$newFolderResult = array();


		# Opens a directory handler so I can read every file/directory in a directory!

		$handler = opendir($folderPath);


		# Runs a while loop to read every line of the directory handler!

		while($file = readdir($handler)) 
		{


			# Checks if the file/dir the handler currently looking at is . (current dir) or .. (the parent directory)!

			if ($file != "." && $file != "..")
			{


				# Checks if $file is a directory or a file!
				# If it's a folder, then add a {folder} tag to the $file variable and then add it to the $folderResult array!
				# If it's a file, then add a {file} tag to the $file variable and then add it to the $fileResult array!

				if (is_dir($folderPath . "/" . $file))
				{
					$folderResult[] = "{folder}" . $file;
				}
				else
				{
					$fileResult[] = "{file}" . $file;
				}
			}
		}


		# Closes the directory handler (no need to use it again)!

		closedir($handler);


		# Runs a foreach loop through every $folderResult key to replace {folder} with nothing!
		# The commented stuff was used in an earlier version and I might add it again in the future, for now they will stay where they are!

		foreach ($folderResult as $key => $value)
		{
			//$value = str_replace('{blue}', '', $value);
			$value = str_replace('{folder}', '', $value);

			//$newValue = str_replace('{blue}', '<span style="color:#2B2BFF">', $value) . "</span>";
			$newFolderResult[$value] = str_replace('{folder}', '', $value);
		}


		# Same as above except folder is replaced with file!

		foreach ($fileResult as $key => $value)
		{
			//$value = str_replace('{yellow}', '', $value);
			$value = str_replace('{file}', '', $value);

			//$newValue = str_replace('{yellow}', '<span style="color:#D9D900">', $value) . "</span>";
			$newFileResult[$value] = str_replace('{file}', '', $value);
		}
	}


	# If the path is currently a file then add a file handler to $fileContext so the code can read the file
	# and then add some extension that can't be read in a raw format (images, zip files etc.)!

	else
	{
		$fileContext = file($folderPath);

		$imageExtension = array("png", "jpg", "jpeg", "ico",
								"gif", "bmp", "tiff", "svg"
								);

		$downloadExtension = array("zip", "jar", "rar", "pdf",
								   "avi", "ai"
								   );
	}

?>

<html>
	<head>


		<!-- Just some css stuff -->

		<style type="text/css">
			body
			{
				background-color:grey;
				color:white;
			}
		</style>
		<?php include("lib/css.php"); ?>
	</head>
	<body>
		<?php


			# Checks if the current path is a dir!
			# If it is then start the process of showing the dir UI!

			if($currentPathIsDir)
			{
				?>
				<div class="row">
					<div class="col-md-6">
						<?php


						# Checks if you are in the top directory or not, if you are then add a .. link so you can get back to the previous folder!

						if (isset($_GET['file']) && $_GET['file'] != "")
						{
							echo '<img src="img/directory_icon.png" width="24" height="24"> <a href="?file=' . substr($filePath, 0, strrpos($filePath, "/")) . '">..</a><br>';
						}


						# foreach loops on $newFolderResult and $newFileResult and output it in a nice UI view!

						foreach ($newFolderResult as $key => $value)
						{
							echo '<img src="img/directory_icon.png" width="24" height="24"> <a href="?file=' . $filePath . "/" . $key . '">'  . $value . '</a><br>';
						}

						foreach ($newFileResult as $key => $value)
						{
							echo '<img src="img/file_icon.png" width="24" height="24"> <a href="?file=' . $filePath . "/" . $key . '">'  . $value . '</a><br>';
						}
						
						?>
					</div>
					<div class="col-md-6">


						<!-- The form for uploading a file!-->

						<form action="" method="post" enctype="multipart/form-data">
							File: <input type="file" name="uploadfield">
							Name: <input type="text" name="uploadname"><br>
							<input type="submit" value="Upload File">
						</form>

						<br>
						<br>


						<!-- The form for renaming a file! -->

						<form action="" method="post" name="rename">
							File/folder: <select name="renameFile">
								<?php


									# Performs a foreach loop on $newFolderResult and $newFileResult to make it easier to pick the file/dir you want to rename!

									foreach ($newFolderResult as $key => $value)
									{
										echo '<option value="' . $value . '">' . $value . "</option>";
									}
									foreach ($newFileResult as $key => $value)
									{
										echo '<option value="' . $value . '">' . $value . "</option>";
									}
								?>
							</select> <br>
							Name: <input type="text" name="renameName"> <br>
							<input type="submit" value="rename">
						</form>

						<br>
						<br>


						<!-- The form for deleting a file! -->

						<form action="" method="post" name="delete">
							File/folder: <select name="deleteFile">
								<?php


									# Performs a foreach loop on $newFolderResult and $newFileResult to make it easier to pick the file/dir you want to delete!

									foreach ($newFolderResult as $key => $value)
									{
										echo '<option value="' . $value . '">' . $value . "</option>";
									}
									foreach ($newFileResult as $key => $value)
									{
										echo '<option value="' . $value . '">' . $value . "</option>";
									}
								?>
							</select><br>
							<input type="submit" value="delete">
						</form>

						<br>
						<br>


						<!-- The form for creating a file! -->

						<form action="" method="post" name="create">
							File name: <input type="text" name="createFile"> <br>
							<input type="submit" value="create">
						</form>

					</div>
				</div>
			<?php
			}


			# If the current path is a file then start the process of showing the file UI!

			else
			{


				# Checks if the file extension is in the $imageExtension array!
				# If the file is in the array then output it as an image using the html img tag!
				# If the file is not in an array then start the editing a file UI!

				if(in_array(pathinfo($folderPath)["extension"], $imageExtension))
				{
					echo '<img src="' . $filePath . '">';
				}
				else
				{
					?>


					<!-- Setup a textarea form and prints every line from the current file -->

					<form name="text" action="" method="post">
						<textarea name="textarea" rows="50" cols="200">
<?php

								foreach($fileContext as $key => $value)
								{
									echo ($value);
								}
							?>
</textarea>
						<br>
						<input type="submit" value="Submit">
					</form>
				<?php
				}
			}
		?>


		<!-- Adds the js libs -->

		<?php include("lib/js.php"); ?>
	</body>
</html>