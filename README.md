# Composer local dependencies resolver

This plugin allows registration of your local directories and injects them
into your projects as composer repositories. This allows installing your
dependencies as symlinks in your local projects, making work over your
projects and dependencies at the same time a lot easier.

You can also test your dependencies without the need to git push and composer
update every time to see if the changes are working correctly in
the real project.

## Installation

You can install a plugin as a global composer dependency.

**Remember to allow the plugin to be used!**

```Bash
composer global require othersoftware/composer-resolver-plugin
```

## Usage

This plugin provides extra composer commands to the CLI, which allows you to
manage your local directories.

### Adding a new repository

Go to your dependency project directory in the terminal and run:

```Bash
composer add-repository
```

Remember that the directory must contain a valid composer.json file.

### Resolving dependencies

Once you have registered your local dependency projects with the plugin, you can
simply run ```composer update``` within your project, and the plugin will
automatically prepend your registered directories as a `path` repositories
in your local environment.

As these repositories are prepended to the list, they have higher priority than
repositories defined in your project's composer.json file, meaning you can
leave a remote git repository entry in the file, for production use. 
