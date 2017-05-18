//site full url
var siteUrl = window.location.protocol+"//"+window.location.host + "/mycms/";

requirejs.config({

	baseUrl: siteUrl + "src/js/mod/",
    paths: {
        'jquery': 'require-jquery',
        'moment' : 'moment.min',
        'bootstrap' : 'bootstrap-4.0.0-alpha.6-dist/js/bootstrap',
        'datetimepicker' : 'bootstrap-4.0.0-alpha.6-dist/plugins/datetimepicker/bootstrap-datetimepicker.min',
        'domReady' : 'domReady',
        'window' : 'window',
        'tether' : 'bootstrap-4.0.0-alpha.6-dist/plugins/tether/tether.min',
        'tooltip' : 'bootstrap-4.0.0-alpha.6-dist/plugins/tether/tooltip',


        'footable': 'footable/js/footable.min'
        /*'footable.core' : 'footable/js/footable.core.min',
        'footable.editing' : 'footable/js/footable.editing.min',        
        'footable.filtering': 'footable/js/footable.filtering.min',
        'footable.paging': 'footable/js/footable.paging.min',
        'footable.sorting': 'footable/js/footable.sorting.min',
        'footable.state': 'footable/js/footable.state.min'*/
    },

    shim: {
    	footable:{
    		exports: 'footable'
    	},
    	moment: {
    		exports: 'moment'
    	},
        bootstrap: {
            exports: 'bootstrap'
        },
        tether: {
            exports: 'tether'
        },
        tooltip: {
            exports: 'tooltip'
        },
        bootstrap: {deps: ['jquery']},

        footable: {deps: ['jquery']},

        // deps: (['footable', 'moment', 'bootstrap', 'jquery']), 
        // callback: function(){
        //     alert ('test');
        // }
        /*footable: {deps: [
            'jquery', 
            'footable.core', 
            'footable.editing',
            'footable.paging',
            'footable.sorting',
            'footable.state'
        ]},*/
    },

    /*
        Deps: An array of dependencies to load.
        Callback: A function to execute after depshave been loaded.
    */
    /*deps: [
        'footable',
        'footable.core',
        'footable.editing',       
        'footable.filtering',
        'footable.paging',
        'footable.sorting',
        'footable.state'
    ],*/
    priority: ['jquery']
});

// my module
define('app', function(require, exports, module){
	require('require-jquery');
	require('moment');
	require('footable');
    require('datetimepicker');
    var domReady = require('domReady');
    var window = require('window');

    var domReady = require('domReady');
    domReady(function () {
        //This function is called once the DOM is ready.
        //It will be safe to query the DOM and manipulate
        //DOM nodes in this function.
        //alert('barn');
    });

	//$ = $_;
	_revealed = function(){
		//return $('body').append("I'm all good!<br />");
	};
	exports.init = function(){
		_revealed();
		
	};














    
});



