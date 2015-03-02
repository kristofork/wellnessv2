var gulp = require('gulp'),
    less = require('gulp-less'),
    autoprefixer = require('gulp-autoprefixer'),
    smless = require('gulp-less-sourcemap')
    watch = require('gulp-watch'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    concatCSS = require('gulp-concat-css'),
    minifyCSS = require('gulp-minify-css'),
    liveReload = require('gulp-livereload'),
    uglify = require('gulp-uglify'),
    notify = require('gulp-notify'),
    lr = require('tiny-lr'),
    server = lr();

// directories
var appDir = "app",
    assetsDir = "public/assets",
    lessDir = assetsDir + "/css/less",
    jsVendor = assetsDir + "/js/vendor",
    jsWorking = assetsDir + "/js",
    publicCSS = "public/css",
    jsDir = "public/js";

gulp.task('styles', function() {
    gulp.src(lessDir+ '/style-lite.less')
    .pipe(less())
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie9', 'ios 6', 'android 4'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(assetsDir+ '/css'))
    .pipe(liveReload(server))
    .pipe(notify({ message: 'Style task completed.' }));
});


gulp.task('styles-home', function() {
    gulp.src(lessDir+ '/cover-lite.less')
    .pipe(watch())
    .pipe(less())
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie9', 'ios 6', 'android 4'))
    .pipe(minifyCSS({keepSpecialComments: 0}))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest(publicCSS))
    .pipe(liveReload(server))
    .pipe(notify({ message: 'Style task completed.' }));
});
gulp.task('styles-jquery', function() {
   gulp.src(assetsDir+ '/css/jquery/*.css')
   .pipe(concatCSS('all-jquery.css'))
   .pipe(minifyCSS({keepSpecialComments: 0}))
   .pipe(gulp.dest(publicCSS))
   .pipe(notify({message: 'CSS Jquery file task complete.'}));
    
});
gulp.task('styles-vendor', function() {
   gulp.src(assetsDir+ '/css/vendor/*.css')
   .pipe(concatCSS('all-vendor.css'))
   .pipe(minifyCSS())
   .pipe(gulp.dest(publicCSS))
   .pipe(notify({message: 'CSS Vendor file task complete.'}));
   
});

gulp.task('styles-main', function() {
   gulp.src([publicCSS+ '/all-jquery.css', lessDir+ '/style-lite.css',publicCSS+ '/all-vendor.css'])
   .pipe(concatCSS('style.min.css'))
   .pipe(minifyCSS())
   .pipe(gulp.dest('public/css'))
   .pipe(liveReload(server))
   .pipe(notify({message: 'CSS Main file generated.'}));
})
gulp.task('styles-admin', function() {
   gulp.src([publicCSS+ '/all-jquery.css', lessDir+ '/admin.css', ,publicCSS+ '/all-vendor.css'])
   .pipe(concatCSS('admin.min.css'))
   .pipe(minifyCSS())
   .pipe(gulp.dest('public/css'))
   .pipe(liveReload(server))
   .pipe(notify({message: 'CSS Admin file generated.'}));
})

// merge all vender js 
gulp.task('js-merge-vendor', function() {
    return gulp.src(jsVendor + "/*.js")
        .pipe(concat('all-vendor.js'))
        .pipe(gulp.dest(jsDir))
        .pipe(notify({message: 'Vender js merged'}));
});

// minify all app functions
gulp.task('js-min-app-functions', function() {
    return gulp.src(jsWorking + "/app-functions.js")
        .pipe(uglify())
        .pipe(rename({basename: 'app', suffix: '.min'}))
        .pipe(gulp.dest(jsDir))
        .pipe(notify({message: 'App Functions processed'}));
});


gulp.task('watch', function() {
    gulp.watch([lessDir+ '/style-lite.css'], ['styles-main']);

});

gulp.task('watch-admin', function() {
       gulp.watch([lessDir+ '/admin.css'], ['styles-admin']); 
});



