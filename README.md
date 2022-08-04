# robusta magerun CLI tools for Magento 2

<img src="robusta.png" alt="robusta" width="200"/>

--- 

The robusta magerun cli tools provides some handy tools to work with Magento
from command line.

> This project is just a wrapper for [netz98 magerun](https://github.com/netz98/n98-magerun2/tree/5.1.0) tool to override module creation with a robusta flavored template for our own projects.

## Installation

It's best recommended to install this tool globally to use it in all of your projects since it has the ability to detect the magento instance.

### Install with Composer

1. Add the magento group to your list of composer repositories as a private package registry
   ``` sh
   composer global config repositories.4532970 composer https://gitlab.com/api/v4/group/4532970/-/packages/composer/
   ```

2. Install the package globally using
   ``` sh
   composer global require robusta/magerun2
   ```

3. Now you can go to any magento instance and start typing `robusta-magerun2`

## Usage / Commands

> **NOTE** There are more commands available as documented here. Please refer to the [main repository](https://github.com/netz98/n98-magerun2/tree/5.1.0#usage--commands) if you want.

All commands try to detect the current Magento root directory. If you
have multiple Magento installations you must change your working
directory to the preferred installation.

### Create Module Skeleton

Creates an empty module and registers it in current Magento shop.
> This is the main command that this tool customizes.

The command is simply `module:create` and accepts your module name

``` sh
robusta-magerun2 module:create YourModuleName [--description [DESCRIPTION]] [-h|--help] [-q|--quiet] [-v|vv|vvv|--verbose] [-V|--version] [--ansi] [--no-ansi] [-n|--no-interaction] [--root-dir [ROOT-DIR]] [--skip-config] [--skip-root-check] [--skip-core-commands [SKIP-CORE-COMMANDS]] [--skip-magento-compatibility-check] [--]
```

The following template structure is generated under your instance's `app/code`

``` sh
├── CHANGELOG.md
├── composer.json
├── etc
│   └── module.xml
├── .gitlab
│   ├── issue_templates
│   │   ├── Bug.md
│   │   └── Feature Proposal.md
│   └── merge_request_templates
│       └── default.md
├── .gitlab-ci.yml
├── README.md
├── registration.php
└── sonar-project.properties

4 directories, 10 files
```