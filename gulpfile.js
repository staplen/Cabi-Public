var gulp = require('gulp'),
    gp_concat = require('gulp-concat'),
    gp_rename = require('gulp-rename'),
    gp_uglify = require('gulp-uglify'),
    minifyCss = require('gulp-minify-css');

gulp.task('js-fef', function(){
    return gulp.src([
	  		'js/lib/jquery-2.0.3.min.js',
	  		'js/lib/underscore-1.5.2.min.js',
	  		'js/lib/backbone-1.1.0.min.js',
	  		'js/lib/jquery.scrollTo-1.4.6.min.js',
	  		'js/lib/jquery.timeago.js',
            'js/lib/bootstrap.min.js',
            'js/lib/js.cookie.js',
	  		'js/app/utils.js',
	  		'js/app/models.js',
	  		'js/app/views.js',
	  		'js/app/collections.js',
	  		'js/app/routers.js',
            'js/app/init.js'
	  	])
        .pipe(gp_concat('concat.js'))
        .pipe(gulp.dest('dist'))
        .pipe(gp_rename('all.js'))
        .pipe(gp_uglify())
        .pipe(gulp.dest('dist'));
});

gulp.task('minify-css', function() {
  return gulp.src('css/*.css')
	.pipe(gp_concat('concat.css'))
  	.pipe(gulp.dest('dist'))
    .pipe(gp_rename('all.css'))
    .pipe(minifyCss())
    .pipe(gulp.dest('dist'));
});

gulp.task('default', ['js-fef','minify-css'], function(){});