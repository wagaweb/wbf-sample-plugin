var pkg = require('./package.json');

var gulp = require('gulp'),
    concat = require('gulp-concat'),
    rename = require("gulp-rename"),
    sourcemaps = require('gulp-sourcemaps'),
    jsmin = require('gulp-jsmin'),
    uglify = require('gulp-uglify'),
    sass = require('gulp-sass'),
    browserify = require('gulp-browserify'),
    zip = require('gulp-zip'),
    bower = require('gulp-bower'),
    copy = require('gulp-copy'),
    runSequence  = require('run-sequence');

var plugin_slug = "wb-sample";

var paths = {
    builddir: "./builds",
    scripts: ['./public/assets/src/js/**/*.js'],
    mainjs: ['./public/assets/src/js/main.js'],
    bundlejs: ['./public/assets/src/js/bundle.js'],
    mainscss: './public/assets/src/scss/main.scss',
    build: ["**/*", "!.*" , "!Gruntfile.js", "!gulpfile.js" , "!package.json", "!bower.json", "!{builds,builds/**}", "!{node_modules,node_modules/**}", "!{bower_components,bower_components/**}"]
};

gulp.task('cssmin',function(){
    return gulp.src(paths.mainscss)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(rename(plugin_slug+'.min.css'))
        .pipe(sourcemaps.write("."))
        .pipe(gulp.dest('./public/assets/dist/css'));
});

gulp.task('jsmin', ['browserify'] ,function(){
    return gulp.src(paths.bundlejs)
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(rename(plugin_slug+'.min.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./public/assets/dist/js'));
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

gulp.task('make-package', function(){
    return gulp.src(paths.build)
        .pipe(copy(paths.builddir+"/pkg/"+plugin_slug));
});

gulp.task('archive', function(){
    return gulp.src(paths.builddir+"/pkg/**")
        .pipe(zip(plugin_slug+'-'+pkg.version+'.zip'))
        .pipe(gulp.dest("./builds"));
});

gulp.task('bower-install',function(){
    return bower();
});

gulp.task('bower-update',function(){
    return bower({cmd: 'update'});
});

gulp.task('build', function(callback) {
    runSequence('bower-update', ['jsmin', 'cssmin'], 'make-package', 'archive', callback);
});

// Rerun the task when a file changes
gulp.task('watch', function() {
    gulp.watch(paths.mainjs, ['jsmin']);
    gulp.watch(paths.mainscss, ['cssmin']);
});

gulp.task('default', function(callback){
    runSequence('bower-install', ['jsmin', 'cssmin'], 'watch', callback);
});