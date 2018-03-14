Steps to perform workbench moderation to content moderation update.

The order that these steps are performed is very important. The update will have
three separate phases.

PHASE 1:
Preliminary setup.

Step 1.
- Put the site into maintenance mode. We don't want any new content created or
  existing content to be updated at this time.
- Make a backup of the db. We will be touching all moderatable entities with
  this migration. 

Step 2.
This must be performed before any of the code is deployed.
Perform the following drush commands on the environment.

drush en -y content_moderation
drush cr

Verify that both these steps completed without issue before moving on.

Step 3.
Deploy the code. This will include:
 - custom module wbm_to_cm
 - Update to ess
 - update to page_wrapper_companion
 - various config files to enable workflow states and update views
 
Step 4.
For verification purposes run the following drush commands.

drush en -y wbm_to_cm (This should return that it is already enabled.)
drush cr (This should run clean with no errors.)

PHASE 2.
This phase will consist of drush commands to migrate the workbench moderation
data to content moderation. This step utilizes a script to automate the process. 
If the script is running correctly you will see visual feedback during the
entire process.

Step 1.
Run the wbm_to_cm_step_1.sh script: 
./docroot/modules/custom/wbm_to_cm/wbm_to_cm_step_1.sh

You should see 'migration complete...' when this step is finished. There should
be no errors that occur at this point. If an error is observed you can attempt
to re-run that portion of the migration using the individual drush command.
Do not move on to the next phase until this phase runs cleanly.

Phase 3.
This phase will remove the old moderation state data which will allow 
workbench moderation to be uninstalled. Because workbench moderation is a pain
in the ass you can expect to see errors during the uninstallation of workbench
moderation and workbench access. For this reason the command is called several
times in the script to uninstall it.

Step 1. 
Run the wbm_to_cm_step_2.sh script: 
./docroot/modules/custom/wbm_to_cm/wbm_to_cm_step_2.sh

You should see 'Update completed...' when this script is finished. For good
measure you can run:
drush pm-uninstall -y workbench_moderation
drush pm-uninstall -y workbench_access

For both of these you should see a message stating they are already uninstalled.
The wbm_to_cm module will also uninstall itself at this time as well.

Phase 4.
Post operations.

Step 1.
Login to the environment and create a dummy access request. You will get a error,
refresh and it will go through. The first time a entity is created content
moderation will attempt to set the primary key for that entity to one in the db.
This primary key will already be in use from the entities that were migrated,
this step will allow content moderation to find the correct key to create entities
from this point forward. You can now delete this request.

Step 2. 
Repeat step 1 except create a piece of content. This can be deleted as well
afterwards.

Step 3.
Take the site out of maintenance mode.