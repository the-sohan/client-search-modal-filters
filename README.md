# Client Search Modal Filters

A standalone WordPress customization that adds **More Filters** to a selected Directorist Search Modal in Bricks. Advanced fields expand inside the existing search dialog and submit through Directorist’s native search form.

This is a client-specific customization, not a global Directorist feature. It does not modify Directorist, AddonsKit, or Bricks files.

## Installation

1. Download `client-search-modal-filters-1.0.0.zip` from [Releases](https://github.com/the-sohan/client-search-modal-filters/releases/latest).
2. In WordPress, open **Plugins → Add New → Upload Plugin**.
3. Upload the ZIP and activate it.

## Requirements and scope

- WordPress 6.0+ and PHP 7.4+.
- Directorist, AddonsKit for Bricks, and the Bricks theme.
- Advanced search fields configured in the Directorist Directory Builder.
- Default target page slug: `aaa-brick-test`.
- Default Bricks Search Modal element ID: `jlwxvn`.

If the destination page or element differs, update `PAGE_SLUG` and `ELEMENT_ID` in `client-search-modal-filters.php` before installation. Other elements are left unchanged.

## Behavior

- More Filters expands/collapses within the existing search dialog.
- Apply Filters submits the existing Directorist form.
- Reset Filters restores the form’s initial values.
- Escape collapses filters first; a subsequent Escape closes the parent dialog.
- Deactivation restores the original modal. No database settings are stored.

## Local verification

Tested with Directorist 8.10.4, AddonsKit for Bricks 2.0.3, and Bricks 2.3.4:

- Desktop (1280 × 900) and mobile (390 × 844) layout and scrolling.
- Advanced filter open/close, reset, and search submission.
- Test phone filter returned zero results; cleared filters returned six listings.
- Keyboard Escape and deactivation/reactivation behavior.
- PHP syntax, JavaScript syntax, and release ZIP integrity checks passed.

Compatibility with other versions or client configurations has not been verified. Retest after dependency updates.

## License

GPL-2.0-or-later, as declared in the plugin header.
