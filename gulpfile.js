var gulp = require('gulp'),
    less = require('gulp-less'),
    smless = require('gulp-less-sourcemap')
watch = require('gulp-watch'),
rename = require('gulp-rename'),
minifyCSS = require('gulp-minify-css'),
livereload = require('gulp-livereload'),
lr = require('tiny-lr'),
server = lr();

gulp.task('less', function() {
    gulp.src('public/assets/css/less/*.less')
        .pipe(watch())
        .pipe(less())
        .pipe(smless({
            generateSourceMap: true
        }))
        .pipe(rename("style.css"))
        .pipe(gulp.dest('./public/assets/css/less'))
        .pipe(livereload(server));
});


gulp.task('sourcemaps', function() {
    gulp.src('public/assets/css/less/*.less')
        .pipe(smless({
            generateSourceMap: true
        }))
        .pipe(gulp.dest('./public/assets/css/less'));
});


gulp.task('default', ['less']);