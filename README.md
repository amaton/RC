# RC
There you can find 2 magento modules (ready for paste in any fresh magento installation) regarding RaceChip_BE_Coding_Challenge.pdf :

1) Extcms module which implements Coding Challenge 1 - you can find additional field-set in "Page Information" tab with "Category" field and grouped list on http://your.domain/extpages ;
TIme: ~3 hours;

2) ExtSales module which implements Coding Challenge 2 -  you can find additional configuration tab in system/config which called "PDF Attachments" (you need re-login to enter it) with config fields for attached PDF template (you can choose from any transactional emails including custom ones);
also you can find switcher to default behaviour there; 
Time: ~4.5 hours;

SQL :
No sql export needed, all db changes will be implemented with modules install scripts;

Used libraries:
tcpdf - library for generation pdf attachments from predefined html templates;

Development environment : 
PhpStorm IDE;
Vagrant box with Ubuntu 14.04 LTE, LAMP, magento-ce-1.9.1.1 and postfix for testing purposes;
MacBook Pro (Retina, 15-inch, Late 2013) OS X Yosemite 10.10.4;
