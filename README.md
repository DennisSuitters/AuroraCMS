# AuroraCMS - The Free Australian Content Management System

AuroraCMS the **Free** Australian Open Source [MIT](https://github.com/DiemenDesign/AuroraCMS/blob/master/LICENSE) licensed Content Management System, built primarily for Australian Businesses, built utilising [PHP](http://php.net/), PDO, [jQuery](http://jquery.com/) and [iCONS](https://github.com/DiemenDesign/iCONS). Built to take advantage of HTML5 and CSS3, with necessary SEO attributes that fit in with Google's recommendations, Micro-formats, JSON-LD, ARIA (A11Y), and general SEO Markup.

Current version is v0.2.26-4

### Features
- AuroraCMS is a Quasi-MVC, Front End is completely MVC, with some AJAX Functions for Form Processing.
- Accessibility (A11Y) Widget that can be enabled to allow site visitors to change settings to allow those with disabilities to use the website more easily, and to adhere to the Australian Accessibility Law.
- Hosting and Site Payments for Developers.
  - When setup, Hosting and Site Payment notifications are displayed on the Dashboard of Client Sites.
    - Show Status of Hosting Payments, Overdue by days which has an alert animation to attract attention, Outstanding due date, Paid with number of days.
    - Show Status of Site Payment as Site is paid off.
- Forms
  - Editable minimum and maximum times to submit forms. (Too Fast, is possible Bot Submission).
  - Hidden Captcha taking Screen Reader user's into account, so they don't get trapped.
  - Optional Google reCaptcha v2 for Forms.
  - Form Filtering for Blacklisted editable text lists.
  - Project Honey Pot Blacklist IP Filtering.
- No Plugins. AuroraCMS does use some Third Party Script's, that are security vetted.
- Business Hours Editor.
- Content Scheduler with Auto Content Publishing.
- Related Content, either Chosen or Category matched.
- FOMO Notifications.
  - Limit different content types to Australian State area.
  - Choose differents per contentType.
- Custom Pages.
- Content Types with pages, and individual item pages.
  - Activities
  - Articles
    - Add lists of items in Articles with images that can be opened in quickview and cycled through including the description.
  - Portfolio
  - Events.
    - Book Events and Invoice for immediate payment.
    - Option to display Countdown Clock for when Event Starts.
    - Display Events on Home Page.
  - News.
    - Display News on Home Page.
  - Testimonials.
    - Approval before public display.
  - Inventory.
    - Quick View Option for Inventory.
    - Product Reviews and Approval before public display.
    - Assign Points to Items, that get added to user's Earned Points.
    - Expenses per Inventory item.
      - Add Expense items.
      - Button when editing inventiry to help calculate sales price.
    - Restrict Wholesale Items to Wholesale Account per Level.
    - Sales Content.
      - Editable Sales periods with date selecting for custom Sale Periods.
      - Front End parsing for Sales periods to promote items set with Sale periods for sales promotion.
    - Download available directly from page when Order required isn't set.
      - Option that file/s only available via Invoice, and time limit.
      - Download link sent via Invoice when Invoice is Paid.
      - File Download options for electronic products, such as documents, ebooks.
    - Link/s to other services or content.
      - Option that Link/s only available via Invoice, and time limit.
      - Link/s sent via Invoice when Invoice is Paid.
  - Newsletters.
  - Proofs.
    - User accessible area.
  - Services.
- FAQ's.
- Gallery.
- Client Proofs.
- Messages.
- Bookings.
  - Convert booking to invoice.
  - Print booking.
  - Signature taking and storage for confirmation of Services.
- Messaging.
  - Whenever a message is created via the Contact Us page, it can be stored in the messages system as well as emailed.
  - Live Chat. Choose between the built in Live Chat, or easily integrate Facebook Messenger.
- Orders.
  - Create quotes, invoices. Client viewing of Orders.
  - PayPal Integration for Accepting PayPal and Credit Card Payments.
  - Stripe Integration for Accepting Credit Card Payments (includes enabling AfterPay).
  - Australia Post API Integration for Calculating Postage Costs.
  - Deduction rows to allow multiple payments showing date of payment, editable title, amount, and total left owing.
  - Rewards with percentage or value off, date period available, quantity usage.
  - Discount Range Calculation depending on Account Expenditure.
  - GST Calculating.
  - Payment Options with Surcharge options.
  - Create New Quote/Invoice from selected items.
- TODO/Joblist in a Kanban board.
- Forum
  - Post, Reply as per other Forums.
  - Integrated Help Tickets as Forum Posts.
  - Upvote or Downvote posts and comments.
- Course Management.
  - Add/Edit Courses.
    - Add Multiple-Choice Questions.
    - Add Multiple Questions, with Answer Entry.
  - Track User Progression.
  - Display available courses, with online Payments.
  - Display Paid Courses when User is logged in, including Current Progression.
- Banner Notifications with Entrance Animation choice. Dissmissable with local storage variable.
- Media.
  - Upload and manage various types of files for addition into content using elFinder.
  - Auto resizing, makes thumbnails and Large, Medium and Small versions of images for use with srcset.
  - Browse Unsplash Free Photo's to adding to content.
  - FileRobot Image editing in page.
- Featured Content.
  - Can use Content Items as Featured Content, or Images and HTML Templates uploaded into the `media/carousel/` folder. Which then will get sorted, and number of items displayed depending on the settings attributes in the `featured.html` template file.
- Accounts.
  - Create Accounts for co-workers with Account Types for:
    - Administrators.
    - Editors (especially good for SEO and Copywriters).
    - Client's.
    - Members with Silver/Bronze/Gold/Platinum
      - Default and Account editable purchasing limits.
    - Visitors.
    - Wholesalers with Silver/Bronze/Gold/Platinum
      - Default and Account editable purchasing limits.
      - Approval of Wholesaler Purchasing.
      - Time limited purchasing, disables purchasing if purchases are not made inside maximum time limit (this encourages Wholesalers to continue purchasing).
- Easy Theme Selector.
  - Themes are built in such a way that changes in Administration are carried over to other themes. However, this will also depend on the features built into the theme selected.
- Front End Theme Engine using HTML Style Markup, the use of any CSS or JavaScript Framework.
- Administration uses jQuery, iCONS, and other jQuery Addons.
- Activity Fingerprint Analysis Logs of Previous Content Changes with Undo, and who made the changes. Examine Content Inputs with Draggable Popover with Undoing.
- Suggestions Editor to allow Administrators and Content Editor to make Editing Suggestions with Reasons, and Click Adding of Suggestions.
- SEO Information.
  - Informational Popups for important items for client's to learn SEO.
- Security.
  - Spam Filter than can Auto Blacklist IP's using custom blacklist text files that can be edited.
  - Project Honey Pot Integration that can Auto Blacklist when check IP's against the httpBL API Service when forms are submitted via visitors.
  - Ability to Add suspicious visitor interactions to Blacklist.
  - 30 Day Auto-Clearance of Blacklisted IP's.
  - Site Block if visitor's IP is listed in Blacklist, saving server resources, and to hopefully stop Spammers or Email Harvester's.
  - Database Backup and ability to Prefix Table Names.
  - Blacklist IP's that try to access WordPress based files or attempt WordPress Access.
  - Developer "Lock Down", this stops accounts lower than the developer from taking the website out of "maintenance" or "Coming Soon" modes.
- Page and Visitor Tracking for Analytics.
  - Records visit counts per IP, stores IP and Browser Information, with option of clearing data.
- Progressive Web Application (PWA) Service Worker for Offline Pages.
- GDPR Privacy Notice Compliance.
  - For those providing Services and or Products to Countries that require Privacy Cookie Consent.
- Open Street Maps via the Leaflet JavaScript library.
  - Address location Map can be displayed on Home Page, Contact Us, and Event Items.
- Dashboard Widgets, that can be enabled/disabled, resized, and repositioned.
  - AuroraCMS Updates, changelog of the CMS updates.
  - Browsers, browsers count used to access website.
  - Devices, devices count used to access website.
  - Recent Admin Activity
  - Referrers, popular referrers, such as Google, Duck Duck Go, and other popular places.
  - Sale Content, uses current date to determine known Australian popular Sales periods, and selects Inventory that was published at the same time on previous year minus 1 month.
  - SEO links, links to resources to learn SEO for DIY.
  - SEO Unsolicited Tips, Unsolicited tips from Candour on LinkedIn.
  - Top Keywords, search keywords used via the front end search (on site search, not from Search Engines).
  - Viewed pages, top ten viewed pages, and their view count.
  - Visitor Stats, some visitors stats, like new bookings, orders, calls when clicking linked phone numbers.
  - Weather, takes Longitude and Latitude values from Map Position to find weather for that area (usually business location), if not set, tries to get approximate location via Browser Connection Information.
- Content Widgets, that can be enabled/disabled.
  - Text Analysis, uses the Hemmingway Javascript implementation to analyse text and gives ratings.
  - SEO Content Help, links to handy tools for writing content, or to get inspiration.
- Advertisements.
  - Home page for Horizontal Banners, Side Menu for Vertical Banners.
  - Add Cost so Advertisements can be monetised and added to Orders.
  - Count Impressions of times Advertisement has been displayed.
  - Count Clicks.
  - Date restriction for start displaying advertisements, and end date.
- Agronomy for managing Farms.
  - Area map plotting for managing pasture/paddock areas.
  - Livestock management, incl. selecting which area they are currently in.
  - Cropping for crop management, incl. whole paddock area cropping as well as small plots.
  - Logging for area, livestock and crop history. (WIP)
- Multiple Custom Summernote (WYSIWYG Editor) Addons, created by Diemen Design.
  - [summernote-audio](https://github.com/DiemenDesign/summernote-audio)
  - [summernote-checkbox](https://github.com/DiemenDesign/summernote-checkbox)
  - [summernote-classes](https://github.com/DiemenDesign/summernote-classes)
  - [summernote-cleaner](https://github.com/DiemenDesign/summernote-cleaner)
  - [summernote-ext-elfinder](https://github.com/semplon/summernote-ext-elfinder)
  - [summernote-image-captionit](https://github.com/DiemenDesign/summernote-image-captionit)
  - [summernote-image-shapes](https://github.com/DiemenDesign/summernote-image-shapes)
  - [summernote-save-button](https://github.com/DiemenDesign/summernote-save-button)
  - [summernote-text-findnreplace](https://github.com/DiemenDesign/summernote-text-findnreplace)
  - [summernote-video-attributes](https://github.com/DiemenDesign/summernote-video-attributes)

You can get themes from our Themes GitHub Repository @ [AuroraCMS-Themes](https://github.com/DiemenDesign/AuroraCMS-themes)

### Dependencies
- PHP > 7.0 - Must have PDO, and Password Compat support. If you have tried AuroraCMS with a higher version, please report your experiences.
- Works with PHP 7+. Please make sure PHP Libraries are installed before reporting Issues.
- Works with PHP 8+. Please make sure PHP Libraries are installed before reporting Issues.
- mod_rewrite or rewrite.
- mbstring.
- xml functions.
- GD-Image & Imagemagick- AuroraCMS will work without them, but things like Order PDF Viewing, Thumbnails, and image resizing won't work.
- mail services - Are needed for mail notification sending, Orders Sending and for the Newsletters.

#### Integrated Projects:
- [iCONS](https://github.com/DiemenDesign/iCONS)
- [Summernote](https://github.com/summernote/summernote) Skunkworks Version (In Development)
  - [summernote-audio](https://github.com/DiemenDesign/summernote-audio)
  - [summernote-checkbox](https://github.com/DiemenDesign/summernote-checkbox)
  - [summernote-classes](https://github.com/DiemenDesign/summernote-classes)
  - [summernote-cleaner](https://github.com/DiemenDesign/summernote-cleaner)
  - [summernote-ext-elfinder](https://github.com/semplon/summernote-ext-elfinder)
  - [summernote-image-captionit](https://github.com/DiemenDesign/summernote-image-captionit)
  - [summernote-image-shapes](https://github.com/DiemenDesign/summernote-image-shapes)
  - [summernote-save-button](https://github.com/DiemenDesign/summernote-save-button)
  - [summernote-text-findnreplace](https://github.com/DiemenDesign/summernote-text-findnreplace)
  - [summernote-video-attributes](https://github.com/DiemenDesign/summernote-video-attributes)
- [CodeMirror](https://github.com/codemirror/CodeMirror)
- [FullCalendar](https://github.com/fullcalendar/fullcalendar)
- [PHPMailer](https://github.com/PHPMailer/PHPMailer)
- [Zebra_Image](https://github.com/stefangabos/Zebra_Image)
- [kses](https://github.com/RichardVasquez/kses)
- [elFinder](https://github.com/Studio-42/elFinder)
- [FileRobot Image Editor](https://github.com/scaleflex/filerobot-image-editor)

### Tested on:
- CentOS Linux 8.2 with Webmin 2.101
- Ubuntu Linux 14.04 + Apache v2.4.57 + PHP v8.1 + MySQL v8.1.23
- Linux Mint Ubuntu Edition Apache 2.4.57 + PHP v8.1+ & MySQL v8.1.23
- Linux Mint Debian Edition Apache 2.4.57 + PHP v8.1+ & MySQL v8.1.23
- Debian 7 + nGinx + PHP 8.1 + MySQL v8.1.23
- Windows 7 + WAMP + PHP 8 + MySQL

### TODO:
Consult the everchanging [TODO](https://github.com/DiemenDesign/AuroraCMS/blob/master/TODO.md) file.

### LEGAL:
By downloading AuroraCMS you hereby agree not to hold Diemen Design liable for any damages that your usage of AuroraCMS may cause to your system, or persons. Damages may infer such things as Data Loss, Aural or Visual Impairment, Server Crashes, Alien Abduction, Coding nightmare's, Alien Implants, or Visiting Alternate Realities. AuroraCMS is Licensed under [MIT](https://github.com/DiemenDesign/AuroraCMS/blob/master/LICENSE). We request that if you modify, and hopefully enhance AuroraCMS, that you take part in maintaining, and contributing to it's code base here at GitHub.

### Contributors:
- [Raycraft Computer Services](https://www.raycraft.com.au/)
  - Live Testing, Suggestions, and witty Banter.
- GitHub User [Digifolder](https://github.com/Digifolder)
  - Windows Testing, bug finding and reporting.
- GitHub User [CoffeeQuotes](https://github.com/CoffeeQuotes)
  - Found and fixed spelling errors.

### AuroraCMS Live Sites by Diemen Design:
- [BizzyKnits](https://bizzyknits.biz/)
- [Corner Life Coach](https://corner.net.au/)
- [Cradle Mountain Fishery and Camping](https://cradlemountainfisheryandcamping.com.au/)
- [Diemen Design](https://diemendesign.com.au/)
- [EntertainMe](https://entertainme.net.au/)
- [Fast Track Business Club](https://www.fasttrackbusinessclub.com.au/)
- [Happy Valley Free Rang Farm](https://happyvalleyfarm.com.au/)
- [Hays Technologies](https://haystechnologies.com.au/)
- [Live Lightly Centre](https://livelightlycentre.com.au/)
- [Lone Wolf Anime](https://lonewolfanime.com.au/)
- [Raycraft Computer Services](https://www.raycraft.com.au/)
