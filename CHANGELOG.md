### v0.1.0
- Deprecate and remove Bootstrap in favour of {stylesheet}.
- Fix Breadcrumb JSON-LD Schema producing parsing errors.
- Add Seasonal changes to Login and Administration Header.
- Fix HTML Attributes Order for consistency, which also allowed fixing missed classes when deprecating Bootstrap.
- Fix issue with categories where any category was only characters the parser would think it was for a year date value and throw errors crashing the whole site, adding a check that the value is numeric fixed the issue.
