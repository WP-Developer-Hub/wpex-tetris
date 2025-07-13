
# WP Tetris Plus
**Maintained by [@DJABHipHop](https://github.com/BAProductions) under the [WP-Developer-Hub](https://github.com/WP-Developer-Hub/)** brand
**Latest update:** July 9, 2025

This repo keeps Tetris Free (by WPExplorer) modern, lightweight, and standards-compliant, with enhancements from my Universal Theme.

## Instructions for wpex-tetris Users

### Existing Users (Upgrading or Fixing on PHP 8+)
If you are using the old Tetris theme ([wpexplorer/wpex-tetris](https://github.com/wpexplorer/wpex-tetris)) and your site is broken after upgrading to PHP 8 or newer:

1. **Backup Your Site:**
   Always backup your site and database before making changes.

2. **Remove or Rename the Old Theme:**
   - Connect to your website via FTP.
   - Download a copy of the old `wpex-tetris` theme folder for backup, or simply rename the folder (e.g., `wpex-tetris-old`).
   - Optionally, open `style.css` in the theme folder and rename the theme there as well to avoid conflicts.

3. **Install the New Theme:**
   - Download the latest release of the new theme from:
     [https://github.com/WP-Developer-Hub/wpex-tetris/releases](https://github.com/WP-Developer-Hub/wpex-tetris/releases)
   - Upload and activate this new theme in your WordPress dashboard.

4. **Install the Migration Tool:**
   - Download the migration tool from:
     [https://github.com/WP-Developer-Hub/wpex-tetris-migration-tool](https://github.com/WP-Developer-Hub/wpex-tetris-migration-tool)
   - Install and activate the plugin.

5. **Run the Migration Tool:**
   - Follow the on-screen instructions in the migration tool to migrate your content and settings.

---

### Existing Users (PHP 7.x or Old Theme Still Works)
If you are **not** on PHP 8 or newer and the old theme is still working:

- You only need to install the migration tool if you want to migrate to the new theme.
- The old theme may continue to work, but it is **strongly recommended** to upgrade for security and future compatibility[2][3][5][8].

---

### New Users (Fresh Install)
If you are a new user (not upgrading from the old theme):

- Simply install the new theme from [WP-Developer-Hub/wpex-tetris releases](https://github.com/WP-Developer-Hub/wpex-tetris/releases).
- You do **not** need the migration tool.

---

## Key Features
## Options (via Customizer)

- Option to set the accent color, with 2 dynamically adjustable shades—each with automatic black/white text color. Includes 2 toggles to manually fix the text color for each shade if automatic detection fails (black for light backgrounds, white for dark).
- Dynamic accent color support with automatic contrast (set)
- Accent color text contrast auto-calculated (set)
- Option to switch between displaying the publication date or modification date (select)
- Option to toggle the author box in single.php (toggle)
- Option to toggle the post tags in single.php (toggle)
- Option to set post thumbnail aspect-ratio to either 1/1 or 9/16 on post grid (set)
- Option to toggle new post badge on post grid (toggle)
- Option to adjust new post badge text on post grid (set)
- Option to adjust excerpt length on post grid (set)
- Option to toggle read more button on post grid (toggle)
- Option to set copyright start date on the footer (set)
- Option to edit the copyright info on the footer (set)

## Other Features

- HTML5 mobile menu
- No JavaScript (no JS libraries needed to fix default player or core features)
- Adds custom classes to WordPress media players for styling and aspect ratio control
- Ensures all video and playlist players are responsive (16:9) with correct max-height
- Fixes WordPress media player responsiveness bug with a minimal inline script (no bulky JS libraries)
- Handles fullscreen transitions for media players, adjusting max-height as needed
- Automatically wraps media elements for consistent layout and responsive sizing
- Improved copyright system
- Modern form elements ([see example](https://codepen.io/_rahul/pen/jOJRKzm))
- Custom `ufg.css` for flex/grid layouts
- Improved widget titles
- Minimal background textures (sidebar & bubble tips only)
- Improved `search.php` and HTML5 search form
- Supports all WordPress classic theme features
- Media display in grid view by post format
- Quick tags in comments (now moved to [WP Comment Toolbox](https://github.com/WP-Developer-Hub/wp-comment-toolbox))
- Menu & pagination icons
- Improved comment paging system
- Responsive video iframes & embeds (CSS only)
- Text overflow fixes with `ufg.css`
- Wider layout, larger author box images
- Custom block colors synced with theme accent
- Search filters by post format
- Custom block pattern for a simple contact form
- Player color matches theme accent

## Gallery & Lightbox
The default WordPress gallery and caption styling are intentionally basic for flexibility.
For a modern gallery slider, see the [demo](https://pressthemes.freesite.host/portfolio/lightning-fast-rom.html).
> **Recommended:**
> For best gallery slider results, install [Simple Lightbox](https://wordpress.org/plugins/simple-lightbox/).
> Without it, the gallery slider may not look or function as intended.

## Sidebar on Pages
By default, **pages do not have a sidebar or title** for a clean look.
> **Want sidebar support on pages?**
> Use this branch:
> [SidebarOnPagesWithToggle](https://github.com/WP-Developer-Hub/wpex-tetris/tree/SidebarOnPagesWithToggle)
> This branch adds a toggle to enable or disable the sidebar on pages.
>
> If you’d like this feature in the main branch, [open an issue or ticket](https://github.com/WP-Developer-Hub/wpex-tetris/issues) and I’ll consider merging it.

## Not Included
- Built-in lightbox (use plugin above)
- Custom gallery
- Social icons/widgets
- RSS feed in dashboard
- Meta box frameworks
- Quote, link, and chat post formats
- Header image support

## Notes
- Gallery/caption styles are minimal for flexibility and performance.
- Modern enhancements include background effects, text truncation, and responsive layouts.
- Customize further as needed!
- If you are on PHP 8 or newer and this is a fresh install, install both the theme and tools; otherwise, install the tool only.

