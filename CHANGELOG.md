### v0.0.7
- Fix Width Formatting for better responsiveness.
- Add Development Tools to assist with Theme Development.
- Add Website Voice service.
- Fix Stock Status Display.
- Add Parsing for RRP (Recommended Retail Price) and Reduced Cost Prices.
- Add Options to Lock Down Site for Developer Accounts (handy for non-paying clients).
- Fix old CMS references.

### v0.0.6
- Fix reference to jQuery on Login page being wrong.
- Remove missed Pace Artifacts which were causing script errors.
- Add GDPR Banner Optional Display.
- Add features to LiveChat, email enable admin users, show status of new chat messages.
- Adjust Admin Bootstrap Tabs styling.

### AuroraCMS v0.0.5
- Add Chat Widget. With option to use built-in Chat or Facebook Messenger.
- Remove Pace.
- Add check if User Agent isn't set, or User Agent is Google Speed Insight and don't render Google Analytics Code if us. This helps when Google is testing as Google Analytics slows page loading.

### AuroraCMS v0.0.4
- Fix Installer Account Creation SQL.
- Add Timezone Option to Installer Page.
- Adjust SQL for Related Items so only Published Content is selected.
- Add Front End Editing.
- Add Sessions Var Options for User Permissions.
- Fix Tracking Acquisition.
- Fix Administration Tooltips to stop interfering with Popovers.

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