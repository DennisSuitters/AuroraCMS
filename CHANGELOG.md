### v0.0.16
- Add adding Brands (URL and Image) to Content Settings, so a Brand can be added for display when viewing content items.
- Add selecting Brand in Content Editing.
- Add Weight, Size and Branding parsing to Side Area and Content.
- Add Condition to Content Options.
- Add Sold field to database, calculation and storage.
- Add parsing and processing for Sort Form selection.

##### v0.0.15
- Enable CodeMirror to work with Summernote Codeview.
- Add styling to indicate unnecessary H1 Headers in Editor.
- Refactor CSS to reduce footprint size.
- Add Display Block Elements in Editor Button.
- Add Check to Current Item in Dropdown.
- Update Summernote WYSIWYG to our development version.
- Add Summernote Plugin Classes, and adjust theme.ini to include custom classes.
- Add Star Rating parser to Testimonials.
- Add SEO Pre-Publish Checklist.
- Add Add Content Button next to back button for quickly adding next content item.
- Fix incorrect column name /core/view/orders.php line 182
- Fix truncating file extensions for 3 or 4 character length extensions.
- Fix Check for Reduced Cost against Cost.
- Add Preferences Cart page for clearing or removing cart items.
- Add Media Edit page.
- Add Edit Media button to media items.
- Fix Adding Postage Options.
- Add GST Calculation, Options and Template Parser.
- Fix Linking to PayPal for Online Payments.
- Fix Account Creation Errors, Timezone and Options.
- Remove System Utilization from Side Menu, add to Dashboard.
- Fix Typo's in Chat Script.

##### v0.0.14
- Fix elFinder not adding files to single fields.
- Remove Views from "Coming Soon" and "Maintenance" pages.
- Fix Index/Home page not showing Category images.
- Create default-mvp theme based on mvp.css the classless CSS Framework.
- Fix incorrect number of Testimonials being displayed dependant on <settings items="#">
- Adjust Template Category select to allow selecting up to 4 different categories.
- Fix displaying just Categories when using Shop by Category.

##### v0.0.13
- Add X-Clacks Silent Attribute Header, Add you site to the list: https://xclacksoverhead.org/dearheart/review
- Add Lorem Generator for Administrators.
- Fix Scheduler breaking on Quotes in Titles.
- Fix wrong hidden class on Orders items in Administration.
- Fix width issues with Default Theme on Mobile.
- Update Summernote WYSIWYG Editor to v0.8.16

##### v0.0.12
- Fix showing stock status.
- Fix Save Button for Image and Thumbnail selection not showing unsaved changes.
- Add option to Enable Panoramic Photo's.
- Fix Multiple Media Adding.
- Remove Front End Editing in preperation of multi-site single Administration.
- Fix Parser not correctly parsing some content elements.

##### v0.0.11
- Adjust administration avatar styling to reflect account type when logged in.
- Continue to prepare for PHP7.4 compatibility. Remove {} in favour [].
- Set permissions per account of what is allowed in media manager.
- Fix elFinder dialog buttons to be more consistent with other dialogs.
- Fix elFinder multi-menu styling.
- Fix administration rewards page Date/Time picker.
- Fix initial number of notifications displayed in title on page load.
- Fix administration navigation stats.
- Add Define VERSION constant.
- Fix formatting of password reset email layouts.
- Update PHPMailer and fix references and interaction to use new version.
- Fix unlogged in users accessing Settings page.
- Add Password remove Page Block, and reset Password Update button colour.
- Add login.html parsing to display Terms of Service in Modal.
- Add logged in info alert.
- Fix all themes form layouts and ajax processing to a single ajax method and feedback.
- Add check for Nonexistent user emails when display Comments in Administration.
- Remove unneeded URL forward slash for extra pages in menu.
- Add parsing for Inventory Item status.

##### v0.0.10
- Fix Administration Service Worker not displaying Offline Page.
- Add Markdown Parsing for prettier, easier to read CHANGELOG.
- Prepare for PHP7.4 Compatibility. Remove {} in favour [].
- Add PHP Version to Developer Display and move to the top of the page.
- Add Developer Information to Administration.
- Fix Logo Width overriding other header items in Administration.
- Fix typos and missing SQL Fields in add_testimonial.php file.
- Relabel "Screen against WordPress Attacks" to "Screen Against Attacks".
- Update Summernote WYSIWYG Editor to v0.8.14
- Move other platform security checks so they only check when enabled.

