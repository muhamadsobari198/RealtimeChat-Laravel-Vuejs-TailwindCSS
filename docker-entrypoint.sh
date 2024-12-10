#!/bin/bash

# Run composer install if vendor directory does not exist
if [ ! -d "/var/www/html/vendor" ]; then
  composer install
fi


# Run npm install if node_modules directory does not exist
if [ ! -d "/var/www/html/node_modules" ]; then
  echo "node_modules directory not found. Running npm install..."
  npm install
fi

# Check if Laravel Mix is configured and start npm run watch
if [ -f "webpack.mix.js" ]; then
  echo "Starting npm run watch..."
  npm run watch &
fi

# Continue with the original Laravel commands
exec "$@"
