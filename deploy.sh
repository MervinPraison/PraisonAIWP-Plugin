#!/bin/bash
#
# Deploy script for WordPress.org SVN
# Usage: ./deploy.sh "Commit message"
#

set -e

PLUGIN_SLUG="praisonai"
SVN_URL="https://plugins.svn.wordpress.org/${PLUGIN_SLUG}/"
SVN_DIR="${HOME}/svn-${PLUGIN_SLUG}"
PLUGIN_DIR="$(cd "$(dirname "$0")" && pwd)"

# Files/folders to exclude from deployment
EXCLUDE=(
    ".git"
    ".gitignore"
    ".vscode"
    ".DS_Store"
    "deploy.sh"
    "README.md"
    "WORDPRESS_PLUGIN_DEVELOPMENT_GUIDE.md"
    "build.md"
    "assets"
    "*.sh"
)

# Get commit message
COMMIT_MSG="${1:-Update plugin}"

echo "🚀 Deploying ${PLUGIN_SLUG} to WordPress.org..."

# Checkout SVN if not exists
if [ ! -d "$SVN_DIR" ]; then
    echo "📥 Checking out SVN repository..."
    svn checkout "$SVN_URL" "$SVN_DIR" --trust-server-cert --non-interactive
else
    echo "🔄 Updating SVN repository..."
    svn update "$SVN_DIR"
fi

# Clear trunk
echo "🧹 Clearing trunk..."
rm -rf "${SVN_DIR}/trunk/"*

# Copy files to trunk (excluding items in EXCLUDE)
echo "📦 Copying files to trunk..."
EXCLUDE_ARGS=""
for item in "${EXCLUDE[@]}"; do
    EXCLUDE_ARGS="$EXCLUDE_ARGS --exclude=$item"
done

rsync -av $EXCLUDE_ARGS "${PLUGIN_DIR}/" "${SVN_DIR}/trunk/"

# Copy assets to svn assets folder
if [ -d "${PLUGIN_DIR}/assets" ]; then
    echo "🎨 Copying assets..."
    cp -r "${PLUGIN_DIR}/assets/"* "${SVN_DIR}/assets/" 2>/dev/null || true
fi

# Add new files and remove deleted
echo "📝 Staging changes..."
cd "$SVN_DIR"
svn add --force trunk/* 2>/dev/null || true
svn add --force assets/* 2>/dev/null || true

# Remove deleted files
svn status | grep '^!' | awk '{print $2}' | xargs -I {} svn rm {} 2>/dev/null || true

# Show status
echo "📋 Changes to commit:"
svn status

# Commit
echo ""
read -p "Commit these changes? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    svn commit -m "$COMMIT_MSG"
    echo "✅ Deployed successfully!"
else
    echo "❌ Deployment cancelled"
fi
