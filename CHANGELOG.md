CHANGELOG
=========

Changes made from the Simone Theme, version 2.1.1

Sunday May 10, 2020 Michael A. Peters
-------------------------------------

* Updated FontAwesome to 4.7.0, do not use minified CSS with it
* Serve the Lato font locally rather than via Google Fonts
* Added Intel Clear Sans (served locally) to replace PT Serif
* Removed references to Google Plus as it is dead
* Rebrand from Simone to PipTheme
* nuke gmpg.org and pingback <link/> tags from header.php
* disable emojis (via https://kinsta.com/knowledgebase/disable-emojis-wordpress/#disable-emojis-code)
* fix css for abbr tag
* update superfish.js to 1.7.10, do not use minified
* update enquire.js to 2.1.6, do not use minified
* remove more of the <link> crap wordpress adds by default

Monday May 11, 2020 Michael A. Peters
-------------------------------------

* Changed header color for WCAG AAA contrast, changed site description font-weight to bold
* tweaked CSS header for mobile
* only use CSS3 colors (well, still have some hex codes)
* don't alter hyperlink colors, let browser do that
* don't make site title in the header a home link
* fix the Skip to content link so that it is visible rather than screen-reader only

Tuesday May 12, 2020 Michael A. Peters
--------------------------------------

* Unify webfont CSS into single file

Wednesday May 13, 2020 Michael A. Peters
----------------------------------------

* Add .htaccess file to fonts/ directory to serve webfonts with proper mime type and set cache header font fonts and css
* Add WOFF variant for FontAwesome
