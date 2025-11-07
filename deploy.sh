#!/bin/bash

# PHP Authentication System Deployment Script
# This script helps deploy your application to various cloud platforms

echo "🚀 PHP Authentication System Deployment Script"
echo "=============================================="
echo ""

# Function to deploy to Heroku
deploy_heroku() {
    echo "📦 Deploying to Heroku..."
    
    # Check if Heroku CLI is installed
    if ! command -v heroku &> /dev/null; then
        echo "❌ Heroku CLI not found. Please install it first:"
        echo "   https://devcenter.heroku.com/articles/heroku-cli"
        exit 1
    fi
    
    # Login to Heroku
    echo "🔑 Logging in to Heroku..."
    heroku login
    
    # Create new app or use existing
    read -p "Enter app name (leave empty for auto-generated): " app_name
    if [ -z "$app_name" ]; then
        heroku create
    else
        heroku create $app_name
    fi
    
    # Add MySQL database
    echo "🗄️ Adding MySQL database..."
    heroku addons:create cleardb:ignite
    
    # Get database credentials
    echo "📋 Getting database credentials..."
    db_url=$(heroku config:get CLEARDB_DATABASE_URL)
    echo "Database URL: $db_url"
    
    # Set environment variables
    echo "⚙️ Setting environment variables..."
    read -p "Enter database host: " db_host
    read -p "Enter database username: " db_user
    read -p "Enter database password: " db_pass
    read -p "Enter database name: " db_name
    
    heroku config:set DB_HOST=$db_host
    heroku config:set DB_USER=$db_user
    heroku config:set DB_PASS=$db_pass
    heroku config:set DB_NAME=$db_name
    
    # Deploy
    echo "🚀 Deploying to Heroku..."
    git push heroku main
    
    echo "✅ Deployment to Heroku completed!"
    heroku open
}

# Function to deploy to Vercel
deploy_vercel() {
    echo "📦 Deploying to Vercel..."
    
    # Check if Vercel CLI is installed
    if ! command -v vercel &> /dev/null; then
        echo "❌ Vercel CLI not found. Please install it first:"
        echo "   npm i -g vercel"
        exit 1
    fi
    
    # Login to Vercel
    echo "🔑 Logging in to Vercel..."
    vercel login
    
    # Deploy
    echo "🚀 Deploying to Vercel..."
    vercel --prod
    
    # Set environment variables
    echo "⚙️ Setting environment variables..."
    read -p "Enter database host: " db_host
    read -p "Enter database username: " db_user
    read -p "Enter database password: " db_pass
    read -p "Enter database name: " db_name
    
    vercel env add DB_HOST production <<< "$db_host"
    vercel env add DB_USER production <<< "$db_user"
    vercel env add DB_PASS production <<< "$db_pass"
    vercel env add DB_NAME production <<< "$db_name"
    
    echo "✅ Deployment to Vercel completed!"
}

# Main menu
echo "Choose deployment platform:"
echo "1. Heroku (Recommended)"
echo "2. Vercel"
echo "3. Exit"
echo ""

read -p "Enter your choice (1-3): " choice

case $choice in
    1)
        deploy_heroku
        ;;
    2)
        deploy_vercel
        ;;
    3)
        echo "👋 Exiting..."
        exit 0
        ;;
    *)
        echo "❌ Invalid choice. Please run the script again."
        exit 1
        ;;
esac