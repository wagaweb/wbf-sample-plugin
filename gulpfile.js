'use strict';

var gulp = require('gulp'),
    csso = require('gulp-csso'),
    concat = require('gulp-concat'),
    rename = require("gulp-rename"),
    sourcemaps = require('gulp-sourcemaps'),
    jsmin = require('gulp-jsmin'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-sass'),
    browserify = require('gulp-browserify');

var plugin_slug = "wb-sample";

var paths = {
    scripts: ['./public/assets/src/js/**/*.js'],
    mainjs: ['./public/assets/src/js/main.js'],
    bundlejs: ['./public/assets/src/js/bundle.js'],
    mainscss: './public/assets/src/scss/main.scss'
};

gulp.task('cssmin',function(){
    return gulp.src(paths.mainscss)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(rename(plugin_slug+'.min.css'))
        .pipe(sourcemaps.write("."))
        .pipe(gulp.dest('./public/assets/dist/css'));
});

gulp.task('browserify', function(){
    return gulp.src(paths.mainjs)
        .pipe(browserify({
            insertGlobals : true,
            debug : true
        }))
        .pipe(rename('bundle.js'))
        .pipe(gulp.dest('./public/assets/src/js'));
});

gulp.task('jsmin', ['browserify'] ,function(){
    return gulp.src(paths.bundlejs)
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(rename(plugin_slug+'.min.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./public/assets/dist/js'));
});

// Rerun the task when a file changes
gulp.task('watch', function() {
    gulp.watch(paths.scripts, ['jsmin']);
    gulp.watch(paths.mainscss, ['cssmin']);
});

gulp.task('default', ['jsmin', 'cssmin', 'watch']);