##### v0.0.9
- Complete PayPal transaction order updating.
- Fix service-worker not referencing Logo correctly.
- Fix incorrect ID for input's.

##### v0.0.8
- Fix SQL error when creating a Developer Account in Install.
- Fix missing SQL prefix from SQL Query at line 326.
- Add Offline Progressive Web Application (PWA) for Front End and Administration.
- Add parser to Featured Items for item counting.
- Add PayPal Payment Options.

##### v0.0.7
- Fix Width Formatting for better responsiveness.
- Add Development Tools to assist with Theme Development.
- Add Website Voice service.
- Fix Stock Status Display.
- Add Parsing for RRP (Recommended Retail Price) and Reduced Cost Prices.
- Add Options to Lock Down Site for Developer Accounts (handy for non-paying clients).
- Fix old CMS references.

##### v0.0.6
- Fix reference to jQuery on Login page being wrong.
- Remove missed Pace Artifacts which were causing script errors.
- Add GDPR Banner Optional Display.
- Add features to LiveChat, email enable admin users, show status of new chat messages.
- Adjust Admin Bootstrap Tabs styling.

##### v0.0.5
- Add Chat Widget. With option to use built-in Chat or Facebook Messenger.
- Remove Pace.
- Add check if User Agent isn't set, or User Agent is Google Speed Insight and don't render Google Analytics Code if us. This helps when Google is testing as Google Analytics slows page loading.

##### v0.0.4
- Fix Installer Account Creation SQL.
- Add Timezone Option to Installer Page.
- Adjust SQL for Related Items so only Published Content is selected.
- Add Front End Editing.
- Add Sessions Var Options for User Permissions.
- Fix Tracking Acquisition.
- Fix Administration Tooltips to stop interfering with Popovers.

##### v0.0.3
- Add AutoPublish Options.
- Fix Scheduler actions.
- Add content processing for Coming Soon and Maintenance pages. Both "Coming Soon" and "Maintenance" pages can be edited like other pages, including SEO information.
- Stop pages that only show up when logged in from showing up in sitemap.xml
- Remove unnecessary language files to reduce file space.
- Change Pages Views to show Actual Page and Content Views on Dashboard.
- Add Toggle to Enable Administration Activity Tracking.
- Change position of Toggles and Descriptions for better formatting in Preferences/Interface.
- Add Forgotten Google Analytics tracking script to Coming Soon and Maintenance view parser.
- Fix listing all pages when site is in Coming Soon or Maintenance modes.
- Add Check if shareImage is no image and replace with FavIcon.
- Fix Image for JSON-LD Schema to fall back to Favicon.

##### v0.0.2
- Add test in Administration Header to test if admin.css exists in the theme, and add if it does. This is for the WYSIWYG Editor to make text look the same in the Editor as it does on the Main Site.
- Change Administration Dashboard to only show Stats that have values greater than 0.
- Properly Add Permissions Options.
- Fix Meta-Title from using Old Default (no longer used), now Uses SEO-Title first, then Content Title second, then Auto-Generated from Page Title.
- Add Related Items Processing, Editor, and Option to show related items by Category of Parent Content.
- Fix Administration Search Function, and add Search Button to Header Bar.
- Add Switch to Toggle Visitor Tracking.
- Make sure all links end with /
- Add Description for Profiles and Meta-Description data.

##### v0.0.1
- Rebrand from LibreCMS to AuroraCMS (see https://github.com/DiemenDesign/LibreCMS for previous changes).
- Add Reason to Blacklist (add field to iplist table in database and interface additions).
- Move Settings Links to Menu.
- Add Comments and Reviews Administration Page for quick and easy approval or deletion of items.
- Change LibreICONS to iCONS which contain only used icons with Administration saving file space.
- Change some Administration UI placements. e.g. Settings is now in menu (icon on right).
- Remove MINIFY option due to Minification breaking sites layouts.
- Remove Fingerprint Popups, editing changes can be found in Preferences/Activity for reverting content.
- Add SEO Information and Help.
