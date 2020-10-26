# Drupal GovCon
Welcome to the repo for the Drupal GovCon event website. This is an open source project and we proudly make all of our source code available (not only to those that want to contribute to the project, but for those that are interested in seeing a working Drupal 9 site!).

## Getting Started

This project built with BLT, an open-source project template and tool that enables building, testing, and deploying Drupal installations following Acquia Professional Services best practices.

* Ensure that your computer meets the minimum installation requirements (and then install the required applications). See the [BLT System Requirements](https://docs.acquia.com/blt/install/) and [Lando System Requirements](https://docs.lando.dev/basics/installation.html).
* Fork the parent repository in GitHub
* Request access to the Drupal4Gov organization in GitHub
* Request access to the Acquia Cloud Environment for Drupal GovCon
* Setup a SSH key that can be used for GitHub and the Acquia Cloud (you CAN use the same key)
    * [Setup GitHub SSH Keys](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)
    * [Setup Acquia Cloud SSH Keys](https://docs.acquia.com/acquia-cloud/ssh/generate)

After creating a fork of the repository in Github 9and installing all dependencies above) there are only 4 commands to get started:

* `git clone` (clone your fork)
* `composer install` (install dependencies for the project)
* `lando start` (provision the vm)
* `lando blt setup` (install Drupal)

## Working with Lando and BLT

Our team utilizes a standard [Git flow](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow) for our development workflow. You can read more about our recommended workflow in the [BLT docs](https://docs.acquia.com/blt/developer/dev-workflow/#workflow-example-local-development).

In general, "all" commands (drush, blt, etc.) should be run "inside" the Lando container. You can do this by first running the `lando` command.

For example:

Cleanly Install Drupal:

`lando blt setup`

Sync Drupal Database from Cloud:*

`lando blt sync`

Log Into Drupal

`lando drush uli`

## Resources

* JIRA - https://drupal4gov.atlassian.net
* GitHub - https://github.com/Drupal4Gov/Drupal-GovCon-2017
