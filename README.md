![AuroraCMS](core/images/auroracms.svg)
AuroraCMS the **Free** Australian Open Source [MIT](https://github.com/DiemenDesign/AuroraCMS/blob/master/LICENSE) Content Management System, built primarily for Australian Businesses, built utilising [PHP](http://php.net/), PDO, [jQuery](http://jquery.com/), [Bootstrap](http://getbootstrap.com/), and [iCONS](https://github.com/DiemenDesign/iCONS). Built to take advantage of HTML5 and CSS3, with necessary SEO attributes that fit in with Google's recommendations, Micro-formats, JSON-LD, ARIA (A11Y), and general SEO Markup.

#### Version
We are currently at Version v0.0.14

### FAQ
- Why no Plugins?
  - Anybody who's worked on or developed any kind of Content Mangement System in any Programming Language knows that Plugins are a potential security problem. Plugins are something that because third parties can build them, end up being out of the control of the developer, especially if the Plugin Maker disregards the conventions set by the project.
- Update Cycle.
  - As at the moment there is only one person working on the project, updates are as they get time to do them.

### Features
- Blog Articles, Portfolio's, Bookings, Events, News, Testimonials, Inventory, Services, Gallery, Proofs, Messages, and Newsletters.
- Content Scheduler with Auto Content Publishing.
- Related Content, either Chosen or Category matched.
- Custom Pages.
- Messaging.
  - Whenever a message is created via the Contact Us page, it is stored in the Messages system as well as emailed.
  - Live Chat. Choose between the built in Live Chat, or easily integrate Facebook Messenger.
- Orders.
  - Create Quotes, Invoices. Client viewing of Orders.
  - Send PDF versions of Orders.
  - PayPal Integration for accepting PayPal and Credit Card Payments.
- Media.
  - Upload and manage various types of files for addition into content using elFinder.
- Featured Content.
  - Can use Content Items as Featured Content, or Images and HTML Templates uploaded into the `media/carousel/` folder. Which then will get sorted, and number of items displayed depending on the settings attributes in the `featured.html` template file.
- Accounts.
  - Create Accounts for co-workers with Account Types for:
    - Administrators.
    - Editors (especially good for SEO and Copywriters).
    - Client's.
    - Visitors.
- Client Proofs and Commenting.
- Easy Theme Selector.
  - Themes are built in such a way that changes in Administration are carried over to other themes. However, this will also depend on the features built into the theme selected.
- Front End Theme Engine using HTML Style Markup, the use of any CSS or Javascript Framework.
- Administration uses jQuery, Modified Bootstrap, iCONS, and other jQuery Addons.
- Activity Fingerprint Analysis Logs of Previous Content Changes with Undo, and who made the changes. Examine Content Inputs with Draggable Popover with Undoing.
- Suggestions Editor to allow Administrators and Content Editor to make Editing Suggestions with Reasons, and Click Adding of Suggestions.
- Security.
  - Spam Filter than can Auto Blacklist IP's using custom blacklist text files that can be edited.
  - Project Honey Pot Integration that can Auto Blacklist when check IP's against the httpBL API Service when forms are submitted via visitors.
  - Ability to Add suspicious visitor interactions to Blacklist.
  - 30 Day Auto-Clearance of Blacklisted IP's.
  - Site Block if visitor's IP is listed in Blacklist, saving server resources, and to hopefully stop Spammers or Email Harvester's.
  - Database Backup and ability to Prefix Table Names.
  - Blacklist IP's that try to access WordPress based files or attempt WordPress.
  - Developer "Lock Down", this stops accounts lower than the developer from taking the website out of "maintenance" or "Coming Soon" modes.
- Page and Visitor Tracking for Analytics.
- Progressive Web Application (PWA) Service Worker for Offline Pages.
- GDPR Privacy Notice Compliancy.
  - For those providing Services and or Products to Countries that require Privacy Cookie Consent.
- Website Voice service. Ability to add a text to speech reader for visually impaired visitors.
- Multiple Custom Summernote (WYSIWYG Editor) Addons, created by Diemen Design.
  - [summernote-cleaner](https://github.com/DiemenDesign/summernote-cleaner)
  - [summernote-findnreplace](https://github.com/DiemenDesign/summernote-text-findnreplace)
  - [summernote-image-attributes](https://github.com/DiemenDesign/summernote-image-attributes)
  - [summernote-image-captionit](https://github.com/DiemenDesign/summernote-image-captionit)
  - [summernote-image-shapes](https://github.com/DiemenDesign/summernote-image-shapes)
  - [summernote-save-button](https://github.com/DiemenDesign/summernote-save-button)
  - [summernote-seo](https://github.com/DiemenDesign/summernote-seo)
  - [summernote-video-attributes](https://github.com/DiemenDesign/summernote-video-attributes)

You can get themes from our Themes GitHub Repository @ [AuroraCMS-Themes](https://github.com/DiemenDesign/AuroraCMS-themes)

### Dependencies
- PHP > 7.0 - Must have PDO, and Password Compat support. If you have tried AuroraCMS with a higher version, please report your experiences.
- Works with PHP 7+. Please make sure PHP Libraries are installed before reporting Issues.
- mod_rewrite or rewrite.
- GD-Image & Imagemagick- AuroraCMS will work without them, but things like Order PDF Viewing, Thumbnails, and image resizing won't work.
- mail services - Are needed for mail notification sending, Orders Sending and for the Newsletters.

#### Integrated Projects:
- [iCONS](https://github.com/DiemenDesign/iCONS)
- [Summernote](https://github.com/summernote/summernote)
  - [summernote-cleaner](https://github.com/DiemenDesign/summernote-cleaner)
  - [summernote-findnreplace](https://github.com/DiemenDesign/summernote-text-findnreplace)
  - [summernote-image-attributes](https://github.com/DiemenDesign/summernote-image-attributes)
  - [summernote-image-captionit](https://github.com/DiemenDesign/summernote-image-captionit)
  - [summernote-image-shapes](https://github.com/DiemenDesign/summernote-image-shapes)
  - [summernote-save-button](https://github.com/DiemenDesign/summernote-save-button)
  - [summernote-seo](https://github.com/DiemenDesign/summernote-seo)
  - [summernote-video-attributes](https://github.com/DiemenDesign/summernote-video-attributes)
  - [summernote-ext-elfinder](https://github.com/semplon/summernote-ext-elfinder)
  - [summernote-libreICONS-svg](https://github.com/DiemenDesign/LibreICONS/tree/master/themes/summernote)
- [CodeMirror](https://github.com/codemirror/CodeMirror)
- [FullCalendar](https://github.com/fullcalendar/fullcalendar)
  - fullcalendar-bootstrap-theme (Unreleased, but within AuroraCMS, WIP)
- [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [TCPDF](http://www.tcpdf.org/)
- [Zebra_Image](https://github.com/stefangabos/Zebra_Image)
- [kses](https://github.com/RichardVasquez/kses)
- [elFinder](https://github.com/Studio-42/elFinder)
  - [elFinder-bootstrap-theme](https://github.com/DiemenDesign/LibreICONS/tree/master/themes/elFinder)

### Tested on:
- CentOS Linux 7.2.1511 with Webmin 1.791
- Ubuntu Linux 14.04 + Apache v2.4.7 + PHP v5.6-7.3 + MySQL v5.5.37
- Linux Mint Ubuntu Edition Apache 2.4.7 + PHP v5.6-7+ & MySQL v5.5.37
- Linux Mint Debian Edition Apache 2.4.7 + PHP v5.6-7+ & MySQL v5.5.37
- Debian 7 + nGinx + PHP 5.5-7.3 + MySQL
- Windows 7 + WAMP + PHP 5.5 + MySQL

### TODO:
- Add Content to the Wiki Pages on how to use AuroraCMS and how to create Templates.
- Add Instructional [Videos to the AuroraCMS YouTube Channel](https://www.youtube.com/channel/UC9vFbrBKmnSgf8TNUBvDX2Q).
- Create Free Templates.
- Testing, and Bug Squashing, as per the usual with ongoing projects.

### LEGAL:
By downloading AuroraCMS you hereby agree not to hold Diemen Design liable for any damages that your usage of AuroraCMS may cause to your system, or persons. Damages may infer such things as Data Loss, Aural or Visual Impairment, Server Crashes, Alien Abduction, Coding nightmare's, Alien Implants, or Visiting Alternate Realities. AuroraCMS is Licensed under [MIT](https://github.com/DiemenDesign/AuroraCMS/blob/master/LICENSE). We request that if you modify, and hopefully enhance AuroraCMS, that you take part in maintaining, and contributing to it's code base here at GitHub.

### Contributors:
- [Raycraft Computer Services](https://www.raycraft.com.au/)
  - Live Testing, Suggestions, and witty Banter.

### AuroraCMS Live Sites by Diemen Design:
- [AAA Earthworx](https://www.aaaearthworx.com.au/)
- [Anime Excess](https://www.animeexcess.com.au/)
- [BizzyKnits](https://www.bizzyknits.biz/)
- [Corner Life Coach](https://corner.net.au/)
- [Diemen Design](https://diemen.design/)
- [Fast Track Business Club](https://www.fasttrackbusinessclub.com.au/)
- [Happy Valley Goat Farm](https://happyvalleygoat.farm/)
- [Hays Computer World](https://hayscomputerworld.com.au/)
- [K9FineDining](https://k9finedining.com/)
- [Live Lightly Centre](https://www.livelightlycentre.com.au/)
- [Lovely Gardens](https://www.lovelygardens.com.au/)
- [Powerline Automotive Services](https://www.powerlineauto.com.au/)
- [Raycraft Computer Services](https://www.raycraft.com.au/)
- [Raycraft Entertainment](https://www.entertainme.net.au/)
