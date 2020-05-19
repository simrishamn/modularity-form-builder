// Include gulp
const {
    series,
    src,
    dest,
    watch: gulpWatch
} = require('gulp');

// Include Our Plugins
var gulpSass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var cssnano = require('gulp-cssnano');
var rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');

// Compile Our Sass
function sassDist() {
    return src('source/sass/modularity-form-builder.scss')
        .pipe(plumber())
        .pipe(gulpSass())
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1'))
        .pipe(rename({suffix: '.min'}))
        .pipe(cssnano())
        .pipe(dest('dist/css'));
}

function sassDev() {
    return src('source/sass/modularity-form-builder.scss')
        .pipe(plumber())
        .pipe(gulpSass())
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1'))
        .pipe(rename({suffix: '.dev'}))
        .pipe(dest('dist/css'));
}

// Concatenate & Minify JS
function scriptsDist() {
    const admin = src([
        'source/js/admin/*.js',
    ])
        .pipe(concat('form-builder-admin.dev.js'))
        .pipe(dest('dist/js'))
        .pipe(rename('form-builder-admin.min.js'))
        .pipe(uglify())
        .pipe(dest('dist/js'));

    const front = src([
            'source/js/front/*.js',
        ])
        .pipe(concat('form-builder-front.dev.js'))
        .pipe(dest('dist/js'))
        .pipe(rename('form-builder-front.min.js'))
        .pipe(uglify())
        .pipe(dest('dist/js'));

    return Promise.all([admin, front]);
}

// Watch Files For Changes
function watch() {
    gulpWatch('source/js/**/*.js', series(scriptsDist));
    gulpWatch('source/sass/**/*.scss', series(sassDist, sassDev));
}

// Build Task
const build = series(sassDist, sassDev, scriptsDist);
exports.build = build;

// Default Task
exports.default = series(build, watch);
