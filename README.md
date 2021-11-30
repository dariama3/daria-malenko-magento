## Project Deployment

After running the command `composer install` revert the following files:

```bash
# ./pub/.htaccess - checkout due to websites mapping and custom rewrite rules
git checkout ./pub/.htaccess .gitignore
```

## Local development

Create a symlink to the proper `app/etc/env.*.php` file. It is preferable to use `app/etc/env.dev.php` as the configuration source. Use this with the appropriate `docker-compose*.yaml` file.
