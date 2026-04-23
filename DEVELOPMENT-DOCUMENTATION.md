# Development documentation — Estatein Growmodo theme

**Purpose:** Brief deliverable describing development process, theme-related technical choices, and tools/plugins used.  
**Audience:** Assessors / stakeholders reviewing the Growmodo assessment submission.

---

## 1. Development process

Work followed an **iterative, design-led** flow aligned with provided mockups and written specs:

1. **Foundation** — Registered a **standalone custom theme** (no parent framework) with standard `functions.php` setup: theme supports, navigation locations, enqueued assets, and SVG upload helpers where needed for brand assets.

2. **Content model** — Defined **custom post types** (Properties, Team, Testimonials) and **taxonomies** for listings in code (`inc/cpt-registration.php`). Paired listings with **Advanced Custom Fields (ACF)** for structured data (price, address, gallery, features, pricing tables, FAQs, inquiry email) with **JSON sync** under `acf-json/` so field definitions are version-controlled and portable across environments.

3. **Page composition** — Built the main marketing page from **template parts** rather than a single monolithic file: hero, service highlights, and a **flexible ACF “card loop”** system (`page_card_sections`) so editors can add/reorder Featured Properties, Testimonials, and FAQ-style sections without code changes.

4. **Property experience** — Implemented **`single-property.php`** and `template-parts/single-property/content.php` to match the property detail desktop layout: gallery, description and stats, features, inquiry form (server-side handler + email), pricing breakdown, and FAQs. **JavaScript** was added only where interaction was required (carousel slot math, gallery thumbs, expandable sections); otherwise behavior stays in PHP and CSS for clarity and performance.

5. **Quality and handoff** — **Demo content seeding** (`Tools > Estatein demo data`) accelerates local/staging review. **README.md** documents setup, ACF usage, and key file locations. This document summarizes rationale for assessors.

---

## 2. Theme development choices (why I did it this way)

| Choice | Rationale |
|--------|-----------|
| **Classic theme (PHP templates)** over a full headless or block-only Figma > React pipeline | Matches WordPress hosting reality for many real-estate sites, keeps **assessor import** (e.g. All-in-One Migration) straightforward, and fits ACF’s strengths for editor-managed layouts. |
| **ACF + JSON** in the repo | Treats fields as **code**: reproducible builds, easier reviews in Git, and fewer “works on my machine” field mismatches than DB-only field groups. |
| **Flexible content** for homepage sections | Editors get **layout control** without custom Gutenberg blocks; each layout maps to a small PHP partial under `template-parts/sections/` and shared header/footer components. |
| **`style.css` as primary design layer** with **Tailwind** as a thin utility layer | Brand layout, spacing, and components live in one predictable place; Tailwind is compiled from `assets/css/tailwind-input.css` when needed (`npm run build:tailwind`) rather than relying on utility classes for every rule. |
| **BEM-style classnames** (e.g. `section-card-loop__*`, `property-detail__*`) | Predictable naming for sections that grew over time; easier to grep and extend than unstructured utility-only markup. |
| **Dedicated helpers** (`inc/card-loop-helpers.php`, `inc/property-template-helpers.php`) | Avoids duplicating price formatting, image fallbacks (featured + gallery), and gallery normalization across templates. |
| **Inquiry form via `admin-post.php`** | No extra plugin dependency for a simple POST > `wp_mail()` flow; nonce + honeypot for basic abuse resistance. Hosts often require SMTP for reliable delivery—documented in README for operators. |

---

## 3. Plugins and tools used

### WordPress plugins (expected in a running site)

| Plugin / role | Use in this project |
|---------------|---------------------|
| **Advanced Custom Fields (ACF)** | Required for theme options (header/footer/outro), hero, service highlights, flexible page sections, and all property fields. Field groups ship from **`acf-json/`**. |

No other plugins are **required** by the theme code itself for core front-end rendering.

### Development tools

| Tool | Use |
|------|-----|
| **VS Code–class editor** | Theme and PHP authoring, integrated search, and AI-assisted iteration on specs. |
| **Node.js + npm** | Runs **Tailwind CSS 3.x** (`package.json`: `build:tailwind` / `watch:tailwind`). |
| **Git** | Version control for theme sources (respect `.gitignore` for `node_modules` and local artifacts). |
| **Local WordPress stack** (XAMPP) | Runtime for PHP, ACF, and migration testing. |

### Fonts and assets

- **Urbanist** is loaded from **self-hosted** font files referenced in `style.css` (no Google Fonts dependency in the shipped CSS path used for that stack).
- **SVG** icons and graphics live under `assets/images/` where appropriate for crisp UI at multiple breakpoints.
- **WEBP** for raster graphics where used (e.g. decorative / section imagery).

---

## 4. Summary

The theme prioritizes **editor-friendly structure (ACF + partials)**, **portable configuration (acf-json)**, and **clear separation** between global options, page-level flexible sections, and single-property detail pages. Tooling stays minimal: **WordPress + ACF** for runtime behavior, **Node** only for optional Tailwind builds, and standard migration plugins for **assessor handoff**, not as hard dependencies of the theme itself.
