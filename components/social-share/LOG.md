# Social Share Component Log

## Purpose
This file tracks work completed for the standalone `social-share` component so the lead developer can review what was added, when it was added, and what still requires manual integration in existing theme files.

## Task Summary
- Task intent: build an isolated social share template part for the WordPress theme.
- Requested UI behavior: when the user clicks the copy action, show a nearby hint saying `Посилання скопійовано`.
- Delivery mode: existing theme files were modified only where required to wire the component and recover missing compiled assets.

## Timeline

### 2026-03-14
- Created branch `feature/social-share-copy-hint`.
- Reviewed theme structure and conventions in:
  - `style.css`
  - `functions.php`
  - `package.json`
  - `templates/single-opportunity.php`
  - `template-parts/control-header-auth.php`
  - `template-parts/control-favorites.php`
  - `src/scss/components/_single-opportunity.scss`
  - `src/scss/mixins/_media.scss`
- Confirmed the current share area already exists in `templates/single-opportunity.php`, but it is static markup and does not yet provide copy feedback.
- Confirmed the current theme uses:
  - WordPress template parts
  - compiled theme assets
  - mostly mobile-first SCSS mixins via `min-*`
  - existing theme prefix patterns that are not fully consistent, so the fallback safe prefix `sc-` was used for the new component.
- Re-scoped the implementation to a shared template-part approach that can power all live share triggers in the theme with minimal changes.

## Files Added

### `components/social-share/social-share.php`
- Converted into the reusable share template part used by live templates.
- Added sanitized args handling for:
  - `post_id`
  - `post_url`
  - `post_title`
  - `label`
  - `copy_label`
  - `copied_label`
- Added optional class args for targeted template integration:
  - `wrapper_class`
  - `trigger_class`
- Added escaped external share links for:
  - Facebook
  - X
  - WhatsApp
  - Telegram
  - LinkedIn
- Added accessible trigger button, popover panel, and inline copy status node.
- Added data attributes used by the bundled JS controller.

### `src/js/social-share.js`
- Added the standalone share controller to the main theme JS bundle.
- Handles:
  - open/close behavior
  - outside click close
  - `Escape` close
  - copy to clipboard
  - inline copied-hint lifecycle

### `src/scss/components/_social-share.scss`
- Added share trigger, dropdown, icon tray, and copied-status styling.
- Refined the panel to stay compact by default and expand only when the copied hint is visible.

## Existing Files Modified
- `templates/single-opportunity.php`
- `templates/single-project.php`
- `src/js/app.js`
- `src/scss/app.scss`
- `inc/listing/Assets/grid/getters.js`
- `inc/listing/Core/ListingCore.php`

### `qa/tests/e2e/social-share.spec.js`
- Added Playwright coverage for:
  - component rendering
  - copy interaction
  - keyboard interaction
  - visibility at 375, 768, 968, 1440, and 1920 widths.
- Test expects `SOCIAL_SHARE_URL` to point to a page where the component is integrated.

## Local Repo / Environment Actions
- Fetched latest remote state from `origin`.
- Rebased local branch onto updated `origin/main`.
- Cleaned temporary tracked-file conflicts caused by `--autostash` reapply.
- Verified local WordPress Docker stack is available at `http://localhost:8080/`.
- Rebuilt theme assets with a Node 20 runtime shim:
  - `npx -y node@20 node_modules/gulp/bin/gulp.js styles scripts --prod`
- Full `build` task still has an unrelated pre-existing error in `moduleScripts`:
  - `Can't resolve '@wordpress/i18n' in '/inc/listing/Assets/grid'`
  - This did not block rebuilding the specific `app.css` and `app.js` assets used by the share feature.

## Important Constraints / Not Done
- Existing files are now modified in a minimal, reviewable way to wire the shared component into both live share locations.
- The following original files were updated and marked with `Social Share Integration START/END` comments for lead-dev review:
  - `templates/single-opportunity.php`
  - `templates/single-project.php`
- The following bundle entry points were updated to load the shared feature:
  - `src/js/app.js`
  - `src/scss/app.scss`
- New bundled source files added:
  - `src/js/social-share.js`
  - `src/scss/components/_social-share.scss`

## Review Notes
- The share feature is currently live-targeted for:
  - single opportunity pages
  - single project pages
- The copy hint behavior is intentionally small and inline to avoid disruptive UI.
- Draft standalone files `components/social-share/social-share.css` and `components/social-share/social-share.js` were removed in favor of the theme’s existing global asset pipeline.
- Clipboard behavior in `src/js/social-share.js` was hardened to fall back if `navigator.clipboard.writeText()` is unavailable or denied, so the hint still appears under more local-browser conditions.

