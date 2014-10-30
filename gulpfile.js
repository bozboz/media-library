var scriptsDest = 'public/js/min/';

var appFiles = {
	scripts: [
		'bower_components/PATH_TO_FILE',
		'bower_components/PATH_TO_FILE',
		'public/js/media_OLD.js',
	]
}



var gulp = require('gulp'),
	concat = require('gulp-concat'),
    ugligy = require('gulp-uglify');


gulp.task('scripts', function() {
  gulp.src(appFiles.scripts)
  	.pipe(concat('media.js'))
		.pipe(gulp.dest(paths.scripts.dest))
		.pipe(uglify())
		.pipe(gulp.dest(paths.scripts.dest));
});



gulp.task('default', ['scripts']);