module.exports = function( grunt ) {
  grunt.initConfig( {
    pkg: grunt.file.readJSON( 'package.json' ),

    jshint: {
      files: [ 'Gruntfile.js', 'js/*.js' ],
      options: {
        globals: {
          jQuery: true
        }
      }
    },

    uglify: {
      dist: {
        files: {
          '../js/main.min.js' : 'js/main.js',
          '../js/customiser.min.js' : 'js/customiser.js',
          '../js/color-scheme-control.min.js' : 'js/color-scheme-control.js',
        }
      }
    },

    watch: {
      files: [ '<%= jshint.files %>' ],
      tasks: [ 'jshint', 'uglify' ]
    }
  } );

  grunt.loadNpmTasks( 'grunt-contrib-jshint' );
  grunt.loadNpmTasks( 'grunt-contrib-uglify' );
  grunt.loadNpmTasks( 'grunt-contrib-watch' );

  grunt.registerTask( 'default', [ 'jshint', 'uglify' ] );
};
