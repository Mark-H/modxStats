module.exports = function(grunt) {
	// Project configuration.		
	var initConfig = {
		pkg: grunt.file.readJSON('package.json'),
		dirs: { /* just defining some properties */
			lib: './lib/',
            tmp: './tmp/',
			scss: './scss/',
			theme: '../../../',
			assets: 'assets/components/modxstats/',
            components:'core/components/modxstats/',
			css: 'css/',
			js:  'js/',
			img: 'img/'
		},
		bower: {
			install: {
				options: {
					targetDir: './lib',
					layout: 'byComponent'
				}
			}
		},
		copy: { 
		},
		cssmin: {
			compress: {
				options: {
					report: 'min',
					keepSpecialComments: 0,
					banner: '/*!\n*  <%= pkg.title %> - v<%= pkg.version %> %>\n*/'
				},
				files: {
					'<%= dirs.theme %><%= dirs.assets %><%= dirs.css %>stats.min.css': '<%= dirs.theme %><%= dirs.assets %><%= dirs.css %>stats.css'
				}
			}
		},
		
		sass: {
			dist: {
				options: {
					style: 'compressed',
					compass: false
				},
				files: {
					'<%= dirs.theme %><%= dirs.assets %><%= dirs.css %>stats.css': '<%= dirs.scss %>stats.scss'
				}
			},
			dev: {
				options: {
					style: 'expanded',
					compass: false,
                    sourcemap: true
				},
				files: {
					'<%= dirs.theme %><%= dirs.assets %><%= dirs.css %>stats.css': '<%= dirs.scss %>stats.scss'
				}
			}
		},
		
		csslint: {
			strict: {
				options: {
					import: 2
				},
				src: ['<%= dirs.theme %><%= dirs.assets %><%= dirs.css %>**/*.css']
			}
		},
		
		concat: {
			options: {
				separator: '',
			}
			
		},
		uglify: {
			main: {
				options: {
					report: 'min'
				},
				files: {
					//'<%= dirs.theme %><%= dirs.assets %><%= dirs.js %>main-min.js': ['<%= dirs.theme %><%= dirs.assets %><%= dirs.js %>main-dev.js']
				}
				
			}
		},
        cacheBust: {
            options: {
                  enableUrlFragmentHint: false,
                  //dir:'<%= dirs.theme %><%= dirs.assets %><%= dirs.css %>',
                  /*filters: {
                          'style' : [
                              function() { return this.attribs['src'].replace('[[+asset_url]]','../../../../../assets/'); },
                              function() { return this.attribs['src']; } // keep default 'src' mapper
                          ]
                  }*/
            },
            files: {
                src: ['<%= dirs.tmp %>wrapper.chunk.tpl']
            }
        },
		watch: { /* trigger tasks on save */
			options: {
				livereload: true 
			},
			
			scss: {
                options: {
                    livereload: false
                },
				files: '<%= dirs.scss %>**/*.scss',
				tasks: ['sass:dev', 'growl:sass']
			},
            css: {
				files: ['<%= dirs.theme %><%= dirs.assets %><%= dirs.css %>*.css','!<%= dirs.theme %><%= dirs.assets %><%= dirs.css %>*.min.css'],
				tasks: ['sass:dev', 'growl:sass']
            },
			js: {
				files: ['<%= dirs.theme %><%= dirs.assets %><%= dirs.js %>*','!<%= dirs.theme %><%= dirs.assets %><%= dirs.js %>**/*-dev.js*','!<%= dirs.theme %><%= dirs.assets %><%= dirs.js %>**/*-min.js*'],
				tasks: ['concat', 'growl:concat', 'uglify', 'growl:uglify']
			}
		},
        replace:{
            cb: {
                options:{
                    patterns:[
                        {
                            match:/\[\[\+assets_url]]/g,
                            replacement:'../<%= dirs.theme %><%= dirs.assets %>'
                        }
                    ],
                    usePrefix: false
                },
                files: [
                {expand:true,flatten:true,src:['<%= dirs.theme %><%= dirs.components %>elements/chunks/wrapper.chunk.tpl'],dest:'<%= dirs.tmp %>'}
                ]
            },
            ncb: {
                options:{
                    patterns:[
                        {
                            match:/..\/..\/..\/..\/assets\/components\/modxstats\//g,
                            replacement:'[[+assets_url]]'
                        }
                    ],
                    usePrefix: false
                },
                files: [
                {expand:true,flatten:true,src:['<%= dirs.tmp %>wrapper.chunk.tpl'],dest:'<%= dirs.theme %><%= dirs.components %>elements/chunks/'}
                ]
            }
        },
		clean: { /* take out the trash */
			options: {
				force: true
			},
			prebuild: ['<%= dirs.scss %>bourbon', '<%= dirs.scss %>font-awesome'],
			postbuild: ['<%= dirs.lib %>','<%= dirs.tmp %>']
		},
		growl: { /* optional growl notifications requires terminal-notifer: gem install terminal-notifier */
			
			sass: {
				message: "Sass files created.",
				title: "grunt"
			},
			
			build: {
				title: "grunt",
				message: "Build complete."
			},
			watch: {
				title: "grunt",
				message: "Watching. Grunt has its eye on you."
			},
			expand: {
				title: "grunt",
				message: "CSS Expanded. Don't check it in."
			},
			concat: {
				title: "grunt",
				message: "JavaScript concatenated."
			},
			uglify: {
				title: "grunt",
				message: "JavaScript minified."
			},
			cachebust: {
				title: "grunt",
				message: "Cache busted."
			}
		}
	};

	initConfig.copy["bourbon"] = {
		files: [{
			src: 'bourbon/**/*',
			cwd: '<%= dirs.lib %>',
			dest: '<%= dirs.scss %>',
			expand: true
		}]
	};

	initConfig.copy["neat"] = {
		files: [{
			src: 'neat/**/*',
			cwd: '<%= dirs.lib %>',
			dest: '<%= dirs.scss %>',
			expand: true
		}]
	};
	
	initConfig.copy["rickshaw"] = {
		files: [{
			src: 'rickshaw/*rickshaw*',
			cwd: '<%= dirs.lib %>',
			dest: '<%= dirs.theme %><%= dirs.assets %>',
			expand: true
		}]
	};
    
	initConfig.copy["wrapper"] = {
		files: [{
			src: 'wrapper.chunk.tpl',
			cwd: '<%= dirs.theme %><%= dirs.components %>elements/chunks/',
			dest: '<%= dirs.tmp %>',
			expand: true
		}]
	};

	grunt.initConfig(initConfig);
	
	grunt.loadNpmTasks('grunt-bower-task');
	grunt.loadNpmTasks('grunt-contrib-copy');
	
	grunt.loadNpmTasks('grunt-contrib-sass');
	
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-growl');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-csslint');
	
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	
    grunt.loadNpmTasks('grunt-replace');
    grunt.loadNpmTasks('grunt-cache-bust');

	grunt.registerTask('default', ['sass:dist', 'cssmin', 'growl:sass', 'growl:watch', 'watch']);
	grunt.registerTask('build', ['clean:prebuild', 'bower', 'copy', 'sass:dev', 'cssmin', 'concat', 'growl:sass', 'cachebust']);
    grunt.registerTask('cachebust',['replace:cb','cacheBust','replace:ncb','growl:cachebust','clean:postbuild']);
};
