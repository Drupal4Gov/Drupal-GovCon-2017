# Display starting data
echo "Node data before migration."
drush wtc-dq node_field_revision node

# Migrate node data
echo "Migrating nodes"
drush wtc-nr message

echo "Migration complete..."
# Display starting data
echo "Node data before migration."
drush wtc-dq node_field_revision node

# Display data after migration
echo "Node data after migration."
drush wtc-dq content_moderation_state_field_revision node
