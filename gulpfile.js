'use strict';

// Include gulp
var gulp = require('gulp');

// Include other dependencies
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var watch = require('gulp-watch');

// Compile the sass files
gulp.task('sass', function () {
    return gulp.src('./public/raw/sass/**/*.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/raw/css/'));
});

// watch for changes in only sass files
gulp.task('sass:watch', function () {
    gulp.watch('./public/raw/sass/**/*.scss', ['sass']);
});

// Concatenate and minify js
gulp.task('scripts', function() {
    return gulp.src('./public/raw/js/**/*.js')
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest('public/js/'))
        .pipe(rename('scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('public/js/'));
});

// watch for changes in only js files
gulp.task('js:watch', function () {
    gulp.watch('./public/raw/js/**/*.js', ['scripts']);
});

// Concatenate and minify css
gulp.task('css', function(files){
    return gulp.src('./public/raw/css/**/*.css')
        .pipe(concat('site.css'))
        .pipe(gulp.dest('public/css/'))
        .pipe(rename('site.min.css'))
        .pipe(cssmin({compatibility:''}))
        .pipe(gulp.dest('public/css/'));
});

// watch for changes in only sass files
gulp.task('css:watch', function () {
    gulp.watch('./public/raw/sass/**/*.scss', ['sass']);
});

// Watch all files for changes
gulp.task('watch', function() {
    gulp.watch('./public/raw/sass/**/*.scss', ['sass', 'css']);
    gulp.watch('./public/raw/js/**/*.js', ['scripts']);
});

// Default Task
gulp.task('default', ['sass', 'scripts', 'css']);