# Week 07 Learning Journal

### Learning Activities & Resources

* Using Echo, Decisions, Repetition, Functions, Include, etc.
* Refactoring existing Practical 04 Trivia Quiz web application to include such structures.
* Reviewing official PHP documentation on include/require statements, session management, and control structures:
  * https://www.php.net/manual/en/function.include.php
  * https://www.php.net/manual/en/language.control-structures.php
  * https://www.php.net/manual/en/language.functions.php

---

### Estimated hours of Explicit Learning Activity

Around 6+ hours

---

### Content Insights

* Using `include` or `require_once` for common elements like headers and footers significantly reduces code duplication (DRY principle). Changes made to `header.php` or `footer.php` automatically update across all pages on the site. No need to copy paste often.
* Using `if/else` statements enables conditional views, such as showing different UI layouts for logged-in users versus guest users.
* `while` loops are ideal for fetching rows from database query results, `foreach` loops excel at iterating through arrays, and `for` loops are effective for precise numeric iterations (such as showing different numbers of stars based on score).
* Creating custom functions such as `renderScoreStars()` and `getRankBadge()` reduces duplication and results in more readable files.

---

### Career/Employability/Learning Insights

* Don't Repeat Yourself (DRY) principle is a universal concept across modern full-stack web development and software engineering.
* Learning how templating, includes, and helper functions interact behind the scenes builds a solid foundation for understanding component-based modern frameworks and backend architectures (MVC).
* Understanding web backend fundamentals and dynamic state handling is valuable for building tools, APIs, and dashboard interfaces even if it is a different system or language.