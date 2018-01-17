#!/usr/bin/env bash

echo "running frontend build for twentyseventeen"
(cd docroot/themes/custom/twentyseventeen;npm run build)

echo "running frontend build for twentyeighteen"
(cd docroot/themes/custom/twentyeighteen;npm run build)
