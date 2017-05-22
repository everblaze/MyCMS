//site full url
var siteUrl = window.location.protocol+"//"+window.location.host + "/mycms/";

requirejs.config({

	baseUrl: siteUrl + "src/js/",
    paths: {
        'jquery': 'mod/require-jquery',
        // 'jquery': 'vendors/jquery/dist/jquery.min',
        //'moment' : 'mod/moment.min',
        //'bootstrap' : 'mod/bootstrap-4.0.0-alpha.6-dist/js/bootstrap',
        'datetimepicker' : 'mod/bootstrap-4.0.0-alpha.6-dist/plugins/datetimepicker/bootstrap-datetimepicker.min',
        'domReady' : 'mod/domReady',
        'window' : 'mod/window',
        'tether' : 'mod/bootstrap-4.0.0-alpha.6-dist/plugins/tether/tether.min',
        'tooltip' : 'mod/bootstrap-4.0.0-alpha.6-dist/plugins/tether/tooltip',


        'footable': 'mod/footable/js/footable.min',
        'chatbody': 'mod/chatbody',

        'bootstrap' : 'vendors/bootstrap/dist/js/bootstrap.min',
        'fastclick' : 'vendors/fastclick/lib/fastclick',
        'chart' : 'vendors/Chart.js/dist/Chart.min',
        'gauge' : 'vendors/gauge.js/dist/gauge.min',
        'nbootstrap-progressbar' : 'vendors/bootstrap-progressbar/bootstrap-progressbar.min',
        iCheck : 'vendors/iCheck/icheck.min',
        nprogress : 'vendors/nprogress/nprogress',
        skycons : 'vendors/skycons/skycons',
        flot : 'vendors/Flot/jquery.flot',
        pie : 'vendors/Flot/jquery.flot.pie',
        time : 'vendors/Flot/jquery.flot.time',
        stack : 'vendors/Flot/jquery.flot.stack',
        resize : 'vendors/Flot/jquery.flot.resize',
        orderBars : 'vendors/flot.orderbars/js/jquery.flot.orderBars',
        spline : 'vendors/flot-spline/js/jquery.flot.spline.min',
        curvedLines : 'vendors/flot.curvedlines/curvedLines',
        date : 'vendors/DateJS/build/date',
        vmap : 'vendors/jqvmap/dist/jquery.vmap',
        world : 'vendors/jqvmap/dist/maps/jquery.vmap.world',
        sampledata : 'vendors/jqvmap/examples/js/jquery.vmap.sampledata',
        moment : 'vendors/moment/min/moment.min',
        daterangepicker : 'vendors/bootstrap-daterangepicker/daterangepicker',
        custom : 'build/js/custom',
        templates: 'templates'

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
        bootstrap: {
            exports: 'bootstrap'
        },
        tether: {
            exports: 'tether'
        },
        tooltip: {
            exports: 'tooltip',
            deps: ['jquery']
        },
        bootstrap: {deps: ['jquery']},
        chatbody: {
            exports: 'chatbody'
            //deps: ['bootstrap']
        },
        footable: {deps: ['jquery']},
        fastclick: {deps: ['jquery']},
        chart: {deps: ['jquery']},
        gauge: {deps: ['jquery']},
        'nbootstrap-progressbar': {deps: ['jquery']},
        iCheck: {
            exports: 'iCheck',
            deps: ['jquery']
        },
        skycons: {
            deps: ['jquery']
        }, 
        stack: {deps: ['jquery', 'flot'], exports : 'stack'},
        resize: {deps: ['jquery', 'flot'], exports : 'resize'},
        orderBars: {deps: ['jquery', 'flot'], exports : 'orderBars'},
        spline: {deps: ['jquery', 'flot'], exports : 'spline'},
        date: {deps: ['jquery']},
        vmap: {deps: ['jquery']},
        world: {deps: ['jquery', 'vmap']},
        sampledata: {deps: ['jquery','vmap']},
        moment: {
            exports: 'moment'
        },
        daterangepicker: {
            exports : 'datetimepicker',
            deps: ['moment']
        },
        flot: {
            exports : 'flot',
            deps: ['jquery']
        },
        curvedLines: {
            exports: 'curvedLines',
            deps: ['jquery','flot']
        },
        curvedLines: {
            exports: 'curvedLines',            
            deps: ['jquery','flot']
        },          
        'pie': {            
            exports : 'pie',
            deps: ['jquery', 'flot']
        },
        'time': {
            deps: ['flot', 'jquery'], 
            exports : 'time'
        },
        custom: {
            exports: 'custom',
            deps: ['bootstrap',
            'tooltip', 
            'nprogress', 
            'nbootstrap-progressbar', 
            'iCheck' , 
            'skycons',
            'fastclick',
            'chart',
            'gauge',
            'skycons',
            'date',
            'curvedLines',
            'flot',
            'time',
            'pie', 
            'stack',
            'resize',
            'orderBars',
            'spline'
            ]
        },

        templates: {
            exports: 'templates'
        }

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


