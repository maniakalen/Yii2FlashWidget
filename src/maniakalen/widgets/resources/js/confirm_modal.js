confirmModal = function(outerconfig) {
    return $.Deferred(function(def) {
        (function(config) {
            config = $.extend({}, {
                "title" : "Confirm an action",
                "content" : "Are you sure you want to proceed with this action?",
                "titleOk" : "Yes",
                "titleCancel" : "No"
            }, config);
            if (typeof config.id === 'undefined') {
                return false;
            }
            var $dom = $('#' + config.id);
            if ($dom.length === 0) {
                $dom = $('<div/>').attr('id', config.id);
                $dom.addClass('modal');
                $dom.appendTo($('body'));
            }
            $dom.modal({'backdrop' : true, 'show': false});
            var html  = '<div class="modal-dialog" role="document">';
            html += 	'<div class="modal-content">';
            html += 		'<div class="modal-header">';
            html += 			'<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
            html += 				'<span aria-hidden="true">&times;</span>';
            html += 			'</button>';
            html += 			'<h4 class="modal-title" id="myModalLabel">' + config.title + '</h4>';
            html += 		'</div>';
            html += 		'<div class="modal-body">' + config.content + '</div>';
            html += 		'<div class="modal-footer">';
            html +=         '<a href="#" class="btn btn-success" id="button-ok" data-dismiss="modal">' + config.titleOk + '</a>';
            html +=         '<a href="#" class="btn btn-danger" id="button-cancel" data-dismiss="modal" >' + config.titleCancel + '</a>';
            html +=         '</div>';
            html += 	'</div>';
            html += '</div>';
            $dom.html(html);

            $('a#button-ok', $dom).on('click', function() {
                def.resolve();
            });
            $('a#button-cancel', $dom).on('click', function() {
                def.reject();
            });

            $dom.modal('show');
        })(outerconfig);
    });
};