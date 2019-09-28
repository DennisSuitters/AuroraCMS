### AuroraCMS v0.0.3
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

### AuroraCMS v0.0.2
- Add test in Administration Header to test if admin.css exists in the theme, and add if it does. This is for the WYSIWYG Editor to make text look the same in the Editor as it does on the Main Site.
- Change Administration Dashboard to only show Stats that have values greater than 0.
- Properly Add Permissions Options.
- Fix Meta-Title from using Old Default (no longer used), now Uses SEO-Title first, then Content Title second, then Auto-Generated from Page Title.
- Add Related Items Processing, Editor, and Option to show related items by Category of Parent Content.
- Fix Administration Search Function, and add Search Button to Header Bar.
- Add Switch to Toggle Visitor Tracking.
- Make sure all links end with /
- Add Description for Profiles and Meta-Description data.

### AuroraCMS v0.0.1
- Rebrand from LibreCMS to AuroraCMS (see https://github.com/DiemenDesign/LibreCMS for previous changes).
- Add Reason to Blacklist (add field to iplist table in database and interface additions).
- Move Settings Links to Menu.
- Add Comments and Reviews Administration Page for quick and easy approval or deletion of items.
- Change LibreICONS to iCONS which contain only used icons with Administration saving file space.
- Change some Administration UI placements. e.g. Settings is now in menu (icon on right).
- Remove MINIFY option due to Minification breaking sites layouts.
- Remove Fingerprint Popups, editing changes can be found in Preferences/Activity for reverting content.
- Add SEO Information and Help.