## Verification
- Browser smoke test passed on:
  - `http://localhost:8080/opportunities/dvotyzhneva-rezydentsiia-u-regensburzi-dlia-mediinykiv/`
  - `http://localhost:8080/project/platforma-dlia-podachi-mrii-i-pidboru-metsenativ-abo-orhanizatsii-dlia-realizatsiyi-copy/`
- Verified behaviors:
  - share trigger opens panel
  - copy button is rendered
  - hint text `Посилання скопійовано` appears after click

### Share UI Refinement
- Refined the share dropdown toward the Figma reference:
  - compact icon tray instead of text pills
  - icon order updated to `copy / X / WhatsApp / Telegram / Viber / Facebook / LinkedIn`
  - trigger spacing and typography adjusted to match the horizontal Figma composition more closely
- Implementation details:
  - replaced text actions with icon-only actions in `components/social-share/social-share.php`
  - added inline SVG icon rendering for missing assets
  - tightened dropdown styling in `src/scss/components/_social-share.scss`
- Follow-up polish:
  - removed the permanently reserved empty message space under the icon row
  - the tray now expands only when the copied message is shown
  - replaced the gold-like hover feel with a more tactile violet interaction using subtle scale and shadow
  - allowed the `viber://` protocol explicitly in the rendered share link so the Viber action does not collapse to a self-link after WordPress URL sanitization
  - lead-dev concern: on Linux desktop environments the Viber action may trigger an `xdg-open` prompt if Viber Desktop is not installed or not registered as the protocol handler; this is an OS/application-handler behavior rather than a theme bug

## Incident Recovery
- After the earlier failed full build, the live page showed missing theme assets:
  - `assets/js/single-opportunity-store.module.js`
  - `assets/js/favorites-store.module.js`
  - `assets/css/blocks/breadcrumbs/breadcrumbs.module.css`
- This caused unrelated regressions on the page, including broken breadcrumbs styling and disabled favorites/share-related runtime behavior.
- Recovery action:
  - rebuilt `breadcrumbs.module.css` directly from `inc/acf/blocks/breadcrumbs/breadcrumbs.module.scss`
  - rebuilt `favorites-store.module.js` from `inc/favorites/Assets/favorites-store.js`
  - rebuilt `single-opportunity-store.module.js` from `inc/launchpad/Assets/single-opportunity-store.js`
- Post-recovery verification:
  - no more 404 asset requests on the tested opportunity page
  - breadcrumbs styles restored
  - share panel still opens and shows the copied hint

### Home Page Follow-up
- Additional regression found on `http://localhost:8080/home/`:
  - hero background missing
  - homepage block layouts looked broken
  - multiple block stylesheet requests returned `404`
- Root cause:
  - block CSS outputs under `assets/css/blocks/` had been removed during the earlier failed build cleanup and had not yet been regenerated.
- Recovery action:
  - rebuilt block styles with:
    - `npx -y node@20 node_modules/gulp/bin/gulp.js blockStyles --prod`
- Result:
  - hero background restored
  - block stylesheet `404`s resolved on `/home/`

### Opportunities Listing Follow-up
- Additional regression found on `http://localhost:8080/opportunities/`:
  - page data was present in SSR state
  - listing UI still showed the empty-state path
  - `assets/js/listing-store.module.js` was missing at first
- Recovery actions:
  - rebuilt `assets/js/listing-store.module.js`
  - removed the unused `@wordpress/i18n` import from `inc/listing/Assets/grid/getters.js`
- Reason:
  - `inc/listing/Assets/grid/getters.js` imported `@wordpress/i18n`, but the current local runtime does not expose it as a script module
  - the imported translation helpers were unused in the active code path, so removing the import was the safest minimal fix

### Projects Pages Follow-up
- Additional regression found on single project pages such as:
  - `http://localhost:8080/projects/platforma-dlia-podachi-mrii-i-pidboru-metsenativ-abo-orhanizatsii-dlia-realizatsiyi-copy/`
- Symptom:
  - page shell rendered
  - project content panels stayed hidden
  - `assets/js/projects-store.module.js` returned `404`
- Recovery action:
  - rebuilt `assets/js/projects-store.module.js` from `inc/projects/Assets/projects-store.js`
- Result:
  - project tabs hydrate correctly again
  - about panel is visible
  - opportunities and NGO tab data are present

## Update Rule
- Any future change to this component should append a dated entry here with:
  - what changed
  - which file changed
  - why the change was made
  - whether integration instructions changed.
