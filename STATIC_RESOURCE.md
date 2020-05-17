Static Resources
================

I do JS and CSS in this theme a little differently than what is typical for
WordPress.

Static resources, such as JavaScript, CSS, and images, should be served in such
a manner that the browser knows that it can cache the resource and for how long
it can assume the resource is still valid before it needs to ask the server if
the resource has changed.

Furthermore, if a Content Distribution Network (CDN) is to be used, it is
imperitive that Subresource Integrity (SRI) be implemented so that the client
can verify the file it receives from the CDN is in fact identical to the file
on your server.

The former can be accomplished in the Apache web server with the `mod_expires`
apache module, a standard module. The latter, well, I may write a WordPress
plugin that does it.

Not all static resources should be cached by the browser for the same amount of
time. In order to facilitate easy machine determination of how long a static
resource should be cached before the browser checks to see if their copy is the
same as what is on the server, I do JavaScript and CSS a little differently
than the standard way that WordPress does it.

Wordpress uses the `wp_enqueue_script` and the `wp_enqueue_style` functions to
add script and style resources to a page that is served. In those functions,
they include a field for version number. When the field is set to `false` which
is the default, then WordPress uses the WordPress version number as the version
number for the file. If set to a string, it uses the string as the version
number for the file.

So example:

    wp_enqueue_style('piptheme_webfonts', get_template_directory_uri() . '/fonts/webfonts.min.css');

That would result in `/[themepath]/fonts/webfonts.min.css?ver=5.4.1` being used
as the URL for loading that CSS file.

In theory that would allow you to set a very long cache time on CSS files and
browsers would know to grab a new copy when the `ver=` string changes but that
system is quite brittle.

First of all, inside a theme or plugin it *should* use the version of the theme
or the plugin rather than the WordPress version, but the WordPress function
does not. It relies upon the developer of the theme or plugin to set a version
and update it.

Secondly, it does not make it easy for development versions of a resource to be
flagged such that they will not be cached by browsers at all.

Within PipTheme, with a few exceptions I may not have yet gotten to, I
__always__ set the version field to `null` so that WordPress does not add any
query string with a version number attached. Versioned CSS and JavaScript then
have a `-YYYYMMDD` appended to the filename right before the extension.

This allows me to set up Apache for WordPress with the following directive:

    <Directory /path/to/wordpress>
      Options FollowSymlinks
      AllowOverride All
      Require all granted
      <IfModule mod_expires.c>
        ExpiresActive On
        <FilesMatch "\.(js|css)">
          ExpiresDefault "access plus 1 days"
        </FilesMatch>
        <FilesMatch "-devel\.(js|css)">
          ExpiresDefault "access"
        </FilesMatch>
        <FilesMatch "-[0-9]{8}\.(js|css)">
          ExpiresDefault "access plus 1 years"
        </FilesMatch>
      </IfModule>
    </Directory>

That tells Apache that by default, any file served with a `.js` or `.css` file
extension will be sent with a header telling the browser it can cache the file
for a day before it needs to check if a newer version exists.

For files that end in `-devel.js` or `-devel.css` that gets overridden and the
browser is told to *always* check for a newer version of the file. That is
useful for when I am hacking on a theme or plugin and testing tweaks.

For files that end in `-YYYYMMDD.js` or `-YYYYMMDD.css` then Apache tells the
browser it does not need to check for a new version for an entire year. That is
what I rename a file to once I am done hacking on it.

The way my CDN plugin will work, it will create a wrapper to the WordPress core
functions so that when a file ends in `-YYYYMMDD.{js|css}` __and__ there is a
database entry with the SHA-384 checksum, it will add the checksum to the
`<link>` or `<script>` tag and reference the resource on the CDN. With a pull
CDN, when the CDN does not already have a copy of the file it will pull it from
the actual server and serve it, and when it does have a copy it just serves it.

In either case, the Resource Integrity attributes are there so that the client
can verify it is getting a version of the file that has not been modified.

When the database does not have a SHA-384 sum for the resource then the CDN
will not be used as it is not secure to do so.

Also, using a timestamp as part of the filename makes it easier to revert to a
previous version of the file in the event that a newer version is causing
issues for some users that did not exist in a previous version.

