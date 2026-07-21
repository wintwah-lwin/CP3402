# Learning Journal Entry — Prac 05: WordPress Child Themes

## Learning Activities & Resources
  * [WordPress Developer Docs: Child Themes](https://developer.wordpress.org/themes/advanced-topics/child-themes/)
  * [WordPress Developer Docs: wp_enqueue_style Reference](https://developer.wordpress.org/reference/functions/wp_enqueue_style/)
  * [How to Create a WordPress Child Theme](https://www.youtube.com/watch?v=coLDoM1fQcc)

---

## Estimated Hours of Explicit Learning Activity
* Around 3+ hours

---

## Content Insights
* Creating a child theme creates new custom logic for the design while keeping updates from the parent theme.
* A child theme requires a `style.css` file with a standard header comment containing the `Template:` field, which must match the exact directory folder name of the parent theme (e.g., `Template: fresh-blog-lite`).
* Enqueueing stylesheets in `functions.php` via the `wp_enqueue_scripts` action hook and `wp_enqueue_style()` manages stylesheet dependencies efficiently without using legacy CSS `@import` rules.
* WordPress enforces a strict two-tier theme hierarchy (parent and child) and does not support grandchild themes.

---

## Career/Employability/Learning Insights
* Troubleshooting the initial invalid parent theme error reinforced the habit of reading official developer documentation first rather than relying solely on trial-and-error debugging.
* Understanding theme customization and PHP action hooks aligns directly with key requirements for junior frontend roles, where modifying pre-existing themes are used.
* Working with child themes highlights the principle of keeping custom code isolated from third-party vendor code to build maintainable systems.