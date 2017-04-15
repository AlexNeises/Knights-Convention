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

        exec:
            sass:
                command: 'npm run sass'
            css:
                command: 'npm run css'

        clean:
            styles: [
                'static/styles/core.css'
                'static/styles/core.css.map'
                'static/styles/core.scss'
            ]

    grunt.loadNpmTasks 'grunt-contrib-clean'
    grunt.loadNpmTasks 'grunt-contrib-concat'
    grunt.loadNpmTasks 'grunt-exec'

    grunt.registerTask 'default', ['concat:sass', 'exec:sass', 'concat:css', 'exec:css', 'clean:styles']
    