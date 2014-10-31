var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

gulp.task('js', function(){
    gulp.src([
	'bower_components/knockout/dist/knockout.js',
	'bower_components/masonry/dist/masonry.pkgd.js',
	'src/assets/js/media-browser.js'
    ])
    .pipe(uglify())
    .pipe(concat('media.js'))
    .pipe(gulp.dest('public/js/'));
});

gulp.task('default', ['js']);
