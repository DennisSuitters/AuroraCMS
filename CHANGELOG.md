### AuroraCMS v0.0.1
- Rebrand from LibreCMS to AuroraCMS.
- Add Reason to Blacklist (add field to iplist table in database and interface additions).
- Move Settings Links to Menu.
- Add Comments and Reviews Administrtion Page for quick and easy approval or deletion of items.
- Change LibreICONS to iCONS which contain only used icons with Administration saving file space.
- Change some Administratio UI placements. e.g. Settings is now in menu (icon on right).
- Remove MINIFY option due to Minification breaking sites layouts.
- Remove Fingerprint Popups, editing changes can be found in Preferences/Activity for reverting content.
- Add SEO Information and Help.

### LibreCMS v2.0.6
- Fix Schema JSON-LD.
- Remove blocking "/search/" directive from robots.txt
- Remove inline MicroFormats in favour of JSON-LD.
- Fix Content Items not using Thumbnails.
- Fix Google Analytics tracking code.
- Build work around for using Google Tracking Code via entering UA code.

### LibreCMS v2.0.5
- Fix Comments Content display when enabled. Display Comments without Comments form if disabled, or don't add Comments markup if no comments exist.
- Fix Display Created By on Content rather than edited.
- Fix SEO not displaying correct information.
- Fix Fix Media Display in Pages and Content Tabs.
- Fix Messages reading correct storage of Messages Body.
- Fix Subjects display when Added.
- Remove unnecessary role attributes from elements.
- Fix many ARIA-A11Y issues.
- Add Clear IP from Visitor Tracker
- Fix URL/IP Tracking.
- Add More to Tracker Page to stop loading thousands of results.

### LibreCMS v2.0.4
- Add Detect and Decrypt of Base64 Email Messages
- Fix elFinder Theme Styling to suite Dark and Light Administration themes.

### LibreCMS v2.0.3
- Fix Social ARIA Labels
- Fix Meta Tag Generation and Fallbacks.
- Fix Robots Meta Head Tag to correctly Allow or Disallow Robots.
- Add Image ALT with Fallback to Title for Media Images and Attribution Title for Content.
- Fix Display Name or Business with fall back both ways.
- Fix RSS Display Errors.
- Remove unnecessary DB Query from Sitemap
- Add Category Options in Content Settings, add Categories per contentType and an image per Category.
- Add Category Option Template Parsing.
- Add Email Retreiving Emails and Interaction.
- Add Whitelisting for Messages.

### LibreCMS v2.0.2
- Fix Item Count when displaying number of items using <settings items="">
- Fix Content Type when retreiving Content when <settings contenttype="all"> is set.
- Add Category 3 & 4 Parsing and Editing.
- Add i18n Functionality.
- Create i18n Files.
- Add Language Flags.
- Add Timezone Setting.
- Fix Sortable Media breaking other Page Scripts.
- Update TCPDF due to severe vulnerability.
- Fix ARIA Attributes in Administration.
- Add simpleLightbox to view Images in Admin.
- Fix 'robots.txt' output, causing malformed output.
- Fix Select Options not updating in various places in Admin.
- Fix Path finding for any folder location to display Installer.
- Add Server Stats for Developers.
- Fix ARIA Attributes for Default Theme.

### LibreCMS V2.0.1
- Adjust some Administration UI Colours and Layout Adjustments.
- Change Back Button Links in Administration to HTTP_REFERER to actually go back to previous page.
- Fix Breadcrumbs throughout Administration Header areas.
- Add Dropdown Settings selector to access Settings Pages from anywhere in Admin.
- Make Notification & Tint Buttons not display on Mobile.
- Add Postage Options when placing Orders. Including Order Editing Options.
- Add Dropdown to Select Rewards Code if Available in Admin Orders Editing
- Clean up Administration Login Page layout.
- Fix Label and ARIA on Administration Login Page Layout.
- Add manifest.json to Front End and Administration, but NOT Offline Web Apps.
- Fix Meta-Tags for Administration Login Page.
- Fix missing ARIA attributes for the Default Theme.
- Add proper "404 Not Found" header output for error pages.
- Add Slugification for Content that uses (or used) Title to Display Items.
- Fix Media Styling and Media Item Layout and Interaction.
- Add Changelog to Dashboard page.
- Fix Administration Menu Links to not load Front End for slow loading.
- Add Dropdown in Breadcrumb for Editing Content and Pages for Quick Content Navigation.

### LibreCMS V2.0.0
Due to laziness on my part I didn't bother keeping a history of changes to the project. But now with releasing V2.0.0 I want to try and keep a history of changes as they are made to the project.
