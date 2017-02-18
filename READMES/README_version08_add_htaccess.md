
## version 8 - simplify URLs with .htaccess

1. add a `.htaccess` file inside directory `/public` containing:

        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule (.+) index.php [QSA,L]
        </IfModule>

1. now simplfy the URL link to the list route in `/templates/index.html.twig` (we can remove the `index.php/`:

        <ul>
            <li>
                <a href="/list">list all great books</a>
            </li>
        </ul>
