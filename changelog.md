# Version 0.5.0 (FUTURE RELEASE)

-   Fall back to media caption if no alt text is provided, when using `HTML::media()`


# Version 0.4.2 (2015-01-29)

-   Fix sorting bug when saving media on a model


# Version 0.4.1 (2015-01-27)

-	Fix bug when saving Media
-	Fix disappearing Media issue when sorting


# Version 0.4.0 (2015-01-13)

-	Fix incorrect composite key in mediables table
-	Add FileField class from bozboz/admin
-	Add a fallback for displaying non-image media
-	Prevent re-uploading a file on existing Media instance
-	Define reverse "mediable" relation on Media instance
-	Ensure filename attribute can be set manually on Media model, if no file is sent via POST
-	Add `HTML::media()` macro
-	Clean Media filenames on upload
-	Add static `Media::forCollection()` method
