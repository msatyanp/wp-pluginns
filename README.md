# Newari WordPress Theme and Plugins

This workspace contains a complete WordPress setup for a Newari heritage website, including a custom theme and a companion plugin.

## Included Projects

### Newar Heritage Theme
A custom child theme built on Twenty Twenty-Four for a heritage-focused community website.

Features:
- Heritage-inspired visual design with warm earthy colors and traditional decorative motifs
- Custom homepage and page templates
- Support for reusable blocks and section-based content
- Styling for the member directory shortcode from the plugin

### Newar Members Plugin
A custom WordPress plugin for managing community members, roles, tiers, and yearly organizer records.

Features:
- Custom member post type
- Taxonomy-based member tiers and roles
- Native meta boxes for member profile details
- Shortcode-based member directory display
- Organizer tracking for yearly hosting rotation
- Single-member detail template
- WP-CLI support for setup and maintenance tasks

## Requirements
- WordPress 6.4 or newer
- PHP 8.0 or newer
- The Newar Heritage theme requires the parent theme Twenty Twenty-Four to be installed

## Installation
1. Place the theme folder in your WordPress installation under wp-content/themes/
2. Place the plugin folder in wp-content/plugins/
3. Activate the Newar Heritage theme from Appearance → Themes
4. Activate the Newar Members plugin from Plugins
5. Create or configure pages that use the member shortcode as needed

## Quick Start
- Use the Newar Heritage theme for the site design and front-end layout
- Use the Newar Members plugin to manage members and display them on the site
- Add the shortcode [newar_members] to a page to show the member directory

## Suggested Structure
- newar-heritage/ — theme files
- newar-members/ — plugin files

## Notes
The theme and plugin are designed to work together, with the theme providing the presentation layer and the plugin providing the member management system.
