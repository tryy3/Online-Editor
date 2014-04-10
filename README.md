#Simple Online Editor
##Installation
Currently it's a bit complicated to install, but this is how to install it:

1. Download/Fork the project
2. Open ftp.php with your favourite editor
3. Search for $folderPath (should be around line 94-102)
4. Change both of the $folderPath variables, the first should be $folderPath = "Path/To/Your/Directory" . $filePath; and second should just be $folderPath = "Path/To/Your/Directory"
5. Optional: You can edit the file size limit on uploaded files by changing the $fileSize variable (which should be around line 135 and should look similar to $fileSize = pow(1024, 3) * 5 - by default it's set to 5gb, note that the fileSize is in bytes!
6. Optional: edit css.php and js.php (or if you prefer, you can edit ftp.php to change the UI)

##Files & Folders
By default js.php and css.php contain the default bootstrap theme, you can change this to whatever you want and if you really want you can change the UI in ftp.php.

The directory /img/ contains some default images (currently only the image for directories and the default files).

