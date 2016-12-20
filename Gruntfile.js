'use strict';

// # Globbing
// for performance reasons we're only matching one level down:
// 'test/spec/{,*/}*.js'
// use this if you want to recursively match all subfolders:
// 'test/spec/**/*.js'

module.exports = function (grunt) {

  // Load grunt tasks automatically
  require('load-grunt-tasks')(grunt);


  // Define the configuration for all the tasks
  grunt.initConfig({

    // Watches files for changes and runs tasks based on the changed files
    watch: {
      styles: {
        files: ['less/{,*/}*.less'],
        tasks: ['less'],
        options: {
          spawn: false
        }
      },
      icons: {
        files: ['./images/glyphs/*.svg'],
        tasks: ['font']
      }
    },

    // compile LESS files into style.css
    less: {
      material: {
        files: {
          "css/material.css": "less/material.less",
        }
      },
      materialfullpalette: {
        files: {
          "css/material-fullpalette.css": "less/material-fullpalette.less",
        }
      },
      roboto: {
        files: {
          "css/roboto.css": "less/material/roboto.less",
        }
      },
      ripples: {
        files: {
          "css/ripples.css": "less/material/ripples.less",
        }
      },
      toolbar: {
        files: {
          "css/side-toolbar.css": "less/components/side-toolbar.less",
        }
      }
    },


    //Add vendor prefixed styles
    postcss: {
      options: {
        processors: [
          require('autoprefixer-core')({browsers: ['last 5 version', 'ie 8', 'ie 9']})
        ]
      },
      dist: {
        files: [{
          expand: true,
          src: './css/style.css'
        }]
      }
    },

    cssmin: {
      target: {
        files: [{
          expand: true,
          cwd: 'css',
          src: ['*.css', '!*.min.css'],
          dest: 'css',
          ext: '.min.css'
        }]
      }
    }
  });

  grunt.registerTask('start', [
    'less',
    'watch'
  ]);

  grunt.registerTask('build', [
    'less',
    'postcss',
    'cssmin'
  ]);


  grunt.registerTask('default', [
    'build'
  ]);

};
