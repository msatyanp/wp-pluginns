# Newar Members Plugin (v2.0.0) — Clean Architecture

Taxonomy-based rearchitecture of the Newar Members plugin. Tier and Role
are handled as native WordPress taxonomies. All custom fields use native
WordPress meta boxes (no ACF dependency). Includes built-in Organizer
yearly rotation tracking (host_member_1/host_member_2 reference member
posts, year uniqueness validation, and front-end callout display).

## Architecture

```
wp-content/plugins/newar-members/
├── newar-members.php          ← Main entry point, activation hooks, includes loader
└── includes/
    ├── cpt.php                ← "member" post type registration (publicly_queryable)
    ├── taxonomies.php         ← member_tier + member_role taxonomy registration
    ├── meta-boxes.php         ← Native WP meta boxes for member and bhoj_host post types
    │                            (replaces ACF field groups: first_name, last_name, phone,
    │                            address, location, photo, display_order, bio, contact_email
    │                            for members; year, host_member_1/2, notes for bhoj_host)
    ├── options-page.php       ← Theme options page using native WP Settings API
    │                            (hero bg, stats, gallery, contact, socials, samaj branches)
    ├── avatar.php             ← newar_member_avatar() for photo circle + initials fallback
    ├── shortcode.php          ← [newar_members tier="..."] shortcode (card grid)
    ├── admin-list.php         ← Admin list table: columns, taxonomy filters, sort
    ├── bhoj-host.php          ← Bhoj Host CPT, native meta boxes, admin list columns,
    │                            year uniqueness & duplicate-member validation,
    │                            BS year calculation/override, and newar_get_current_bhoj_hosts()
    └── cli.php                ← WP-CLI: setup_pages, migrate-names, reset-all-members
```

## Taxonomy Design

### member_tier (hierarchical, like Categories)
- Hidden from front-end URLs (`publicly_queryable = false`, `rewrite = false`)
- Shows as a metabox on the member edit screen (checkbox style, like Posts → Categories)
- 3 default terms created on activation: General Member, Committee, Leadership
- Protected from accidental deletion (admin notice + deletion blocked)

### member_role (hierarchical, like Categories)
- Has its own admin submenu under Members → Roles (like Posts → Categories)
- Fully editable from admin — add/rename/delete terms freely
- Rendered as plain text (no link) in cards and on detail page

### Why taxonomies over ACF for tier/role?
- Taxonomies are natively manageable in wp-admin (add/rename/delete via standard UI)
- No ACF conditional_logic + required field validation bugs
- Filter dropdowns on the admin list table come for free
- Native term assignment UI is proven and reliable

## Shortcode

```
[newar_members tier="general_member"]
[newar_members tier="committee"]
[newar_members tier="leadership"]
```

Queries members filtered by the member_tier taxonomy term matching the attribute,
sorted by display_order ascending. Renders a responsive card grid with:
- centered circular photo (or initials fallback),
- member name as a link to the single-member detail page,
- role term(s) as plain text (no link to taxonomy archive).

Phone, address, and Google Map display only on the single-member detail page
and are gated behind `is_user_logged_in()`.

## Organizer Tracking

Organizer yearly rotation tracking is built into the newar-members plugin
and is active automatically whenever the plugin is active — no separate
plugin activation is needed.

### Organizers Admin

- **Organizers** appears as a submenu under Members in wp-admin.
- Each record represents a year with two host members (`host_member_1` and
  `host_member_2`, both referencing `member` posts), a year, and optional notes.
- **Year uniqueness validation**: An organizer record for a given year can only exist once — a
  validation error is shown if a duplicate year is attempted.
- **Duplicate-member validation**: Organizer 1 and Organizer 2 must be
  different people; saving is blocked if the same member is selected for both.
- The admin list table shows Year, Organizer 1 name (linked to edit), Organizer 2 name
  (linked to edit), and a trimmed Notes column.

### BS Year Calculation

The plugin auto-calculates the current Bikram Sambat (BS) year from the
Gregorian date (approximation: BS new year begins mid-April). A **Current BS
Year Override** setting is available under Settings → General for manual
adjustment around the April transition.

### Front-End Callout

When the `[newar_members]` shortcode is used on a page, a highlighted
callout block appears at the top of the member grid showing the current
year's two Organizers with their photos, names, and notes.

## Activation & Quick Start

1. Ensure the newar-members plugin is active.
2. Run `wp newar setup_pages --allow-root` to create the 3 front-end pages (or create them manually with the `[newar_members]` shortcode).
3. Go to **Members → Add New** in wp-admin and enter members manually.
4. (Optional) Go to **Settings → Newar Options** to configure hero background, stats, gallery, contact info, and social links.

## Google Maps

The single member detail page shows a link to Google Maps when a location
(latitude/longitude) is set for a member. To embed an interactive map instead
of a link, add your Google Maps API key to `wp-config.php`:

```php
define( 'GOOGLE_MAPS_API_KEY', 'your-key-here' );
```

The key needs the **Maps JavaScript API** enabled in Google Cloud Console.
If the constant is not defined, the plugin falls back to a plain Google Maps
search link.

## WP-CLI Commands

| Command | Description |
|---------|-------------|
| `wp newar setup_pages` | Create Members/Committee/Leadership pages with shortcodes + nav menu |
| `wp newar migrate-names` | Migrate old `full_name` custom field into `first_name` + `last_name` |
| `wp newar reset-all-members` | Delete ALL member posts (loud confirmation required) |

## Files Changed Since v1.0.0

- Completely rebuilt using taxonomies for tier/role instead of ACF selects
- Removed broken ACF conditional_logic + required field combination
- Renamed `full_name` custom field into `first_name` + `last_name` (with `wp newar migrate-names`)
- Replaced SVG avatar fallback with CSS-only initials box
- Added phone_number, address, and Google Map location fields
- Added single-member detail page template (`single-member.php`)
- Shortcode card grid: centered photo, linked name, plain-text role, no thar