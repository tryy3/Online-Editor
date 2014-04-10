#Simple Online Editor
##Installation
1. Download/Fork the project
2. Open the Config Directory
3. Open the general.ini file
4. Change the Path setting to where you want the editor to read from!

##Files & Folders
By default js.php and css.php contain the default bootstrap theme, you can change this to whatever you want and if you really want you can change the UI in ftp.php.

The directory /img/ contains some default images (currently only the image for directories and the default files).

##Configuration
* General.ini
  * SizeFile = The maximum size of a file being uploaded!
  * Path = The path that the editor is gonna read from

* Extension.ini
  * img[] = The extensions that the editor is gonna assume is images!
  * dl[] = The extensions that the editor can't open raw and have to make the user download the file instead (zip, jar, rar etc.)

