# Newar Heritage Theme

Child theme of Twenty Twenty-Four for the Newari Heritage Community site.

## Design System

- **Palette:** Terracotta (#A6462B), Maroon (#6B1E23), Gold (#C89B3C), Wood (#5A3A29), Cream (#F4EDE0), Ink (#2B1E14)
- **Headings:** Tiro Devanagari Hindi / Noto Serif Devanagari (serif, Devanagari-ready)
- **Body:** Noto Sans / system-ui (clean Devanagari rendering)
- **Decorations:** SVG patterns inspired by carved wood struts (tundal), pagoda tiered roofs, and peacock-window lattice (mayurakhana)

## Files

| File | Purpose |
|------|---------|
| `style.css` | All CSS custom properties, layout, responsive styles |
| `functions.php` | Enqueues, theme supports, hamburger menu JS |
| `header.php` | Site header with logo, nav, strut divider |
| `footer.php` | Site footer with maroon bg and strut divider |
| `front-page.php` | Homepage: hero, events, vision, photo grid |
| `page.php` | Default page template |
| `index.php` | Fallback / blog index |
| `assets/patterns/` | Lightweight SVG decorative assets |

## Shortcode Integration

The `[newar_members]` shortcode (from the `newar-members` plugin) is styled by this theme's CSS. The plugin outputs `.newar-members-grid` and `.newar-member-card` elements which the theme's `style.css` targets for card layout, gold rings, and responsive grids.

## Activation

1. Ensure the parent theme "Twenty Twenty-Four" is installed.
2. Go to Appearance → Themes and activate "Newar Heritage."
3. Set a static front page under Settings → Reading if using `front-page.php`.