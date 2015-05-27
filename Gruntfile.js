module.exports = function(grunt) {
    // load all tasks
    require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});
    var pkg_slug = "wb-events";
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        pot:{
            options:{
                text_domain: pkg_slug,
                dest: 'languages/',
                keywords: [
                    '__:1',
                    '_e:1',
                    '_x:1,2c',
                    'esc_html__:1',
                    'esc_html_e:1',
                    'esc_html_x:1,2c',
                    'esc_attr__:1',
                    'esc_attr_e:1',
                    'esc_attr_x:1,2c',
                    '_ex:1,2c',
                    '_n:1,2',
                    '_nx:1,2,4c',
                    '_n_noop:1,2',
                    '_nx_noop:1,2,3c'
                ]
            },
            files:{
                src: ['*.php','public/**/*.php'],
                expand: true
            }
        }
    });
    // Register tasks
    grunt.registerTask('default', ['pot']); // Default task
};