# Backup and maintenance

## What to back up

| What | Why | How often |
|---|---|---|
| The Git repository (code, content, docs) | Source of truth for everything except secrets | Every change (push to GitHub) |
| `amaniq/config/config.php` from the server | Holds the SMTP password and app key; it is not in Git | After each change. Store it in a password manager or encrypted storage, **not** in email or Git |
| `amaniq/storage/logs/` | Useful for diagnosing delivery issues | Optional, monthly |

The site has no database and no uploaded files, so a full restore needs only the repository plus `config.php`.

## Hosting backups

- cPanel → *Backup* (or JetBackup, if GO54 provides it): download a full account backup monthly, and before any major change.
- Do not leave backup archives inside `public_html`.

## Routine maintenance

**Monthly**
- Check `amaniq/storage/logs/app-YYYY-MM.log` for repeated "email failed" entries. These mean enquiries are not being delivered.
- Submit a test enquiry to confirm email delivery still works.

**Quarterly**
- Confirm the PHP version is still supported; update it in *MultiPHP Manager* and re-test.
- Check that the SSL certificate auto-renewal is working (*SSL/TLS Status*).
- Review team profiles, services and contact details for accuracy.

**Yearly**
- Review the Privacy Policy and Terms with your adviser; update the "last updated" dates.
- Update the copyright year. This is automatic, but check the footer.

## Logs

Logs are monthly files and are small. Delete files older than 12 months from `amaniq/storage/logs/` unless they are needed for an investigation.

## Making changes safely

1. Edit locally and run `php -S 127.0.0.1:8080 -t public_html tools/dev-router.php`.
2. Run `php tools/smoke-test.php http://127.0.0.1:8080`.
3. Commit and push to GitHub.
4. Upload only the changed files to the server.
