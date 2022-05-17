### v0.2.9
- Fix wrong thumbnail reference in YouTube JSON response when adding playlist items.
- Adjust date and inventory selection for suggested sale period suggestions.
- Change how versioning is done with patch releases, releases and full frozen versions. Consult [CONTRIBUTING.md](https://github.com/DiemenDesign/AuroraCMS/blob/master/CONTRIBUTING.md) for more information.

#### v0.2.10
- Reduce file access times and latency by combining icons for Administration and Front End into Separate Font files, and combining them directly into the icons stylesheets.
- Improve icons stylesheets, removing unnecessary style declarations.

#### v0.2.11
- Fix Author Social Buttons.
- Modify Events display in Administration to display order based on Start Date of Event in descending order first, then Created Date if the Start Date isn't set.

#### v0.2.12
- Adjust area under footer so it is less obtrusive on the main design.
- Remove HTMLPurifer from front end page processing, as we are already sanitising text input for safe output before database insertion. No point in doing it twice, which helps speed up site rendering.
- Adjust Administration Favicon to use Favicon from theme.
- Restyle Administration area, making it easier to use, and visually improved. Now uses less Styling.
- Fix Descending order for widget referrers.
- Add ctrl+s SaveAll keyboard shortcut, this override's the browser default, but makes it much more user friendly for user's.
- Fix Admin Activity Page not clearing entries.
- Fix Admin Side Menu not showing correct active page.
