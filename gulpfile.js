// Requires
var gulp = require('gulp');

// Include plugins
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var minifycss = require('gulp-minify-css');
// var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');


// tâche CSS = compile vers knacss.css et knacss-unminified.css
gulp.task('css', function() {
    gulp.src('./resources/assets/sass/paff-deck.scss')
        .pipe(sass({
            outputStyle: 'expanded' // CSS non minifiée plus lisible ('}' à la ligne)
        }))
        .pipe(autoprefixer())
        .pipe(rename('paff-deck-unminified.css'))
        .pipe(gulp.dest('./public/css'))
        .pipe(rename('paff-deck.css'))
        //.pipe(sourcemaps.init())
        .pipe(minifycss())
        //.pipe(sourcemaps.write('.', {includeContent: false}))
        .pipe(gulp.dest('./public/css'));
});

gulp.task('js', function() {
    gulp.src(['./resources/assets/js/paff-deck.js', './resources/assets/js/jouer-deck.js',
            './resources/assets/js/multi-event.js','./resources/assets/js/profile.js'])
        .pipe(concat('paff.js'))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('images', function() {
    gulp.src('./resources/assets/images/*')
        .pipe(gulp.dest('./public/images'));
});

gulp.task('grillade', function() {
    return gulp.src(['./resources/assets/sass/_config/_breakpoints.scss', './resources/assets/sass/grids/_grillade.scss'])
        .pipe(concat('grillade.scss'))
        .pipe(gulp.dest('./public/css'))
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(minifycss())
        .pipe(gulp.dest('./public/css'));
});

// Watcher
gulp.task('watch', function() {
    gulp.watch(['./resources/assets/sass/*.scss'], ['css']);
});


gulp.task('default', ['css']);
