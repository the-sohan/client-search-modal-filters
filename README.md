# Client Search Modal Filters

A standalone WordPress customization that adds **More Filters** to Directorist Search Modal elements in Bricks. Advanced fields expand inside the existing search dialog and submit through Directorist’s native search form.

## What changed in 1.1.0

- Removed the fixed page slug and element ID restrictions.
- Added **Show More Filters → Show / Hide** to each Search Modal’s Bricks controls.
- Supports header templates wherever Bricks displays that header, including other pages, archives, and search results.
- Existing Search Modal elements default to **Show** while this customization is active. Set an individual element to **Hide** to opt out.
- Directorist, Bricks, and AddonsKit files remain unchanged.

## Install or upgrade

1. Upload the packaged `client-search-modal-filters-1.1.0.zip` through **Plugins → Add New → Upload Plugin**.
2. If version 1.0.0 is installed, choose **Replace current with uploaded**. Keep only one copy active.
3. Activate **Client Search Modal Filters** and reload any open Bricks Builder tabs.

The GitHub source archive may have a different folder name. Use the installable release ZIP when one is available.

## Configure in Bricks

1. Edit the header template with Bricks.
2. Select the Directorist **Search Modal** element.
3. Open **Content → Button → Show More Filters**.
4. Choose **Show** or **Hide**, then save the header.
5. Ensure the header’s Bricks template conditions include the desired pages (for example, Entire Website).
6. Check the actual frontend at desktop and mobile sizes.

No page slug, PHP changes, or per-page configuration are needed. This is an element setting: the same saved header element uses the same setting wherever that header is rendered. The customization does not change your header’s template conditions or repair a separate Search Form layout.

## Requirements

- WordPress 6.0+ and PHP 7.4+.
- Directorist, AddonsKit for Bricks, and the Bricks theme.
- Advanced search fields configured in the Directorist Directory Builder. Without advanced fields, Directorist does not render the More Filters button.

## Behavior and rollback

- Apply Filters submits the existing Directorist form.
- Reset Filters restores the form’s initial values.
- Escape collapses filters first; a subsequent Escape closes the parent dialog.
- Deactivation restores the original modal rendering. The saved per-element choice remains in the Bricks template data and takes effect again on activation.
- Customization assets load on the frontend while the Bricks modal dependency is available; styling and interaction changes are scoped to enabled modal forms.

## Verification

Locally verified with Directorist 8.10.4, AddonsKit for Bricks 2.0.3, and Bricks 2.3.4:

- Show and Hide saved through Bricks Builder and respected on the frontend.
- The same header modal renders More Filters on Sample Page and the separate test page.
- A header modal and page modal coexist without sharing their advanced panels.
- Advanced fields open, reset after keyboard input, and submit through the native results URL.
- Mobile at 390 × 844: header popup fits viewport, fields scroll, and Apply Filters submits the advanced value.

Version 1.0.0 had page and element constants. Those restrictions no longer apply in 1.1.0, including if your older copy was edited for a different slug.

Retest after dependency updates. Client-site verification has not been performed for this release.

## License

GPL-2.0-or-later, as declared in the plugin header.
