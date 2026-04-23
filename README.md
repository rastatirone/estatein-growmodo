# Estatein Growmodo

Custom WordPress theme for the Estatein brand: dark UI, Advanced Custom Fields (ACF), custom post types, and modular front-page sections.

**Theme name:** Estatein Growmodo  
**Text domain:** `estatein-growmodo`  
**Version:** 1.0.0 (see `style.css` header)

---

## Requirements

- **WordPress** 6.x (typical hosting stack)
- **Advanced Custom Fields (ACF)** Pro or Free — field groups load from `acf-json/`; many templates call `get_field()` / `have_rows()`.
- **Node.js** (optional) — only if you rebuild Tailwind utilities (`npm run build:tailwind`).

---

## Quick start (using the theme)

1. **Install**  
   Copy this folder to `wp-content/themes/estatein-growmodo` and activate **Estatein Growmodo** under **Appearance → Themes**.

2. **ACF**  
   With ACF active, field groups in `acf-json/` sync automatically. Visit **Custom Fields** in admin if you need to sync or review groups.

3. **Global settings**  
   **Theme Settings** (ACF options page) holds site-wide content: promo banner, logo, header CTA, footer columns/social, etc.

4. **Menus**  
   Under **Appearance → Menus**, assign:

   - **Primary Menu** — main header navigation  
   - **Footer - Home / About Us / Properties / Services / Contact Us** — five column locations used by `footer.php`

5. **Home / landing pages**  
   Use the default **Page** template (`page.php`). Typical structure:

   - **Hero** — ACF group on the page (`group_hero_configuration`)  
   - **Service highlights** — optional block below hero  
   - **Card sections** — flexible field **`page_card_sections`** (Featured Properties, Testimonials, FAQ cards). Each layout can have its own title, subtext, optional CTA, and relationship/repeater content.  
   - **Editor content** — optional WYSIWYG in a `.container` below the sections

6. **Properties**  
   Create **Properties** (`property` CPT) with **Property Details** ACF fields: price, address, bedrooms, bathrooms, area, gallery, features, pricing categories, property FAQs, inquiry email. Use taxonomies **Locations**, **Property Types**, **Statuses** where needed.

   - Public archive slug: **`/properties/`**  
   - **Single listing:** **`single-property.php`** renders the property detail layout (hero, gallery, description & stats, features, inquiry form, pricing breakdown, FAQs). Footer still includes the global **outro CTA** from Theme Settings.

7. **Supporting content**

   - **Testimonials** — used by card-loop “Testimonials” layout (relationship). Includes `client_name` and related fields.  
   - **Team** — `team_member` CPT for team grids (demo seeder can create samples).

8. **Demo content (optional)**  
   **Tools → Estatein demo data** seeds sample properties (nine listings in demo data v2), testimonials, and team members. Requires ACF.  
   - First run creates everything and sets demo version **v2**.  
   - Sites that already ran **v1** get **six additional properties** automatically on next admin load (one-time migration).  
   - **Force run** may duplicate posts — use only on local/staging.

9. **Tailwind (optional)**  
   From the theme directory:

   ```bash
   npm install
   npm run build:tailwind
   ```

   Source: `assets/css/tailwind-input.css` → output: `assets/css/tailwind-output.css`. Main visual design lives in **`style.css`** (loads after Tailwind).

---

## Theme structure (high level)

