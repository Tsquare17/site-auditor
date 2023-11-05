# Site Auditor

## A Site Auditing CLI utility
Site Auditor uses spatie/lighthouse-php to perform lighthouse audits on a list of URLs provided in a single CSV file.

A CSV report file is generated, containing the list of URLs audited and their scores for the given test.

### Examples
`php bin/site-auditor.php performance /path/to/audit.csv`

`php bin/site-auditor.php a11y --report-fail-only --output-path /path/to/output /path/to/audit.csv`

### Audits
- performance
- a11y
- best-practices
- seo
- pwa

### Note
Audit file should be a CSV file, containing a comma delimited list of URLs.
