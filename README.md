PipTheme by Pipfrosch Press
===========================

Work in progress. I do not *yet* recommend use in production.

I do JS and CSS files differently than what is customary in WordPress themes
and Plugins. See the file `STATIC_RESOURCE.md` for details.

In addition to the contents of that file, within this theme (with one
exception) I prefer not to minidy JS and CSS files. The reason is that when
there is a bug, it is easier to identify the bug if the JS or CSS file is not
minified. With proper caching, lack of minified file would only be a possible
performance hit when the file is not already cached, and I suspect that brotli
compression greatly reduces that impact.

About PipTheme
--------------

This is a fork of the Simome WordPress theme intended to meet the needs of
Pipfrosch Press.

Specifically it enhances privacy by removing third party resources the Simone
theme referenced (such as Google Fonts) and by disabling some of the third
party references that WordPress adds by default.

Note that this does not guarantee no trackers, for example a plugin in use
might add a third party resource that tracks or Gravatar if enabled in your
WordPress site will add a third party resource.

Some CSS and other tweeks have also been made, see the CHANGELOG.md file.


Important WebFont Notes
-----------------------

In the `fonts/` directory is a `.htacess` file that at least in the Apache web
server with the correct Apache modules installed (`mod_mime` and `mod_expires`
which are both standard modules) will ensure that the webfonts are served with
the correct MIME type (`font/woff2`) and makes sure that the proper expires
header is sent with the fonts to allow the browser to cache them for one month.

If your server is not Apache or if you disable `.htaccess` files within
the web root, make sure your server is otherwise configured to send the correct
MIME type for WOFF2 web fonts and that browsers know they can cache the web
fonts for a long period of time. The cache time for the CSS is less critical,
but since the `webfonts.min.css` file has a timestamp as part of the file name,
browsers can be told to cache that file for much longer than they cache other
CSS files as the filename will change if it is ever updated.

Only WOFF2 versions of webfonts are included. With the exception of Opera Mini
and IE 11, WOFF2 is supported by the most recent versions of every browser. For
Opera Mini and IE 11 users, the system fonts should be sufficient.

See https://caniuse.com/#search=woff2

IE 11 could be supported by adding WOFF versions but it is not worth it. Opera
Mini simply does not support webfonts at all.

IE 11 is no longer maintained and has not been for years, so it is not worth
supporting. As of April 30 2020 it is reported to still have 1.75% of the
global market share but that will only continue to drop. My *suspicion* is that
a large percentage of that 1.75% is with low income users who do not have
fast Internet, it may be better for them to use system fonts anyway to reduce
their bandwidth needs.

### FontAwesome Exception

The WOFF variant for FontAwesome is included for the benefit of IE11 users as
it uses private unicode range so system fonts can not be substituted for it.

### CDN Note

When serving webfonts from a CDN, the CDN has to be properly set up to send the
right headers or the browser will not use them because the domain they come
from differs from the domain the page is served from. If you plan to serve the
webfonts from a CDN, keep that in mind.

While you could just use Google Fonts, Google tracks users so I do not
recommend it. If you do not wish to serve the fonts from your host, make sure
that the CDN you use specifies they do not use cookies or otherwise track
users.


INSTALL
-------

clone the repository and copy it into the `wp-content/themes` directory of your
WordPress install. Then you can activate it from within your admin panel.

Please note presently there are some inconsistencies between the CSS as sent
to browsers and the admin CSS, this is a work in progress.
