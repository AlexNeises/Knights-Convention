module.exports = (grunt) ->
    grunt.initConfig
        concat:
            sass:
                src: [
                    'static/styles/scss/*.scss'
                ]
                dest: 'static/styles/core.scss'
            css:
                src: [
                    'static/foundation/dist/css/foundation-flex.css'
                    'static/styles/core.css'
                ]
                dest: 'static/styles/dist/combined.css'
            js:
                src: [
                    'static/foundation/dist/js/foundation.js'
                    'static/js/dist/*.js'
                ]
                dest: 'static/js/scripts.js'

        exec:
            sass:
                command: 'npm run sass'
            css:
                command: 'npm run css'

        coffee:
            compile:
                files: [
                    expand: true
                    cwd: 'static/js/src/'
                    src: ['**/*.coffee']
                    dest: 'static/js/dist/'
                    ext: '.js'
                ]

        clean:
            styles: [
                'static/styles/core.css'
                'static/styles/core.css.map'
                'static/styles/core.scss'
            ]

    grunt.loadNpmTasks 'grunt-contrib-clean'
    grunt.loadNpmTasks 'grunt-contrib-coffee'
    grunt.loadNpmTasks 'grunt-contrib-concat'
    grunt.loadNpmTasks 'grunt-exec'

    grunt.registerTask 'default', ['concat:sass', 'exec:sass', 'concat:css', 'exec:css', 'coffee', 'concat:js', 'clean:styles']
    