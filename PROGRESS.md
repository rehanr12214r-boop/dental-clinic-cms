# Phase 5 — Patient Portal & Public Pages

**Status:** Implementation resumed. Design research/API extraction is complete; Blade/Tailwind implementation is in progress.

**Last checkpoint:** 2026-10-23

## Objective

Redesign the public site and patient portal to match the Medio dental-clinic Figma template while preserving all existing Laravel behavior, booking JavaScript, routes, and Pest coverage.

## Figma source

- File: `Medio – Dental Clinic & Healthcare Website Template`
- File key: `dGy7oM1M4h9rp9B3I7p50w`
- Page: `Design` (`0:1`)
- URL: `https://www.figma.com/design/dGy7oM1M4h9rp9B3I7p50w/Medio-%E2%80%93-Dental-Clinic---Healthcare-Website-Template-%7C-Dentist--Appointments---CMS--Community-?node-id=0-1`
- Access method: Figma REST API (`https://api.figma.com/v1/files/dGy7oM1M4h9rp9B3I7p50w`).
- The personal access token was supplied at runtime and is **not stored in the repository**.

### Saved design artifacts

- `storage/app/figma/medio-full.json` — full Figma file document.
- `storage/app/figma/medio-tokens.txt` — extracted colors, typography, effects, radii, layout modes, image refs.
- `storage/app/figma/node-map.txt` — top-level frame map.
- `storage/app/figma/reference/pages/` — rendered reference images of page frames.
- `storage/app/figma/reference/home/` — rendered reference images of key home sections.
- `storage/app/figma/raw-images/` — raw image fills downloaded for implementation.

These are local design references and can be removed before production.

## Design tokens extracted from Figma

### Colors

| Token | Hex | Usage |
| --- | --- | --- |
| Cream background | `#FEF9EF` | Page canvas, footer |
| Ink | `#3C3D42` | Headings, nav, dark buttons, wordmark |
| Near black | `#121212` | Body/nav text |
| Body gray | `#676767` | Paragraphs, breadcrumbs |
| Muted gray | `#6A6C71` | Meta text |
| Terracotta | `#C2714D` | Primary accent, testimonial card, icon circles |
| Bright orange | `#EC5B37` | `//` eyebrow accent |
| Soft beige | `#F3EFE5` | Alternate section background |
| Dark section | `#212123` | Appointment CTA section |
| White | `#FFFFFF` | Cards/forms |
| Border | `#E2E3E4` | Hairlines and inputs |
| Soft border | `#F4F5F5` | Dividers |
| Stats gray | `#4F5154` | Large statistics |
| Lavender ticker | `#EBD1FF` | Home announcement marquee |

### Typography

- **Headings:** `Libre Caslon Text` (400/500/600/700)
  - Hero: 58px / 69.6px, letter-spacing -1.74px
  - Section: 56px / 67.2px
  - Page title: 48px / 57.6px
  - Subsection: 36px / 43.2px
  - Card title: 24px / 28.8px
  - Feature title: 20px / 24px
- **Body / nav:** `Inter Tight` (400/500)
  - Nav: 18px / 21.78px
  - Body: 16px / 22.4px
  - Meta: 16px / 19.36px
  - Uppercase eyebrow: 16px / 22.4px, letter-spacing -0.48px
- **Forms/article body:** `Geist` (400/600), 16–20px.
- **Buttons:** `Inter` 700, 18px / 28px.
- **Logo/wordmark:** geometric sans, 700; footer wordmark approx. 428px tall.
- **Copyright:** `Poppins` 400, 20px / 28px, letter-spacing -0.4px.
- **Eyebrow marker:** `Be Vietnam` 400, 16px / 23.375px.

### Radii / effects / spacing

- Cards: 12px; service rows/images: 12px; team cards: 10px.
- Image cards in collage: 20px; CTA pills: 100px.
- Buttons: full pill, dark `#3C3D42` fill with white text and a 34px terracotta circle arrow.
- Image shadow: `0 4px 8px rgba(0,0,0,0.08)`.
- Content width: 1296px inside 1440px frame (72px side margins).
- Section rhythm: large vertical spacing (~90–120px).
- Forms: split image + terracotta panel, underlined fields rather than boxed inputs.

## Figma page map

### Home (`0:363`)

- Header/nav: `0:364`, `0:370`, `0:371`, `0:375`.
- Hero: image `0:668`, heading `0:669`, lavender marquee `0:678`.
- About intro: `0:376`; photo collage `0:400`.
- Benefits image block: `0:416`.
- Services list: `0:434`.
- Dark process section: `0:466` / `0:468`.
- Team cards: `0:489`, `0:499`, `0:509`, `0:519`, `0:529`; heading `0:539`.
- Testimonials: `0:544`.
- Blog teaser: heading `0:581`; cards `0:586`–`0:601`.
- Dark appointment CTA: `0:606`.
- Footer links/wordmark: `0:627`.

### Public page frames

- Make an Appointment: `0:953` (form `0:971`, image `0:992`, footer `0:993`).
- Contact Us: `0:1031` (form `0:1049`, image `0:1066`, info `0:1071`, footer `0:1073`).
- Services list: `0:1111`.
- Services detail variant: `0:1215`.
- Dentists: `0:1336`.
- About Us: `0:1481`.
- Dentist Single: `0:1646`.
- Blog article: `0:732`.
- Blog list: `0:845`.
- Standalone CTA: `0:932`.

