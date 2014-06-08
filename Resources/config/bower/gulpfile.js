var gulp = require("gulp");
var gulpBowerFiles = require("gulp-bower-files");
var uglify = require('gulp-uglify');
var jsmin = require('gulp-jsmin');
var rename = require('gulp-rename');

gulp.task("bower-files", function() {
	 gulpBowerFiles()
		.pipe(gulp.dest("../../public/vendor"));
});

gulp.task('compress', function() {
	gulp.src('../../public/vendor/**/*.js')
		.pipe(uglify())
		.pipe(gulp.dest("../../public/vendor"));
});

gulp.task('minify', function() {
	gulp.src('../../public/vendor/**/*.js')
		.pipe(jsmin())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('../../public/vendor'));
});