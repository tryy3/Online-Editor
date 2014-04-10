#Simple Online Editor
##Installation
Currently its a bit overcomplicated to install it but this is how to install it:

1) Download/Fork the project
2) Open ftp.php with your favorite editor
3) Search for $folderPath (should be around line 94-102)
4) Change both of the $folderPath, the first instance should be $folderPath = "Path/To/Your/Directory" . $filePath;
   and second instance should just be $folderPath = "Path/To/Your/Directory"!
5) Optional: You can edit the file limit on uploading files by changing the line $fileSize (should be around line 135 and look like $fileSize = pow(1024, 3) * 5;) by default its set to 5gb, note that the fileSize is in byte!
6) Optional: edit css.php and js.php (or if you want to, you can edit ftp.php to change the UI)

##Files & Folders
By default js.php and css.php contains the default bootstrap theme's, you can change this to whatever you want and if you really want you can change the UI inside ftp.php
The directory img, contains some default images (currently only the image for directories and the default files)!
