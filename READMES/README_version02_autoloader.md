
## version 2 - Composer autoloader
1. add class to composer.json

        "autoload": {
            "psr-4" : {
                "Itb\\": "src"
            }
        },

1. At the CLI make Composer generate its autoloader

        $ composer dump-autoload

1. replace individual class requires with autoload require `/public/index.php`

        require_once __DIR__ . '/../vendor/autoload.php';
