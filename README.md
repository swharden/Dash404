# Dash404

**Dash404 is a PHP API and dashboard for tracking HTTP error codes.** It was created to offer a web-based live view of broken URLs as an alternative to manual or semi-automated inspection of raw log files.

Dash404 uses a custom `.htaccess` rule to serve a specific PHP page when a 404 error is incurred. The PHP script gets details about the requested file and client and logs it as [Newline delimited JSON](http://ndjson.org/)

> **WARNING: This project is pre-alpha** and is intended only for personal use at this time.