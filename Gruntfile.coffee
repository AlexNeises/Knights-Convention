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
                    'static/crevasse/dependencies/solarized-light.css'
                    'static/crevasse/lib/css/crevasse.css'
                    'static/styles/core.css'
                ]
                dest: 'static/styles/dist/combined.css'
            js:
                src: [
                    'static/jquery/jquery-3.1.1.min.js'
                    'static/crevasse/dependencies/jquery.caret.js'
                    'static/crevasse/dependencies/jquery.scrollTo.min.js'
                    'static/crevasse/dependencies/marked.js'
                    'static/crevasse/dependencies/rainbow-custom.min.js'
                    'static/foundation/dist/js/foundation.js'
                    'static/crevasse/lib/js/crevasse.js'
                    'static/js/dist/*.js'
                ]
                dest: 'static/js/scripts.js'

        exec:
            sass:
                command: 'npm run sass'
            css:
                command: 'npm run css'
            js:
                command: 'npm run js'

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

    grunt.registerTask 'default', ['concat:sass', 'exec:sass', 'concat:css', 'exec:css', 'coffee', 'concat:js', 'exec:js', 'clean:styles']
    