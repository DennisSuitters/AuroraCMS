### v0.2.24
- Fix style variables that were missing, and make improvements.
- Improve visibilty and functionality of quiededit/quickview content dropdowns.
- Improve Gallery & Content Media items, can now view thumbnails via click replacement of main image, or use modal viewer.
- Add Jumpbar for content lists to quickly find content alphabetically.
- Fix the content category navigation menu not display all categories.
- Fix Banners not being displayed if Heading is empty.
- Adjust content type display for content and dropdown content selection in Administration.
- Add ability to add listed items to Articles.
  - Quickview on front end for cyclying through list.
- Fix display and responsivness for quickview products.
- Fix display layout of Messages in Administration.
- Add feature to add login background images.
- Update jQuery for Administration.
- Adjust Administration styling for better visuals.
- Update Summernote-Cleaner.
- Improve Livechat Administration interface, add a filter field for finding chats.

#### v0.2.23
- Update Summernote, fix Summernote plugins.
- Add multiline editing to some text inputs.
- Add FileRobot Image Editor in a dropdown section where images are added to content.
- Make sure edited images are saved in their appropriate folders.
- Fix Light & Dark styling for FileRobot Image Editing.
- Add Search for Images via Unsplash.com.
- Fix checkbox toggling.
- Add duplicate title check for content and pages.
- Change Country Flag lookup to Emoji's, reducing footprint.
- Adjust Dashboard widgets to resize and remember size depending on different screen widths to differentriate between SM, MD, LG, XL and XXL.
- Adjust administration menu to not completely disappear, and to not save it's state on mobile devices.
- Fix permissions for accounts to correctly respond to settings.
- Change content items images to link to content to edit/view rather than open in lightbox.
- Fix Calendar not rendering correctly when switch between table and calendar views.
- Adjust weather widget columns to collapse correctly when viewed on mobile devices.
- Remove Ladda, reducing CSS and Javascript footprint.
- Improve Page Blocking and update animation.
- Sort CSS Styles removing duplicates and unused declarations.
- Fix Save All to now save text editor contents.
- Fix Event/News side area display showing out of date and events from incorrect account levels.
- Fix Quickview Products now showing information, and allow multiple product viewing.

#### v0.2.22
- Retheme primary Administration Interface.
- Fix Summernote Editor custom plugin button sizes to fit in better with default toolbar buttons.
- Fix filename renaming for media uploads, emailed links were creating encoded entities making files seem unavailable due to filename mismatch.
- Fix SEO Errors not showing correct number of errors.
- Add Orders listing to Accounts, incl. item purchases in quick dropdown.
- Add missing content types to templates administration page.
- Modify database fields for large text to LongBlob to allow multi-byte storage.
- Improve the database connection to use UTF8MB4_unicode_ci, this allows using Unicode Glyphs when storing data.
- Add database encoding check to ensure the database used was created using UTF8MB4_unicode_ci encoding.

#### v0.2.21
- Adjust SEO Error reporting for some Content Types.
- Fix missing padding on page seetings tab.
- Make changes to elFinder to allow upload WebP and AV1F images.
- Adjust SQL selection and metaRobots of page and content items appearance in Sitemaps.
- Fix thumbnail src image reference.
- Update robots.txt to exclude .php files within media/ folder.
- Fix Stock Status JSON+LD values not parsing correctly.
- Fix sameAs JSON+LD Organization Schema.
- Create new SQL table & sales cell in content table to record monthly sales.
- Add Sales statistics graph to dashboard.
- Fix border style for total display on orders.

#### v0.2.20
- Fix Canonical URL for pages.
- Adjust page parser to include elements encoded with entities.
- Fix Product Schema missing comma and priceValidUntil.
- Improve CSS Styling.
- Add SEO Warnings for various content with highlights.
- Fix some styling in Administration.
- Allow all Reviews to display in Administration Reviews Page.
- Add Template Parser and Administration Editing for Advertisements.
- Add Impressions Count.
- Add Click Count.
- Add Cost for monetising Advertisements.
- Add Date restriction for start and end of Impressions.
