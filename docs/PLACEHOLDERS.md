# Placeholders and open items

Items that need real company assets, confirmation or decisions before or after launch.

## Assets

| Item | Current state | What to supply | Where it goes |
|---|---|---|---|
| Founder portrait | Monogram placeholder "MI" | Genuine professional headshot, 4:5, ≥ 640×800 | `public_html/assets/img/team/` + `photo` in `amaniq/data/team.php` |
| Associate Consultant portrait | Monogram placeholder "HB" | Genuine professional headshot | as above |
| Logo | Approved "amaniq" wordmark geometry from the brand files | Nothing, unless the brand changes | `wordmark()` in `amaniq/src/view.php` and `assets/img/brand/*.svg` |
| Favicon, app icons | Generated from the wordmark's "a" and diamond | Optional designer version | `assets/img/brand/` (same names and sizes) |
| Social-sharing image | Generated 1200×630 brand card | Optional designer version | `assets/img/brand/og-default.png` |
| Division visuals | Original abstract SVG motifs (no external assets) | Optional illustrations | `division_art()` in `amaniq/src/view.php` |
| Photography | None used, to avoid unrelated stock images | Optional genuine office/team photography | New sections as needed |

## Information to confirm

| Item | Notes |
|---|---|
| Hissein Banaye Hassan's certifications | Confirm exact names, levels and current status of CEH, CySA+, Security+, ISO 27001, SC-200, CISM, CISSP and Fortinet NSE |
| Hissein's degree details | Institution name "ESGIS" and graduation year (no year is shown) |
| ITIL 4 credential level | Shown as "ITIL 4"; add the level (e.g. Foundation) if it should appear |
| WhatsApp number | Hidden until `whatsapp` is set in `company.php` |
| Company LinkedIn page | Not linked until `linkedin` is set |
| Individual LinkedIn profiles | Optional `linkedin` per team member |
| Office hours | Not shown (not supplied) |
| Postcode | Not shown in the address (not supplied) |
| Privacy Policy and Terms | Drafts; need legal review (retention period, lawful bases, NDPA registration or audit obligations, governing law). Then turn off the review notice |
| Academy launch status | `academy.live` is `false`; set `true` when `academy.amaniqgroup.com` is public |
| SMTP credentials | To be created on the hosting account (`docs/DEPLOYMENT-GO54.md` §5) |
| `security.app_key` | Generate on the server |

## Deliberately not included

These were left out because they would need verified facts: client logos, testimonials, case studies, awards, statistics, years in business, partner or vendor badges, accreditations and government approvals. Add them only once they are verified and you have permission to publish them.
