# DPUsers
This is the official DPUsers Github repository. DPUsers is a tiny Joomla user list extension which provides front end lists with comprehensive filtering for user groups.

## PREREQUISITS
- Joomla 4.4
- mysql >= 8.0.0
- PHP >= 8.1.0

## INSTALLATION
Download the file from [here](https://joomla.digital-peak.com/download/dpusers) and install the zip file through the Joomla extension manager. After the installation make sure the plugins are enabled.


## UPGRADE
To upgrade DPUsers from an older version just install the downloaded zip file through the Joomla extension manager or by web update.

## DOCUMENTATION
Check [joomla.digital-peak.com](https://joomla.digital-peak.com/documentation/dpusers) for more documentation.

## Development corner
If you are cloning this repository, then clone also the [DPDocker project](https://github.com/Digital-Peak/DPDocker) into the same folder as DPUsers and build the images. There are several tasks you can run then:

### Install PHP dependencies
Installs the PHP dependencies.

`DPDocker/composer/run-install.sh DPUsers`

### Install JS dependencies
Installs the Javascript dependencies.

`DPDocker/npm/run-install.sh DPUsers`

### Build assets
Builds the assets.

`DPDocker/npm/run-build.sh DPUsers all`

### Build packages
Creates the installable packages.

`DPDocker/build/run.sh DPUsers`

### Build a release
Creates the installable packages with version 4.0.0. Change the version string when you want to build a different release version.

`DPDocker/build/run.sh DPUsers 4.0.0`

### Fix code style
If you made some changes and want to contribute them back as a pr, please fix any code style issues.

`DPDocker/code/run-fix.sh DPUsers`

### Run system tests
Runs the system tests.

`DPDocker/tests/run-system-tests.sh -e DPUsers`

### Start a web server
Start a web server with DPUsers installed.

`DPDocker/webserver/run.sh`

## Notes
License GPL v3

Have fun
The Digital Peak team
