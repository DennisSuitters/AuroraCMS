### v0.2.22
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