> The Figma file contains public marketing pages only. It has no patient-portal frame; the portal will be styled by extending the same tokens, heading treatment, pill buttons, cream surfaces, and terracotta accents.

## Existing app audit

### Public routes

- `/` — `HomeController@index` / `home.blade.php`
- `/treatments` — `treatments.index`
- `/treatments/{treatment}` — `treatments.show`
- `/book` — `booking.index`
- `/appointment/lookup` — `appointment-lookup.blade.php`

### Patient routes

- `/patient/login`, `/patient/register`, password reset.
- `/patient/dashboard`
- `/patient/profile`
- `/patient/appointments/{appointment}/reschedule`

### Existing selectors that must remain intact

- Layout: `data-site-nav-toggle`, `data-site-nav`.
- Booking: `page-config`, `booking-shell`, `booking-wizard`, `step-2`, `step-3`, `treatment-options`, `appointment-date-picker`, `appointment-time`, `slots-loading`, `slots-meta`, `slots-grid`, `slots-empty`, `slots-error`, `booking-form`, `patient-name`, `patient-phone`, `patient-age`, `patient-notes`, `booking-submit`, `booking-confirmation`, `confirmation-*`, `booking-again`.
- Reschedule: `reschedule-config`, `reschedule-date-picker`, `reschedule-time`, `reschedule-slots-*`, `reschedule-submit`.
- Portal: `data-countdown-to`.
- Toasts: `data-flash-toast`, `data-flash-dismiss`.

### Copy assertions currently in Pest tests

Preserve these where possible (or update tests only for intentional redesign copy changes):

- Home: `Healthy teeth.`, `Book appointment`, `View treatments`, `1200+`, `12+`, featured treatment names, `Dr. Sara Mahmoud`, clinic address.
- Treatments: `Treatments & transparent pricing`, `90 min visit`, `90 minute visit`, `Book this treatment`, `Book online`, `Other treatments you may need`, `Book this`.
- Patient portal: `Treatment history`, `No upcoming appointments`, `Your visit history is empty`, `Reschedule`, `Cancel`, `Receipt`, `data-countdown-to`.
- Auth: `Forgot your password?`, `Choose a new password`.

## Completed

- [x] Connected to Figma through the REST API and downloaded the file.
- [x] Extracted design tokens, typography, colors, layout patterns, shadows, radii, and image refs.
- [x] Downloaded rendered references for Home, Appointment, Contact, Services, Dentists, About, Dentist Single, and Blog frames.
- [x] Audited existing public and patient views, JS selectors, routes, and test expectations.
- [x] Saved Figma artifacts under `storage/app/figma/`.
- [ ] Implement design system/layout.
- [ ] Redesign public pages.
- [ ] Redesign patient portal/auth pages.
- [ ] Add/update Pest coverage.
- [ ] Run `npm run build` and `php artisan test`.

## Remaining implementation plan

1. **Design foundation**
   - Add Google Fonts (`Libre Caslon Text`, `Inter Tight`, `Geist`) in `resources/views/components/layouts/public.blade.php`.
   - Add Tailwind v4 theme tokens in `resources/css/app.css` for cream, ink, terracotta, body gray, borders, display/body fonts.
   - Rebuild the public header, mobile drawer, and oversized footer wordmark.

2. **Reusable Blade components**
   - `components/public/section-heading.blade.php` — eyebrow `//`, serif heading with italic terracotta accent.
   - `components/public/button.blade.php` — pill CTA with arrow circle (dark/white variants).
   - `components/public/field.blade.php` — underlined form field.
   - `components/public/cta.blade.php` — dark appointment CTA with four images.
   - `components/public/status-badge.blade.php` — portal status badge using Figma palette.
   - Redesign `components/public/treatment-card.blade.php`.

3. **Home**
   - Hero with large serif headline, terracotta italic words, portrait image, lavender marquee.
   - About intro + overlapping photo collage + stats.
   - Benefits image block with pill tags.
   - Services list rows.
   - Dark process section.
   - Team cards, testimonials accordion, blog teaser, dark CTA, footer.

4. **Treatments**
   - List page with serif heading, large service rows and images.
   - Detail page with article-style content, sidebar booking card, related treatments.

5. **Booking & lookup**
   - Apply “Make An Appointment” / “Contact Us” split-card language.
   - Keep the booking wizard JS and IDs exactly intact.
   - Restyle slots, summary, confirmation, and lookup result states.

6. **Patient portal**
   - Auth pages: cream background, centered card, serif heading, underlined fields, pill CTA.
   - Dashboard: serif welcome, stat cards, appointment cards, treatment table.
   - Profile/reschedule: same card and form language.

7. **Verification**
   - Run `npm run build`.
   - Run targeted public/patient tests, then `php artisan test`.
   - Fix any regressions before stopping.

## Notes / decisions

- Do not add new public routes for Figma-only pages (Blog, Dentists, Contact) unless explicitly requested. The Figma pages are references for visual language; the Laravel app only has the routes listed above.
- Keep all existing booking and countdown JavaScript contracts.
- Use original Figma images only as local design references/assets; do not hotlink expiring Figma URLs.
- The workspace is not a Git repository. `PROGRESS.md` is the checkpoint.