| Path | Purpose |
|------|--------|
| `style.css` | Main stylesheet + theme metadata; Urbanist `@font-face`; layout/components |
| `functions.php` | Setup, enqueues, ACF JSON paths, options page, includes |
| `header.php` / `footer.php` | Site chrome, promo bar, nav, footer columns |
| `page.php` | Default page: hero → service highlights → flexible card sections → content |
| `index.php` | Generic fallback for archives/singles without a dedicated template |
| `single-property.php` | Full property detail page |
| `template-parts/single-property/content.php` | Property detail markup (ACF-driven) |
| `inc/property-template-helpers.php` | Gallery normalization, stat formatting |
| `inc/property-inquiry-handler.php` | `admin-post.php` handler for inquiry emails |
| `assets/js/property-detail.js` | Gallery, “View all photos”, pricing toggles, FAQ expand |
| `acf-json/` | Versioned ACF field group JSON (sync with DB) |
| `inc/cpt-registration.php` | `property`, `team_member`, `testimonial` + property taxonomies |
| `inc/card-loop-helpers.php` | Property card helpers (type label, price HTML, image URL + gallery fallback) |
| `inc/dummy-data-seed.php` | Demo seeder + v1→v2 property migration |
| `template-parts/sections/` | `hero.php`, `service-highlights.php`, `section-card-loop.php`, card-loop layouts |
| `template-parts/components/` | Shared section header/footer (titles, CTAs, carousel toolbar) |
| `assets/js/` | `section-card-loop.js` (carousel), `mobile-navigation.js`, `header-scroll.js`, `promo-banner.js` |
| `assets/images/` | SVG UI assets (e.g. carousel arrows `svg-vector-17.svg`) |

---

## Recent feature & polish updates

Summarizes work shipped in this theme iteration (card loops, property UI, toolbar, demo data).

### Flexible “card loop” sections (`page_card_sections`)

- ACF flexible content on pages drives **Featured Properties** (relationship → `property`), **Testimonials**, and **FAQ cards** layouts.
- Shared **section header** (sparkles/graphics from theme assets where applicable), title, subtext, optional section CTA; **footer** with carousel prev/next, pagination (`01 of NN`), and optional **mobile-only** toolbar CTA (duplicated from header CTA behavior where configured).
- **Carousel:** `assets/js/section-card-loop.js` — per-section paging, responsive “per view” from `data-per-view-*` attributes, respects reduced motion. **Slot width** uses the track’s **computed CSS `gap`** (not a hardcoded pixel value) so it stays correct when the gap changes by breakpoint.

### Property cards (featured layout)

- **Image frame sizes:** ~**310×210** (mobile), **353×255** (≥1024px), **432×318** (≥1441px), scoped to property cards.
- **Track gap between cards:** **20px** up to large desktop; **30px** from **1441px** upward.
- Card images use **`loading="eager"`** where output; gallery/fallback resolution via `estatein_card_loop_property_card_url()` pattern in helpers.

### Toolbar / pagination UX

- **Desktop (≥1024px):** Pagination text **left**, prev/next buttons **grouped on the right** (`.section-card-loop__toolbar-controls` + `.section-card-loop__toolbar-arrows`).
- **Mobile:** **Prev | page count | next** in one row; **“View all”** CTA and nav **side by side** when the CTA exists (CTA capped so the control cluster keeps space).

### Demo data

- **`inc/dummy-data-seed.php`:** Tools screen **Estatein demo data**; seeds **nine** sample properties (richer pricing/FAQ on the first listing), testimonials (with **`client_name`**), and team members.
- **Demo DB version `2`:** Fresh seed creates all nine; older **`1`** installs receive **six extra properties** once on admin load (no duplicate testimonials/team from that migration path).

### Single property detail page

- **`single-property.php`** — Hero (title, address, price), thumbnail strip (up to 9), two large images, “View all photos” expander, two-column description + key features, inquiry form (posts to `admin-post.php`, emails **`inquiry_email`** or site admin), pricing categories with “View details” rows, FAQ cards with “Read more”.
- **`property-detail.js`** — Enqueued only on singular `property`.

### Other

- **SVG uploads** — helpers in `functions.php` so admins can upload SVG logos/icons where appropriate (trusted roles only).
- **ACF JSON** — save/load under `acf-json/`; orphan **Global FAQs** DB group is deactivated when the merged JSON options exist.

---

## Development notes

- Prefer editing **`style.css`** for layout/visuals tied to this theme; use Tailwind for utility layers when you extend `tailwind-input.css`.
- **`section-card-loop.js`** is enqueued on **`is_page()`** only; if you reuse card loops outside standard pages, enqueue that script where needed or broaden the condition in `functions.php`.
- After changing ACF fields in the admin UI, **sync to JSON** so `acf-json/` stays the source of truth for version control.

---

## Credits

Built for the Estatein / Growmodo assessment. Thank you for using this theme.
