# Newar Members Plugin

Newar Members is a custom WordPress plugin for managing community members, member roles, member tiers, and yearly organizer records. It is designed to work smoothly with the Newar Heritage theme and to avoid heavy dependencies.

## What It Does
- Registers a custom member post type
- Uses native WordPress taxonomies for tier and role management
- Provides a shortcode-based member directory
- Supports organizer tracking for yearly hosting rotation
- Includes a single-member detail template and basic admin organization tools

## Key Features
- Member tiers such as General Member, Committee, and Leadership
- Role-based classification that can be managed from the WordPress admin area
- Native meta boxes for member profile information
- Responsive member cards for front-end display
- Optional Google Maps link support for member addresses
- WP-CLI commands for setup and cleanup tasks

## Quick Start
1. Place the plugin folder in wp-content/plugins/.
2. Activate the plugin from Plugins → Installed Plugins.
3. Add members from Members → Add New.
4. Insert the shortcode [newar_members] on any page to display the directory.

## Shortcode Usage
```text
[newar_members]
[newar_members tier="committee"]
```

## WP-CLI Commands
- wp newar setup_pages — create starter pages and navigation for the member directory
- wp newar migrate-names — migrate legacy name fields to the new structure
- wp newar reset-all-members — remove all member posts after confirmation

## Notes
The plugin is intentionally built around native WordPress features so it can be maintained without requiring extra field plugins.
