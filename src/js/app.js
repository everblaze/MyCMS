// my module
define('app', function(require, exports, module){
    require('jquery');

    require('footable');
    require('datetimepicker');
    require('chatbody');

    // require('fastclick');
    // require('chart');
    // require('gauge');
    // require('icheck');
    // require('skycons');
    // require('flot');
    // require('flot.pie');
    // require('flot.time');
    // require('flot.stack');
    // require('flot.resize');
    // require('flot.orderBars');
    // require('flot.spline');
    // require('curvedLines');
    // require('date');
    // require('vmap');
    // require('vmap.world');
    // require('vmap.sampledata');
    // require('moment');
    //require('daterangepicker');

    //require('moment');
    //require('daterangepicker');



    var domReady = require('domReady');



    //var window = require('window');



    //$ = $_;
    _revealed = function(){

        // If loading chatbody as a js string...
        /*require('chatbody');
        $('body').append(window.chatbody);
        $(function(){
            $("#addClass").click(function () {
                $('#qnimate').addClass('popup-box-on');
            });

            $("#removeClass").click(function () {
                $('#qnimate').removeClass('popup-box-on');
            });
        });*/


        domReady(function () {
            //This function is called once the DOM is ready.
            //It will be safe to query the DOM and manipulate
            //DOM nodes in this function.
            //alert('barn');


            require('custom');

            chatbody = require('chatbody');

            //alert(chatbody);

            /*$('body').append(chatbody);
            $(function(){
                $("#addClass").click(function () {
                    $('#qnimate').addClass('popup-box-on');
                });

                $("#removeClass").click(function () {
                    $('#qnimate').removeClass('popup-box-on');
                });
            });*/

        });

    };

    exports.init = function(){
        _revealed();
    };
});
