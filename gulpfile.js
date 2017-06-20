'use strict';
var gulp = require('gulp'),
    gls = require('gulp-live-server'),
    livereload = require('gulp-livereload'),
    uglify = require('gulp-uglify'),
    gulpif = require('gulp-if'),
    gulputil = require('gulp-util'),
    minifyHTML = require('gulp-minify-html'),
    minifyCss = require('gulp-minify-css'),
    imagemin = require('gulp-imagemin'),
    compass = require("gulp-compass"),
    browserSync = require("browser-sync"),
    swPrecache = require('sw-precache'),
    useref = require('gulp-useref');
var assets = useref();
const reload = browserSync.reload;

gulp.task('compass', function () {
    return gulp.src('app/scss/**/*.scss')
        .pipe(compass({
            sass: 'app/scss',
            css: 'app/css',
            image: 'app/images',
        }))
        .pipe(gulp.dest('app/css'));
});

gulp.task('images', () = >
gulp.src('app/images/**/*')
    .pipe(imagemin({
        progressive: true,
        interlaced: true
    }))
    .pipe(gulp.dest('dist/images'))
)
;

gulp.task('serve', () = > {
    browserSync({
                    notify: false,
                    logPrefix: 'PREF',
                    scrollElementMapping: ['main', '.mdl-layout'],
                    proxy: 'http://localhost/site/',
                    port: 3123
                });

gulp.watch(['app/*.php'], reload);
gulp.watch(['app/scss/**/*.scss'], ['compass', reload]);
gulp.watch(['app/js/*.js'], reload);
gulp.watch(['app/images/*'], reload);
})
;

var gutil = require('gulp-util');
var ftp = require('gulp-sftp');

gulp.task('sftp', ['images', 'htmldist'], function () {
    return gulp.src('dist/**/*')
        .pipe(ftp({
            host: '123.456.789.12',
            user: 'root',
            pass: 'password',
            remotePath: '/var/www/vhosts/site.com/httpdocs/',
            port: '22'
        }));
});

gulp.task('htmldist', ['compass'], function () {
    return gulp.src('app/*.php')
        .pipe(assets)
        .pipe(gulpif('app/js/*.js', uglify()))
        .pipe(gulpif('app/css/*.css', minifyCss()))
        .pipe(gulpif('app/*.html', minifyHTML()))
        .pipe(gulpif('app/*.php', minifyHTML()))
        .pipe(gulp.dest('dist'));
});

gulp.task('default', ['sftp'], function () {
});
