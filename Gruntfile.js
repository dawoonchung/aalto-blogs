module.exports = function( grunt ) {
  grunt.initConfig( {
    pkg: grunt.file.readJSON( 'package.json' ),

    jshint: {
      files: [ 'Gruntfile.js', 'dev/js/*.js' ],
      options: {
        globals: {
          jQuery: true
        }
      }
    },

    uglify: {
      dist: {
        files: {
          'js/main.min.js' : 'dev/js/main.js',
          'js/customiser.min.js' : 'dev/js/customiser.js'
        }
      }
    },

    watch: {
      files: [ '<%= jshint.files %>' ],
      tasks: [ 'jshint' ]
    }
  } );

  grunt.loadNpmTasks( 'grunt-contrib-jshint' );
  grunt.loadNpmTasks( 'grunt-contrib-uglify' );
  grunt.loadNpmTasks( 'grunt-contrib-watch' );

  grunt.registerTask( 'default', [ 'jshint', 'uglify' ] );
};
