#!/usr/bin/env bash

echo "running frontend setup for twentyseventeen"
(cd docroot/themes/custom/twentyseventeen;npm run install-tools)

echo "running frontend setup for twentyeighteen"
(cd docroot/themes/custom/twentyeighteen;npm run install-tools)

echo "running frontend setup for twentynineteen"
(cd docroot/themes/custom/twentynineteen;npm install)
