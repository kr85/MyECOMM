var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var concatCss = require('gulp-concat-css');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');

gulp.task('css', function() {
    gulp.src('assets/sass/main.scss')
        .pipe(sass())
        .pipe(autoprefixer('last 50 versions'))
        .pipe(gulp.dest('assets/css'))
});

gulp.task('css-concat', function() {
    gulp.src([
        'assets/css/font-awesome.css',
        'assets/css/core.css',
        'assets/css/invoice.css',
        'assets/css/main.css'
    ])
        .pipe(concatCss('all.css'))
        .pipe(minifyCss({keepBreaks:false}))
        .pipe(gulp.dest('assets/main'))
});

gulp.task('scripts-client', function() {
    gulp.src([
        'assets/js/lib/jquery-1.11.2.min.js',
        'assets/js/lib/jquery.imgpreload.min.js',
        'assets/js/object/systemObject.js',
        'assets/js/object/basketObject.js',
        'assets/js/system.js',
        'assets/js/basket.js'
    ])
        .pipe(concat('all-client.js'))
        .pipe(uglify())
        .pipe(gulp.dest('assets/main'))
});

gulp.task('scripts-admin', function() {
    gulp.src([
        'assets/js/lib/jquery-1.11.2.min.js',
        'assets/js/lib/jquery.livequery.js',
        'assets/js/lib/jquery.tablednd.0.7.min.js',
        'assets/js/object/systemObject.js',
        'assets/js/object/basketObject.js',
        'assets/js/object/adminObject.js',
        'assets/js/system.js',
        'assets/js/basket.js',
        'assets/js/admin.js'
    ])
        .pipe(concat('all-admin.js'))
        .pipe(uglify())
        .pipe(gulp.dest('assets/main'))
});

gulp.task('watch', function() {
    gulp.watch('assets/sass/**/*.scss', ['css']);
    gulp.watch('assets/js/**/*.js', ['scripts-client', 'scripts-admin']);
});

gulp.task('default', ['css-concat', 'scripts-client', 'scripts-admin']);