# phpSANE
Fork of phpSANE 0.8.0 to fix bugs caused by it not being updated on sourceforge.

Made it work for my Brother MFC-235C

## Fixes and changes

* Missing directories (output, scanners, tmp), incorrect permissions prevented phpSane to create a scanner ini for the scanner.

* The Mode selection list was not filled as phpSane expects the special mode names Gray, Color and Lineart. I hard coded the mode_list and changed security.php to allow spaces, [, ] and &

* The pnm output of the scanimage command for the brother is corrupted. I added a pipe into pamfixtrunc in the cmd used to generate files or preview (scan.php)

* changed config.php to meet the scanners featutres. I.e. the lowest res supported is 100 and not 75.

* although scanimage says the scanner supports brightness and contrast, I did not fix these parts.

## brother-mfc-235c-usb-scanner.ini

	mode:Black & White;Gray [Error Diffusion];True Gray;24bit Color|True Gray
	resolution:100;150;200;300;400;600;1200;2400;4800;9600|200|
	brightness:false|-50|0|50
	contrast:false|-50|0|50
